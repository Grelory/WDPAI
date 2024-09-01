<?php

class Provider {

    public $providerId;
    public $providerName;

    public function __construct() {
    }

    public function getProviderId() : string {
        return $this->providerId;
    }

    public function getProviderName() : string {
        return $this->providerName;
    }
}