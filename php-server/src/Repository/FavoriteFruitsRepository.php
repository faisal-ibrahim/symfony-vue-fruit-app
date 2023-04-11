<?php

namespace App\Repository;

use App\Entity\FavoriteFruits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FavoriteFruits>
 *
 * @method FavoriteFruits|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteFruits|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteFruits[]    findAll()
 * @method FavoriteFruits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteFruitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoriteFruits::class);
    }

    public function save(FavoriteFruits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FavoriteFruits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FavoriteFruits[] Returns an array of FavoriteFruits objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FavoriteFruits
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
