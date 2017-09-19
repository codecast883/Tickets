<?php


namespace app\Admin\Controllers;

use app\Components\TicketsApp;
use app\DB\RequestGateway;


class RequestController extends Controller
{
    protected $requestGateway;

    public function __construct()
    {
        parent::__construct();
        $this->requestGateway = new RequestGateway();

    }

    public function ActionList($event)
    {
        $eventData = $this->eventsGateway->getEvent($event);
        if ($eventData->user_id != $this->id) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/404');
        }

        $this->eventId = $event;

        (new \app\Admin\DB\TicketsGateway)->cleanCountNewTickets($this->eventId);
        $listRequest = $this->requestGateway->getAllRequest($this->eventId);


        require_once ROOT . '/../app/Admin/View/requestList.php';
    }
}