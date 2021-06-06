<?php

namespace App\WebService\Soap\CommerceWS;

use App\WebService\Iservice;
use App\WebService\RessourceInterface;

class CommerceAPI implements Iservice {

    private RessourceInterface $ressourceInterface;

    public function __construct(RessourceInterface $ressourceInterface)
    {
        $this->ressourceInterface = $ressourceInterface;
    }

    /**
     * getModels
     *
     * @return array
     */
    public function getModels(): array {
        return $this->ressourceInterface->getList();
    }

    /**
     * getModelById
     *
     * @param  int $id
     * @return void
     */
    public function getModelById($id) {
        return $this->ressourceInterface->get($id);
    }
    
    /**
     * deleteModelById
     *
     * @param  int $id
     * @return void
     */
    public function deleteModelById($id) {
        return $this->ressourceInterface->delete($id);
    }
    
    /**
     * addModel
     *
     * @param  mixed $obj
     * @return void
     */
    public function addModel($obj) {
        return $this->ressourceInterface->add($obj);
    }
    
    /**
     * updateModelById
     *
     * @param  mixed $id
     * @param  mixed $obj
     * @return void
     */
    public function updateModelById($id, $obj) {
        return $this->ressourceInterface->update($id, $obj);
    }
}