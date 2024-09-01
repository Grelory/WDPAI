<?php

require_once __DIR__ . '/../AppController.php';
require_once __DIR__ . '/../../repository/TicketsRepository.php';
require_once __DIR__ . '/../../repository/LocationsRepository.php';

class AdminViewController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->ticketsRepository = new TicketsRepository();
        $this->locationsRepository = new LocationsRepository();
    }

    public function dashboard() {
        return $this->render('admin/dashboard');
    }

    public function tickets() {
        return $this->render('admin/tickets');
    }

    public function providers() {
        return $this->render('admin/providers');
    }

    public function locations() {
        if ($this->isGet()) {
            return $this->render('admin/locations', [
                "items" => $this->locationsRepository->getLocations()
            ]);
        }
        $this->locationsRepository->saveLocation($_POST['location']);
        $this->redirect('/admin/locations');
    }

    public function transport() {
        return $this->render('admin/transport');
    }

    public function types() {
        return $this->render('admin/types');
    }
}
