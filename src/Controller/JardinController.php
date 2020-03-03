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

        if($file != null)
        {
        $uploaddir = '../public/jardins/';
        $uploadfile = $uploaddir . basename($file['name']);
        chmod('../public/jardins/',766);
        move_uploaded_file($file['tmp_name'], $uploadfile);

        $jardin->setPhoto('../public/jardins/'.$file['name']);
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
         $res["typeGardenParc"] = $this->extraireChaineToTab($res["typeGardenParc"]);

            if($res["photo"] != null)
            {
                $res["photo"] = base64_encode(file_get_contents($res["photo"]));
            }
        }

        return new JsonResponse(

            $this->file($this->getParameter('photo').'../public/jardins/jardin1.png'), Response::HTTP_CREATED
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
    public static function geocodeAddress($address) {
        //valeurs vide par défaut
        $data = array('address' => '', 'lat' => '', 'lng' => '', 'city' => '', 'department' => '', 'region' => '', 'country' => '', 'postal_code' => '');
        //on formate l'adresse
        $address = str_replace(" ", "+", $address);
        //on fait l'appel à l'API google map pour géocoder cette adresse
        $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=" ."AIzaSyC_nJYQLTEyo52KeM4_T2UTT3W-rLi1e_c"."&address=$address&sensor=false&region=fr");
        $json = json_decode($json);
        //on enregistre les résultats recherchés
        if ($json->status == 'OK' && count($json->results) > 0) {
            $res = $json->results[0];
            //adresse complète et latitude/longitude
            $data['address'] = $res->formatted_address;
            $data['lat'] = $res->geometry->location->lat;
            $data['lng'] = $res->geometry->location->lng;
            foreach ($res->address_components as $component) {
                //ville
                if ($component->types[0] == 'locality') {
                    $data['city'] = $component->long_name;
                }
                //départment
                if ($component->types[0] == 'administrative_area_level_2') {
                    $data['department'] = $component->long_name;
                }
                //région
                if ($component->types[0] == 'administrative_area_level_1') {
                    $data['region'] = $component->long_name;
                }
                //pays
                if ($component->types[0] == 'country') {
                    $data['country'] = $component->long_name;
                }
                //code postal
                if ($component->types[0] == 'postal_code') {
                    $data['postal_code'] = $component->long_name;
                }
            }
        }
        return $data;
    }
    public static function curl_get_contents($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $html = curl_exec($ch);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    /**
     * @Route("/test", name="test", methods={"GET"})
     */
public function test(){


    $geocode = static::curl_get_contents('https://nominatim.openstreetmap.org/search.php?q=60120%20Picardie,%20France&format=json');
    $tab = json_decode($geocode,true);
    $latitude = $tab[0]['lat'];
    $longitude = $tab[0]['lon'];

    return new JsonResponse(
        $latitude
        , Response::HTTP_CREATED
    );

}



}
