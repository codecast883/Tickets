<?php
namespace app\DB;


class Request
{
    public $name;
    public $phone;
    public $email;
    public $note;

    private $requestGateway;


    /**
     * RequestModel constructor.
     */
    public function __construct()
    {
        $this->requestGateway = new RequestGateway;
    }


    /**
     * @return array
     */
    public function allRequest()
    {
        $arrayRequest = [];
        $allRequest = $this->requestGateway->getAllRequest();

        foreach ($allRequest as $key => $value) {
            if ($value->no_time) {
                $value->time = 'Без времени';
            }
            $date = Day::dateFormat($value->date);
            $dateString = $date[0] . ' ' . $date[1];
            $arrayRequest[$key]['date'] = $dateString;

            if ((int)(substr($value->time, 0))) {
                $arrayRequest[$key]['time'] = Tickets::timeFormat($value->time);
            } else {
                $arrayRequest[$key]['time'] = $value->time;
            }

            $arrayRequest[$key]['price'] = $value->price;
            $arrayRequest[$key]['name'] = $value->name;
            $arrayRequest[$key]['phone'] = $value->phone;
            $arrayRequest[$key]['email'] = $value->email;
            $arrayRequest[$key]['note'] = $value->note;
            $arrayRequest[$key]['no_time'] = $value->no_time;
        }

        foreach ($arrayRequest as $key => $value) {
            $RequestObjects[] = (object)$value;
        }

        return $RequestObjects;
    }

}