<?php

require_once __DIR__ . '/../AppController.php';
require_once __DIR__ . '/../../repository/TicketsRepository.php';
require_once __DIR__ . '/../../repository/LocationsRepository.php';
require_once __DIR__ . '/../../repository/TransportTypesRepository.php';
require_once __DIR__ . '/../../repository/ProvidersRepository.php';

class AdminViewController extends AppController { 

    public function __construct()
    {
        parent::__construct();
        $this->ticketsRepository = new TicketsRepository();
        $this->locationsRepository = new LocationsRepository();
        $this->transportTypesRepository = new TransportTypesRepository();
        $this->providersRepository = new ProvidersRepository();
    }

    public function dashboard() {
        return $this->render('admin/dashboard');
    }

    public function tickets() {
        return $this->render('admin/tickets');
    }

    public function providers() {
        if ($this->isGet()) {
            return $this->render('admin/providers', [
                "items" => $this->providersRepository->getProviders()
            ]);
        }
        $this->providersRepository->saveProvider($_POST['provider']);
        $this->redirect('/admin/providers');
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
        if ($this->isGet()) {
            return $this->render('admin/transport', [
                "items" => $this->transportTypesRepository->getTransportTypes()
            ]);
        }
        $this->transportTypesRepository->saveTransportType($_POST['transport-type']);
        $this->redirect('/admin/transport');
    }

    public function types() {
        return $this->render('admin/types');
    }
}
