<?php

namespace App\Service;

use CategorieService;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Service\Iservice;



class CommerceAPI implements Iservice {

    private $api_commerce;

    public function __construct(string $api_commerce)
    {
        $this->api_commerce = $api_commerce;
    }

    public function getModels(): array {
        $soapClient = new \SoapClient($this->api_commerce);
        $categorieService = new CategorieService();
        return ["produit" => $this->getProduits($soapClient),
                "categorie" => $categorieService->getCategories($soapClient)];
    }

    /**
     * @return Produit[]
     */
    public function getProduits($soapClient): array {
        $categories = $soapClient->getListCategories();
        $produits = $soapClient->getListProduits();
        $produitsObject = [];
        $categoriesObject = [];

        foreach($categories as $c) {
            $categorie = new Categorie();
            $categorie->setId($c->id)
                      ->setNom($c->nom);
            array_push($categoriesObject, $categorie);           
        }
        foreach($produits as $p) {
            $produit = new Produit();
            $produit->setId($p->id)
                    ->setNom($p->nom)
                    ->setDescription($p->description)
                    ->setPrix($p->prix)
                    ->setImage($p->image)
                    ->setQuantite($p->quantite);
            foreach($categoriesObject as $ca) {
                if($p->categorie->id === $ca->getId()) {
                    $ca->addProduit($produit);  
                    $produit->setCategorie($ca);
                }
            }
            array_push($produitsObject, $produit);
        }
        return $produitsObject;
    }


}