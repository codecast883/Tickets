<?php

namespace app\Controllers;

use app\Components\TicketsApp;


class CronController
{
    public $hash;
    public $id;

    public function __construct()
    {
        if (!empty($_GET['getiframe'])) {

            $this->hash = htmlspecialchars($_GET['getiframe']);

            $this->id = TicketsApp::getDataAdmin('getUserIdByHash', 'Admin', $this->hash);
        }

    }

    public function actionAdd($eventId)
    {

//        if (!empty($this->id)) {

        (new \app\DB\TicketsGateway)->pullNewTickets($eventId);

//        } else {
//            header("HTTP/1.0 404 Not Found");
//            echo "404 Not Found" . '<br>';
//            die;
//        }
    }

    public function actionUpdate()
    {

        if (!empty($this->id)) {

            (new \app\DB\TicketsGateway)->pullNewTickets($this->id, 1);

        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found" . '<br>';
            die;
        }
    }

    public function actionCron()
    {
        $ticketsGateway = new \app\DB\TicketsGateway;

        $allEventsId = (new \app\Admin\DB\EventsGateway)->getAllEventsId();

        if ($_GET['t'] === 's4FR4LhsHIyT') {

            foreach ($allEventsId as $key => $value) {
                $ticketsGateway->pullNewTickets($value->event_id, 1);
            }
        }
    }

}

?>