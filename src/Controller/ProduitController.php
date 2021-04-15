<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Service\AllData;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     */
    public function index(AllData $commerceProduit): Response
    {
        //dd($commerce->getAllData()["produit"]);
        $produits = $commerceProduit->getAllData()["produit"];
        return $this->render('produit/index.html.twig', [
            'produits' => array_reverse($produits)
        ]);
    }

     /**
     * @Route("/produits/new", name="produit_new")
     */
    public function new(AllData $commerceProduit, AllData $commerceCategorie, Request $request): Response
    {
        $categories = $commerceCategorie->getAllData()["categorie"];
        if(isset($_POST['Ajouter'])) {
            $commerceProduit->addData($_POST);
            $this->addFlash('success', 'Vous avez ajouter le produit avec succées !');
            return $this->redirectToRoute('produits');
        }
        return $this->render('produit/new.html.twig', [
            'categories' => $categories,
        ]);
    }

   /**
     * @Route("/produits/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(AllData $commerceProduit, AllData $commerceCategorie, Request $request, $id): Response
    {
        $repos = $commerceProduit->getDataById($id);
        $categories = $commerceCategorie->getAllData()["categorie"];

        if(isset($_POST['Modifier'])) {
            $commerceProduit->updateDataById($id, $_POST);
            $this->addFlash('success', 'Vous avez modifié le produit avec succées !');
            return $this->redirectToRoute('produits');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $repos,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/produit/{id}", name="produit_delete")
     */
    public function delete(AllData $commerceProduit, Request $request, $id): Response
    {
        $commerceProduit->deleteDataById($id);
        $this->addFlash('alert', 'Le produit a été supprimé');

        return $this->redirectToRoute('produits');
    }
}
