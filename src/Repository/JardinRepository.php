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


    public function findOneBySomeField($value): ?Jardin
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.id = :val')
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
            j.name ,
            j.description
            "
            );
        return $query->getQuery()->getArrayResult();
    }
}
