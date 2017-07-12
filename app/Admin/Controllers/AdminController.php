<?php

namespace app\Admin\Controllers;

use app\Components\Validator;
use app\Admin\DB\AdminGateway;
use app\Admin\DB\Admin;
use app\Admin\DB\TicketsGateway;
use app\Components\TicketsApp;


class AdminController
{
    public $adminGateway;
    public $adminModel;
    public $ticketsGateway;


    public function __construct()
    {
        $this->adminGateway = new AdminGateway;
        $this->adminModel = new Admin;
        $this->ticketsGateway = new TicketsGateway;

    }


    public function actionLogin()
    {
        $formData = [];
        $error = [];

        $formData['login'] = '';
        $formData['password'] = '';

        $error[0]['login'] = '';
        $error[1]['login'] = '';

        $error[0]['password'] = '';
        $error[1]['password'] = '';


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $formData['login'] = htmlentities(trim($_POST['login']));
            $formData['password'] = htmlentities(trim($_POST['password']));
            // $formData['remember'] = htmlentities(trim($_POST['remember']));


            if ($errorCode = Validator::checkName($formData['login'])) {
                $error[0]['login'] = $errorCode[0];
                $error[1]['login'] = $errorCode[1];
            }

            if ($errorCode = Validator::checkName($formData['password'])) {
                $error[0]['password'] = $errorCode[0];
                $error[1]['password'] = $errorCode[1];
            }


            $checkForm = true;
            foreach ($error[1] as $key => $value) {
                if (!empty($value)) {
                    $checkForm = false;
                }
            }

            if ($checkForm) {
                $passHash = '';
                if ($passHash = $this->adminGateway->checkUser($formData['login'], $formData['password'])) {
                    setrawcookie('usr', $passHash, time() + 43600, '', '', 0, 1);
                    $this->adminGateway->setDateAuth($formData['login']);
                    header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin');

                } else {

                    $error[1]['login'] = "<span style='color:red';>Пользователь или пароль неверны</span>";

                }

            }

        }

        require_once ROOT . '/../app/Admin/View/login.php';
    }


    public function actionProfile()
    {
        if (!Admin::checkAuth()) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/loginform');
            die;
        }

        $listRequest = TicketsApp::getData('getAllRequest','Request');
        $this->ticketsGateway->cleanCountNewTickets();


        require_once ROOT . '/../app/Admin/View/dashboard.php';


    }


    public function actionIndex()
    {
        if (!Admin::checkAuth()) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/loginform');
            die;
        }
        require_once ROOT . '/../app/Admin/View/index.php';
    }


    public function actionLogout()
    {
        setrawcookie('usr', '', time() - 460000, '', '', 0, 1);
        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/profile');


    }

    public function actionRegister()
    {

        $formData = [];
        $error = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formData['login'] = htmlentities(trim($_POST['login']));
            $formData['email'] = htmlentities(trim($_POST['email']));
            $formData['password'] = htmlentities(trim($_POST['password']));
            $formData['passwordRetry'] = htmlentities(trim($_POST['passwordRetry']));

            if ($errorCode = Validator::checkName($formData['login'])) {
                $error[0]['login'] = $errorCode[0];
                $error[1]['login'] = $errorCode[1];
            }

            if ($errorCode = Validator::checkEmail($formData['email'])) {
                $error[0]['email'] = $errorCode[0];
                $error[1]['email'] = $errorCode[1];
            }

            if ($errorCode = Validator::checkName($formData['password'])) {
                $error[0]['password'] = $errorCode[0];
                $error[1]['password'] = $errorCode[1];
            }

            $checkForm = true;
            foreach ($error[1] as $key => $value) {
                if (!empty($value)) {
                    $checkForm = false;
                }
            }

            if ($checkForm) {
               if ($formData['password']!== $formData['passwordRetry']){
                   $error[1]['password'] = '<label class="control-label" for="inputError1">Введенные пароли не совпадают</label>';
                   $error[0]['password'] = 'has-error';
               }else{
                   if (!$this->adminGateway->checkSameLogin($formData['login'])){
                       $error[1]['login'] = '<label class="control-label" for="inputError1">Введенный пользователь уже существует</label>';
                       $error[0]['login'] = 'has-error';
                       TicketsApp::debug(TicketsApp::getDate());
                   }else{
                       $this->adminGateway->addUser($formData['login'],$formData['password'],$formData['email']);
                   }

               }

            }

        }
        require_once ROOT . '/../app/Admin/View/register.php';


    }
}