<?php

namespace app\Admin\DB;


class EventsGateway extends Gateway
{
    public function isEventsExist($userId)
    {

        $sql = 'SELECT * FROM ' . 'events WHERE user_id=?';
        $result = $this->db->query($sql, [$userId]);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }

    }

    public function getAllHeaderImages()
    {
        $id = 2;
        $sql = "SELECT pic_src FROM events_files WHERE user_id = ?";
        if ($picSrc = $this->db->query($sql, [$id])) {
            return $picSrc;
        }
        return false;

    }


    public function deleteAllImages()
    {
        $this->db->query('TRUNCATE table events_files');
    }

    /**
     * @param $path
     * @return bool
     */
    public function insertImage($path, $userId)
    {

        $sql = "INSERT INTO events_files (user_id, pic_src) VALUES (:user_id, :pic_src)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':pic_src', $path);
        if ($statement->execute()) {
            return true;
        }


    }

    /**
     * @return bool
     */
    public function getOptions($userId)
    {
        $sql = "SELECT title,phone,description,day_amount,day_of_week FROM events WHERE user_id = ?";
        if ($data = $this->db->query($sql, [$userId])) {
            return $data[0];
        }
        return false;
    }

    /**
     * @param $options
     */
    public function optionsUpdate($options, $userId)
    {
        $sql = '';

        $sql = 'UPDATE events SET title = :title, phone = :phone,description = :description,day_of_week = :day_of_week WHERE user_id = :user_id';

        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':title', $options['title']);
        $statement->bindValue(':phone', $options['phone']);
        $statement->bindValue(':description', $options['description']);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':day_of_week', 7);
        $statement->execute();

    }

    public function optionsInsert($options, $userId)
    {
        $sql = '';

        $sql = "INSERT INTO events (title,phone,description,user_id,day_of_week) VALUES (:title, :phone, :description,:user_id,:day_of_week)";

        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':title', $options['title']);
        $statement->bindValue(':phone', $options['phone']);
        $statement->bindValue(':description', $options['description']);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':day_of_week', 7);
        $statement->execute();

    }
}