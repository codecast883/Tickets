<?php

namespace app\Admin\Controllers;


class IndexController extends Controller
{
    public function actionIndex()
    {
        echo $this->userName;
        require_once ROOT . '/../app/Admin/View/index.php';
    }
}