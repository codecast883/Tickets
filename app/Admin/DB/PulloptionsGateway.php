<?php
namespace app\Admin\DB;



class PulloptionsGateway
{

    protected $db;


    public function __construct()
    {
        global $dbo;
        $this->db = $dbo;

    }


    /**
     * @return mixed
     */
    public function countDay()
    {
        $count = '';
        $sql = 'SELECT COUNT(day_id) FROM ' . 'options_pull_day';
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
        $allDay = $this->countDay();
        for ($i = 0; $i <= $allDay; $i++) {
            foreach ($post as $key => $value) {
                $type = explode('_', $key);
                if ($type[2] == $i) {
                    $outArray[$i][$type[0]][$type[1]] = $value;
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

        $allTickets = \app\Components\TicketsApp::getData('getFullOptions','Settings');
        foreach ($upTickets as $number => $ticket) {
            foreach ($ticket as $key => $value) {

                $idTicket = $allTickets[$number][--$key]->id;


                $sql = 'UPDATE options_pull_ticket SET time = :time, price = :price ,no_time = :no_time WHERE id = :id';
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
        $sql = 'DELETE FROM options_pull_ticket WHERE id = :id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }


    /**
     * @param $data
     * @return bool
     */
    public function addOneTickets($data)
    {

        $sql = "INSERT INTO options_pull_ticket (day_id,time,price,no_time) VALUES (:d_week_id,:time,:price,:no_time)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':d_week_id', $data['day']);
        $statement->bindValue(':time', $data['time']);
        $statement->bindValue(':price', $data['price']);
        if (isset($data['noTime'])) {
            $statement->bindValue(':no_time', $data['noTime']);
        } else {
            $statement->bindValue(':no_time', '');
        }
        if ($statement->execute()){
            return true;
        }

    }
}