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
    public function addRequest($array, $userId)
    {
        $sql = "INSERT INTO request (event_id,date,time,price,name,phone,email,note,count_peoples,no_time) VALUES (:event_id, :date, :time, :price, :name, :phone, :email, :note,:count_peoples, :no_time)";
        $statement = $this->db->dbh->prepare($sql);

        foreach ($array as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        if ($statement->execute()) {
            $this->setCountNewTickets($userId);
            return true;

        }

    }

    public function addRequestService($arrayIdService, $requestId)
    {
        foreach ($arrayIdService as $item) {
            $sql = "INSERT INTO request_and_services (request_id, service_id) VALUES (:request_id,:service_id)";
            $statement = $this->db->dbh->prepare($sql);
            $statement->bindValue(':request_id', $requestId);

            $statement->bindValue(':service_id', $item);
            $statement->execute();
        }

    }

    public function getRequestService($requestId)
    {
        $sql = "SELECT service_id 
        FROM request_and_services 
        WHERE request_id = ?";

        return $this->db->query($sql, [$requestId]);
    }


    /**
     * @return array|bool
     */
    public function getAllRequest($eventId)
    {
        $sql = "SELECT * 
        FROM request 
        WHERE event_id = '$eventId' 
        ORDER BY id DESC";
        return $this->db->query($sql);
    }

    public function getLastRequest($eventId)
    {
        $sql = "SELECT * 
                FROM  `request` 
                WHERE event_id = ?
                ORDER BY id DESC 
                LIMIT 1";

        return $this->db->query($sql, [$eventId]);
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