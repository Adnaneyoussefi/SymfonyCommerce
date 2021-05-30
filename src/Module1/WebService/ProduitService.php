<?php

namespace App\Module1\WebService;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Module1\WebService\CustomSoapClient;
use App\Module1\WebService\RessourceInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ProduitService extends CustomSoapClient implements RessourceInterface {

    public function __construct(string $apikey, ParameterBagInterface $params)
    {   
        parent::__construct($apikey, $params);
    }

    /**
     * Récupérer la liste des produits
     *
     * @return Produit[]
     */
    public function getList(): array {
        $this->ws_name = 'getListProduits';
        $produits = $this->getListProduits();
        $this->ws_name = 'getListCategories';
        $categories = $this->getListCategories();

        $produitsObject = [];
        $categoriesObject = [];

        if(isset($categories) && isset($produits))
        {
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
                        ->setQuantite(intval($p->quantite));
                
                foreach($categoriesObject as $ca) {
                    if($p->categorie->id == $ca->getId()) {
                        $ca->addProduit($produit);  
                        $produit->setCategorie($ca);
                    }
                }
                array_push($produitsObject, $produit);
            }
        }
        dump($produitsObject);
        return $produitsObject;
    }

    /**
     * Récupérer le produit par id
     *
     * @param  int $id
     * @return Produit
     */
    public function get(int $id) {
        $this->ws_name = 'getProduitById';
        $response = $this->getProduitById($id);
        $c = $this->getCategorieById($response->categorie->id);
        $produit = new Produit();
        $produit->setId((int)$response->id)
                ->setNom($response->nom)
                ->setDescription($response->description)
                ->setPrix($response->prix)
                ->setImage($response->image)
                ->setQuantite((int)$response->quantite);
        $categorie = new Categorie();
        $categorie->setId((int)$c->id)
                ->setNom($c->nom);
        if($response->categorie->id == $categorie->getId())
            $categorie->addProduit($produit);
            $produit->setCategorie($categorie);
        return $produit;
    }
    
    /**
     * Ajouter un produit
     *
     * @param  object $obj
     * @return object
     */
    public function add($obj) {
        $array = [$obj['nom'], $obj['description'], $obj['prix'], '', $obj['quantite'],
        $obj['categorie']];
        $response = $this->addNewProduit(...$array);
        return $response;
    }
    
    /**
     * Modifier un produit
     *
     * @param  int $id
     * @param  object $obj
     * @return object
     */
    public function update(int $id, $obj) {
        $array = [$id, $obj['nom'], $obj['description'], $obj['prix'], '', $obj['quantite'],
        $obj['categorie']];
        $response = $this->updateProduit(...$array);
        return $response;
    }
    
    /**
     * Supprimer un produit
     *
     * @param  int $id
     * @return object
     */
    public function delete(int $id) {
        $response = $this->deleteProduit($id);
        return $response;
    }
}
