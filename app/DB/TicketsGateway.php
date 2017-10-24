<?php
namespace app\DB;
use app\Components\TicketsApp;


class TicketsGateway
{
    protected $db;
    protected $day;



    /**
     * TicketsGateway constructor.
     */
    public function __construct()
    {
        global $dbo;
        $this->db = $dbo;
        $this->day = new DayGateway;

    }


    /**
     * @param $userId
     * @param int $type: 1 = update, 0 = add
     */
    public function pullNewTickets($eventId, $type = 0)
    {
        $week = '';
        $i = 1;
        $dayAmount = TicketsApp::getDataAdmin('getEvent', 'Events', $eventId)->day_amount;

            if ($type == 0){
                $this->cleanFullTicketsByEvent($eventId);
                $this->day->cleanFullDaysByUser($eventId);
                $this->day->addNewDays($dayAmount, $eventId);
                $week = TicketsApp::getData('getFullOptions', 'Settings', $eventId);
            }elseif ($type == 1){
                $week = $this->getTicketsUpdate($eventId);
                $this->cleanFullTicketsByEvent($eventId);
                $this->day->cleanFullDaysByUser($eventId);
                $this->day->addNewDays($dayAmount, $eventId);

            }

            foreach ($week as $array) {
                foreach ($array as $key => $value) {
                    $sql = "INSERT INTO tickets (id,day_id,event_id,time,price,no_time) VALUES (:id,:day_id,:event_id,:time,:price,:no_time)";
                    $statement = $this->db->dbh->prepare($sql);
                    $statement->bindValue(':day_id', $value['day_id']);
                    $statement->bindValue(':id', $i++);
                    $statement->bindValue(':event_id', $eventId);
                    $statement->bindValue(':time', $value['time']);
                    $statement->bindValue(':price', $value['price']);
                    $statement->bindValue(':no_time', $value['no_time']);
                    $statement->execute();
                }
            }


    }


    public function cleanFullTicketsByEvent($eventId)
    {
        $sql = 'DELETE FROM tickets WHERE event_id = :event_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->execute();
    }


    public function getAllDay($eventId)
    {
        $day = [];
        $sql = 'SELECT day_id,date FROM ' . 'day WHERE event_id=?';
        $dayObj = $this->db->query($sql, [$eventId]);
        foreach ($dayObj as $value) {
            $day[$value->day_id] = $value->date;
        }
        return $day;
    }


    /**
     * @param $userId
     * @return array
     */
    public function getAllTickets($eventId)
    {
        $ticketDay = [];
        $allDate = $this->getAllDay($eventId);

        $sql = 'SELECT * FROM ' . 'tickets ' . 'WHERE event_id = ?';
        $tickets = $this->db->query($sql, [$eventId]);

        foreach ($allDate as $dayNumber => $date) {
            foreach ($tickets as $key => $value) {
                if ($dayNumber == $value->day_id) {
                    $ticketDay[$date][] = $value;
                }
            }

        }

        return $ticketDay;
    }


    /**
     * @param $id
     * @param $userId
     * @return mixed
     */
    public function getTicketsById($id, $eventId)
    {
        $sql = "SELECT id,event_id,time,price,no_time,date FROM tickets JOIN day USING (day_id,event_id) WHERE id = ?  AND event_id = ?";


        return $this->db->query($sql, [$id, $eventId])[0];

    }


    public function cleanFullTickets()
    {
        $sql = "TRUNCATE table tickets";
        $statement = $this->db->query($sql);


    }


    /**
     * @return mixed
     */
    public function countTickets()
    {
        $sql = 'SELECT COUNT(id) FROM ' . 'tickets';
        $str = $this->db->query($sql)[0];
        foreach ($str as $value) {
            $count = $value;
        }
        return $count;
    }

    /**
     * @param $post
     * @return array
     */
    public function formatPostUpdate($post, $eventId)
    {
        $outArray = [];
        $allDay = $this->getAllDay($eventId);
        foreach ($allDay as $date) {
            foreach ($post as $key => $value) {
                $type = explode('_', $key);
                if ($type[2] == $date) {
                    $outArray[$date][--$type[0]][$type[1]] = $value;
                }
            }
        }
        return $outArray;
    }

    /**
     * @param $upTickets
     */
    public function ticketsUpdate($upTickets, $eventId)
    {

        $allTickets = $this->getAllTickets($eventId);
        foreach ($upTickets as $date => $ticket) {
            foreach ($ticket as $key => $value) {
                $idTicket = $allTickets[$date][$key]->id;
                $r = '';

                $sql = 'UPDATE tickets SET time = :time, price = :price ,no_time = :no_time WHERE id = :id AND event_id = :event_id';
                $statement = $this->db->dbh->prepare($sql);
                $statement->bindValue(':time', $value['time']);
                $statement->bindValue(':price', $value['price']);
                if (!empty($value['noTime'])) {
                    $statement->bindValue(':no_time', $value['noTime']);
                } else {
                    $statement->bindValue(':no_time', 0);
                }

                $statement->bindValue(':id', $idTicket);
                $statement->bindValue(':event_id', $eventId);
                $statement->execute();
            }
        }


    }

    public function getTicketsUpdate($eventId)
    {

        $settings = TicketsApp::getData('getFullOptions', 'Settings', $eventId);
        $lastDay = array_pop($settings);
        $tickets = $this->getAllTickets($eventId);
        array_shift($tickets);

        $newTickets = [];
        $i = 0;
        foreach ($tickets as $date => $value) {
            $i++;
            foreach ($value as $key => $values) {
                $newTickets[$i][$key]['day_id'] = $i;
                $newTickets[$i][$key]['time'] = $values->time;
                $newTickets[$i][$key]['price'] = $values->price;
                $newTickets[$i][$key]['no_time'] = $values->no_time;

            }
        }
        $newTickets[$i+1] = $lastDay;
        return $newTickets;
    }



    /**
     * @param $id
     */
    public function deleteTicketById($id, $eventId)
    {
        $sql = 'DELETE FROM tickets WHERE id = :id AND event_id = :event_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':event_id', $eventId);
        $statement->execute();
    }



    /**
     * @param $data
     * @return mixed
     */
    public function addOneTickets($data, $eventId)
    {
        $date = $data['date'];
        $sql = "SELECT day_id FROM day WHERE date = '$date' AND event_id = '$eventId'";
        $dayId = $this->db->query($sql)[0]->day_id;
        $ticketId = $this->getLastTicket()[0]->id;
        $sql = "INSERT INTO tickets (id,event_id,day_id,time,price,no_time) VALUES (:id,:event_id,:day_id,:time,:price,:no_time)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':id', $ticketId + 1);
        $statement->bindValue(':event_id', $eventId);
        $statement->bindValue(':day_id', $dayId);
        $statement->bindValue(':time', $data['time']);
        $statement->bindValue(':price', $data['price']);
        if (isset($data['noTime'])) {
            $statement->bindValue(':no_time', $data['noTime']);
        } else {
            $statement->bindValue(':no_time', '');
        }
        $statement->execute();

        return $dayId;
    }

    public function getLastTicket()
    {
        $sql = "SELECT * FROM tickets ORDER BY id DESC LIMIT 1";
        $str = $this->db->query($sql);
        return $str;
    }


}
