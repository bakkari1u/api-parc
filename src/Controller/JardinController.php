<?php

namespace App\Controller;

use App\Entity\Jardin;
use App\Form\ContactInformationType;
use App\Form\InformationType;
use App\Form\JardinType;
use App\Form\MediaType;
use App\Form\OpeningConditionsType;
use App\Form\SpecialType;
use App\Form\UsefulInformationType;
use App\Form\VisitType;
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

//        $jardin = new Jardin();
//        $jardin->setName($data["name"]);
//        $jardin->setAdresse($data["adresse"]);
//        $jardin->setCodePostale($data["codePostale"]);
//        $jardin->setType($data["type"]);
//        $jardin->setAnimauxAccept($data["animauxAccept"]);
//        $jardin->setPublicPrive($data["publicPrive"]);
//        $jardin->setVille($data["ville"]);
//        $jardin->setDescription($data["description"]);
//
//        $manager->persist($jardin);
//        $manager->flush();
//        $manager->clear();

        return new Response("OK");
    }

    /**
     * @Route("/jardins", name="jardin_show", methods={"GET"})
     */
    public function show()
    {

        $imagedata = file_get_contents("../public/jardins/1.jpg");
        $base64 = base64_encode($imagedata);

        $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->findAllJardin();
         return new JsonResponse(
        [
            "jardins_list" => $res,
            "photo" => $base64
        ], Response::HTTP_CREATED
    );
    }

    /**
     * @Route("/new", name="new_jardin", methods={"POST"})
     */
    public function add(Request $request):Response
    {
        $data = json_decode($request->getContent(), true);
        $contactInformation = $data["garden"]["contactInformation"];
        $usefulInformation = $data["garden"]["usefulInformation"];
        $openingConditions = $data["garden"]["openingConditions"];
        $visit = $data["garden"]["visit"];
        $information = $data["garden"]["information"];
        $special = $data["garden"]["special"];
        $media = $data["garden"]["media"];

        $manager = $this->getDoctrine()->getManager();
        $jardin = new Jardin();



        $formulaire0 = $this->createForm(ContactInformationType::class, $jardin);
        $formulaire1 = $this->createForm(UsefulInformationType::class, $jardin);
        $formulaire2 = $this->createForm(OpeningConditionsType::class, $jardin);
        $formulaire3 = $this->createForm(VisitType::class, $jardin);
        $formulaire4 = $this->createForm(InformationType::class, $jardin);
        $formulaire5 = $this->createForm(SpecialType::class, $jardin);
        $formulaire6 = $this->createForm(MediaType::class, $jardin);
        $formulaire0->submit($contactInformation, false);
        $formulaire1->submit($usefulInformation, false);
        $formulaire2->submit($openingConditions, false);
        $formulaire3->submit($visit, false);
        $formulaire4->submit($information, false);
        $formulaire5->submit($special, false);
        $formulaire6->submit($media, false);


        $manager->persist($jardin);
        $manager->flush();
        $manager->clear();

        return new JsonResponse(
        [
            "success" => true,
            "jardin_id" => $jardin->getId(),
        ], Response::HTTP_CREATED
    );
    }


}
