<?php

namespace App\Repository;

use App\Entity\Pyramid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pyramid>
 *
 * @method Pyramid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pyramid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pyramid[]    findAll()
 * @method Pyramid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PyramidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pyramid::class);
    }

    public function save(Pyramid $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pyramid $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByAuthor($id): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.author = :val')
            ->setParameter('val', $id)
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findById($Id): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $Id)
            ->getQuery()
            ->getResult();
    }



    //    /**
    //     * @return Pyramid[] Returns an array of Pyramid objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Pyramid
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
