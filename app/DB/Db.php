<?php
namespace app\DB;

require_once __DIR__ . '/../config.php';

class Db
{
    public $dbh;

    /**
     * Db constructor.
     */
    public function __construct()
    {

        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
           \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $this->dbh = new \PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $opt);
    }

    /**
     * @param $sql
     * @param array $param
     * @param bool $callback
     * @return array|bool
     */
    public function query($sql, $param = [], $callback = true)
    {
        $statement = $this->dbh->prepare($sql);
        $statement->execute($param);
        if ($callback) {
            return $statement->fetchAll();
        } else {
            return true;
        }

    }

}

