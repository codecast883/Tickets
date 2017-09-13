<?php
namespace app\Admin\Controllers;

use app\Components\TicketsApp;

class PulloptionsController extends Controller
{


    public function actionList($event)
    {

        if ($this->eventsGateway->getEvent($event)->user_id != $this->id) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/404');
        }

        $this->eventId = $event;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//

            $postFormat = $this->pulloptionsGateway->formatPostUpdate($_POST, $this->eventId);

            $this->pulloptionsGateway->ticketsUpdate($postFormat, $this->eventId);

        }


        $fullOptions = TicketsApp::getData('getWeekOptions', 'Settings', $this->eventId);

        require_once ROOT . '/../app/Admin/View/pull.php';

    }


    public function actionDelete($idItem)
    {

        $this->pulloptionsGateway->deleteTicketById($idItem);


    }

    public function actionAdd($eventId)
    {

        $this->pulloptionsGateway->addOneTickets($_POST, $eventId);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/events/pulloptions/' . $eventId . '?add');


    }

}