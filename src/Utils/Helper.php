<?php

namespace App\Utils;

use App\Entity\Jardin;

/**
 * Class Helper
 * @package App\Utils
 */
class Helper
{

    /**
     * Helper constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $array
     * @return string
     */
    public function extraireTabToChaine($array) : string
    {
        $res = "";
        foreach ($array as $key => $value)
        {
            if($key < count($array)-1)  $res .= $value."|";
            else  $res .= $value;
        }
        return $res ;
    }

    /**
     * @param $string
     * @return array|null
     */
    public function extraireChaineToTab($string)
    {

        return  $string == null ? null : explode("|", $string);
    }

    /**
     * @param $url
     * @return bool|string
     */
    public function curl_get_contents($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param $address
     * @param $manager
     * @param $id
     */
    public function calculLatAndLong($address , $manager , $id){

        $geocode = static::curl_get_contents('https://nominatim.openstreetmap.org/search.php?q='.$address.'&format=json');
        $tab = json_decode($geocode,true);

        $jardinRepo = $manager->getRepository(Jardin::class);
        $jardin =  $jardinRepo->findOneBy(["id" => $id]);

        $latitude = $tab[0]['lat'];
        $longitude = $tab[0]['lon'];

        $jardin->setLatitude($latitude);
        $jardin->setLongitude($longitude);

        $manager->persist($jardin);
        $manager->flush();
        $manager->clear();

    }



}