<?php


namespace app\Admin\DB;


class TicketsGateway extends Gateway
{


    public function getCountNewTickets($eventId)
    {
        $sql = "SELECT number FROM new_tickets_number WHERE event_id = ?";
        $count = $this->db->query($sql, [$eventId]);
        if (empty($count)) {
            return false;
        } else {
            return $count[0]->number;
        }
    }


    public function cleanCountNewTickets($eventId)
    {
        $sql = 'DELETE FROM new_tickets_number WHERE event_id = :event_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->execute();

    }
}