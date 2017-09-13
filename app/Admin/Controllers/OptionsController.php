<?php

namespace app\Admin\Controllers;

use app\Admin\DB\EventsGateway;
use app\Components\Validator;
use app\Admin\DB\Admin;
use app\Components\TicketsApp;


class OptionsController extends Controller
{


    public function actionList($event)
    {
        if ($this->eventsGateway->getEvent($event)->user_id != $this->id) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/404');
        }

        $this->eventId = $event;

        $allImages = TicketsApp::getDataAdmin('getAllEventsImages', 'Events', $this->eventId);
        $optionsData = TicketsApp::getDataAdmin('getEvent', 'Events', $this->eventId);


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

        $errorinfo = '';

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
                if ($errorTitle == 0
                    and $errorPhone == 0
                    and $errorDescription == 0
                ) {
                    $this->eventsGateway->optionsUpdate($formOptions, $this->eventId);

                    if ($filesSend) {
                        if ($this->eventsGateway->getAllEventsImages($this->eventId)) {
                            $this->eventsGateway->updateTitleImage($path, $this->eventId);
                        } else {
                            $this->eventsGateway->insertTitleImage($path, $this->eventId);
                        }

                    }
                    header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/events/options/' . $this->eventId . '?saveOpt');
                }

            }

        }

        require_once ROOT . '/../app/Admin/View/options.php';
    }


}
