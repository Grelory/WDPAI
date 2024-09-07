<?php

class User {

    public $userId;
	public $userName;
    public $userEmail;
    public $userPassword;

    public function __construct() {
    }

    public function getUserId() : string {
        return $this->userId;
    }

    public function getUserName() : string {
        return $this->userName;
    }

    public function getUserEmail() : string {
        return $this->userEmail;
    }

    public function getUserPassword() : string {
        return $this->userPassword;
    }
}