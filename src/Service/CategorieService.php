<?php

namespace App\Service;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Service\Ressource;

class CategorieService extends Ressource
{

    /**
     * @return Categorie[]
     */
    public function getList($soapClient): array
    {
        $categoriesObject = [];
        $categories = [];
        if($this->bouchonne == 'on') {
            $path_xml = "../src/Bouchonné/getListCategories.xml";
            $categories = $this->convertResponseXML($path_xml);
        }
        else
            $categories = $soapClient->getListCategories();

        foreach ($categories as $c) {
            $categorie = new Categorie();
            $categorie->setId((int)$c->id)
                ->setNom($c->nom);
                $produits = [];
                if(isset($c->produits->item)) {
                    $produits = is_array($c->produits->item) ? $c->produits->item : [$c->produits->item];
                }
                else
                    $produits = $c->produits;
            foreach($produits as $p) {
                $produit = new Produit();
                $produit->setId((int)$p->id)
                        ->setNom($p->nom)
                        ->setDescription($p->description)
                        ->setPrix($p->prix)
                        ->setImage($p->image)
                        ->setQuantite($p->quantite)
                        ->setCategorie($categorie);
                $categorie->addProduit($produit);
            }
            array_push($categoriesObject, $categorie);
        }
        return $categoriesObject;
    }

    public function delete($get, $soapClient)
    {
        return $soapClient->deleteCategorie($get);
    }

    public function get($id, $soapClient)
    {
        $c = array_filter($this->getList($soapClient), function ($x) use ($id) {
            return $x->getId() == $id;
        });
        return [...$c][0];
    }

    public function add($obj, $soapClient)
    {
        return $soapClient->addNewCategorie($obj->getNom());
    }

    public function update($id, $obj, $soapClient)
    {
        return $soapClient->updateCategorie($id, $obj->getNom());
    }
}
