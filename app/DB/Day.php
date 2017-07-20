<?php
namespace app\DB;
class Day
{



    /**
     * @param $dayNumber
     * @return array
     */
    public static function getMassDate($dayNumber)
    {
        $massDate = [];
        $dateTime = new \DateTime;
        for ($i = 0; $i < $dayNumber; $i++) {
            if ($i !== 0){
                $day = $dateTime->add(new \DateInterval('P1D'));
                $date = $day->format('Y-m-d');
                $massDate[] = $date;
            }else{
                $massDate[] = $dateTime->format('Y-m-d');
            }

        }


        return $massDate;
    }

    /**
     * @param $date
     * @return array
     */
    public static function dateFormat($date)
    {

        $monLocale = ['month' => [
            'Jan' => 'Января',
            'Feb' => 'Февраля',
            'Mar' => 'Марта',
            'Apr' => 'Апреля',
            'May' => 'Мая',
            'Jun' => 'Июня',
            'Jul' => 'Июля',
            'Aug' => 'Августа',
            'Sep' => 'Сентября',
            'Oct' => 'Октября',
            'Nov' => 'Ноября',
            'Dec' => 'Декабря',
        ],
            'dweek' => [
                'Mon' => 'Понедельник',
                'Tue' => 'Вторник',
                'Wed' => 'Среда',
                'Thu' => 'Четверг',
                'Fri' => 'Пятница',
                'Sat' => 'Суббота',
                'Sun' => 'Воскресенье',


            ]
        ];

        $format = strftime("%d/%b/%a", strtotime($date));

        $mass = explode('/', $format);

        foreach ($mass as $key => $value) {
            if ($key == 0) {
                continue;
            }
            if ($key == 1) {
                $mass[1] = $monLocale['month'][$value];
            }
            if ($key == 2) {
                $mass[2] = $monLocale['dweek'][$value];
            }
        }

        return $mass;


    }


}
