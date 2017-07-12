<?php
namespace app\Admin\DB;




class AdminGateway
{

    private $db;

    /**
     * AdminGateway constructor.
     */
    public function __construct()
    {
        global $dbo;
        $this->db = $dbo;

    }

    /**
     * @param $login
     * @param $pass
     * @return bool
     */
    public function checkUser($login, $pass)
    {
        $sql = "SELECT login, password FROM users WHERE login = '$login'";
        $user = $this->db->query($sql);
        if (empty($user)) {
            return false;
        } else {
            if (password_verify($pass, $user[0]->password)) {
                return $user[0]->password;
            } else {
                return false;
            }

        }

    }

    /**
     * @return bool
     */
    public function getNameUser()
    {

        if ($hash = $_COOKIE['usr']) {
            $sql = "SELECT login FROM users WHERE password = '$hash'";
            if ($user = $this->db->query($sql)) {
                return $user[0]->login;
            }

        }
        return false;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function getIdUser($name = '')
    {
        if (empty($name)) {
            $login = $this->getNameUser();
        } else {
            $login = $name;
        }

        $sql = "SELECT user_id FROM users WHERE login = '$login'";
        if ($id = $this->db->query($sql)) {
            return $id[0]->user_id;
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function setDateAuth($name){
        $userId = $this->getIdUser($name);
        $userIp = $_SERVER['REMOTE_ADDR'];
        $date = \app\Components\TicketsApp::getDate();

        $sql = "INSERT INTO auth_log (user_id,user_ip,auth_date) VALUES (:user_id, :user_ip,:auth_date)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':user_ip', $userIp);
        $statement->bindValue(':auth_date', $date);
        if ($statement->execute()) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $login
     * @return bool
     */
    public function checkSameLogin($login){
        $sql = "SELECT login FROM users WHERE login = '$login'";
        $result = $this->db->query($sql);
        if (empty($result)){
            return true;
        }else{
            return false;
        }
    }

    public function addUser($login,$pass,$email)
    {
        $date = \app\Components\TicketsApp::getDate();
        $passHash = password_hash($pass, PASSWORD_DEFAULT);
        $appHash = mb_strimwidth(md5($login), 0, 18);
        $sql = "INSERT INTO users (login,password,email,date_reg,app_hash) VALUES (:login,:password,:email,:date_reg,:app_hash)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':login', $login);
        $statement->bindValue(':password', $passHash);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':date_reg', $date);
        $statement->bindValue(':app_hash', $appHash);

        if($statement->execute()){
            return true;
        }


    }

}