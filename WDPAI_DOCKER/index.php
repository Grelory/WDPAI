<?php

require_once 'src/controllers/AppController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/auth/LoginController.php';
require_once 'src/controllers/auth/RegistrationController.php';

require_once 'src/controllers/user/UserViewController.php';
require_once 'src/controllers/user/AdminViewController.php';
require_once 'src/controllers/resource/TicketsToBuyResource.php';

require_once 'src/repository/ProjectRepository.php';
require_once 'src/models/Project.php';
require_once 'Database.php';

$controller = new AppController();
$loginController = new LoginController();
$dashboardController = new DashboardController();
$userViewController = new UserViewController();
$adminViewController = new AdminViewController();
$registrationController = new RegistrationController();
$ticketsToBuyResource = new TicketsToBuyResource();

$routing = [
    'user/available' => [
        'action' => array($userViewController, 'available'),
        'params' => ['authorizedUser'],
        'access' => ['USER']
    ],
    'user/buy' => [
        'action' => array($userViewController, 'buy'),
        'params' => ['authorizedUser'],
        'access' => ['USER']
    ],
    'user/dashboard' => [
        'action' => array($userViewController, 'dashboard'),
        'params' => [],
        'access' => ['USER']
    ],
    'user/expired' => [
        'action' => array($userViewController, 'expired'),
        'params' => ['authorizedUser'],
        'access' => ['USER']
    ],
    'user/favourites' => [
        'action' => array($userViewController, 'favourites'),
        'params' => [],
        'access' => ['USER']
    ],
    'user/logout' => [
        'action' => array($userViewController, 'logout'),
        'params' => [],
        'access' => ['USER']
    ],

    'admin/dashboard' => [
        'action' => array($adminViewController, 'dashboard'),
        'params' => [],
        'access' => ['ADMIN']
    ],
    'admin/tickets' => [
        'action' => array($adminViewController, 'tickets'),
        'params' => [],
        'access' => ['ADMIN']
    ],
    'admin/providers' => [
        'action' => array($adminViewController, 'providers'),
        'params' => [],
        'access' => ['ADMIN']
    ],
    'admin/locations' => [
        'action' => array($adminViewController, 'locations'),
        'params' => [],
        'access' => ['ADMIN']
    ],
    'admin/transport' => [
        'action' => array($adminViewController, 'transport'),
        'params' => [],
        'access' => ['ADMIN']
    ],
    'admin/types' => [
        'action' => array($adminViewController, 'types'),
        'params' => [],
        'access' => ['ADMIN']
    ],

    'auth/login' => [
        'action' => array($loginController, 'login'),
        'params' => [],
        'access' => []
    ],
    'auth/logout' => [
        'action' => array($loginController, 'logout'),
        'params' => [],
        'access' => []
    ],
    'auth/registration' => [
        'action' => array($registrationController, 'registration'),
        'params' => [],
        'access' => []
    ],

    'resources/tickets-to-buy' => [
        'action' => array($ticketsToBuyResource, 'ticketsToBuy'),
        'params' => [],
        'access' => []
    ]
];

$uri = $_SERVER['REQUEST_URI'];
$path = trim(parse_url($uri, PHP_URL_PATH), '/');

$action = $routing[$path]['action'];
$params = $routing[$path]['params'];
$access = $routing[$path]['access'];

$user = $loginController->searchUser();

function createContext($params, $user) {
    $context = [];
    switch(true) {
        case in_array('authorizedUser', $params):
            array_push($context, $user);
            break;
    }
    return $context;
}

switch(true) {
    case $path == null || $path = '':
        $url = "http://$_SERVER[HTTP_HOST]";
        header("location: {$url}/auth/login");
        die();
    case $action == null:
        // TODO implement screen
        echo "404 Not found";
        die();
    case $user != null && in_array($path, array('auth/login', 'auth/registration')):
        $loginController->redirectByRole($user->getUserRole());
        die();
    case empty($access):
        call_user_func_array($action, createContext($params, $user));
        die();
    case $user == null:
        $loginController->unauthorized();
        die();
    case in_array($user->getUserRole(), $access):
        call_user_func_array($action, createContext($params, $user));
        die();
                                            
}

$loginController->forbidden();

