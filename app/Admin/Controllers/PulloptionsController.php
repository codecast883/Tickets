<?php
namespace app\Admin\Controllers;

use app\Admin\DB\PulloptionsGateway;
use app\Admin\DB\Admin;
use app\Components\TicketsApp;

class PulloptionsController
{
    private $pulloptionsGateway;


    public function __construct()
    {
        $this->pulloptionsGateway = new PulloptionsGateway;


    }

    public function actionList()
    {

        if (!Admin::checkAuth()) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/loginform');
            die;
        }


        $formSuccess = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postFormat = $this->pulloptionsGateway->formatPostUpdate($_POST);
            $this->pulloptionsGateway->ticketsUpdate($postFormat);

            $formSuccess = '<div class="alert alert-success">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Изменения сохранены</div>';


        }


        $fullOptions = TicketsApp::getData('getFullOptions','Settings');

        require_once ROOT . '/../app/Admin/View/pull.php';

    }


    public function actionDelete($idItem)
    {

        $this->pulloptionsGateway->deleteTicketById($idItem);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/pulloptions');

    }

    public function actionAdd()
    {

        $this->pulloptionsGateway->addOneTickets($_POST);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/pulloptions');


    }

}