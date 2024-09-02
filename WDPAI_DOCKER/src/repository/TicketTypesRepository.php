<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Interval.php';
require_once __DIR__ . '/../models/TicketType.php';

class TicketTypesRepository extends Repository {

    public function getTicketTypes() {
        $stmt = $this->database->connect()->prepare('
            SELECT 
                ticket_type_id as "ticketTypeId",
	            ticket_type_name as "ticketTypeName",
	            ticket_type_expiry_interval as "ticketTypeExpiryInterval"
	        FROM ticket_types
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'TicketType');
    }

    public function saveTicketType($ticketType, $interval) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO ticket_types (ticket_type_name, ticket_type_expiry_interval)
            VALUES (?, ?)
        ');
        $stmt->execute([
            $ticketType, 
            $interval
        ]);
    }

    public function getIntervals() {
        $stmt = $this->database->connect()->prepare('
            SELECT 
                interval_id as "intervalId",
	            interval_name as "intervalName"
	        FROM intervals
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Interval');
    }
}