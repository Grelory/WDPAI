<?php

class Ticket {

    public $ticket_id;
	public $user_id;
	public $provider_id;
	public $location_id;
	public $transport_id;
	public $ticket_type_id;
	public $expiry_time;
	public $purchase_time;

    public function __construct() {
    }

    public function getTicketId() : string {
        return $this->ticket_id;
    }

    public function getUserId() : string {
        return $this->user_id;
    }

    public function getProviderId() : string {
        return $this->provider_id;
    }

    public function getLocationId() : string {
        return $this->location_id;
    }

    public function getTransportId() : string {
        return $this->transport_id;
    }

    public function getTicketTypeId() : string {
        return $this->ticket_type_id;
    }

    public function getExpiryTime() : string {
        return $this->expiry_time;
    }

    public function getPurchaseTime() : string {
        return $this->purchase_time;
    }
}