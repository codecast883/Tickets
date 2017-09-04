<?php

namespace app\Admin\Controllers;

use app\Admin\DB\EventsGateway;
use app\Components\Validator;
use app\Components\TicketsApp;

class EventsController extends Controller
{
    protected $events;

    public function __construct()
    {
        session_start();
        parent::__construct();
        $this->events = $this->eventsGateway->isEventsExist($this->id);


    }

    public function actionEvents()
    {

        $eventPic = function($event){
            return $this->eventsGateway->getAllEventsImages($event->event_id)[0]->pic_src;
        };

        require_once ROOT . '/../app/Admin/View/events.php';


    }

    public function actionEventsAdd()
    {

        if (!empty($_GET['step'])) {
            $step = htmlspecialchars($_GET['step']);

            if ($step == 1) {

                $formOptions = [];
                $fileErrors = [];
                $errors = 0;
                $filesSend = 0;
                $errorTitle = 0;
                $errorPhone = 0;
                $errorDescription = 0;
                $errorTitleMsg = "";
                $errorPhoneMsg = "";
                $errorDescriptionMsg = "";

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $formOptions['title'] = htmlentities(trim($_POST['title']));
                    $formOptions['phone'] = htmlentities(trim($_POST['phone']));
                    $formOptions['description'] = htmlentities(trim($_POST['description']));


                    $errorTitle = Validator::nCheckTitle($formOptions['title']);
                    $errorPhone = Validator::nCheckNumber($formOptions['phone']);
                    $errorDescription = Validator::nCheckTextArea($formOptions['description']);


                    if ($_FILES["file"]["error"] !== 4) {

                        if ($_FILES["file"]["type"] != 'image/jpeg') {
                            if ($_FILES["file"]["type"] != 'image/png') {
                                $fileErrors[] = 'Файл должен быть изображением';
                            }

                        }

                        if ($_FILES["file"]["size"] > 3145728) {
                            $fileErrors[] = 'Большой размер файла';
                        }

                        if ($_FILES["file"]["error"] != 0) {
                            $fileErrors[] = 'Ошибка, код ' . $_FILES["file"]["error"];
                        }

                        if ($_FILES["file"]["error"] == 2) {

                            $fileErrors[] = 'Большой размер файла';
                        }

                        if (empty($fileErrors)) {
                            $dir = 'src/pictures/' . $this->appHash;
                            if (!is_dir($dir)) {
                                mkdir($dir, 0777, true);
                            }

                            if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
                                $name = mt_rand(100000, 200000);

                                $path = '/' . $dir . '/' . $name . '.jpg';

                                if (move_uploaded_file($_FILES["file"]["tmp_name"], ROOT . $path)) {
                                    $filesSend = 1;
                                }


                            } else {
                                $fileErrors[] = "Ошибка загрузки файла";
                            }

                        }

                    }

                    if (!empty($fileErrors)) {
                        $errors = 1;
                    } else {
                        if ($errorTitle == 0 and $errorPhone == 0 and $errorDescription == 0) {
                            if ($this->eventsGateway->eventsInsert($formOptions, $this->id)) {
                                $lastEventId = $this->eventsGateway->getLastEvent($this->id)->event_id;
                                $this->eventsGateway->insertTitleImage($path,$lastEventId);
                                $_SESSION['lastEventId'] = $lastEventId;
                            }
//
                            setrawcookie('step', 1, time() + 4368, '', '', 0, 1);
                            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/events/add?step=2');
                        }

                    }


                }

                require_once ROOT . '/../app/Admin/View/eventsAdd.php';

            } elseif ($step == 2) {

                if ($_COOKIE['step'] != 1) {
                    header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/events/add?step=1');
                }
                $errorinfo = '';
                $styleError = '';
                $formOptions = [];
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $formOptions['daysAmount'] = htmlspecialchars(trim($_POST['daysAmount']));
                    $formOptions['ticketsAmount'] = htmlspecialchars(trim($_POST['ticketsAmount']));
                    $formOptions['ticketsPrice'] = htmlspecialchars(trim($_POST['ticketsPrice']));
                    $formOptions['from'] = htmlspecialchars(trim($_POST['from']));
                    $formOptions['to'] = htmlspecialchars(trim($_POST['to']));

                    if ($formOptions['daysAmount'] > 30) {
                        $errorinfo = 'Слишком много дней';
                        $styleError = 'display: inline-block;';

                    } elseif ($formOptions['ticketsAmount'] > 30) {
                        $errorinfo = 'Слишком много билетов';
                        $styleError = 'display: inline-block;';
                    } else {
                        $week = '';
                        $week = $this->eventsGateway->getGenerateWeek($formOptions, $this->id);
//                        TicketsApp::debug($week);
//                        $this->pulloptionsGateway->insertPullOptions($week, $this->id);
//                        $this->eventsGateway->setDayAmount($formOptions['daysAmount'], $this->id);
//                        setrawcookie('step', 1, time() - 460000, '', '', 0, 1);
//                        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/pulloptions');


                    }

                }

                require_once ROOT . '/../app/Admin/View/eventsAddWeek.php';
            }


        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found" . '<br>';
            die;
        }


    }
}
