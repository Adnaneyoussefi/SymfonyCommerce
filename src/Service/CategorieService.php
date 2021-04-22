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

    public function delete($get, $soapClient) {
        return $soapClient->deleteCategorie($get);
    }

    public function get($id, $soapClient) {
        $c = array_filter($this->getCategories($soapClient), function($x) use($id) {
            return $x->getId() == $id;
        });
        return [...$c][0];
    }

    public function add($obj, $soapClient) {
        if($obj->getNom() != "")
        return $soapClient->addNewCategorie($obj->getNom());
    }

    public function update($id, $obj, $soapClient) {
        return $soapClient->updateCategorie($id, $obj->getNom());
    }
}