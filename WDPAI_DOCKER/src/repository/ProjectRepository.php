<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Project.php';

class ProjectRepository extends Repository {

    public function getProjects() {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.projects2
        ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Project');
    }

    public function getProject(int $id) {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.projects2 WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_CLASS, 'Project');
    }

    public function saveProject($data) {
        $stmt = $this->database->connect()->prepare("
            INSERT INTO public.projects2 (title, description, \"photoUrl\") VALUES (?, ?, ?);
        ");

        $stmt->execute([
            $data["title"],
            $data["description"],
            $data["photoUrl"],
        ]);

        return;
    }

    public function getProjectByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM projects2 WHERE LOWER(title) LIKE :search OR LOWER(description) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // return $stmt->fetch(PDO::FETCH_CLASS, 'Project');
    }
}