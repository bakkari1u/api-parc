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

class RegistreController extends AbstractController
{
    /**
     * @Route("/register", name="app_register" ,  methods={"POST"})
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

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse(
                [
                    "success" => true,
                    "user" => $user->getId()
                ], Response::HTTP_OK
            );

        }
        return new Response('Adresse email déja utilisé');
        }

}