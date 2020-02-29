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

    // /**
    //  * @return Jardin[] Returns an array of Jardin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


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
            j.averageDurationVisit
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
            j.nameParcGarden
            "
            )
            ->where('j.nameParcGarden LIKE :keyWords')
            ->setParameter('keyWords', "%".$keyWords."%");;
        return $query->getQuery()->getArrayResult();
    }
}
