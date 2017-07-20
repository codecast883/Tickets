<?php
namespace app\Admin\DB;
class OptionsGateway
{
    private $db;

    public function __construct()
    {
        global $dbo;
        $this->db = $dbo;

    }

    /**
     * @return array|bool
     */
    public function getAllHeaderImages()
    {
        $id = 2;
        $sql = "SELECT pic_src FROM options_files WHERE options_id = ?";
        if ($picSrc = $this->db->query($sql,[$id])) {
            return $picSrc;
        }
        return false;

    }



    public function deleteAllImages()
    {
        $this->db->query('TRUNCATE table options_files');
    }

    /**
     * @param $path
     * @return bool
     */
    public function insertImage($path)
    {

        $optionsId = \app\Components\TicketsApp::getDataAdmin('getIdUser','Admin');

        $sql = "INSERT INTO options_files (options_id, pic_src) VALUES (:options_id, :pic_src)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':options_id', $optionsId);
        $statement->bindValue(':pic_src', $path);
        if ($statement->execute()) {
            return true;
        }


    }

    /**
     * @return bool
     */
    public function getOptions()
    {
        $id = 2;
        $sql = "SELECT title,phone,description,day_amount FROM options WHERE options_id = ?";
        if ($data = $this->db->query($sql,[$id])) {
            return $data[0];
        }
        return false;
    }

    /**
     * @param $options
     */
    public function optionsUpdate($options)
    {
        $id = 2;
        $sql = 'UPDATE options SET title = :title, phone = :phone,description = :description WHERE options_id = :options_id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':title', $options['title']);
        $statement->bindValue(':phone', $options['phone']);
        $statement->bindValue(':description', $options['description']);
        $statement->bindValue(':options_id', $id);
        $statement->execute();

    }

}