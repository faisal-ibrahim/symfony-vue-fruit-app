<?php

namespace App\Service;

use App\Entity\FavoriteFruits;
use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;

class FruitService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FruitRepository $fruitRepository,
        private LoggerInterface $logger
    ) {
    }

    public function createOrUpdate($data): bool
    {

        $fruit = $this->fruitRepository->findOneByFruityviceId($data['fruityvice_id']);

        if ($fruit == null) {
            $fruit = new Fruit();
        }

        $fruit->setName($data['name']);
        $fruit->setFamily($data['family']);
        $fruit->setGenus($data['genus']);
        $fruit->setFruityviceId($data['fruityvice_id']);
        $fruit->setFruitOrder($data['fruit_order']);
        $fruit->setCalories($data['calories']);
        $fruit->setFat($data['fat']);
        $fruit->setSugar($data['sugar']);
        $fruit->setCarbohydrates($data['carbohydrates']);
        $fruit->setProtein($data['protein']);

        $sum = $data['calories'] + $data['fat']
            + $data['sugar'] + $data['carbohydrates']
            + $data['protein'];
        $fruit->setNutritionSum($sum);


        $this->entityManager->persist($fruit);

        try {
            $this->entityManager->flush();
            return true;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return false;
    }

    public function search($page, $limit, $filter = []): array
    {
        $fruits = [];
        try {

            $queryBuilder = $this->entityManager->createQueryBuilder();

            $queryBuilder->select('f')
                ->from(Fruit::class, 'f');


            /**
             * Add filters to query builder
             */
            if (isset($filter['name']) && !empty($filter['name'])) {
                $queryBuilder->andWhere('f.name > :name')
                    ->setParameter('name', $filter['name']);
            }


            if (isset($filter['family']) && !empty($filter['family'])) {
                $queryBuilder->andWhere('f.family > :family')
                    ->setParameter('family', $filter['family']);
            }

            /**
             * Add isFavorite calculation
             */

            $userId = 1;

            $queryBuilder
                ->leftJoin(FavoriteFruits::class, 'ff', 'WITH', 'ff.fruit = f AND ff.user_id = :userId')
                ->setParameter('userId', $userId)
                ->addSelect('ff.id as favorite_fruit_id');

            /**
             * Add pagination
             */
            $page = empty($page) ? 0 : $page - 1;
            $limit = empty($limit) ? 20 : $limit;
            $firstResult = $page * $limit;


            $queryBuilder
                ->setFirstResult($firstResult)
                ->setMaxResults($limit);


            /**
             * Get result
             */
            $results = $queryBuilder->getQuery()->getResult();


            /**
             * Populate isFavorite property
             */
            foreach ($results as $result) {
                $fruit = $result[0];
                $favoriteFruitId = $result['favorite_fruit_id'];
                $fruit->setIsFavorite($favoriteFruitId !== null);
                $fruits[] = $fruit;
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $fruits;
    }
}
