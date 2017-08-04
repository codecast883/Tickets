<?php
namespace app\Admin\DB;



use Composer\Factory;

class PulloptionsGateway extends Gateway
{



    /**
     * @param $post
     * @return array
     */
    public function formatPostUpdate($post,$userId)
    {
        $outArray = [];
        $allDay = \app\Components\TicketsApp::getDataAdmin('getOptions', 'Events',$userId)->day_of_week;
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
    public function ticketsUpdate($upTickets,$userId)
    {

        $allTickets = \app\Components\TicketsApp::getData('getWeekOptions','Settings',$userId);
        foreach ($upTickets as $number => $ticket) {
            foreach ($ticket as $key => $value) {

                $idTicket = $allTickets[$number][--$key]->id;


                $sql = 'UPDATE options_pull_ticket SET time = :time, price = :price ,no_time = :no_time WHERE id = :id AND user_id = :user_id';
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

    public function insertPullOptions($options,$userId)
    {


        foreach ($options as $number => $ticket) {
            foreach ($ticket as $key => $value) {

                $sql = "INSERT INTO options_pull_ticket (user_id,day_id,time,price,no_time) VALUES (:user_id,:day_id,:time,:price,:no_time)";;
                $statement = $this->db->dbh->prepare($sql);
                $statement->bindValue(':user_id', $userId);
                $statement->bindValue(':day_id', $number);
                $statement->bindValue(':time', $value['time']);
                $statement->bindValue(':price', $value['price']);
                $statement->bindValue(':no_time', 0);

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
    public function addOneTickets($data,$userId)
    {

        $sql = "INSERT INTO options_pull_ticket (user_id,day_id,time,price,no_time) VALUES (:user_id,:day_id,:time,:price,:no_time)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':day_id', $data['day']);
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