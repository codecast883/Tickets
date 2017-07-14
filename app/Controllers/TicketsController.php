<?php
namespace app\Controllers;

use app\Components\TicketsApp;

class TicketsController
{


    public function actionList()
    {

        $list = TicketsApp::getData('getAllTickets','Tickets');
        TicketsApp::debug($_SERVER['REQUEST_URI']);
        require_once ROOT . '/../app/Views/list.php';


    }
}
