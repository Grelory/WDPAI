<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/TransportType.php';

class TransportTypesRepository extends Repository {

    public function getTransportTypes() {
        $stmt = $this->database->connect()->prepare('
            SELECT 
                transport_type_id as "transportTypeId",
	            transport_type_name as "transportTypeName"
	        FROM transport_types
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'TransportType');
    }

    public function saveTransportType($transportType) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO transport_types (transport_type_name)
            VALUES (?)
        ');
        $stmt->execute([$transportType]);
    }
}