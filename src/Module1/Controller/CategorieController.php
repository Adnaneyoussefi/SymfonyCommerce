<?php

namespace App\Module1\Controller;

use App\Module1\WebService\AllData;
use App\Module1\Entity\Categorie;
use App\Module1\Form\CategorieType;
use App\Module1\WebService\ExceptionMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController{

    /**
     * @Route("/categories", name="categories")
     */
    public function index(AllData $commerceCategorie): Response
    {
        $categories = $commerceCategorie->getAllData();
        return $this->render('module1/categorie/index.html.twig', [
            'categories' => $categories
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
        $repos = $commerceCategorie->getDataById($id);
        $form = $this->createForm(CategorieType::class, $repos);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commerceCategorie->updateDataById($id, $form->getNormData());
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
    public function delete(AllData $commerceCategorie, $id): Response
    {
        try
        {
            //$categorie = $commerceCategorie->getDataById($id);
            /*if(count($categorie->getProduits()) == 0) {
                $commerceCategorie->deleteDataById($id);
                $this->addFlash('success', 'La catégorie a été bien supprimé');
            }*/
            $response = $commerceCategorie->deleteDataById($id);
            if($response->code != '204')
                throw new ExceptionMessage($response->msg, $response->code);
            return $this->redirectToRoute('categories');
            //dd($response);
            /*else {
                throw new ExceptionMessage
                $this->addFlash('warning', 'Attention la categorie est associée à un produit !!');
            }*/
        } catch(\Exception $e)
        {
            $this->addFlash('alert', $e->getMessage());
            return $this->redirectToRoute('categories');
        }
        
        
    }
}