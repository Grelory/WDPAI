<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Provider.php';

class ProvidersRepository extends Repository {

    public function getProviders() {
        $stmt = $this->database->connect()->prepare('
            SELECT 
                provider_id as "providerId",
	            provider_name as "providerName"
	        FROM providers
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Provider');
    }

    public function saveProvider($provider) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO providers (provider_name)
            VALUES (?)
        ');
        $stmt->execute([$provider]);
    }
}