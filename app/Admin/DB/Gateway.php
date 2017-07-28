<?php

namespace app\Admin\DB;


class Gateway
{
    protected $db;

    public function __construct()
    {
        global $dbo;
        $this->db = $dbo;

    }
}