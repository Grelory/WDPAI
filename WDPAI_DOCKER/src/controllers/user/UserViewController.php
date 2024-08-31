<?php

require_once __DIR__ . '/../AppController.php';
require_once __DIR__ . '/../../repository/TicketsRepository.php';

class UserViewController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->ticketsRepository = new TicketsRepository();
    }

    public function available($user) {
        return $this->render('user/available', [
            "items" => $this->ticketsRepository->getTicketsByUserId($user->getUserId())
        ]);
    }

    public function buy($user) {
        if ($this->isGet()) {
            return $this->render('user/buy', [
                "items" => $this->ticketsRepository->getTickets()
            ]);
        }
        
        $this->ticketsRepository->saveTicket(
            $user->getUserId(),
            $_POST['provider'], 
            $_POST['location'], 
            $_POST['transport-type'], 
            $_POST['ticket-type']
        );  

        $this->redirect('/user/available');
    }

    public function dashboard() {
        return $this->render('user/dashboard', [
            "items" => $this->ticketsRepository->getTickets()
        ]);
    }

    public function expired() {
        return $this->render('user/expired', [
            "items" => $this->ticketsRepository->getTickets()
        ]);
    }

    public function favourites() {
        return $this->render('user/favourites', [
            "items" => $this->ticketsRepository->getTickets()
        ]);
    }

    public function logout() {
        return $this->render('user/logout', [
            "items" => $this->ticketsRepository->getTickets()
        ]);
    }
}
