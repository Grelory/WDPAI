<?php

class TicketToBuy {

    public $ticketToBuyId;
	public $providerName;
	public $locationName;
	public $transportTypeName;
	public $ticketTypeName;

    public function __construct() {
    }

    public function getTicketToBuyId() : string {
        return $this->ticketToBuyId;
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
}