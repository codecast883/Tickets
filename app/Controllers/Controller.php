<?php

namespace app\Controllers;

use app\Components\TicketsApp;
use app\Admin\DB\EventsGateway;

class Controller
{
    protected $eventData;
    protected $headerImg;
    protected $hash;
    protected $id;
    protected $eventId;
    protected $eventsGateway;


    public function __construct()
    {
        $this->eventsGateway = new EventsGateway;

        if (!empty($_GET['getiframe'])) {
            if (!empty($_GET['id'])) {
                $this->eventId = htmlspecialchars($_GET['id']);
                $this->eventData = TicketsApp::getDataAdmin('getEvent', 'Events', $this->eventId);
                $this->headerImg = TicketsApp::getDataAdmin('getAllEventsImages', 'Events', $this->eventId);


            }

            $this->hash = htmlspecialchars($_GET['getiframe']);

            if (!$this->id = TicketsApp::getDataAdmin('getUserIdByHash', 'Admin', $this->hash)) {

                header("HTTP/1.0 404 Not Found");
                echo "404 Not Found" . '<br>';
                die;

            }


        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found" . '<br>';
            die;
        }


    }


}