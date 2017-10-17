<?php
/**
 * Created by PhpStorm.
 * User: Yaroslav
 * Date: 09.10.2017
 * Time: 17:45
 */

namespace app\Admin\Controllers;


class TestController
{
    public function actionTest()
    {
        require_once ROOT . '/../app/Admin/View/test.php';
    }
}