<?php

require_once __DIR__ . '/../AppController.php';
require_once __DIR__ . '/../../repository/TicketsRepository.php';

class AdminViewController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->ticketsRepository = new TicketsRepository();
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
        return $this->render('admin/locations');
    }

    public function transport() {
        return $this->render('admin/transport');
    }

    public function types() {
        return $this->render('admin/types');
    }
}
