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
        $services = TicketsApp::getDataAdmin('getAllServices', "services", $this->eventId);

        /*
        *Validation Form
        */
        $ticketData = TicketsApp::getData('getTicketsById', 'Tickets', $idItem, $this->eventId);
        $formData = [];
        $error = [];


        foreach ($this->requestModel as $key => $value) {
            $formData[$key] = '';
            $error[0][$key] = '';
            $error[1][$key] = '';
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $formData['name'] = htmlentities(trim($_POST['name']));
            $formData['phone'] = htmlentities(trim($_POST['phone']));
            $formData['email'] = htmlentities(trim($_POST['email']));
            $formData['note'] = htmlentities(trim($_POST['note']));
            $formData['price'] = htmlentities(trim($_POST['totalPrice']));

            if ($errorCode = Validator::checkName($formData['name'])) {
                $error[0]['name'] = $errorCode[0];
                $error[1]['name'] = $errorCode[1];
            }

            if ($errorCode = Validator::checkNumber($formData['phone'])) {
                $error[0]['phone'] = $errorCode[0];
                $error[1]['phone'] = $errorCode[1];
            }

            if ($errorCode = Validator::checkEmail($formData['email'])) {
                $error[0]['email'] = $errorCode[0];
                $error[1]['email'] = $errorCode[1];
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
                $this->requestGateway->addRequestService($idsService, $lastRequestId);
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

