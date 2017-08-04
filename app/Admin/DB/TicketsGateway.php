<?php


namespace app\Admin\DB;


class TicketsGateway extends Gateway
{


    public function getCountNewTickets($userId)
    {
        $sql = "SELECT number FROM new_tickets_number WHERE user_id = ?";
        $count = $this->db->query($sql, [$userId]);
        if (empty($count)) {
            return false;
        } else {
            return $count[0]->number;
        }
    }


    public function cleanCountNewTickets($userId)
    {
        $sql = 'DELETE FROM new_tickets_number WHERE user_id = :user_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();

    }
}