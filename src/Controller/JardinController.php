<?php


namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Jardin;
use App\Form\ContactInformationType;
use App\Form\ContactType;
use App\Form\InformationType;
use App\Form\MediaType;
use App\Form\OpeningConditionsType;
use App\Form\SpecialType;
use App\Form\UsefulInformationType;
use App\Form\VisitType;
use App\Utils\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class JardinController extends AbstractController
{

    protected $helper;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

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
//                $res[$key]["photo"] = file_exists($value["photo"]) ? base64_encode(file_get_contents($value["photo"])) : $res[$key]["photo"];
//            }
//        }

         return new JsonResponse(
             $res, Response::HTTP_CREATED
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

        $visit["typeVisit"] = $this->helper->extraireTabToChaine($visit["typeVisit"]);
        $usefulInformation["disabilityAccessibility"] = $this->helper->extraireTabToChaine($usefulInformation["disabilityAccessibility"]);
        $special["typeGardenParc"] = $this->helper->extraireTabToChaine( $special["typeGardenParc"]);

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
//
//        if($file != null)
//        {
//        $uploaddir = '../public/jardins/';
//        $uploadfile = $uploaddir . basename($file['name']);
//        move_uploaded_file($file['tmp_name'], $uploadfile);
//
//        $jardin->setPhoto('../public/jardins/'.$file['name']);
//        }
        $jardin->setPhoto((base64_encode(file_get_contents($file['tmp_name']))));
//        $jardin->setPhoto(gzencode('oookkkkkkkkkkkkkkkkkkkkkkkkkkkkkjo',9));



        $address = $contactInformation["address"]." ".$contactInformation["zipCode"];
        if($this->helper->calculLatAndLong($address) == "error")
        {
            return new JsonResponse(
                [
                    "message" => "votre adresse est invalide"
                ], Response::HTTP_PRECONDITION_FAILED
            );
        }
        else
            {
            $tabCordonnee = $this->helper->calculLatAndLong($address);
            $jardin->setLatitude($tabCordonnee["latitude"]);
            $jardin->setLongitude($tabCordonnee["longitude"]);
            $manager->persist($jardin);
            $manager->flush();

        return new JsonResponse(
        [
            "success" => true
        ], Response::HTTP_CREATED
    );
    }}

    /**
     * @Route("/jardin/{id}", name="jardin_show", methods={"GET"})
     */
    public function show($id)
    {

        $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->findOneById($id);
        if($res != null)
        {
         $res["typeVisit"] = $this->helper->extraireChaineToTab($res["typeVisit"]);
         $res["typeGardenParc"] = $this->helper->extraireChaineToTab($res["typeGardenParc"]);

//            if($res["photo"] != null)
//            {
//                $res["photo"] = file_exists($res["photo"]) ? base64_encode(file_get_contents($res["photo"])) : $res["photo"];
//            }
        }

        return new JsonResponse(

            $res, Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/jardins-research/{keyWords}", name="jardins_research_keyWords", methods={"GET"})
     */
    public function researchKeyWords($keyWords)
    {

        $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->finJardinWithKeyWords($keyWords);
        return new JsonResponse(
           $res
            , Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/jardins-filter/{params?1}", name="jardins_research_criteria", methods={"GET"})
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
             if($tab[0] == "public") $paramsTab["public"] = $tab[1] ;
             if($tab[0] == "private") $paramsTab["private"] = $tab[1] ;
             if($tab[0] == "city") $paramsTab["city"] = $tab[1] ;
             if($tab[0] == "note") $paramsTab["note"] = $tab[1] ;
             if($tab[0] == "area") $paramsTab["area"] = $tab[1] ;
             if($tab[0] == "type") $paramsTab["type"] = $tab[1] ;
             if($tab[0] == "type") $paramsTab["type"] = $tab[1] ;
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
     * @Route("/note/{id}/{n}", name="jardins_note", methods={"POST"})
     */
    public function noterJardin($id , $n)
    {
        $manager = $this->getDoctrine()->getManager();
        $jardinRepo = $manager->getRepository(Jardin::class);

        $jardin =  $jardinRepo->findOneBy(["id" => $id]);
        $note = $jardin->getNote();
        if($note == 0) $jardin->setNote($n);
        else $jardin->setNote(($n+$note)/2);

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
     * @Route("/city-research/{keyWords}", name="city_research_keyWords", methods={"GET"})
     */
    public function researchCity($keyWords)
    {

        $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->finCityWithKeyWords($keyWords);
        return new JsonResponse(
            $res
            , Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/contact", name="contact", methods={"POST"})
     */
    public function contact(Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $contactRepo = $manager->getRepository(Contact::class);

        $data = json_decode($request->getContent(), true);
        $contact = new Contact();
        $formulaire = $this->createForm(ContactType::class, $contact);
        $formulaire->submit($data, false);
        $manager->persist($contact);
        $manager->flush();



        return new JsonResponse(
           [ "success" => true ]
            , Response::HTTP_CREATED
        );
    }

    /**
     * @Route("/jardin-best", name="jardins_best", methods={"GET"})
     */
    public function list_best()
    {

        $res = $this->getDoctrine()->getManager()->getRepository(Jardin::class)->finBestJardin();
//        foreach ($res as $key => $value)
//        {
//            if($value["photo"] != null)
//            {
//                $res[$key]["photo"] = file_exists($value["photo"]) ? base64_encode(file_get_contents($value["photo"])) : $res[$key]["photo"];
//            }
//        }

        return new JsonResponse(
            $res, Response::HTTP_CREATED
        );
    }


}
