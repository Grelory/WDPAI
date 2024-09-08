<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../repository/AuthorizedUsersRepository.php';
require_once __DIR__ . '/../repository/TicketsRepository.php';

class UserViewController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->authorizedUsersRepository = new AuthorizedUsersRepository();
        $this->ticketsRepository = new TicketsRepository();
    }

    public function available($user) {
        return $this->render('user/available', [
            "items" => $this->ticketsRepository->getAvailableTicketsByUserId($user->getUserId())
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

    public function dashboard($user) {
        $userName = $this->authorizedUsersRepository->searchUserNameBySession($user->getSessionId());
        $userName = $userName == null ? 'Stranger' : $userName;
        return $this->render('user/dashboard', [
            "name" => $userName
        ]);
    }

    public function expired($user) {
        return $this->render('user/expired', [
            "items" => $this->ticketsRepository->getExpiredTicketsByUserId($user->getUserId())
        ]);
    }
}
