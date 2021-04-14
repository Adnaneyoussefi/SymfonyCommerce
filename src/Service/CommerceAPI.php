<?php

namespace App\Service;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Service\Iservice;
use App\Service\ProduitService;
use App\Service\RessourceInterface;

class CommerceAPI implements Iservice {

    private RessourceInterface $ressourceInterface;

    private $api_commerce;

    public function __construct(string $api_commerce, RessourceInterface $ressourceInterface)
    {
        $this->api_commerce = $api_commerce;
        $this->ressourceInterface = $ressourceInterface;
    }

    public function getModels(): array {
        $soapClient = new \SoapClient($this->api_commerce);
        $produitService = new ProduitService();
        return ["produit" => $produitService->getProduits($soapClient)];
    }

    public function getModelById($id) {
        $soapClient = new \SoapClient($this->api_commerce);
        //$produitService = new ProduitService();
        return $this->ressourceInterface->get($id, $soapClient);
    }

    public function deleteModelById($id) {
        $soapClient = new \SoapClient($this->api_commerce);
        //$produitService = new ProduitService();
        return $this->ressourceInterface->delete($id, $soapClient);
    }

    public function addModel() {
       
    }

    public function updateModelById($id) {
       
    }
}