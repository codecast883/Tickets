<?php
namespace app\Admin\Controllers;

use app\Admin\DB\Admin;
use app\Components\TicketsApp;


class TicketsController extends Controller
{

    public function actionList($event)
    {
        if ($this->eventsGateway->getEvent($event)->user_id != $this->id) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/404');
        }
        $this->eventId = $event;
        $formSuccess = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postFormat = $this->ticketsGateway->formatPostUpdate($_POST, $this->eventId);
            $this->ticketsGateway->ticketsUpdate($postFormat, $this->eventId);

            $formSuccess = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Изменения сохранены</div>';


        }

        $ticketsList = $this->ticketsGateway->getAllTickets($this->eventId);
        require_once ROOT . '/../app/Admin/View/tickets.php';


    }


    public function actionDelete($idItem)
    {
        $eventId = $_GET['event'];
        $this->ticketsGateway->deleteTicketById($idItem, $eventId);


    }

    public function actionAdd($eventId)
    {

        $this->ticketsGateway->addOneTickets($_POST, $eventId);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/events/tickets/' . $eventId . '?add');


    }
}
