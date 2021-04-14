<?php

namespace App\Service;

use CategorieService;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Service\Iservice;
use App\Service\ProduitService;

class CommerceAPI implements Iservice {

    private $api_commerce;

    public function __construct(string $api_commerce)
    {
        $this->api_commerce = $api_commerce;
    }

    public function getModels(): array {
        $soapClient = new \SoapClient($this->api_commerce);
        $produitService = new ProduitService();
        $categorieService = new CategorieService();
        return ["produit" => $produitService->getProduits($soapClient),
                "categorie" => $categorieService->getCategories($soapClient)];
    }

    public function getModelById($id) {
        $soapClient = new \SoapClient($this->api_commerce);
        $produitService = new ProduitService();
        return $produitService->getProduitById($id, $soapClient);
    }

    public function deleteModelById($id) {
        $soapClient = new \SoapClient($this->api_commerce);
        $produitService = new ProduitService();
        return $produitService->deleteProduitById($id, $soapClient);
    }

    public function addModel() {
       
    }

    public function updateModelById($id) {
       
    }
}