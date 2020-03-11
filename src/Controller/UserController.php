<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

//    /**
//     *fonction permet d'afficher le profil de l'utilisateur
//     * @Route("/test/{id}", name="test" ,  methods={"GET"})
//     * @return JsonResponse
//     */
//    public function test($id , UserPasswordEncoderInterface $passwordEncoder)
//    {
//        $res = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneById($id);
//        $test= $passwordEncoder->encodePassword(new User(),"test");
//
//        return new JsonResponse(
//            $test
//        );
//
//    }

}