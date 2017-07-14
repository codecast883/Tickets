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
     * Pull CRUD method
     */
    public function pullNewTickets()
    {

        $this->cleanFullTickets();
        $this->day->cleanFullDays();
        $dayAmount = TicketsApp::getDataAdmin('getOptions','Options')->day_amount;
        $this->day->addNewDays($dayAmount);


        $week = TicketsApp::getData('getFullOptions','Settings');

        foreach ($week as $array) {
            foreach ($array as $key => $value) {
                $sql = "INSERT INTO tickets (day_id,user_id,time,price,no_time) VALUES (:day_id,:user_id,:time,:price,:no_time)";
                $statement = $this->db->dbh->prepare($sql);
                $statement->bindValue(':day_id', $value['day_id']);
                $statement->bindValue(':user_id', 2);
                $statement->bindValue(':time', $value['time']);
                $statement->bindValue(':price', $value['price']);
                $statement->bindValue(':no_time', $value['no_time']);
                $statement->execute();
            }

        }


    }

    /**
     * @return array
     */
    public function getAllDay()
    {
        $day = [];
        $sql = 'SELECT day_id,date FROM ' . 'day ';
        $dayObj = $this->db->query($sql);
        foreach ($dayObj as $value) {
            $day[$value->day_id] = $value->date;
        }
        return $day;
    }

    /**
     * @return array
     */
    public function getAllTickets()
    {
        $ticketDay = [];
        $allDate = $this->getAllDay();

        $sql = 'SELECT * FROM ' . 'tickets ';
        $tickets = $this->db->query($sql);

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
     * @return mixed
     */
    public function getTicketsById($id)
    {
        $sql = "SELECT id,time,price,no_time,date FROM tickets JOIN day USING (day_id) WHERE id = $id";
        return $this->db->query($sql)[0];
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
    public function formatPostUpdate($post)
    {
        $outArray = [];
        $allDay = $this->getAllDay();
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
    public function ticketsUpdate($upTickets)
    {
        $id = 0;
        $allTickets = $this->getAllTickets();
        foreach ($upTickets as $date => $ticket) {
            foreach ($ticket as $key => $value) {
                $idTicket = $allTickets[$date][$key]->id;
                $r = '';
                $id++;

                $sql = 'UPDATE tickets SET time = :time, price = :price ,no_time = :no_time WHERE id = :id';
                $statement = $this->db->dbh->prepare($sql);
                $statement->bindValue(':time', $value['time']);
                $statement->bindValue(':price', $value['price']);
                if (!empty($value['noTime'])) {
                    $statement->bindValue(':no_time', $value['noTime']);
                } else {
                    $statement->bindValue(':no_time', 0);
                }

                $statement->bindValue(':id', $idTicket);
                $statement->execute();
            }
        }


    }

    /**
     * @param $id
     */
    public function deleteTicketById($id)
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
    public function addOneTickets($data)
    {
        $date = $data['date'];
        $sql = "SELECT day_id FROM day WHERE date = '$date'";
        $dayId = $this->db->query($sql)[0]->day_id;
        $r = '';

        $sql = "INSERT INTO tickets (day_id,time,price,no_time) VALUES (:day_id,:time,:price,:no_time)";
        $statement = $this->db->dbh->prepare($sql);
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
