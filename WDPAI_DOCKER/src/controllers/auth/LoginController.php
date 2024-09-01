<?php

require_once __DIR__ . '/../AppController.php';
require_once __DIR__ . '/../../models/auth/AuthorizedUser.php';
require_once __DIR__ . '/../../repository/auth/AuthorizedUsersRepository.php';

class LoginController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->authorizedUsersRepository = new AuthorizedUsersRepository();
    }

    public function login() {
        if ($this->isGet()) {
            return $this->render('auth/login');
        }

        $user = $this->searchUser();

        if ($user == null) {
            $user = $this->authorizedUsersRepository->create($_POST['email'], $_POST['password']);
        }

        if ($user != null) {
            setcookie('sessionId', $user->getSessionId(), 0, '/');
            return $this->redirectByRole($user->getUserRole());
        }

        $this->unauthorized();
    }

    public function logout() {
        $this->authorizedUsersRepository->remove($_COOKIE['sessionId']);
        setcookie('sessionId', '', time()-1, '/');

        $this->render('auth/logout');
    }

    public function forbidden() {
        echo "403 forbidden"; // todo create a view
    }

    public function unauthorized() {
        echo "401 unauthorized"; // todo create a view
    }

    public function searchUser() {
        $sessionId = $_COOKIE['sessionId'];
        return $this->authorizedUsersRepository->searchBySession($sessionId);
    }

    public function redirectByRole($role) {
        switch($role) {
            case 'USER':
                $this->redirect('/user/dashboard');
                return;
            case 'ADMIN':
                $this->redirect('/admin/dashboard');
                return;
        }
    }
}
