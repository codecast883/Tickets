<?php
namespace app\Controllers;

use app\Components\TicketsApp;

class TicketsController
{


    public function actionList()
    {

        $list = TicketsApp::getData('getAllTickets','Tickets');
        TicketsApp::debug(\app\DB\Day::getMassDate(7));
        require_once ROOT . '/../app/Views/list.php';


    }
}
