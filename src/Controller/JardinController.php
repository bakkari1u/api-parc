<?php

namespace App\Controller;

use App\Entity\Jardin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class JardinController extends AbstractController
{
    /**
     * @Route("/jardin", name="jardin")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/JardinController.php',
        ]);
    }

    /**
     * @Route("/jardin_add", name="jardin_add", methods={"POST"})
     */
    public function new(Request $request):Response
    {
        $data = json_decode($request->getContent(), true);
        $manager = $this->getDoctrine()->getManager();
        $jardin = new Jardin();
        $jardin->setName($data["name"]);
        $jardin->setAdresse($data["adresse"]);
        $jardin->setCodePostale($data["codePostale"]);
        $jardin->setType($data["type"]);
        $jardin->setAnimauxAccept($data["animauxAccept"]);
        $jardin->setPublicPrive($data["publicPrive"]);
        $manager->persist($jardin);
        $manager->flush();
        $manager->clear();
        return new Response("OK");
    }

    /**
     * @Route("/jardin_show", name="jardin_show", methods={"GET"})
     */
    public function show()
    {

        $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->findAllJardin();
         return new JsonResponse(
        [
            "jardins_list" => $res
        ], Response::HTTP_CREATED
    );
    }
}
