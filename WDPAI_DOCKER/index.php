<?php

require_once 'src/controllers/AppController.php';

$controller = new AppController();

$path = trim($_SERVER["REQUEST_URI"], "/");
$path = parse_url($path, PHP_URL_PATH);
$action = explode("/", $path)[0];
$action = $action == null ? 'login': $action;

switch($action) {
    case 'dashboard':
        $title = "PROJECTS";
        $projects = [];

        $controller->render($action)
        break;
    case 'login':
        $title = "LOGIN";

        $controller->render($action)
        break;
    default:
        $controller->render($action);
}

$controller->render($action);