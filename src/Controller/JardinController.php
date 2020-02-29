<?php

namespace App\Controller;

use App\Entity\Jardin;
use App\Form\ContactInformationType;
use App\Form\InformationType;
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
     * @Route("/jardins", name="jardins_list", methods={"GET"})
     */
    public function list()
    {

        $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->findAllJardin();
        foreach ($res as $key => $value)
        {
            if($value["photo"] != null)
            {
                $res[$key]["photo"] = base64_encode(file_get_contents($value["photo"]));
            }
        }

         return new JsonResponse(
        [
            "jardins_list" => $res
        ], Response::HTTP_CREATED
    );
    }

    /**
     * @Route("/new", name="new_jardin", methods={"POST"})
     */
    public function add(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $contactInformation = $data["garden"]["contactInformation"];
        $usefulInformation = $data["garden"]["usefulInformation"];
        $openingConditions = $data["garden"]["openingConditions"];
        $visit = $data["garden"]["visit"];
        $information = $data["garden"]["information"];
        $special = $data["garden"]["special"];
        $media = $data["garden"]["media"];
        $photoBase64 = $data["photo"];

        $visit["typeVisit"] = $this->extraireTabToChaine($visit["typeVisit"]);
        $usefulInformation["disabilityAccessibility"] = $this->extraireTabToChaine($usefulInformation["disabilityAccessibility"]);

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

        $name = '../public/jardins/'.$contactInformation["nameParcGarden"].'.png';
        if($photoBase64 != null)
        {
            $photo = file_put_contents($name, base64_decode($photoBase64));
            $jardin->setPhoto($name);
        }

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

    /**
     * @Route("/jardin/{id}", name="jardin_show", methods={"GET"})
     */
    public function show($id)
    {

        $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->findOneById($id);
        if($res != null)
        {
         $res["typeVisit"] = $this->extraireChaineToTab($res["typeVisit"]);
            if($res["photo"] != null)
            {
                $res["photo"] = base64_encode(file_get_contents($res["photo"]));
            }
        }

        return new JsonResponse(
            [
                "jardin" => $res
            ], Response::HTTP_CREATED
        );
    }

    protected static function extraireTabToChaine($array) : string
    {
        $res = "";
        foreach ($array as $key => $value)
        {
            if($key < count($array)-1)  $res .= $value."|";
            else  $res .= $value;
        }
        return $res ;
    }

    protected static function extraireChaineToTab($string) : array
    {

        return  explode("|", $string);
    }


}
