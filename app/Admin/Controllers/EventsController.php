<?php

namespace app\Admin\Controllers;

use app\Admin\DB\EventsGateway;

use app\Components\TicketsApp;

class EventsController extends Controller
{
    protected $events;

    public function __construct()
    {
        parent::__construct();
        $this->events = $this->eventsGateway->isEventsExist($this->id);

        if ($this->events) {
            $this->alert = '<div class="alert alert-danger">Пока что нельзя создать больше 1-го ивента</div>';
        }
    }

    public function actionEvents()
    {

        $pictures = $this->eventsGateway->getAllHeaderImages($this->id);
        require_once ROOT . '/../app/Admin/View/events.php';

    }

    public function actionEventsAdd()
    {

        if (!empty($_GET['step'])) {
            $step = htmlspecialchars($_GET['step']);

            if ($step == 1) {
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
                                if (move_uploaded_file($value, ROOT . $path)) {
                                    $this->eventsGateway->insertImage($path, $this->id);
                                }

                            } else {
                                $fileErrors[] = "Ошибка загрузки файла";
                            }
                        }
                    }
                    $this->eventsGateway->optionsInsert($formOptions, $this->id);
                    setrawcookie('step', 1, time() + 4368, '', '', 0, 1);
                    header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/events/add?step=2');

                }

                require_once ROOT . '/../app/Admin/View/eventsAdd.php';

            } elseif ($step == 2) {
                if ($_COOKIE['step'] != 1){
                    header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/events');
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
                        $this->pulloptionsGateway->insertPullOptions($week, $this->id);
                        $this->eventsGateway->setDayAmount($formOptions['daysAmount'], $this->id);
                        setrawcookie('step', 1, time() - 460000, '', '', 0, 1);
                        header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/pulloptions');


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
