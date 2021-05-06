<?php

namespace App\Service;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Service\Ressource;

class ProduitService extends Ressource
{

    /**
     * @return Produit[]
     */
    public function getList($soapClient): array
    {
        $produits = [];
        $categories = [];

        if ($this->bouchonne == 'on') {
            $path_xml1 = "../src/Bouchonné/getListProduits.xml";
            $path_xml2 = "../src/Bouchonné/getListCategories.xml";
            $produits = $this->convertResponseXML($path_xml1);
            $categories = $this->convertResponseXML($path_xml2);
        } else {
            $categories = $soapClient->getListCategories();
            $produits = $soapClient->getListProduits();
        }

        $produitsObject = [];
        $categoriesObject = [];

        foreach ($categories as $c) {
            $categorie = new Categorie();
            $categorie->setId($c->id)
                ->setNom($c->nom);
            array_push($categoriesObject, $categorie);
        }
        foreach ($produits as $p) {
            $produit = new Produit();
            $produit->setId($p->id)
                ->setNom($p->nom)
                ->setDescription($p->description)
                ->setPrix($p->prix)
                ->setImage($p->image)
                ->setQuantite($p->quantite);

            foreach ($categoriesObject as $ca) {
                if ($p->categorie->id == $ca->getId()) {
                    $ca->addProduit($produit);
                    $produit->setCategorie($ca);
                }
            }
            array_push($produitsObject, $produit);
        }
        dump($produitsObject, $categoriesObject);
        return $produitsObject;
    }

    /**
     * @return Produit[]
     */
    public function get($id, $soapClient)
    {
        $p = array_filter($this->getList($soapClient), function ($x) use ($id) {
            return $x->getId() == $id;
        });
        return [...$p][0];
    }

    public function delete($id, $soapClient)
    {
        return $soapClient->deleteProduit($id);
    }

    public function add($obj, $soapClient)
    {
        return $soapClient->addNewProduit($obj['nom'], $obj['description'], $obj['prix'], '', $obj['quantite'],
            $obj['categorie']);
    }

    public function update($id, $obj, $soapClient)
    {
        return $soapClient->updateProduit($id, $obj['nom'], $obj['description'], $obj['prix'], '', $obj['quantite'],
            $obj['categorie']);
    }
}
