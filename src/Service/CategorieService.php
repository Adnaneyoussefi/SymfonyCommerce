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
    
    /**
     * delete
     *
     * @param  mixed $get
     * @param  mixed $soapClient
     * @return void
     */
    public function delete($get, $soapClient)
    {
        return $soapClient->deleteCategorie($get);
    }
    
    /**
     * get
     *
     * @param  mixed $id
     * @param  mixed $soapClient
     * @return void
     */
    public function get($id, $soapClient)
    {
        $c = array_filter($this->getList($soapClient), function ($x) use ($id) {
            return $x->getId() == $id;
        });
        return [...$c][0];
    }
    
    /**
     * add
     *
     * @param  mixed $obj
     * @param  mixed $soapClient
     * @return void
     */
    public function add($obj, $soapClient) {
        if($obj->getNom() != "")
            return $soapClient->addNewCategorie($obj->getNom());
    }
    
    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $obj
     * @param  mixed $soapClient
     * @return void
     */
    public function update($id, $obj, $soapClient) {
        if($obj->getNom() != "" && is_numeric($id) == 1)
            return $soapClient->updateCategorie($id, $obj->getNom());
    }
}