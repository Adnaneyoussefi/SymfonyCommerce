<?php

namespace App\Service;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Service\Ressource;
use App\Service\CustomSoapClient;
use App\Service\RessourceInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CategorieService extends CustomSoapClient implements RessourceInterface
{

    public function __construct(string $apikey, ParameterBagInterface $params)
    {   
        parent::__construct($apikey, $params);
    }
  
    /**
     * Récupérer la liste des catégories
     *
     * @return Categorie[]
     */
    public function getList(): array
    {
        $categoriesObject = [];
        $this->ws_name = 'getListCategories';
        $categories = $this->__call('getListCategories', array());
        if(isset($categories))
        {
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
                            ->setQuantite(intval($p->quantite))
                            ->setCategorie($categorie);
                    $categorie->addProduit($produit);
                }
                array_push($categoriesObject, $categorie);
            }
        }
        dump($categoriesObject);
        return $categoriesObject;
    }
    
    /**
     * Récupérer la catégorie par id
     *
     * @param  int $id
     * @return Categorie
     */
    public function get(int $id): Categorie
    {
        $this->ws_name = 'getCategorieById';
        $response = $this->__call('getCategorieById', array($id));
        $categorie = new Categorie();
        $categorie->setId(intval($response->id))
                ->setNom($response->nom);
        if(isset($c->produits->item))
            $produits = is_array($response->produits->item) ? $response->produits->item : [$response->produits->item];
        else
            $produits = $response->produits;
        foreach($produits as $p)
        {
            $produit = new Produit();
            $produit->setId((int)$p->id)
                    ->setNom($p->nom)
                    ->setDescription($p->description)
                    ->setPrix($p->prix)
                    ->setImage($p->image)
                    ->setQuantite((int)$p->quantite)
                    ->setCategorie($categorie);
            $categorie->addProduit($produit);
        }
        return $categorie;
    }
    
    /**
     * Ajouter une catégorie
     *
     * @param  object $obj
     * @return object
     */
    public function add(object $obj) {
        $response = $this->__call('addNewCategorie', array($obj->getNom()));
        return $response;
    }
    
    /**
     * Modifier la catégorie
     *
     * @param  int $id
     * @param  object $obj
     * @return object
     */
    public function update(int $id, object $obj) {
        $response = $this->__call('updateCategorie', array($id, $obj->getNom()));
        return $response;
    }
    
    /**
     * Supprimer une catégorie
     *
     * @param  int $id
     * @return object
     */
    public function delete(int $id)
    {
        $response = $this->__call('deleteCategorie', array($id));
        return $response;
    }
}
