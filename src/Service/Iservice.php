<?php

namespace App\Service;

interface Iservice {
    
    public function getModels(): array;

    public function getModelById($id);

    public function addModel($obj);

    public function updateModelById($id, $obj);

    public function deleteModelById($id);
    
}