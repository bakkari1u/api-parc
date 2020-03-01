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
//        foreach ($res as $key => $value)
//        {
//            if($value["photo"] != null)
//            {
//                $res[$key]["photo"] = base64_encode(file_get_contents($value["photo"]));
//            }
//        }

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
        $file =  $_FILES['file'];
        $dataPost = $request->request->get("garden");

        $data = json_decode($dataPost, true);
        $contactInformation = $data["contactInformation"];
        $usefulInformation = $data["usefulInformation"];
        $openingConditions = $data["openingConditions"];
        $visit = $data["visit"];
        $information = $data["information"];
        $special = $data["special"];
        $media = $data["media"];
        //$photoBase64 = $data["photo"];

        $visit["typeVisit"] = $this->extraireTabToChaine($visit["typeVisit"]);
        $usefulInformation["disabilityAccessibility"] = $this->extraireTabToChaine($usefulInformation["disabilityAccessibility"]);
        $special["typeGardenParc"] = $this->extraireTabToChaine( $special["typeGardenParc"]);

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

//        $name = '../public/jardins/'.$contactInformation["nameParcGarden"].'.png';
//        if($photoBase64 != null)
//        {
//            $photo = file_put_contents($name, base64_decode($photoBase64));
//            $jardin->setPhoto($name);
//        }

        if($file != null)
        {
        $uploaddir = '../var/';
        $uploadfile = $uploaddir . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $uploadfile);

        $jardin->setPhoto('../var/'.$file['name']);
        }

        $manager->persist($jardin);
        $manager->flush();
        $manager->clear();

        return new JsonResponse(
        [
            "success" => true
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
                 $res
            ], Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/jardins/{keyWords}", name="jardins_research_keyWords", methods={"GET"})
     */
    public function researchKeyWords($keyWords)
    {

        $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->finJardinWithKeyWords($keyWords);
        return new JsonResponse(
            [
                "jardins_name" => $res
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

    protected static function extraireChaineToTab($string)
    {

        return  $string == null ? null : explode("|", $string);
    }

    /**
     * @Route("/jardins-filters/criteria/{params?1}", name="jardins_research_criteria", methods={"GET"})
     */
    public function researchCriteria($params)
    {
        $jardinRepository = $this->getDoctrine()->getManager()->getRepository(Jardin::class);
        $paramsTab = array();
        if($params == 1)
        {
            $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->findAllJardin();
        }
        else
        {
         $filterTab = explode("&", $params);
         foreach ($filterTab as $key => $value)
         {
             $tab = explode("=", $value);
             if($tab[0] == "remarkableLabel") $paramsTab["remarkableLabel"] = $tab[1] ;
             if($tab[0] == "state") $paramsTab["state"] = $tab[1] ;
             if($tab[0] == "city") $paramsTab["city"] = $tab[1] ;
             if($tab[0] == "disabilityAccessibility") $paramsTab["disabilityAccessibility"] = $tab[1] ;
         }

            $res = $jardinRepository->findByFilters($paramsTab);
        }
        return new JsonResponse(
            [
                "jardins_list" => $res
            ], Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/test", name="test", methods={"GET"})
     */
      public function test(){
          $test = "";
           foreach (new \DirectoryIterator('../var/') as $fileInfo) {
             if ($fileInfo->isDot()) continue;
             $test .= $fileInfo->getFilename() ."-------";
}
          return new JsonResponse(
              [
                  "test" => $test
              ], Response::HTTP_CREATED
          );
}


}
