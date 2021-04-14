<?php

namespace App\Service;

use App\Service\IAllData;
use App\Service\Iservice;

class AllData {
    
    private Iservice $service;

    public function __construct(Iservice $service)
    {
        $this->service = $service;
    }

    public function getService() {
        return $this->service;
    }

    public function setService(Iservice $service) {
        $this->service = $service;
    }

    public function getAllData(): array {
        return $this->service->getModels();
    }

    public function getDataById($id) {
        return $this->service->getModelById($id);
    }

    public function addData() {
        return $this->service->addModel();
    }

    public function updateDataById($id) {
        return $this->service->updateModelById($id);
    }

    public function deleteDataById($id) {
        return $this->service->deleteModelById($id);
    }
}