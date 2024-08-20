<?php

require_once __DIR__ . '/../AppController.php';
require_once __DIR__ . '/../../repository/TicketsRepository.php';

class LoginController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->ticketsRepository = new TicketsRepository();
    }

    public function login() {
        return $this->render('auth/login', [
            "items" => $this->ticketsRepository->getTickets()
        ]);
    }
}
