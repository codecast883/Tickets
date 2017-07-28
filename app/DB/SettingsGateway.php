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
     * @return array
     */


    public function getFullOptions($userId)
    {
        $options = [];
        $fullOptions = [];
        $fullOptionsOut = [];
        $dayOfWeek = (new \DateTime())->format('N');
        $daysNumber = TicketsApp::getDataAdmin('getOptions', 'Events',$userId)->day_of_week;
        $dayAmount = TicketsApp::getDataAdmin('getOptions', 'Events',$userId)->day_amount;

        for ($i = 1; $i <= $daysNumber; $i++) {
            $sql = 'SELECT * FROM ' . ' options_pull_ticket ' . 'WHERE' . '  day_id=' . $i . ' AND user_id=' . $userId;

            $options[$i] = $this->db->query($sql);
        }
        $as = $options;
        $lastElement = array_pop($as);

        for ($i = 1; $i <= $dayAmount; $i++) {

            if ($dayOfWeek !== 1 and $i == 1) {
                $dayOfWeek--;
                for ($a = 1; $a <= $dayOfWeek; $a++) {
                    next($options);
                }
            }

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

