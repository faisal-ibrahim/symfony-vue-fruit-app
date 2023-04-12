<?php

namespace App\Service;

use App\Entity\FavoriteFruits;
use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Exception;
use Psr\Log\LoggerInterface;

class FruitService
{
    public function __construct(
        private FruitRepository $fruitRepository,
        private LoggerInterface $logger
    ) {
    }

    public function createOrUpdate(array $data): bool
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

        try {
            $this->fruitRepository->save($fruit, true);
            return true;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return false;
    }

    public function search(int|null $page, int|null $limit, array $filter = []): array
    {
        $fruits = [];
        try {
            $userId = 1;
            $fruits = $this->fruitRepository->search($userId, $page, $limit, $filter);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $fruits;
    }
}
