<?php

namespace App\Repository;

use App\Entity\CandidatStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CandidatStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidatStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidatStage[]    findAll()
 * @method CandidatStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidatStage::class);
    }

    // /**
    //  * @return CandidatStage[] Returns an array of CandidatStage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CandidatStage
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
