<?php

namespace App\Controller;

use App\Entity\User;
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

    /**
     *fonction permet de modifier les cordonnées de l'utilisateur
     * @Route("/update", name="updat_user" ,  methods={"POST"})
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)->find($data["id"]);
        $password_is_correct = password_verify($data["password"],$user->getPassword());
        if($password_is_correct)
        {
            if($data["username"]!=null and $data["username"]!="") $user->setUsername($data["username"]);
            if($data["firstname"]!=null and $data["firstname"]!="") $user->setFirstname($data["firstname"]);
            if($data["lastname"]!=null and $data["lastname"]!="") $user->setLastname($data["lastname"]);
            $user->setPassword(password_hash($data["new_password"],PASSWORD_DEFAULT));
            $manager->persist($user);
            $manager->flush();

            return new JsonResponse(
                200
            );
        }
        return new JsonResponse(
           "le mot de passe actuel est incorrect" ,  Response::HTTP_BAD_REQUEST
        );

    }

}