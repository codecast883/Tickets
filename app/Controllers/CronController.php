<?php
namespace app\Controllers;
use app\Components\TicketsApp;


class CronController
{

    public function actionAdd()
    {

        TicketsApp::getData('pullNewTickets','Tickets');
    }


}

?>