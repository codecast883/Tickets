<?php

namespace app\Admin\Controllers;

use app\Admin\DB\EventsGateway;
use app\Components\TicketsApp;

class EventsController extends Controller
{


    public function actionEvents()
    {
        require_once ROOT . '/../app/Admin/View/events.php';
    }

    public function actionEventsAdd()
    {


        $formOptions = [];
        $fileErrors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formOptions['title'] = htmlentities(trim($_POST['title']));
            $formOptions['phone'] = htmlentities(trim($_POST['phone']));
            $formOptions['description'] = htmlentities(trim($_POST['description']));

            foreach ($_FILES["fileMulti"]["size"] as $value) {
                if ($value > 3145728) {
                    $fileErrors[] = 'Слишком большой файл';
                }
            }

            foreach ($_FILES["fileMulti"]["type"] as $value) {
                if ($value != 'image/jpeg') {
                    $fileErrors[] = 'Файл должен быть изображением';
                }
            }

            foreach ($_FILES["fileMulti"]["error"] as $value) {
                if ($value != 0) {
                    $fileErrors[] = '$value';
                }
            }

            if (empty($fileErrors)) {

                foreach ($_FILES["fileMulti"]["tmp_name"] as $value) {
                    if (is_uploaded_file($value)) {
                        $name = mt_rand(100000, 200000);
                        $path = '/src/pictures/' . $name . '.jpg';
                        if ( move_uploaded_file($value, ROOT . $path)){
                            $this->eventsGateway->insertImage($path,$this->id);
                        }

                    } else {
                        $fileErrors[] = "Ошибка загрузки файла";
                    }
                }
            }
            $this->eventsGateway->optionsInsert($formOptions,$this->id);
//            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/options');

        }

        require_once ROOT . '/../app/Admin/View/eventsAdd.php';
    }
}
