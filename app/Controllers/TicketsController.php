<?php

namespace app\Controllers;

use app\Components\TicketsApp;


class TicketsController extends Controller
{


    public function actionList()
    {


        $events = $this->eventsGateway->isEventsExist($this->id);
        $countEvents = count($events);

        if ($countEvents == 1) {
            $eventId = $events[0]->event_id;
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/tickets/event?getiframe=' . $this->hash . '&id=' . $eventId);

        } elseif ($countEvents > 1) {

            require_once ROOT . '/../app/Views/eventsList.php';
        }


    }

    public function actionEvent()
    {


        if (!$_GET['id']) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/404');
        }
//        $reservedCookie = $_COOKIE['reserve'];
//        if ($reservedCookie){
//            ksort($reservedCookie);
//        }

        $list = TicketsApp::getData('getAllTickets', 'Tickets', $this->eventId);

        require_once ROOT . '/../app/Views/list.php';
    }
}
