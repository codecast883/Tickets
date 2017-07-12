<?php
namespace app;
class Router
{
    private $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $routesPath = ROOT . '/../app/Components/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     *Функция возврата URL
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');

        }
    }

    /**
     * @param $uri
     * @return bool|mixed
     */
    private function getArrID($uri)
    {
        $uriArray = explode('/', $uri);
        $id = array_pop($uriArray);
        if (is_numeric($id) or preg_match("~(19|20)\d\d-((0[1-9]|1[012])-(0[1-9]|[12]\d)|(0[13-9]|1[012])-30|(0[13578]|1[02])-31)~", $id)) {
            return $id;
        }
        return false;

    }

    /**
     * @param $controllerName
     * @param $controllerMethod
     * @return bool
     */
    private function getIndexList($controllerName, $controllerMethod)
    {

        $controllerFile = ROOT . '/../app/Controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        }
        $controllerObj = new $controllerName;
        $controllerObj->$controllerMethod();
        return true;

    }

    /**
     * Run Application
     */
    public function run()
    {
        $uri = $this->getURI();

        // if ($uri == '') {
        // 	$this->getIndexList('AbiturientController','actionList');
        // 	die;
        // }

        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~^$uriPattern+$~", $uri)) {

                $segments = explode('/', $path);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                $firstUri = explode('/', $uri)[0];
                if ($firstUri == 'admin') {
                    $controllerFile = 'app\\Admin\\Controllers\\' . $controllerName;
                } else {
                    $controllerFile = 'app\\Controllers\\' . $controllerName;
                }

//                if (file_exists($controllerFile)) {
//                    require_once $controllerFile;
//                }

                $controllerObj = new $controllerFile;
                if ($idItem = $this->getArrID($uri)) {
                    $controllerObj->$actionName($idItem);
                    die;
                }
                $controllerObj->$actionName();
                die;

            }

        }

        echo "404 Not Found";
        header("HTTP/1.0 404 Not Found");
    }
}
