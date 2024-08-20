<?php

require_once __DIR__ . '/../Repository.php';
require_once __DIR__ . '/../../models/auth/User.php';

class RegistrationRepository extends Repository {

    public function getUsers() {
        $stmt = $this->database->connect()->prepare('SELECT * FROM users');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
    }
}