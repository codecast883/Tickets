<?php

namespace app\Controllers;

use app\Components\TicketsApp;

class TicketsController extends Controller
{


    public function actionList()
    {


        $list = TicketsApp::getData('getAllTickets', 'Tickets', $this->id);
        require_once ROOT . '/../app/Views/list.php';

    }
}
