<?php

require_once __DIR__ . '/../AppController.php';
require_once __DIR__ . '/../../repository/auth/RegistrationRepository.php';

class RegistrationController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->registrationRepository = new RegistrationRepository();
    }

    public function registration() {
        if ($this->isGet()) {
            return $this->render('auth/registration');
        }

        $this->registrationRepository->saveUser(
            $_POST['userName'], 
            $_POST['email'], 
            $_POST['password']
        );    
    }
}
