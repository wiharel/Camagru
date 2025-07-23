<?php

class Router {
    public function handleRequest() {
        $page = $_GET['page'] ?? 'home';
        $action = $_GET['action'] ?? 'index';

        $controllerName = ucfirst($page) . 'Controller';
        $file = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (file_exists($file)) {
            require_once $file;
            $controller = new $controllerName();

            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                echo "Action '$action' introuvable.";
            }
        } else {
            echo "Page '$page' introuvable.";
        }
    }
}
