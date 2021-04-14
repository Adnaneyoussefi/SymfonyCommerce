<?php

namespace App\Controller;

use App\Service\AllData;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produit")
     */
    public function index(AllData $commerce): Response
    {
        //dd($commerce->getAllData()["produit"]);
        return $this->render('produit/index.html.twig', [
            'produits' => "fds"
        ]);
    }
}
