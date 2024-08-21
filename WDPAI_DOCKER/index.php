<?php

require_once 'src/controllers/AppController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/auth/LoginController.php';
require_once 'src/controllers/auth/RegistrationController.php';

require_once 'src/controllers/AvailableController.php';

require_once 'src/repository/ProjectRepository.php';
require_once 'src/models/Project.php';
require_once 'Database.php';

$controller = new AppController();
$loginController = new LoginController();
$dashboardController = new DashboardController();
$availableController = new AvailableController();
$registrationController = new RegistrationController();

$routing = [
    'user/available' => [
        'action' => array($availableController, 'available'),
        'params' => [],
        'access' => []
    ],

    'auth/login' => [
        'action' => array($loginController, 'login'),
        'params' => [],
        'access' => []
    ],
    'auth/registration' => [
        'action' => array($registrationController, 'registration'),
        'params' => [],
        'access' => []
    ]
];

$uri = $_SERVER['REQUEST_URI'];
$path = trim(parse_url($uri, PHP_URL_PATH), '/');

$action = $routing[$path]['action'];
$args = $routing[$path]['params'];
// TODO check the access


if ($action == null) {
    // TODO change default path
    $action = array($controller, 'render');
    $args = ['auth/login'];
}

$action = $action == null ? array($controller, 'render') : $action;

call_user_func_array($action, $args);

