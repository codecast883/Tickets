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
        $ticketData = TicketsApp::getData('getTicketsById', 'Tickets', $idItem, $this->eventId);
        $priceCountPeoples = TicketsApp::getDataAdmin('getPriceCountPeoples', "Services", $this->eventId);

        /*FOR JS*/
        $priceCountPeoplesJson = json_encode($priceCountPeoples);
        $calculationPriceType = $this->eventData->calculation_price_type;
        /*FOR JS*/


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $totalPrice = 0; //Переменная где будем суммировать общую цену

            $formData = [];
            $servicesIds = [];


            $prices = json_decode($_POST['dataPrices']);

            //Проходимся по POST данным и вытаскиваем все id сервисов
            foreach ($_POST as $key => $value) {
                if (is_int($key)) {
                    $servicesIds[] = $key;
                }
            }

            //Если сервисы выбраны, берём из базы их цены и складываем в общую цену

            if ($servicesIds) {
                foreach ($servicesIds as $serviceId) {
                    $servicePrice = TicketsApp::getDataAdmin('getService', "Services", $serviceId)[0]->price;
                    $totalPrice += $servicePrice;
                }
            }

            //Проверка на кол-во участников
            //Формируется общая цена на билет
            $formData['count_peoples'] = htmlentities(trim($_POST['countPeoples']));
            $totalPrice += $prices->$formData['count_peoples'];

            $formData['name'] = htmlentities(trim($_POST['name']));
            $formData['phone'] = htmlentities(trim($_POST['phone']));
            $formData['note'] = htmlentities(trim($_POST['note']));
            $formData['price'] = htmlentities(trim($totalPrice));

            $formData['vkId'] = htmlentities(trim($_POST['vkId']));
            $formData['second_name'] = htmlentities(trim($_POST['surname']));
            $formData['date_of_birth'] = htmlentities(trim($_POST['bdate']));
            $formData['university_name'] = htmlentities(trim($_POST['university_name']));
            $formData['faculty_name'] = htmlentities(trim($_POST['faculty_name']));
            $formData['city'] = htmlentities(trim($_POST['city']));


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


        }


        require_once ROOT . '/../app/Views/form.php';


    }


    public function actionDone()
    {
        require_once ROOT . '/../app/Views/done.php';

    }
}

