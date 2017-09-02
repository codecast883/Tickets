<?php
namespace app\Admin\Controllers;

use app\Admin\DB\EventsGateway;
use app\Admin\DB\Admin;
use app\Components\TicketsApp;


class OptionsController extends Controller
{



    public function actionList()
    {

        $allImages = TicketsApp::getDataAdmin('getAllHeaderImages','Events',$this->id);
        $optionsData = TicketsApp::getDataAdmin('getOptions','Events',$this->id);
        $formOptions = [];
        $fileErrors = [];
        $formSuccess = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formOptions['title'] = htmlentities(trim($_POST['title']));
            $formOptions['phone'] = htmlentities(trim($_POST['phone']));
            $formOptions['description'] = htmlentities(trim($_POST['description']));
            $formSuccess = '<div class="alert alert-success">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Изменения сохранены</div>';
            $errors = 0;


            if ($_FILES["fileMulti"]["error"][0] !== 4) {

                foreach ($_FILES["fileMulti"]["type"] as $value) {
                    if ($value != 'image/jpeg') {
                        if ($value != 'image/png') {
                            $fileErrors[] = 'Файл должен быть изображением';
                        }

                    }
                }

                foreach ($_FILES["fileMulti"]["size"] as $value) {
                    if ($value > 3145728) {
                        $fileErrors[] = 'Большой размер файла';
                    }
                }

                foreach ($_FILES["fileMulti"]["error"] as $value) {
                    if ($value != 0) {
                        $fileErrors[] = 'Ошибка, код ' . $value;
                    }

                    if ($value == 2) {
                        $fileErrors[] = 'Большой размер файла';
                    }
                }

                if (empty($fileErrors)) {
                    $dir = 'src/pictures/' . $this->appHash;
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    foreach ($_FILES["fileMulti"]["tmp_name"] as $value) {
                        if (is_uploaded_file($value)) {
                            $name = mt_rand(100000, 200000);

                            $path = '/' . $dir . '/' . $name . '.jpg';
                            if (move_uploaded_file($value, ROOT . $path)) {
                                $this->eventsGateway->insertImage($path, $this->id);
                            }

                        } else {
                            $fileErrors[] = "Ошибка загрузки файла";
                        }
                    }
                }
            }
            if (!empty($fileErrors)) {
                $errors = 1;
            } else {
                $this->eventsGateway->optionsUpdate($formOptions, $this->id);
                header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/options?saveOpt');
            }
        }

        require_once ROOT . '/../app/Admin/View/options.php';

    }
}