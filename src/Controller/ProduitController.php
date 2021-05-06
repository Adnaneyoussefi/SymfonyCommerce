<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Service\AllData;
use App\Entity\Categorie;
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

class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     */
    public function index(AllData $commerceProduit): Response
    {
        $produits = $commerceProduit->getAllData();
        return $this->render('produit/index.html.twig', [
            'produits' => array_reverse($produits),
        ]);
    }

    /**
     * @Route("/produits/new", name="produit_new")
     */
    function new (AllData $commerceProduit, AllData $commerceCategorie, Request $request): Response {
        $categories = $commerceCategorie->getAllData();
        if ($request->isMethod('POST')) {
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
        $categories = $commerceCategorie->getAllData();

        if ($request->isMethod('POST')) {
            $commerceProduit->updateDataById($id, $_POST);
            $this->addFlash('success', 'Vous avez modifié le produit avec succées !');
            return $this->redirectToRoute('produits');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $repos,
            'categories' => $categories,
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

    /**
     * @Route("/test", name="test")
     */
    public function test(AllData $commerceCategorie, AllData $commerceProduit)
    {
        $path_produits = "../src/Bouchonné/getListProduits.xml";
        $path_categories = "../src/Bouchonné/getListCategories.xml";

        $soapClient = new \SoapClient('http://127.0.0.1:8000/soap?wsdl');

        $produits_soap = $soapClient->getListProduits();
        $categories_soap = $soapClient->getListCategories();


        $produits = $this->convertResponseXML($path_produits);
        $categories = $this->convertResponseXML($path_categories);

        ///////////////
        $categoriesObject = [];
        foreach ($categories as $c) {
            $categorie = new Categorie();
            $categorie->setId((int)$c->id)
                ->setNom($c->nom);
            foreach(is_array($c->produits->item) ? $c->produits->item : [$c->produits->item]  as $p) {
                $produit = new Produit();
                $produit->setId((int)$p->id)
                        ->setNom($p->nom)
                        ->setDescription($p->description)
                        ->setPrix($p->prix)
                        ->setImage('')
                        ->setQuantite($p->quantite)
                        ->setCategorie($categorie);
                $categorie->addProduit($produit);
            }
            array_push($categoriesObject, $categorie);
        }
        
        dd($categoriesObject, $produits, $produits_soap, $categories, $categories_soap);
    }
    public function convertResponseXML($path_xml)
    {
        $xml = file_get_contents($path_xml);
        //$xml = preg_replace('#[a-zA-Z0-9]+="[\#a-zA-Z0-9]+"#', '', $xml);
        $xml = simplexml_load_string($xml);
        $data = $xml->xpath("//SOAP-ENV:Body/*/*")[0];
        $arrayResult = json_decode(json_encode($data));
        return $arrayResult->item;
    }
}