<?php

namespace App\Service;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Service\Iservice;
use App\Service\Ressource;
use App\Service\ProduitService;
use App\Service\CategorieService;

class CommerceAPI implements Iservice {

    private Ressource $ressource;

    private $api_commerce;

    private $soapClient;

    public function __construct(string $api_commerce, Ressource $ressource)
    {
        $this->api_commerce = $api_commerce;
        $this->ressource = $ressource;
        $this->soapClient = new \SoapClient($api_commerce);
    }

    /**
     * getModels
     *
     * @return array
     */
    public function getModels(): array {
        return $this->ressource->getList($this->soapClient);
    }

    /**
     * getModelById
     *
     * @param  int $id
     * @return void
     */
    public function getModelById($id) {
        return $this->ressource->get($id, $this->soapClient);
    }
    
    /**
     * deleteModelById
     *
     * @param  int $id
     * @return void
     */
    public function deleteModelById($id) {
        return $this->ressource->delete($id, $this->soapClient);
    }
    
    /**
     * addModel
     *
     * @param  mixed $obj
     * @return void
     */
    public function addModel($obj) {
        return $this->ressource->add($obj, $this->soapClient);
    }
    
    /**
     * updateModelById
     *
     * @param  mixed $id
     * @param  mixed $obj
     * @return void
     */
    public function updateModelById($id, $obj) {
        return $this->ressource->update($id, $obj, $this->soapClient);
    }
}