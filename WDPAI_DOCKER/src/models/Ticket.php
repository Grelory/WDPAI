<?php

class Ticket {

    public $ticketId;
	public $userName;
	public $providerName;
	public $locationName;
	public $transportTypeName;
	public $ticketTypeName;
	public $expiryTime;
	public $purchaseTime;

    public function __construct() {
    }

    public function getTicketId() : string {
        return $this->ticketId;
    }

    public function getUserName() : string {
        return $this->userName;
    }

    public function getProviderName() : string {
        return $this->providerName;
    }

    public function getLocationName() : string {
        return $this->locationName;
    }

    public function getTransportTypeName() : string {
        return $this->transportTypeName;
    }

    public function getTicketTypeName() : string {
        return $this->ticketTypeName;
    }

    public function getExpiryTime() : string {
        return $this->expiryTime;
    }

    public function getPurchaseTime() : string {
        return $this->purchaseTime;
    }
}