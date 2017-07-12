<?php
namespace app\Admin\DB;


class Admin
{

    /**
     * Admin constructor.
     */
    public function __construct()
    {


    }

    /**
     * @return bool
     */
    public static function checkAuth()
    {
        $cookie = $_COOKIE['usr'];
        if (empty($cookie)) {
            return false;
        } else {
            return $cookie;
        }

    }


}

	
	


