<?php

namespace App\Service;

interface Iservice {
    
    public function getModels(): array;

    public function getModelById($id);

    public function addModel();

    public function updateModelById($id);

    public function deleteModelById($id);
    
}