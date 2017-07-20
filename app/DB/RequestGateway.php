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
    public function addRequest($array)
    {
        $sql = "INSERT INTO request (user_id,date,time,price,name,phone,email,note,no_time) VALUES (:user_id, :date, :time, :price, :name, :phone, :email, :note, :no_time)";
        $statement = $this->db->dbh->prepare($sql);

        foreach ($array as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        if ($statement->execute()) {
            $this->setCountNewTickets();
            return true;

        }

    }


    /**
     * @return array|bool
     */
    public function getAllRequest()
    {
        $sql = "SELECT date,time,price,name,phone,email,note,no_time FROM request ORDER BY id DESC";
        return $this->db->query($sql);
    }


    /**
     * @return mixed
     */
    public function setCountNewTickets()
    {
        $sql = "SELECT number FROM new_tickets_number ";
        $count = $this->db->query($sql);
        if (empty($count)) {
            $sqli = "INSERT INTO new_tickets_number (number) VALUES (1)";
            $this->db->query($sqli);
        } else {
            $countNumber = $count[0]->number;
            $countNumber++;
            $sqli = "UPDATE new_tickets_number SET number = '$countNumber'";
            $this->db->query($sqli);
        }
        return $countNumber;
    }

}