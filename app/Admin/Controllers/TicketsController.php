<?php
namespace app\Admin\Controllers;

use app\DB\TicketsGateway;
use app\Admin\DB\Admin;
use app\Components\TicketsApp;


class TicketsController
{
    private $ticketsGateway;

    public function __construct()
    {
        $this->ticketsGateway = new TicketsGateway;

    }

    public function actionList()
    {
        if (!Admin::checkAuth()) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/loginform');
            die;
        }

        $formSuccess = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postFormat = $this->ticketsGateway->formatPostUpdate($_POST);
            $this->ticketsGateway->ticketsUpdate($postFormat);

            $formSuccess = '<div class="alert alert-success">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Изменения сохранены</div>';


        }


        require_once ROOT . '/../app/Admin/View/tickets.php';


    }


    public function actionDelete($idItem)
    {

        $this->ticketsGateway->deleteTicketById($idItem);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/tickets');

    }

    public function actionAdd()
    {

        $this->ticketsGateway->addOneTickets($_POST);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/tickets');


    }
}
