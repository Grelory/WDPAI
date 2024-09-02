<?php

class Interval {

    public $intervalId;
    public $intervalName;

    public function __construct() {
    }

    public function getIntervalId() : string {
        return $this->intervalId;
    }

    public function getIntervalName() : string {
        return $this->intervalName;
    }
}