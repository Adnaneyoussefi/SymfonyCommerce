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

    public function __construct(string $api_commerce, Ressource $ressource)
    {
        $this->api_commerce = $api_commerce;
        $this->ressource = $ressource;
    }

    /**
     * getModels
     *
     * @return array
     */
    public function getModels(): array {
        $soapClient = new \SoapClient($this->api_commerce);
        return $this->ressource->getList($soapClient);
    }

    /**
     * getModelById
     *
     * @param  int $id
     * @return void
     */
    public function getModelById($id) {
        $soapClient = new \SoapClient($this->api_commerce);
        return $this->ressource->get($id, $soapClient);
    }
    
    /**
     * deleteModelById
     *
     * @param  int $id
     * @return void
     */
    public function deleteModelById($id) {
        $soapClient = new \SoapClient($this->api_commerce);
        return $this->ressource->delete($id, $soapClient);
    }
    
    /**
     * addModel
     *
     * @param  mixed $obj
     * @return void
     */
    public function addModel($obj) {
        $soapClient = new \SoapClient($this->api_commerce);
        return $this->ressource->add($obj, $soapClient);
    }
    
    /**
     * updateModelById
     *
     * @param  mixed $id
     * @param  mixed $obj
     * @return void
     */
    public function updateModelById($id, $obj) {
        $soapClient = new \SoapClient($this->api_commerce);
        return $this->ressource->update($id, $obj, $soapClient);
    }
}