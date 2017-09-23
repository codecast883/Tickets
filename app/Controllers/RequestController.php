<?php

namespace app\Controllers;

use app\DB\Request;
use app\DB\RequestGateway;
use app\Components\Validator;
use app\Components\TicketsApp;


class RequestController extends Controller
{


    public $requestModel;
    public $requestGateway;

    public function __construct()
    {
        parent::__construct();
        $this->requestGateway = new RequestGateway;
        $this->requestModel = new Request;
        if (!$_GET['id']) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/404');
        }
    }

    public function actionAdd($idItem)
    {
        $services = TicketsApp::getDataAdmin('getAllServices', "Services", $this->eventId);
        $priceCountPeoples = TicketsApp::getDataAdmin('getPriceCountPeoples', "Services", $this->eventId);
        $priceCountPeoplesJson = json_encode($priceCountPeoples);


        /*
        *Validation Form
        */
        $ticketData = TicketsApp::getData('getTicketsById', 'Tickets', $idItem, $this->eventId);
        $formData = [];
        $error = [];
        $servicesIds = [];

        foreach ($this->requestModel as $key => $value) {
            $formData[$key] = '';
            $error[0][$key] = '';
            $error[1][$key] = '';
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Проходимся по POST данным и вытаскиваем все id сервисов
            foreach ($_POST as $key => $value) {
                if (is_int($key)) {
                    $servicesIds[] = $key;
                }
            }

            //Если сервисы выбраны, берём из базы их цены и складываем в общую цену
            $totalPrice = 0;
            if ($servicesIds) {
                foreach ($servicesIds as $serviceId) {
                    $servicePrice = TicketsApp::getDataAdmin('getService', "Services", $serviceId)[0]->price;
                    $totalPrice += $servicePrice;
                }
            }

            //Проверка на кол-во участников

            foreach ($priceCountPeoples as $countPeople) {
                if ($_POST['countPeoples'] == $countPeople->count_peoples) {
                    $totalPrice += $countPeople->price;
                }
            }
            //Формируется общая цена на билет
            $totalPrice += $ticketData->price;


            $formData['name'] = htmlentities(trim($_POST['name']));
            $formData['phone'] = htmlentities(trim($_POST['phone']));
            $formData['email'] = htmlentities(trim($_POST['id']));
            $formData['note'] = htmlentities(trim($_POST['note']));
            $formData['price'] = htmlentities(trim($totalPrice));
            $formData['count_peoples'] = htmlentities(trim($_POST['countPeoples']));

            if ($errorCode = Validator::checkName($formData['name'])) {
                $error[0]['name'] = $errorCode[0];
                $error[1]['name'] = $errorCode[1];
            }

            if ($errorCode = Validator::checkNumber($formData['phone'])) {
                $error[0]['phone'] = $errorCode[0];
                $error[1]['phone'] = $errorCode[1];
            }


            if ($errorCode = Validator::checkTextArea($formData['note'])) {
                $error[0]['note'] = $errorCode[0];
                $error[1]['note'] = $errorCode[1];
            }


            $checkForm = true;
            foreach ($error[1] as $key => $value) {
                if (!empty($value)) {
                    $checkForm = false;
                }
            }

            if ($checkForm) {

                foreach ($ticketData as $key => $value) {
                    if ($key == 'id' or $key == 'price') {
                        continue;
                    }

                    $formData[$key] = $value;
                }
                $idsService = '';
                foreach ($_POST as $key => $value) {
                    if (is_int($key)) {
                        $idsService[] = $key;
                    }
                }

                $this->requestGateway->addRequest($formData, $this->eventId);
                $lastRequestId = $this->requestGateway->getLastRequest($this->eventId)[0]->id;
                if ($idsService) {
                    $this->requestGateway->addRequestService($idsService, $lastRequestId);
                }


                $date = new \DateTime();
                $timeStamp = $date->getTimestamp();
                $getMorgenDate = $date->add(new \DateInterval('P1D'))->format('Y-m-d');
                $morgenTimeStamp = (new \DateTime($getMorgenDate))->getTimestamp();
                $time = $morgenTimeStamp - $timeStamp;

                // TicketsApp::debug(strftime("%d,%m,%Y; %H:%M:%S", time() + $time));

                $countCookie = $_COOKIE['count'];
                if (!$countCookie) {
                    setrawcookie("count", 1, time() + 163600, '/', '', 0, 1);
                } else {
                    $countCookie += 1;
                    setrawcookie("count", $countCookie, time() + 163600, '/', '', 0, 1);
                }

                if (!$countCookie) {
                    setrawcookie("reserve[1][id]", $ticketData->id, time() + $time, '/', '', 0, 1);
                    setrawcookie("reserve[1][event_id]", $ticketData->event_id, time() + $time, '/', '', 0, 1);
                } else {
                    setrawcookie("reserve[$countCookie][id]", $ticketData->id, time() + $time, '/', '', 0, 1);
                    setrawcookie("reserve[$countCookie][event_id]", $ticketData->event_id, time() + $time, '/', '', 0, 1);
                }

                header('Location: https://' . $_SERVER['SERVER_NAME'] . '/request/done?getiframe=' . $this->hash . '&id=' . $this->eventId);

            }


        }


        require_once ROOT . '/../app/Views/form.php';


    }


    public function actionDone()
    {
        require_once ROOT . '/../app/Views/done.php';

    }
}

