<?php

require_once 'src/controllers/AppController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/repository/ProjectRepository.php';
require_once 'src/models/Project.php';
require_once 'Database.php';

$routing = [
    'dashboard' => [
        'controller' => 'DashboardController',
        'action' => 'dashboard',
        'access' => ['user', 'admin']
    ],
    'login' => [
        'controller' => 'SecurityController',
        'action' => 'login',
        'access' => []
    ],
    'project' => [
        'controller' => 'DashboardController',
        'action' => 'project',
        'access' => ["user"]
    ],
    'search' => [
        'controller' => 'DashboardController',
        'action' => 'search',
        'access' => ["user"]
    ]
    ];

$controller = new AppController();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);
$action = explode("/", $path)[0];
$action = $action == null ? 'login': $action;

switch($action){
    case "dashboard":
    case "project":
    case "search":
    case "login":
        //TODO check if user is authenticated and has access to system
        $controllerName = $routing[$action]['controller'];
        $actionName = $routing[$action]['action'];
        $controller = new $controllerName;
        $controller->$actionName();
        break;
    default:
        $controller->render($action);
        break;
}