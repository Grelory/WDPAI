<?php

require_once 'src/controllers/AppController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/auth/LoginController.php';

require_once 'src/controllers/AvailableController.php';

require_once 'src/repository/ProjectRepository.php';
require_once 'src/models/Project.php';
require_once 'Database.php';

$routing = [
    'dashboard' => [
        'controller' => new DashboardController(),
        'action' => 'dashboard',
        'access' => ['user', 'admin']
    ],
    'login' => [
        'controller' => new LoginController(),
        'action' => 'login',
        'access' => []
    ],
    'project' => [
        'controller' => new DashboardController(),
        'action' => 'project',
        'access' => ["user"]
    ],
    'search' => [
        'controller' => new DashboardController(),
        'action' => 'search',
        'access' => ["user"]
    ],
    'available' => [
        'controller' => new AvailableController(),
        'action' => 'available',
        'access' => []
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
    case "available":
        //TODO check if user is authenticated and has access to system
        $actionName = $routing[$action]['action'];
        $controller = $routing[$action]['controller'];
        $controller->$actionName();
        break;
    default:
        $controller->render($action);
        break;
}