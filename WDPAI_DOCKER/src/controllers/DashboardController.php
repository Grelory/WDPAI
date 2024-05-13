<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/ProjectRepository.php';

class DashboardController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->projectRepository = new ProjectRepository();
    }

    public function dashboard() {
        return $this->render('dashboard', [
            "title"=> "PROJECTS | WDPAI", 
            "items" => $this->projectRepository->getProjects()
        ]);
    }

    public function project() {
        if($this->isPost()) {

            $this->projectRepository->saveProject($_POST);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/dashboard");
            return;
        }

        return $this->render('add-project', ["title"=> "ADD PROJECT | WDPAI"]);

    }

    public function search() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->projectRepository->getProjectByTitle($decoded['search']));
        }
    }
}