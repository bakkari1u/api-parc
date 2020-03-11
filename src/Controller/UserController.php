<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     *fonction permet d'afficher le profil de l'utilisateur
     * @Route("/user/{id}", name="profil_user" ,  methods={"GET"})
     * @return JsonResponse
     */
    public function show($id)
    {
        $res = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneById($id);
        if($res != null)
        {
            return new JsonResponse(
                $res, Response::HTTP_CREATED
            );
        }
        return new JsonResponse(
            "l'utilisateur n'existe pas", Response::HTTP_NOT_FOUND
        );

    }

}