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
    public function new(AllData $commerceProduit, Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*$entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez ajouter la catégorie avec succées !');*/


            return $this->redirectToRoute('produits');
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

   /**
     * @Route("/produits/{id}", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(AllData $commerceProduit, Request $request, $id): Response
    {
        //$repos = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(['id' => $produit->getId()]);
        $repos = $commerceProduit->getDataById($id);
        $form = $this->createForm(ProduitType::class, $repos);
        $form->handleRequest($request);

        /*if ($form->isSubmitted() && $form->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le produit '.$produit->getId().' est bien modifié!');

            return $this->redirectToRoute('produits');
        }*/
        //dd($commerce->getDataById($id));

        return $this->render('produit/edit.html.twig', [
            'produit' => $repos,
            'form' => $form->createView(),
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
