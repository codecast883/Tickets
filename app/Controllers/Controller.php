<?php

namespace app\Controllers;

use app\Components\TicketsApp;

class Controller
{
    public $header;
    public $hash;
    public $id;

    public function __construct()
    {
        if (!empty($_GET['getiframe'])) {

            $this->hash = htmlspecialchars($_GET['getiframe']);

            if ($this->id = TicketsApp::getDataAdmin('getUserIdByHash', 'Admin', $this->hash)) {

//
                $this->header = TicketsApp::getDataAdmin('getOptions', 'Events',$this->id);

            } else {
                header("HTTP/1.0 404 Not Found");
                echo "404 Not Found" . '<br>';
                die;
            }

        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found" . '<br>';
            die;
        }


    }


}