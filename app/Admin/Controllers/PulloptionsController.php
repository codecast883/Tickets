<?php
namespace app\Admin\Controllers;

use app\Components\TicketsApp;

class PulloptionsController extends Controller
{


    public function actionList()
    {



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//

            $postFormat = $this->pulloptionsGateway->formatPostUpdate($_POST,$this->id);

            $this->pulloptionsGateway->ticketsUpdate($postFormat,$this->id);
            $formSuccess = '<div class="alert alert-success">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Изменения сохранены</div>';


        }


        $fullOptions = TicketsApp::getData('getWeekOptions','Settings',$this->id);

        require_once ROOT . '/../app/Admin/View/pull.php';

    }


    public function actionDelete($idItem)
    {

        $this->pulloptionsGateway->deleteTicketById($idItem);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/pulloptions?s');

    }

    public function actionAdd()
    {

        $this->pulloptionsGateway->addOneTickets($_POST,$this->id);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/pulloptions?add');


    }

}