<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Location.php';

class LocationsRepository extends Repository {

    public function getLocations() {
        $stmt = $this->database->connect()->prepare('
            SELECT 
                location_id as "locationId",
	            location_name as "locationName"
	        FROM locations
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Location');
    }

    public function saveLocation($location) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO locations (location_name)
            VALUES (?)
        ');
        $stmt->execute([$location]);
    }
}