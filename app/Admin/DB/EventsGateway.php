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

    public function getAllHeaderImages($userId)
    {
        $sql = "SELECT pic_src FROM events_files WHERE user_id = ?";
        if ($picSrc = $this->db->query($sql, [$userId])) {
            return $picSrc;
        }
        return false;

    }


    public function deleteAllImages($userId)
    {
        $sql = 'DELETE FROM events_files WHERE user_id = :user_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();
    }

    /**
     * @param $path
     * @return bool
     */
    public function insertImage($path, $userId)
    {

        $sql = "INSERT INTO events_files (user_id, pic_src) VALUES (:user_id, :pic_src)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':pic_src', $path);
        if ($statement->execute()) {
            return true;
        }


    }

    /**
     * @return bool
     */
    public function getOptions($userId)
    {
        $sql = "SELECT title,phone,description,day_amount,day_of_week FROM events WHERE user_id = ?";
        if ($data = $this->db->query($sql, [$userId])) {
            return $data[0];
        }
        return false;
    }

    /**
     * @param $options
     */
    public function optionsUpdate($options, $userId)
    {
        $sql = '';

        $sql = 'UPDATE events SET title = :title, phone = :phone,description = :description,day_of_week = :day_of_week WHERE user_id = :user_id';

        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':title', $options['title']);
        $statement->bindValue(':phone', $options['phone']);
        $statement->bindValue(':description', $options['description']);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':day_of_week', 7);
        $statement->execute();

    }

    public function optionsInsert($options, $userId)
    {
        $sql = '';

        $sql = "INSERT INTO events (title,phone,description,user_id,day_of_week) VALUES (:title, :phone, :description,:user_id,:day_of_week)";

        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':title', $options['title']);
        $statement->bindValue(':phone', $options['phone']);
        $statement->bindValue(':description', $options['description']);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':day_of_week', 7);
        $statement->execute();

    }

    public function getGenerateWeek($param, $userId)
    {
        $week = [];
        for ($i = 1; $i <= 7; $i++) {
            for ($a = 1; $a <= $param['ticketsAmount']; $a++) {
                $week[$i][$a]['user_id'] = $userId;
                $week[$i][$a]['day_id'] = $i;
                $week[$i][$a]['time'] = $param['from'];
                $week[$i][$a]['price'] = $param['ticketsPrice'];
                $week[$i][$a]['no_time'] = 0;
            }
        }

        return $week;
    }

    public function setDayAmount($countDays, $userId)
    {
        $sql = 'UPDATE events SET day_amount = :day_amount WHERE user_id = :user_id';

        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':day_amount', $countDays);
        $statement->bindValue(':user_id', $userId);

        $statement->execute();

    }

}
