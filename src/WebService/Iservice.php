<?php

namespace App\WebService;

interface Iservice {
        
    /**
     * getModels
     *
     * @return array
     */
    public function getModels(): array;
    
    /**
     * getModelById
     *
     * @param  int $id
     * @return void
     */
    public function getModelById($id);
    
    /**
     * addModel
     *
     * @param  mixed $obj
     * @return void
     */
    public function addModel($obj);
    
    /**
     * updateModelById
     *
     * @param  int $id
     * @param  mixed $obj
     * @return void
     */
    public function updateModelById($id, $obj);
    
    /**
     * deleteModelById
     *
     * @param  int $id
     * @return void
     */
    public function deleteModelById($id);
    
}