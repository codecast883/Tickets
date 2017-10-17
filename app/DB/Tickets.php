<?php
namespace app\DB;
class Tickets
{
    /**
     * @param $time
     * @return string
     */
    public static function timeFormat($time)
    {
        $date = new \DateTime($time);
        return $date->format('H:i');
    }

    /**
     * @param $dateString
     * @return bool
     */
    public static function isDisabled($dateString)
    {
        $todayDate = new \DateTime();
        $date = $todayDate->format('Y-m-d' . ' 00:00:00');
        $todayDate24 = new \DateTime($date);
        $todayDate24->format('Y-m-d');
        $timeStamp = $todayDate24->getTimestamp();

        $dates = new \DateTime($dateString);
        $dates->format('Y-m-d');
        $timeStamp2 = $dates->getTimestamp();

        if ($timeStamp > $timeStamp2) {
            return true;

        }
        return false;


    }


}
