<?php

namespace app\Controllers;

use app\Components\TicketsApp;

class TicketsController extends Controller
{


    public function actionList()
    {

        TicketsApp::debug(TicketsApp::getData('getFullOptions','Settings'));
        $list = TicketsApp::getData('getAllTickets', 'Tickets', $this->id);
        require_once ROOT . '/../app/Views/list.php';

    }
}