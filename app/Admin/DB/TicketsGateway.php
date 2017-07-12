<?php


namespace app\Admin\DB;


class TicketsGateway
{
    protected $db;


    public function __construct()
    {
        global $dbo;
        $this->db = $dbo;

    }


    public function getCountNewTickets()
    {
        $sql = "SELECT number FROM new_tickets_number ";
        $count = $this->db->query($sql);
        if (empty($count)) {
            return false;
        } else {
            return $count[0]->number;
        }
    }


    public function cleanCountNewTickets()
    {
        $sql = "TRUNCATE TABLE new_tickets_number";
        $this->db->dbh->exec($sql);

    }
}