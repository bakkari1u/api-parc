<?php

namespace App\Repository;

use App\Entity\Jardin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Jardin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jardin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jardin[]    findAll()
 * @method Jardin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JardinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jardin::class);
    }

    public function findOneById($value)
    {
        return  $this->createQueryBuilder('j')
            ->select(
                "
            j.id,
            j.nameParcGarden ,
            j.address,
            j.zipCode,
            j.city,
            j.nameOwner,
            j.phone,
            j.emailAdress,
            j.descriptive,
            j.photo,
            j.webSite,
            j.typeGardenParc,
            j.Historical,
            j.dateTime,
            j.price,
            j.typeVisit,
            j.averageDurationVisit,
            j.note,
            j.latitude,
            j.longitude
            ")
            ->where('j.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findAllJardin()
    {
        $query = $this->createQueryBuilder('j')
            ->select(
                "
            j.id,
            j.nameParcGarden ,
            j.descriptive,
            j.photo,
            j.note
            "
            );
        return $query->getQuery()->getArrayResult();
    }

    public function finJardinWithKeyWords(string $keyWords)
    {
        $query = $this->createQueryBuilder('j')
            ->select(
                "
            j.id,
            j.nameParcGarden,
            j.zipCode,
            j.city
            "
            )
            ->where('j.nameParcGarden LIKE :keyWords')
            ->setParameter('keyWords', "%".$keyWords."%");
        return $query->getQuery()->getArrayResult();
    }
    public function findByFilters($params)
    {
        $query = $this->createQueryBuilder('j')
            ->select(
                "
            j.id,
            j.nameParcGarden ,
            j.descriptive,
            j.photo,
            j.note
            "
            );
        if (array_key_exists( "remarkableLabel" , $params)) {
            $query = $query->andWhere("(j.remarkableLabel = :remarq)")
                ->setParameter("remarq", true);
        }
        if (array_key_exists( "public" , $params)) {
            $query = $query->andWhere("(j.state like :s)")
                ->setParameter("s", 'public');
        }
        if (array_key_exists( "private" , $params)) {
            $query = $query->andWhere("(j.state like :s)")
                ->setParameter("s", 'privee');
        }
        if (array_key_exists( "city" , $params)) {
            $query = $query->andWhere("(j.city = :c)")
                ->setParameter("c", $params["city"]);
        }
        if (array_key_exists( "disabilityAccessibility" , $params)) {
            $query = $query->andWhere("(j.disabilityAccessibility is not null )");
        }
        if (array_key_exists( "note" , $params)) {
            $query = $query->addOrderBy('j.note', 'DESC');
        }
        if (array_key_exists( "area" , $params)) {
            $query = $query->addOrderBy('j.area', 'DESC');
        }
        if (array_key_exists( "type" , $params)) {
            $tab = explode("+" , $params["type"]);
            foreach ($tab as $value){
                if($value =="fr") $query = $query->andWhere('j.typeGardenParc like :type')->setParameter('type', "%française%");
                if($value =="ang") $query = $query->andWhere('j.typeGardenParc like :type')->setParameter('type', "%anglaise%");
                if($value =="med") $query = $query->andWhere('j.typeGardenParc like :type')->setParameter('type', "%médiéval%");
                if($value =="bot") $query = $query->andWhere('j.typeGardenParc like :type')->setParameter('type', "%botanique%");
                if($value =="pot") $query = $query->andWhere('j.typeGardenParc like :type')->setParameter('type', "%potager%");
            }
        }
        return $query->getQuery()->getArrayResult();
    }

    public function finCityWithKeyWords(string $keyWords)
    {
        $query = $this->createQueryBuilder('j')
            ->select(
                "
            DISTINCT j.city as name,
            j.zipCode
            "
            )
            ->where('j.city LIKE :keyWords')
            ->setParameter('keyWords', "%".$keyWords."%");;
        return $query->getQuery()->getArrayResult();
    }

    public function finBestJardin()
    {
        $query = $this->createQueryBuilder('j')
            ->select(
                "
            j.id,
            j.nameParcGarden ,
            j.descriptive,
            j.photo, 
            j.note
            "
            )
            ->addOrderBy('j.note', 'DESC')
            ->setMaxResults(4);
        return $query->getQuery()->getArrayResult();
    }

    }
