<?php

namespace App\Service;

use App\Entity\FavoriteFruits;
use App\Entity\Fruit;
use App\Repository\FavoriteFruitsRepository;
use App\Repository\FruitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class FavoriteService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private FruitRepository $fruitRepository,
        private FavoriteFruitsRepository $favoriteFruitsRepository,
        private LoggerInterface $logger
    ) {
    }


    public function get(): array
    {
        $userId = 1;

        $fruits = [];

        try {
            $results = $this->entityManager
                ->createQueryBuilder()->select('f')
                ->from(Fruit::class, 'f')
                ->innerJoin(FavoriteFruits::class, 'ff', 'WITH', 'ff.fruit = f AND ff.user_id = :userId')
                ->setParameter('userId', $userId)
                ->getQuery()
                ->getResult();

            /**
             * Populate isFavorite property
             */
            foreach ($results as $fruit) {
                $fruit->setIsFavorite(true);
                $fruits[] = $fruit;
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $fruits;
    }

    public function add($fruitId): void
    {
        $userId = 1;

        $fruit = $this->fruitRepository->findOneBy([
            'id' => $fruitId
        ]);

        if (!$fruit) {
            throw new BadRequestException(
                'Fruit not found, invalid fruit id.',
            );
        }

        $results = $this->favoriteFruitsRepository->findBy([
            'user_id' => $userId
        ]);

        if (count($results) >= 10) {
            throw new BadRequestException(
                'Maximum number of favorite fruit reached.',
            );
        }

        $exist = false;
        foreach ($results as $object) {
            if ($object->getFruit()->getId() === $fruitId) {
                $exist = true;
                break;
            }
        }

        if ($exist) {
            //Already added, no operation required.
            return;
        }

        $favoriteFruit = new FavoriteFruits();

        $favoriteFruit->setUserId($userId);
        $favoriteFruit->setFruit($fruit);

        $this->entityManager->persist($favoriteFruit);

        $this->entityManager->flush();
    }

    public function remove($fruitId): void
    {
        $userId = 1;

        $favoriteFruit = $this->favoriteFruitsRepository->findOneBy([
            'fruit' => $fruitId,
            'user_id' => $userId
        ]);

        if (!$favoriteFruit) {
            //Already removed or never added, no operation required.
            return;
        }

        $this->entityManager->remove($favoriteFruit);

        $this->entityManager->flush();
    }
}
