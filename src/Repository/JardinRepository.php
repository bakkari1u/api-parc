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
            j.note
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
            j.photo
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
            ->setParameter('keyWords', "%".$keyWords."%");;
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
            j.photo
            "
            );
        if (array_key_exists( "remarkableLabel" , $params)) {
            $query = $query->andWhere("(j.remarkableLabel = :remarq)")
                ->setParameter("remarq", $params["remarkableLabel"]);
        }
        if (array_key_exists( "state" , $params)) {
            $query = $query->andWhere("(j.state = :s)")
                ->setParameter("s", $params["state"]);
        }
        if (array_key_exists( "city" , $params)) {
            $query = $query->andWhere("(j.city = :c)")
                ->setParameter("c", $params["city"]);
        }
        if (array_key_exists( "disabilityAccessibility" , $params)) {
            $query = $query->andWhere("(j.disabilityAccessibility is not null )");
        }
        return $query->getQuery()->getArrayResult();
    }

    }
