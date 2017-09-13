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
    public function addNewDays($dayNumber, $eventId)
    {
        $dates = Day::getMassDate($dayNumber);
        $i = 1;
        foreach ($dates as $date) {
            $sql = "INSERT INTO day (day_id,event_id,date) VALUES (:day_id,:event_id,:date)";
            $statement = $this->db->dbh->prepare($sql);
            $statement->bindValue(':day_id',  $i++);
            $statement->bindValue(':date', $date);
            $statement->bindValue(':event_id', $eventId);
            $statement->execute();
        }
            return true;

    }


    public function cleanFullDaysByUser($eventId)
    {
        $sql = 'DELETE FROM day WHERE event_id = :event_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->execute();
    }
}