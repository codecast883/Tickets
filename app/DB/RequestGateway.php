<?php
namespace app\DB;
class RequestGateway
{
    private $db;


    public function __construct()
    {
        global $dbo;
        $this->db = $dbo;
    }

    /**
     * @param $array
     * @return bool
     */
    public function addRequest($array,$userId)
    {
        $sql = "INSERT INTO request (event_id,date,time,price,name,phone,email,note,no_time) VALUES (:event_id, :date, :time, :price, :name, :phone, :email, :note, :no_time)";
        $statement = $this->db->dbh->prepare($sql);

        foreach ($array as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        if ($statement->execute()) {
            $this->setCountNewTickets($userId);
            return true;

        }

    }


    /**
     * @return array|bool
     */
    public function getAllRequest($eventId)
    {
        $sql = "SELECT date,time,price,name,phone,email,note,no_time FROM request WHERE event_id = '$eventId' ORDER BY id DESC";
        return $this->db->query($sql);
    }


    /**
     * @return mixed
     */
    public function setCountNewTickets($eventId)
    {
        $sql = "SELECT number FROM new_tickets_number WHERE event_id = '$eventId' ";
        $count = $this->db->query($sql);
        if (empty($count)) {
            $sqli = "INSERT INTO new_tickets_number (event_id,number) VALUES ('$eventId',1) ";
            $this->db->query($sqli);
        } else {
            $countNumber = $count[0]->number;
            $countNumber++;
            $sqli = "UPDATE new_tickets_number SET number = '$countNumber' WHERE event_id = '$eventId'";
            $this->db->query($sqli);
        }

    }

}