<?php

namespace app\Admin\Controllers;

use app\Admin\DB\Admin;
use app\Admin\DB\AdminGateway;
use app\Admin\DB\EventsGateway;

class Controller
{
    protected $eventsGateway;
    private $adminGateway;
    public $userName;
    public $id;

    public function __construct()
    {
        $this->adminGateway = new AdminGateway();
        $this->eventsGateway = new EventsGateway();

        if (Admin::checkAuth()) {
            if (!$this->userName = $this->adminGateway->getNameUser()) {
                header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/loginform');
                die;
            } else {
                $this->id = $this->adminGateway->getIdUser($this->userName);
            }
        } else {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/loginform');
            die;
        }

    }



}