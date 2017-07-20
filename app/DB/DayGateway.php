<?php
namespace app\DB;



class DayGateway
{
    private $db;


    /**
     * DayGateway constructor.
     */
    public function __construct()
    {
        global $dbo;

        $this->db = $dbo;
    }


    /**
     * @param $dayNumber
     * @return bool
     */
    public function addNewDays($dayNumber,$userId)
    {
        $dates = Day::getMassDate($dayNumber);

        foreach ($dates as $date) {
            $sql = "INSERT INTO day (user_id,date) VALUES (:user_id,:date)";
            $statement = $this->db->dbh->prepare($sql);
            $statement->bindValue(':date', $date);
            $statement->bindValue(':user_id', $userId);
            $statement->execute();
        }
        return true;
    }


    public function cleanFullDays()
    {
        $sql = "SET foreign_key_checks = 0;
					TRUNCATE TABLE day;
					SET foreign_key_checks = 1;";
        $statement = $this->db->dbh->exec($sql);


    }

}