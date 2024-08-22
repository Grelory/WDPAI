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
    'user/dashboard' => [
        'action' => array($availableController, 'available'),
        'params' => [],
        'access' => ['USER']
    ],
    'user/available' => [
        'action' => array($availableController, 'available'),
        'params' => [],
        'access' => ['USER']
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
$access = $routing[$path]['access'];

$user = $loginController->searchUser();

if ($action == null) {
    // TODO implement screen
    echo "404 Not found";
    die();
}

if ($user != null && in_array($path, array('auth/login', 'auth/registration'))) {
    $loginController->redirectByRole($user->getUserRole());
    die();
}

if (empty($access)) {
    call_user_func_array($action, $args);
    die();
}

if ($user == null) {
    $loginController->unauthorized();
    die();
}

if (in_array($user->getUserRole(), $access)) {
    call_user_func_array($action, $args);
    die();
}

$loginController->forbidden();

