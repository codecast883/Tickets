<?php

namespace app\Admin\DB;


class EventsGateway extends Gateway
{
    public function isEventsExist($userId)
    {

        $sql = 'SELECT * FROM ' . 'events WHERE user_id=?';
        $result = $this->db->query($sql, [$userId]);
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }

    }

    public function getLastEvent($userId)
    {
        $events = $this->isEventsExist($userId);
        return array_pop($events);
    }

    public function getAllEventsImages($eventId)
    {
        $sql = "SELECT pic_src FROM events_files WHERE event_id = ? AND type = ?";
        if ($picSrc = $this->db->query($sql, [$eventId, 'title_pic'])) {
            return $picSrc;
        }
        return false;
    }


    public function deleteAllImages($eventId)
    {
        $sql = 'DELETE FROM events_files WHERE event_id = :event_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->execute();
    }

    /**
     * @param $path
     * @return bool
     */
    public function insertTitleImage($path, $eventId)
    {

        $sql = "INSERT INTO events_files (event_id, pic_src,type) VALUES (:event_id, :pic_src,:type)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->bindValue(':pic_src', $path);
        $statement->bindValue(':type', 'title_pic');
        if ($statement->execute()) {
            return true;
        }


    }

    public function updateTitleImage($path, $eventId)
    {

        $sql = "UPDATE events_files SET  pic_src = :pic_src,type = :type WHERE event_id = :event_id";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->bindValue(':pic_src', $path);
        $statement->bindValue(':type', 'title_pic');
        if ($statement->execute()) {
            return true;
        }


    }


    public function updateUpdateCountPeoples($updateData, $eventId)
    {

        $sql = "UPDATE events SET min_people = :min_people,max_people = :max_people WHERE event_id = :event_id";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->bindValue(':min_people', $updateData['minPeople']);
        $statement->bindValue(':max_people', $updateData['maxPeople']);
        if ($statement->execute()) {
            return true;
        }


    }
    /**
     * @return bool
     */
    public function getEvent($eventId)
    {
        $sql = "SELECT user_id,title,phone,description,day_amount,day_of_week,min_people,max_people, calculation_price_type FROM events WHERE event_id = ?";
        if ($data = $this->db->query($sql, [$eventId])) {
            return $data[0];
        }
        return false;
    }


    /**
     * @param $options
     */
    public function optionsUpdate($options, $eventId)
    {
        $sql = '';

        $sql = 'UPDATE events SET title = :title, phone = :phone,description = :description,day_of_week = :day_of_week WHERE event_id = :event_id';

        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':title', $options['title']);
        $statement->bindValue(':phone', $options['phone']);
        $statement->bindValue(':description', $options['description']);
        $statement->bindValue(':event_id', $eventId);
        $statement->bindValue(':day_of_week', 7);
        $statement->execute();

    }


    public function eventsInsert($options, $userId)
    {
        $sql = '';

        $sql = "INSERT INTO events (title,phone,description,user_id,day_of_week,min_people,max_people) 
                VALUES (:title, :phone, :description,:user_id,:day_of_week,:min_people,:max_people)";

        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':title', $options['title']);
        $statement->bindValue(':phone', $options['phone']);
        $statement->bindValue(':description', $options['description']);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':day_of_week', 7);
        $statement->bindValue(':min_people', 1);
        $statement->bindValue(':max_people', 3);
        if ($statement->execute()) {
            return true;
        }

    }

    public function getGenerateWeek($param, $eventId)
    {
        date_default_timezone_set('UTC');

        $hour =(new \DateTime($param['to']))->format('H');
        $minute =(new \DateTime($param['to']))->format('m');
        $timeToTimeStamp =  mktime($hour, $minute, 0, 1, 1, 1970);

        $time = '';
        $week = [];
        for ($i = 1; $i <= 7; $i++) {
            $time =(new \DateTime($param['from']))->getTimestamp();
            for ($a = 1; $a <= $param['ticketsAmount']; $a++) {
                $week[$i][$a]['event_id'] = $eventId;
                $week[$i][$a]['day_id'] = $i;

                if ($a != 1){
                    $time += $timeToTimeStamp;
                    $week[$i][$a]['time'] = date('H:i', $time);
                }else{
                    $week[$i][$a]['time'] = $param['from'];
                }

                $week[$i][$a]['price'] = $param['ticketsPrice'];
                $week[$i][$a]['no_time'] = 0;
            }
        }


        return $week;
    }

    public function setDayAmount($countDays, $eventId)
    {
        $sql = 'UPDATE events SET day_amount = :day_amount WHERE event_id = :event_id';

        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':day_amount', $countDays);
        $statement->bindValue(':event_id', $eventId);

        $statement->execute();

    }

    /**
     * @return array|bool
     */
    public function getAllEventsId()
    {
        $sql = "SELECT event_id FROM events";
        $idArray = [];
        if ($data = $this->db->query($sql)) {
            return $data;
        }
        return false;
    }

    public function isEventIdHasUser()
    {
        $sql = "SELECT event_id FROM events";
        $idArray = [];
        if ($data = $this->db->query($sql)) {
            return $data;
        }
        return false;
    }

    /**
     * @param $type
     * @param $eventId
     */
    public function changePriceType($type, $eventId)
    {
        $sql = 'UPDATE events SET calculation_price_type = :calculation_price_type WHERE event_id = :event_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':calculation_price_type', $type);
        $statement->bindValue(':event_id', $eventId);
        $statement->execute();
    }

}
