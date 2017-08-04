<?php

namespace app\Admin\Controllers;


class SettingsController extends Controller
{
    public function actionList()
    {

        require_once ROOT . '/../app/Admin/View/settings.php';
    }

    public function actionProfile()
    {

        require_once ROOT . '/../app/Admin/View/profile.php';
    }
}