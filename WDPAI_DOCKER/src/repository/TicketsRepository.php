<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Ticket.php';

class TicketsRepository extends Repository {

    public function getTicketsByUserId($id) {
        $stmt = $this->database->connect()->prepare('
            SELECT 
	            t.ticket_id as "ticketId",
	            u.user_name as "userName",
	            p.provider_name as "providerName",
	            l.location_name as "locationName",
	            tr.transport_type_name as "transportTypeName",
	            ti.ticket_type_name as "ticketTypeName",
                t.expiry_time as "expiryTime",
                t.purchase_time as "purchaseTime"
	        FROM tickets t
	            INNER JOIN users u on u.user_id = t.user_id
	            INNER JOIN providers p ON p.provider_id = t.provider_id
	            INNER JOIN locations l ON l.location_id = t.location_id
	            INNER JOIN transport_types tr ON tr.transport_type_id = t.transport_type_id
	            INNER JOIN ticket_types ti ON ti.ticket_type_id = t.ticket_type_id
            WHERE t.user_id = ?
        ');
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Ticket');
    }

    public function getTickets() {
        $stmt = $this->database->connect()->prepare('
            SELECT 
	            t.ticket_id as "ticketId",
	            u.user_name as "userName",
	            p.provider_name as "providerName",
	            l.location_name as "locationName",
	            tr.transport_type_name as "transportTypeName",
	            ti.ticket_type_name as "ticketTypeName",
                t.expiry_time as "expiryTime",
                t.purchase_time as "purchaseTime"
	        FROM tickets t
	            INNER JOIN users u on u.user_id = t.user_id
	            INNER JOIN providers p ON p.provider_id = t.provider_id
	            INNER JOIN locations l ON l.location_id = t.location_id
	            INNER JOIN transport_types tr ON tr.transport_type_id = t.transport_type_id
	            INNER JOIN ticket_types ti ON ti.ticket_type_id = t.ticket_type_id
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Ticket');
    }
}