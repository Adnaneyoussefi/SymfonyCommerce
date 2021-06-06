<?php

namespace App\Module1\Controller;

use App\Controller\GlobalController;
use App\Module1\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends GlobalController{

    /**
     * @Route("/users/{offres_id?}", name="users")
     */
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $routeParameters = $request->attributes->get('_route_params');
        $userProfilePage = $this->generateUrl('users', [
            'username' => 'aaa'
        ]);

        dd($routeParameters, $userProfilePage
        ,$userRepository->getUserById(4));
        return new Response("fff");
    }
}