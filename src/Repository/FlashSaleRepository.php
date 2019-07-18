<?php

namespace App\Repository;

use App\Entity\FlashSale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FlashSale|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlashSale|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlashSale[]    findAll()
 * @method FlashSale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlashSaleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FlashSale::class);
    }

    public function getPagination($offset, $limit)
    {

        return $this->createQueryBuilder('d')
            ->orderBy('d.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return FlashSale[] Returns an array of FlashSale objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FlashSale
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
