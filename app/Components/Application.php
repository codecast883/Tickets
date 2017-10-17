<?php

namespace app\Components;


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