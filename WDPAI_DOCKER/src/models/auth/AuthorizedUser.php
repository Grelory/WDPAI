<?php

class AuthorizedUser {

    public $userId;
    public $userRole;
	public $sessionId;

    public function __construct() {
    }

    public function getUserId() : string {
        return $this->userId;
    }

    public function getUserRole() : string {
        return $this->userRole;
    }

    public function getSessionId() : string {
        return $this->sessionId;
    }
}