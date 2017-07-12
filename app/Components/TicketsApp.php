<?php
namespace app\Components;

class TicketsApp{


    public static function debug($object){
        echo '<pre>';
         print_r($object);
        echo '</pre>';

    }


    public static function getDate(){
        $date = new \DateTime;
        $dateFormat = $date->format('Y-m-d H:i:s');
        return  $dateFormat;
    }

    /**
     * @param $function
     * @param $model
     * @param string $value
     * @return mixed
     */
    public static function getData($function, $model, $value = ''){
        $objName = '\\app\\DB\\' . $model . 'Gateway';
        $obj = new $objName;
        return $obj->$function($value);
    }


    /**
     * @param $function
     * @param $model
     * @param string $value
     * @return mixed
     */
    public static function getDataAdmin($function, $model,$value = ''){
        $objName = '\\app\\Admin\\DB\\' . $model . 'Gateway';
        $obj = new $objName;
        return $obj->$function($value);
    }

}