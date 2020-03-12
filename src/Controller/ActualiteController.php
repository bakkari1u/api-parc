<?php


namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Commentaire;
use App\Entity\Jardin;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ActualiteController extends AbstractController
{

    /**
     * fonction pour ajouter une actualite par un administrateur
     * @Route("/actualite/new", name="new_actualite", methods={"POST"})
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $file =  $_FILES['file'];
        $dataPost = $request->request->get("news");
        $data = json_decode($dataPost, true);

        $actualite = new Actualite();
        $actualite->setDescription($data["description"]);
        $actualite->setUrl($data["url"]);
        $actualite->setDate($data["date"]);
        if($file['tmp_name'] != '') $actualite->setPhoto((base64_encode(file_get_contents($file['tmp_name']))));
        else $actualite->setPhoto(null);
        $manager->persist($actualite);
        $manager->flush();

        return new JsonResponse(
            Response::HTTP_CREATED
        );
    }

    /**
     * fonction pour afficher tous les actualités de la semaine
     * @Route("/actualite/list", name="actualite_list", methods={"GET"})
     * @return JsonResponse
     */

    public function list()
    {

        $res = $this->getDoctrine()->getManager()->getRepository(Actualite::class)->findAllJardin();
        return new JsonResponse(
            $res, Response::HTTP_CREATED
        );
    }

    /**
     * fonction pour supprimer une actualité
     * @Route("/actualite/delete/{id}", name="delete_actualite", methods={"POST"})
     * @return JsonResponse
     */

    public function delete($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $actualite = $manager->getRepository(Actualite::class)->find($id);
        if($actualite)
        {
            $manager->remove($actualite);
            $manager->flush();
            return new JsonResponse(
                 Response::HTTP_NO_CONTENT
            );
        }
        return new JsonResponse(
             Response::HTTP_NOT_FOUND
        );
    }



}
