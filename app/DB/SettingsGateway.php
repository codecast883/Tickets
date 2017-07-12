<?php

namespace app\DB;

use app\Components\TicketsApp;

class SettingsGateway
{
    private $db;


    public function __construct()
    {
        global $dbo;
        $this->db = $dbo;

    }

    /**
     * @return mixed
     */
    public function countDays()
    {
        $sql = 'SELECT COUNT(day_id) FROM ' . 'options_pull_day';
        $str = $this->db->query($sql)[0];
        foreach ($str as $value) {
            $count = $value;
        }
        return $count;
    }

    /**
     * @return array
     */
    public function getFullOptions()
    {
        $options = [];
        $fullOptions = [];
        $fullOptionsOut = [];
        $daysNumber = $this->countDays();
        $dayAmount = TicketsApp::getDataAdmin('getOptions', 'Options')->day_amount;

        for ($i = 1; $i <= $daysNumber; $i++) {
            $sql = 'SELECT * FROM ' . ' options_pull_ticket ' . 'WHERE' . '  day_id=' . $i;

            $options[$i] = $this->db->query($sql);
        }
        $as = $options;
        $lastElement = array_pop($as);

        for ($i = 1; $i <= $dayAmount; $i++) {
            $arrayIteration = current($options);

            $fullOptions[$i] = $arrayIteration;
            next($options);
            if ($arrayIteration[0]->id == $lastElement[0]->id) {
                reset($options);
            }
        }

        foreach ($fullOptions as $keys => $value) {

            foreach ($value as $key => $values) {
                $fullOptionsOut[$keys][$key]['day_id'] = $keys;
                $fullOptionsOut[$keys][$key]['time'] = $values->time;
                $fullOptionsOut[$keys][$key]['price'] = $values->price;
                $fullOptionsOut[$keys][$key]['no_time'] = $values->no_time;

            }
        }


        return $fullOptionsOut;

    }

}

