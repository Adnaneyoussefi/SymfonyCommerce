<?php

namespace App\Service;

use App\Entity\Produit;
use App\Entity\Categorie;

class ProduitService {

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

    /**
     * @return Produit[]
     */
    public function getProduitById($id, $soapClient) {
        $p = array_filter($this->getProduits($soapClient), function($x) use($id) {
            return $x->getId() == $id;
        });
        return [...$p][0];
    }

    public function deleteProduitById($id, $soapClient) {
        return $soapClient->deleteProduit($id);
    }
}