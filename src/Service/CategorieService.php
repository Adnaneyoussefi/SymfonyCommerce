<?php

use App\Entity\Categorie;

class CategorieService{

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

    public function deleteCategorie($get,$soapClient): void {
            try {
                $categories = $soapClient->deleteCategorie($get);
              
            } catch (Exception $e) {
                
            }
        }
    }



?>