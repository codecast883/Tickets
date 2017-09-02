<?php
namespace app\Admin\Controllers;

use app\Admin\DB\Admin;
use app\Components\TicketsApp;


class TicketsController extends Controller
{

    public function actionList()
    {

        $formSuccess = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postFormat = $this->ticketsGateway->formatPostUpdate($_POST,$this->id);
            $this->ticketsGateway->ticketsUpdate($postFormat,$this->id);

            $formSuccess = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Изменения сохранены</div>';


        }
//        TicketsApp::debug();
        $ticketsList = $this->ticketsGateway->getAllTickets($this->id);
        require_once ROOT . '/../app/Admin/View/tickets.php';


    }


    public function actionDelete($idItem)
    {

        $this->ticketsGateway->deleteTicketById($idItem,$this->id);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/tickets?s');

    }

    public function actionAdd()
    {

        $this->ticketsGateway->addOneTickets($_POST,$this->id);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/tickets?add');


    }
}
