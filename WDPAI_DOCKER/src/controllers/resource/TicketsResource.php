<?php

require_once __DIR__ . '/../AppController.php';
require_once __DIR__ . '/../../repository/TicketsRepository.php';

class TicketsResource extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->ticketsRepository = new TicketsRepository();
    }

    public function ticketsToBuy() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json" || true) {
            $tickets = $this->ticketsRepository->getTicketsToBuy();
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($tickets);
        }
    }

    public function unmatchedTicketsToBuy() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json" || true) {
            $tickets = $this->ticketsRepository->getUnmatchedTicketsToBuy();
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($tickets);
        }
    }
}
