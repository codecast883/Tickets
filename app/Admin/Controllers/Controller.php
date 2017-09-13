<?php

namespace app\Admin\Controllers;

use app\Admin\DB\Admin;
use app\Admin\DB\AdminGateway;
use app\Admin\DB\EventsGateway;
use app\Admin\DB\PulloptionsGateway;
use app\DB\TicketsGateway;

class Controller
{
    protected $eventsGateway;
    protected $pulloptionsGateway;
    protected $ticketsGateway;
    protected $adminGateway;
    protected $userName;
    protected $id;
    protected $appHash;
    protected $eventId;
    protected $alert = '';

    public function __construct()
    {
        $this->adminGateway = new AdminGateway();
        $this->eventsGateway = new EventsGateway();
        $this->pulloptionsGateway = new PulloptionsGateway();
        $this->ticketsGateway = new TicketsGateway();



        if (Admin::checkAuth()) {
            if (!$this->userName = $this->adminGateway->getNameUser()) {
                header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/loginform');
                die;
            } else {
                $this->id = $this->adminGateway->getIdUser($this->userName);
                $this->appHash = $this->adminGateway->getUserHashById($this->id);

            }
        } else {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/loginform');
            die;
        }


    }



}