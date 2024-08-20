<?php

require_once __DIR__ . '/../Repository.php';
require_once __DIR__ . '/../../models/auth/User.php';

class RegistrationRepository extends Repository {

    public function saveUser($userName, $email, $password) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (user_name, user_email, user_password)
            VALUES (?,?,?)');
        $stmt->execute([$userName, $email, $password]);
    }
}