<?php


namespace app\Admin\Controllers;
use app\DB\RequestGateway;

class RequestController extends Controller
{
    protected $requestGateway;
    public function __construct()
    {
        parent::__construct();
        $this->requestGateway = new RequestGateway();

    }

    public function ActionList()
    {
        (new \app\Admin\DB\TicketsGateway)->cleanCountNewTickets($this->id);
        $listRequest = $this->requestGateway->getAllRequest($this->id);
        require_once ROOT . '/../app/Admin/View/requestList.php';
    }
}