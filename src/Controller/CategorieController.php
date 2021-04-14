<?php

namespace App\Controller;

use CategorieService;
use App\Service\AllData;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController{

    /**
     * @Route("/categories", name="categories")
     */
    public function index(AllData $commerce): Response
    {
        //dd($commerce->getAllData()["categorie"]);

        return $this->render('categorie/index.html.twig', [
            'categories' => $commerce->getAllData()["categorie"]
        ]);
    }

}