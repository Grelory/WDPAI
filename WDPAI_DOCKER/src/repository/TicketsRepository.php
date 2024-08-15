<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Ticket.php';

class TicketsRepository extends Repository {

    public function getTickets() {
        $stmt = $this->database->connect()->prepare('SELECT * FROM tickets');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Ticket');
    }
}