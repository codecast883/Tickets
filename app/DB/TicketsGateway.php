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
     * @param int $type
     */
    public function pullNewTickets($userId, $type = 0)
    {
        $week = '';
        $dayAmount = TicketsApp::getDataAdmin('getOptions','Events',$userId)->day_amount;



            if ($type == 0){
                $this->cleanFullTicketsByUser($userId);
                $this->day->cleanFullDaysByUser($userId);
                $this->day->addNewDays($dayAmount,$userId);
                $week = TicketsApp::getData('getFullOptions','Settings',$userId);
            }elseif ($type == 1){
                $week = $this->getTicketsUpdate($userId);
                $this->cleanFullTicketsByUser($userId);
                $this->day->cleanFullDaysByUser($userId);
                $this->day->addNewDays($dayAmount,$userId);

//                $this->cleanFullTickets();
            }

            foreach ($week as $array) {
                foreach ($array as $key => $value) {
                    $sql = "INSERT INTO tickets (day_id,user_id,time,price,no_time) VALUES (:day_id,:user_id,:time,:price,:no_time)";
                    $statement = $this->db->dbh->prepare($sql);
                    $statement->bindValue(':day_id', $value['day_id']);
                    $statement->bindValue(':user_id', $userId);
                    $statement->bindValue(':time', $value['time']);
                    $statement->bindValue(':price', $value['price']);
                    $statement->bindValue(':no_time', $value['no_time']);
                    $statement->execute();
                }
            }


    }


    public function cleanFullTicketsByUser($userId){
        $sql = 'DELETE FROM tickets WHERE user_id = :user_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();
    }



    public function getAllDay($userId)
    {
        $day = [];
        $sql = 'SELECT day_id,date FROM ' . 'day WHERE user_id=?';
        $dayObj = $this->db->query($sql,[$userId]);
        foreach ($dayObj as $value) {
            $day[$value->day_id] = $value->date;
        }
        return $day;
    }


    /**
     * @param $userId
     * @return array
     */
    public function getAllTickets($userId)
    {
        $ticketDay = [];
        $allDate = $this->getAllDay($userId);

        $sql = 'SELECT * FROM ' . 'tickets ' . 'WHERE user_id = ?';
        $tickets = $this->db->query($sql,[$userId]);

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
    public function getTicketsById($id, $userId)
    {
        $sql = "SELECT id,user_id,time,price,no_time,date FROM tickets JOIN day USING (day_id,user_id) WHERE id = ?  AND user_id = ?";


        return $this->db->query($sql,[$id,$userId])[0];

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
    public function formatPostUpdate($post,$userId)
    {
        $outArray = [];
        $allDay = $this->getAllDay($userId);
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
    public function ticketsUpdate($upTickets,$userId)
    {

        $allTickets = $this->getAllTickets($userId);
        foreach ($upTickets as $date => $ticket) {
            foreach ($ticket as $key => $value) {
                $idTicket = $allTickets[$date][$key]->id;
                $r = '';

                $sql = 'UPDATE tickets SET time = :time, price = :price ,no_time = :no_time WHERE id = :id AND user_id = :user_id';
                $statement = $this->db->dbh->prepare($sql);
                $statement->bindValue(':time', $value['time']);
                $statement->bindValue(':price', $value['price']);
                if (!empty($value['noTime'])) {
                    $statement->bindValue(':no_time', $value['noTime']);
                } else {
                    $statement->bindValue(':no_time', 0);
                }

                $statement->bindValue(':id', $idTicket);
                $statement->bindValue(':user_id', $userId);
                $statement->execute();
            }
        }


    }

    public function getTicketsUpdate($userId)
    {

        $settings = TicketsApp::getData('getFullOptions','Settings',$userId);
        $lastDay = array_pop($settings);
        $tickets = $this->getAllTickets($userId);
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
    public function deleteTicketById($id,$userId)
    {
        $sql = 'DELETE FROM tickets WHERE id = :id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }



    /**
     * @param $data
     * @return mixed
     */
    public function addOneTickets($data,$userId)
    {
        $date = $data['date'];
        $sql = "SELECT day_id FROM day WHERE date = '$date' AND user_id = '$userId'";
        $dayId = $this->db->query($sql)[0]->day_id;

        $sql = "INSERT INTO tickets (user_id,day_id,time,price,no_time) VALUES (:user_id,:day_id,:time,:price,:no_time)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':user_id', $userId);
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


}
