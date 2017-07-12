<?php

namespace app\Components;

use app\Router;

class Application
{
    private $router;



    function __construct()
    {

        $this->router = new Router;


    }


    public function run()
    {
        $this->router->run();
    }


}