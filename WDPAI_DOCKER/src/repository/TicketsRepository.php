<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Ticket.php';
require_once __DIR__ . '/../models/TicketToBuy.php';

class TicketsRepository extends Repository {

    public function getAvailableTicketsByUserId($id) {
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
            WHERE t.user_id = ? and t.expiry_time > now()
        ');
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Ticket');
    }

    public function getExpiredTicketsByUserId($id) {
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
            WHERE t.user_id = ? and t.expiry_time < now()
        ');
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Ticket');
    }

    public function getTicketsToBuy() {
        $stmt = $this->database->connect()->prepare('
            SELECT 
	            t.ticket_to_buy_id as "ticketToBuyId",
	            p.provider_name as "providerName",
	            l.location_name as "locationName",
	            tr.transport_type_name as "transportTypeName",
	            ti.ticket_type_name as "ticketTypeName"
	        FROM tickets_to_buy t
	            INNER JOIN providers p ON p.provider_id = t.provider_id
	            INNER JOIN locations l ON l.location_id = t.location_id
	            INNER JOIN transport_types tr ON tr.transport_type_id = t.transport_type_id
	            INNER JOIN ticket_types ti ON ti.ticket_type_id = t.ticket_type_id
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'TicketToBuy');
    }

    public function saveTicket($userId, $provider, $location, $transport, $type) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tickets (user_id, provider_id, location_id, transport_type_id, ticket_type_id, expiry_time)
            SELECT 
                ?,
                t.provider_id,
                t.location_id,
                t.transport_type_id,
                t.ticket_type_id,
                now() + ti.ticket_type_expiry_interval
            FROM tickets_to_buy t
                INNER JOIN providers p ON p.provider_id = t.provider_id
                INNER JOIN locations l ON l.location_id = t.location_id
                INNER JOIN transport_types tr ON tr.transport_type_id = t.transport_type_id
                INNER JOIN ticket_types ti ON ti.ticket_type_id = t.ticket_type_id
            WHERE p.provider_name = ? 
                and l.location_name = ?
                and tr.transport_type_name = ?
                and ti.ticket_type_name = ?
        ');
        $stmt->execute([$userId, $provider, $location, $transport, $type]);
    }

    public function getUnmatchedTicketsToBuy() {
        $stmt = $this->database->connect()->prepare('
            SELECT 
                p.provider_name AS "providerName",
                l.location_name AS "locationName",
                tr.transport_type_name AS "transportTypeName",
                ti.ticket_type_name AS "ticketTypeName"
            FROM 
                providers p
                CROSS JOIN locations l
                CROSS JOIN transport_types tr
                CROSS JOIN ticket_types ti
            LEFT JOIN 
                tickets_to_buy t
                ON t.provider_id = p.provider_id
                AND t.location_id = l.location_id
                AND t.transport_type_id = tr.transport_type_id
                AND t.ticket_type_id = ti.ticket_type_id
            WHERE 
                t.ticket_to_buy_id IS NULL;
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'TicketToBuy');
    }

    public function saveUnmatchedTicketToBuy($provider, $location, $transport, $type) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tickets_to_buy (provider_id, location_id, transport_type_id, ticket_type_id)
            SELECT
                p.provider_id,
                l.location_id,
                tr.transport_type_id,
                ti.ticket_type_id
            FROM providers p
                CROSS JOIN locations l
                CROSS JOIN transport_types tr
                CROSS JOIN ticket_types ti
            WHERE p.provider_name = ? 
                and l.location_name = ?
                and tr.transport_type_name = ?
                and ti.ticket_type_name = ?
        ');
        $stmt->execute([$provider, $location, $transport, $type]);
    }
}