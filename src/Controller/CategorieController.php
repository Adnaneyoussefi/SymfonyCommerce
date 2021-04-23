<?php

namespace App\Controller;

use App\Service\AllData;
use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;

class CategorieController extends AbstractController{

    /**
     * @Route("/categories", name="categories")
     */
    public function index(AllData $commerceCategorie): Response
    {
        $categories = $commerceCategorie->getAllData();
        return $this->render('categorie/index.html.twig', [
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