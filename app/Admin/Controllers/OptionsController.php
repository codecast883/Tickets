<?php
namespace app\Admin\Controllers;

use app\Admin\DB\OptionsGateway;
use app\Admin\DB\Admin;
use app\Components\TicketsApp;


class OptionsController
{

    private $optionsGateway;

    public function __construct()
    {

        $this->optionsGateway = new OptionsGateway;

    }


    public function actionList()
    {
        if (!Admin::checkAuth()) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/loginform');
            die;
        }
        $allImages = TicketsApp::getDataAdmin('getAllHeaderImages','Options');
        $optionsData = TicketsApp::getDataAdmin('getOptions','Options');
        $formOptions = [];
        $fileErrors = [];
        $formSuccess = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formOptions['title'] = htmlentities(trim($_POST['title']));
            $formOptions['phone'] = htmlentities(trim($_POST['phone']));
            $formOptions['description'] = htmlentities(trim($_POST['description']));
            $formSuccess = '<div class="alert alert-success">
  			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Изменения сохранены</div>';
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

                $this->optionsGateway->deleteAllImages();

                foreach ($_FILES["fileMulti"]["tmp_name"] as $value) {
                    if (is_uploaded_file($value)) {
                        $name = mt_rand(100000, 200000);
                        $path = '/src/pictures/' . $name . '.jpg';
                        if ( move_uploaded_file($value, ROOT . $path)){
                            $this->optionsGateway->insertImage($path);
                        }

                    } else {
                        $fileErrors[] = "Ошибка загрузки файла";
                    }
                }
            }
            $this->optionsGateway->optionsUpdate($formOptions);
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/options');

        }

        require_once ROOT . '/../app/Admin/View/options.php';

    }
}