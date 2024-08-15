<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/TicketsRepository.php';

class AvailableController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->ticketsRepository = new TicketsRepository();
    }

    public function available() {
        return $this->render('user/available', [
            "items" => $this->ticketsRepository->getTickets()
        ]);
    }
}
