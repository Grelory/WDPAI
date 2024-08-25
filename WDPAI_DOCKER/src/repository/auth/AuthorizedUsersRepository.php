<?php

require_once __DIR__ . '/../Repository.php';
require_once __DIR__ . '/../../models/auth/User.php';
require_once __DIR__ . '/../../models/auth/AuthorizedUser.php';

class AuthorizedUsersRepository extends Repository {

    public function searchBySession($sessionId) {
        if ($sessionId == null) {
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            SELECT u.user_id as "userId", u.user_role as "userRole", us.session_id as "sessionId"
            FROM users u
            INNER JOIN user_sessions us ON us.user_id = u.user_id
            WHERE us.session_id = ?
        ');
        $stmt->execute([$sessionId]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, AuthorizedUser::class);
        return $stmt->fetch();
    }

    public function create($email, $password) {
        $user = $this->searchUser($email, $password);

        if ($user == null) {
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            INSERT INTO user_sessions (user_id)
            VALUES (?)
            ON CONFLICT (user_id) 
            DO NOTHING
        ');
        $stmt->execute([$user->getUserId()]);

        return $this->searchById($user->getUserId());
    }

    public function remove($cookie) {
        if ($cookie == null) {
            return;
        }

        $stmt = $this->database->connect()->prepare('
            DELETE FROM user_sessions WHERE session_id = ?
        ');
        $stmt->execute([$cookie]);
    }

    private function searchUser($email, $password) {
        $stmt = $this->database->connect()->prepare('
            SELECT user_id as "userId",
                user_name as "userName",
                user_email as "userEmail",
                user_password as "userPassword",
                user_role as "userRole"
            FROM users
            WHERE user_email = ? and user_password = ?
        ');
        $stmt->execute([$email, $password]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $stmt->fetch();
    }

    private function searchById($userId) {
        $stmt = $this->database->connect()->prepare('
            SELECT u.user_id as "userId", 
                u.user_role as "userRole", 
                us.session_id::text as "sessionId"
            FROM users u
            INNER JOIN user_sessions us ON us.user_id = u.user_id
            WHERE u.user_id = ?
        ');
        $stmt->execute([$userId]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, AuthorizedUser::class);
        return $stmt->fetch();
    }
}