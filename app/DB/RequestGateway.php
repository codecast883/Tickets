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
        $sql = "INSERT INTO request (user_id,date,time,price,name,phone,email,note,no_time) VALUES (:user_id, :date, :time, :price, :name, :phone, :email, :note, :no_time)";
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
    public function getAllRequest($userId)
    {
        $sql = "SELECT date,time,price,name,phone,email,note,no_time FROM request WHERE user_id = '$userId' ORDER BY id DESC";
        return $this->db->query($sql);
    }


    /**
     * @return mixed
     */
    public function setCountNewTickets($userId)
    {
        $sql = "SELECT number FROM new_tickets_number WHERE user_id = '$userId' ";
        $count = $this->db->query($sql);
        if (empty($count)) {
            $sqli = "INSERT INTO new_tickets_number (user_id,number) VALUES ('$userId',1) ";
            $this->db->query($sqli);
        } else {
            $countNumber = $count[0]->number;
            $countNumber++;
            $sqli = "UPDATE new_tickets_number SET number = '$countNumber' WHERE user_id = '$userId'";
            $this->db->query($sqli);
        }
        return $countNumber;
    }

}