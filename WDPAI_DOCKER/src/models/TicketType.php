<?php

class TicketType {

    public $ticketTypeId;
    public $ticketTypeName;
    public $ticketTypeExpiryInterval;

    public function __construct() {
    }

    public function getTicketTypeId() : string {
        return $this->ticketTypeId;
    }

    public function getTicketTypeName() : string {
        return $this->ticketTypeName;
    }
    
    public function getTicketTypeExpiryInterval() : string {
        return $this->ticketTypeExpiryInterval;
    }
}