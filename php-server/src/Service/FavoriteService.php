<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\FavoriteFruit;
use App\Repository\FavoriteFruitRepository;
use App\Repository\FruitRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class FavoriteService
{
    public function __construct(
        private readonly FruitRepository $fruitRepository,
        private readonly FavoriteFruitRepository $favoriteFruitRepository,
        private readonly LoggerInterface $logger
    ) {
    }

    public function get(int|null $page, int|null $limit): array
    {
        $userId = 1;

        $fruitResult = [
            'data' => [],
            'totalResult' => 0
        ];
        try {
            $fruitResult = $this->fruitRepository->getFavoriteFruit($userId, $page, $limit);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
        return $fruitResult;
    }

    public function add(int $fruitId): string
    {
        $userId = 1;

        $fruit = $this->fruitRepository->findOneById($fruitId);

        if (!$fruit) {
            throw new BadRequestException(
                'Requested fruit is not found. Unable to add as favorite.',
            );
        }

        $results = $this->favoriteFruitRepository->findByUserId($userId);

        if (count($results) >= 10) {
            throw new BadRequestException(
                'Maximum limit reached. You can only add upto10 fruits as your favorite.',
            );
        }

        $exist = false;
        foreach ($results as $object) {
            if ($object->getFruit()->getId() === $fruitId) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $favoriteFruit = new FavoriteFruit();
            $favoriteFruit->setUserId($userId);
            $favoriteFruit->setFruit($fruit);

            $this->favoriteFruitRepository->save($favoriteFruit, true);
        }

        return $fruit->getName();
    }

    public function remove(int $fruitId): string
    {
        $userId = 1;

        $favoriteFruit = $this
            ->favoriteFruitRepository
            ->findOneByUserIdFruitId($userId, $fruitId);

        if ($favoriteFruit) {
            $this->favoriteFruitRepository->remove($favoriteFruit, true);
        }

        $fruit = $this->fruitRepository->findOneById($fruitId);
        return empty($fruit) ? "" : $fruit->getName();
    }
}
