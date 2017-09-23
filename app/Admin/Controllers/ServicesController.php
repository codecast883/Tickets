<?php


namespace app\Admin\Controllers;

use app\Admin\DB\ServicesGateway;
use app\Components\TicketsApp;

class ServicesController extends Controller
{
    protected $servicesGateway;

    public function __construct()
    {
        parent::__construct();
        $this->servicesGateway = new ServicesGateway;

    }

    public function actionList($event)
    {
        if ($this->eventsGateway->getEvent($event)->user_id != $this->id) {
            header('Location: https://' . $_SERVER['SERVER_NAME'] . '/admin/404');
        }

        $this->eventId = $event;
        $priceCountPeoples = TicketsApp::getDataAdmin('getPriceCountPeoples', "services", $this->eventId);
        $services = $this->servicesGateway->getAllServices($this->eventId);
        $eventData = $this->eventsGateway->getEvent($this->eventId);

        require_once ROOT . '/../app/Admin/View/services.php';
    }

    public function actionAdd($eventId)
    {

        $formData['title'] = htmlentities(trim($_POST['title']));
        $formData['price'] = htmlentities(trim($_POST['price']));

        if ($this->servicesGateway->insertService($eventId, $formData)) {

            $data = [];
            $lastService = $this->servicesGateway->getLastService($eventId);

            foreach ($lastService as $key => $value) {
                $data["last_service"][$key] = $value;
            }
            $data['GET'] = $formData;

            header("Content-Type:application/json");
            echo json_encode($data);
        }

    }

    public function actionUpdateCountPeoples($eventId)
    {
        $formData['minPeople'] = htmlentities(trim($_POST['peopleMin']));
        $formData['maxPeople'] = htmlentities(trim($_POST['peopleMax']));

        $this->eventsGateway->updateUpdateCountPeoples($formData, $eventId);
    }

    public function actionDelete($idItem)
    {
        $eventId = $_GET['event'];
        $this->servicesGateway->deleteService($eventId, $idItem);

    }

    public function actionDeletePrice($idItem)
    {
        $eventId = $_GET['event'];
        $this->servicesGateway->deletePriceCountPeoples($eventId, $idItem);

    }

    public function actionAddPriceCountPeoples($eventId)
    {

        $formData['count_peoples'] = htmlentities(trim($_POST['from']));
        $formData['price'] = htmlentities(trim($_POST['price']));
//TicketsApp::debug( $formData);
        if ($this->servicesGateway->insertPriceCountPeoples($eventId, $formData)) {

            $data = [];
            $lastService = $this->servicesGateway->getLastPriceCountPeoples($eventId);

            foreach ($lastService as $key => $value) {
                $data["last_price"][$key] = $value;
            }


            header("Content-Type:application/json");
            echo json_encode($data);
        }

    }

}