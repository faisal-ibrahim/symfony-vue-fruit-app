<?php

namespace App\Repository;

use App\Entity\Fruit;
use App\Entity\FavoriteFruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fruit>
 *
 * @method Fruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruit[]    findAll()
 * @method Fruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    public function save(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByFruityviceId(int $id): ?Fruit
    {
        return $this->findOneBy([
            'fruityvice_id' => $id
        ]);
    }

    public function getFavoriteFruit(int $userId, int|null $page, int|null $limit): array
    {
        $page = empty($page) ? 0 : $page;
        $limit = empty($limit) ? 10 : $limit;
        $firstResult = $page * $limit;

        $fruits = [];
        $queryBuilder = $this
            ->getEntityManager()
            ->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->from(Fruit::class, 'f')
            ->innerJoin(FavoriteFruit::class, 'ff', 'WITH', 'ff.fruit = f AND ff.user_id = :userId')
            ->setParameter('userId', $userId);

        /**
         * Get count of rows
         */
        $count = (int)($queryBuilder->getQuery()->getSingleScalarResult());

        /**
         * Add pagination
         */
        $page = empty($page) ? 0 : $page;
        $limit = empty($limit) ? 10 : $limit;
        $firstResult = $page * $limit;


        $queryBuilder
            ->select('f')
            ->setFirstResult($firstResult)
            ->setMaxResults($limit);

        /**
         * Get result
         */
        $results = $queryBuilder->getQuery()->getResult();
        /**
         * Populate isFavorite property
         */
        foreach ($results as $fruit) {
            $fruit->setIsFavorite(true);
            $fruits[] = $fruit;
        }

        return [
            'data' => $fruits,
            'totalResult' => $count
        ];
    }

    public function findOneById(int $id): ?Fruit
    {
        return $this->findOneBy([
            'id' => $id
        ]);
    }

    public function search(
        int $userId,
        int|null $page,
        int|null $limit,
        array $filter = []
    ): array {

        $fruits = [];

        $queryBuilder = $this
            ->getEntityManager()
            ->createQueryBuilder('f')
            ->select('COUNT(f.id)')
            ->from(Fruit::class, 'f');

        /**
         * Add filters to query builder
         */
        if (isset($filter['name']) && !empty($filter['name'])) {
            $queryBuilder->andWhere('LOWER(f.name) = :name')
                ->setParameter('name', trim(strtolower($filter['name'])));
        }


        if (isset($filter['family']) && !empty($filter['family'])) {
            $queryBuilder->andWhere('LOWER(f.family) = :family')
                ->setParameter('family', trim(strtolower($filter['family'])));
        }

        /**
         * Add isFavorite calculation
         */

        $queryBuilder
            ->leftJoin(FavoriteFruit::class, 'ff', 'WITH', 'ff.fruit = f AND ff.user_id = :userId')
            ->setParameter('userId', $userId);

        /**
         * Get count of rows
         */
        $count = (int)($queryBuilder->getQuery()->getSingleScalarResult());

        /**
         * Add pagination
         */
        $page = empty($page) ? 0 : $page;
        $limit = empty($limit) ? 10 : $limit;
        $firstResult = $page * $limit;


        $queryBuilder
            ->select('f')
            ->addSelect('ff.id as favorite_fruit_id')
            ->setFirstResult($firstResult)
            ->setMaxResults($limit);

        /**
         * Get result
         */
        $results = $queryBuilder->getQuery()->getResult();

        //die(print_r($results));

        /**
         * Populate isFavorite property
         */
        foreach ($results as $result) {
            $fruit = $result[0];
            $favoriteFruitId = $result['favorite_fruit_id'];
            $fruit->setIsFavorite($favoriteFruitId !== null);
            $fruits[] = $fruit;
        }

        return [
            'data' => $fruits,
            'totalResult' => $count
        ];
    }
}
