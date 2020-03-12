<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RegistreController extends AbstractController
{
    /**
     *fonction permet à un utilisateur de s'enregistrer
     * @Route("/register", name="api_register" ,  methods={"POST"})
     * @return JsonResponse
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $form = $this->createForm(RegistreType::class, $user);
        $form->submit($data);

        $entityManager = $this->getDoctrine()->getManager();
        $userRepo = $entityManager->getRepository(User::class);

        if($userRepo->findUserByEmail($data["email"]) == null) {

            $user->setPassword(password_hash($form->get('password')->getData(),PASSWORD_DEFAULT));
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse(
                   201
            );

        }
        return new JsonResponse(
                'Adresse email déja utilisé'
            , Response::HTTP_RESERVED

        );
        }

    /**
     * @Route("/login", name="api_login", methods={"POST"})
     */
    public function login()
    {

        return new JsonResponse(
            Response::HTTP_OK
        );

    }

    /**
     * @Route("/profile", name="api_profile")
     * @IsGranted("ROLE_USER")
     */
    public function profile(Request $request)
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
//        $jwt = sscanf(, 'Authorization: Bearer %s');
        return $this->json([
//            'user' => $this->getUser()->getUsername()
            $authHeader
        ]);
    }


    }