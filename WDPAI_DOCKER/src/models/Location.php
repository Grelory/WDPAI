<?php

class Location {

    public $locationId;
    public $locationName;

    public function __construct() {
    }

    public function getLocationId() : string {
        return $this->locationId;
    }

    public function getLocationName() : string {
        return $this->locationName;
    }
}