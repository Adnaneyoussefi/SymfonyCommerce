<?php

namespace App\Controller;

use CategorieService;
use App\Service\AllData;
use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController{

    /**
     * @Route("/categories", name="categories")
     */
    public function index(AllData $commerceCategorie): Response
    {
        //dd($commerceCategorie->getDataById(2));

        return $this->render('categorie/index.html.twig', [
            'categories' => $commerceCategorie->getAllData()["categorie"]
        ]);
    }

    /**
     * @Route("/categories/new", name="categorie_new")
     */
    public function new(AllData $commerceCategorie, Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getNormData());
            $commerceCategorie->addData($form->getNormData());
            $this->addFlash('success', 'Vous avez ajouter la catégorie avec succées !');
            return $this->redirectToRoute('categories');
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categories/{id}/edit", name="categorie_edit", methods={"GET","POST"})
     */
    public function edit(AllData $commerceCategorie, Request $request, $id): Response
    {
        //$repos = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(['id' => $produit->getId()]);
        $repos = $commerceCategorie->getDataById($id);
        $form = $this->createForm(CategorieType::class, $repos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commerceCategorie->updateDataById($id, $form->getNormData());
            //$this->getDoctrine()->getManager()->flush();
            $this->addFlash('warning', 'La catégorie est bien modifié!');

            return $this->redirectToRoute('categories');
        }

        return $this->render('categorie/edit.html.twig', [
            'categorie' => $repos,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categories/{id}", name="categorie_delete")
     */
    public function delete(AllData $commerceCategorie, Request $request, $id): Response
    {
        $categorie = $commerceCategorie->getDataById($id);
        if(count($categorie->getProduits()) == 0) {
            $commerceCategorie->deleteDataById($id);
            $this->addFlash('alert', 'La categorie a été supprimé');
        }
        else {
            $this->addFlash('warning', 'Attention la categorie est associée à un produit !!');
        }       
        return $this->redirectToRoute('categories');
    }

}