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
        $i = 1;
        foreach ($dates as $date) {
            $sql = "INSERT INTO day (day_id,user_id,date) VALUES (:day_id,:user_id,:date)";
            $statement = $this->db->dbh->prepare($sql);
            $statement->bindValue(':day_id',  $i++);
            $statement->bindValue(':date', $date);
            $statement->bindValue(':user_id', $userId);
            $statement->execute();
        }
            return true;

    }



    public function cleanFullDaysByUser($userId){
        $sql = 'DELETE FROM day WHERE user_id = :user_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();
    }
}