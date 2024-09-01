<?php

class TransportType {

    public $transportTypeId;
    public $transportTypeName;

    public function __construct() {
    }

    public function getTransportTypeId() : string {
        return $this->transportTypeId;
    }

    public function getTransportTypeName() : string {
        return $this->transportTypeName;
    }
}