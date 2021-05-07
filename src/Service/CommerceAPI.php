<?php

namespace App\Service;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Service\Iservice;
use App\Service\Ressource;
use App\Service\ProduitService;
use App\Service\CategorieService;
use App\Service\RessourceInterface;

class CommerceAPI implements Iservice {

    private RessourceInterface $ressourceInterface;

    public function __construct(RessourceInterface $ressourceInterface)
    {
        $this->ressourceInterface = $ressourceInterface;
    }

    public function getModels(): array {
        return $this->ressourceInterface->getList();
    }

    public function getModelById($id) {
        return $this->ressourceInterface->get($id);
    }

    public function deleteModelById($id) {
        return $this->ressourceInterface->delete($id);
    }

    public function addModel($obj) {
        return $this->ressourceInterface->add($obj);
    }

    public function updateModelById($id, $obj) {
        return $this->ressourceInterface->update($id, $obj);
    }
}