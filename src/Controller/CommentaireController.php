<?php


namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{

    /**
     * fonction pour ajouter un commentaire
     * @Route("/commentaire", name="new_comment", methods={"POST"})
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);
        $commentaire = new Commentaire();
        $formulaire = $this->createForm(CommentaireType::class, $commentaire);
        $formulaire->submit($data, false);
        $commentaire->setDate(new \DateTime());
        $manager->persist($commentaire);
        $manager->flush();

        return new JsonResponse(
             Response::HTTP_CREATED
        );
    }



}
