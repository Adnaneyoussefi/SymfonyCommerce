<?php

namespace App\WebService;

use App\WebService\Iservice;

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

    public function addData($obj) {
        return $this->service->addModel($obj);
    }

    public function updateDataById($id, $obj) {
        return $this->service->updateModelById($id, $obj);
    }

    public function deleteDataById($id) {
        return $this->service->deleteModelById($id);
    }
}