<?php

namespace App\Service;

use App\Entity\Categorie;
use App\Service\RessourceInterface;

class CategorieService implements RessourceInterface {

    /**
     * @return Categorie[]
     */
    public function getCategories($soapClient): array {
        $categoriesObject = [];
        $categories = $soapClient->getListCategories();

        foreach($categories as $c) {
            $categorie = new Categorie();
            $categorie->setId($c->id)
                      ->setNom($c->nom)
                      ->setProduits($c->produits);
            array_push($categoriesObject, $categorie);
        }
        return $categoriesObject;
    }

    public function delete($get,$soapClient): void {
            try {
                $categories = $soapClient->deleteCategorie($get);
              
            } catch (Exception $e) {
                
            }
    }

    public function get($id, $soapClient) {
       
    }

    public function add() {

    }

    public function update($id, $soapClient) {
        
    }
}