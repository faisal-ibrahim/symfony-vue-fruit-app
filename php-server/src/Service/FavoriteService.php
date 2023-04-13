<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\FavoriteFruits;
use App\Repository\FavoriteFruitsRepository;
use App\Repository\FruitRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class FavoriteService
{
    public function __construct(
        private readonly FruitRepository          $fruitRepository,
        private readonly FavoriteFruitsRepository $favoriteFruitsRepository,
        private readonly LoggerInterface          $logger
    )
    {
    }

    public function get(int|null $page, int|null $limit): array
    {
        $userId = 1;

        $fruitResult = [
            'data' => [],
            'totalResult' => 0
        ];
        try {
            $fruitResult = $this->fruitRepository->getFavoriteFruits($userId, $page, $limit);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
        return $fruitResult;
    }

    public function add(int $fruitId): void
    {
        $userId = 1;

        $fruit = $this->fruitRepository->findOneById($fruitId);

        if (!$fruit) {
            throw new BadRequestException(
                'Fruit not found, invalid fruit id.',
            );
        }

        $results = $this->favoriteFruitsRepository->findByUserId($userId);

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

        $this->favoriteFruitsRepository->save($favoriteFruit, true);
    }

    public function remove(int $fruitId): void
    {
        $userId = 1;

        $favoriteFruit = $this
            ->favoriteFruitsRepository
            ->findOneByUserIdFruitId($userId, $fruitId);

        if (!$favoriteFruit) {
            //Already removed or never added, no operation required.
            return;
        }

        $this->favoriteFruitsRepository->remove($favoriteFruit, true);
    }
}
