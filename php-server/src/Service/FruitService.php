<?php

namespace App\Service;

use App\Dtos\FruitDto;
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

    public function createOrUpdate(FruitDto $fruitDto): bool
    {

        $fruit = $this->fruitRepository->findOneByFruityviceId($fruitDto->getFruityviceId());

        if ($fruit == null) {
            $fruit = new Fruit();
        }

        $fruit->setName($fruitDto->getName());
        $fruit->setFamily($fruitDto->getFamily());
        $fruit->setGenus($fruitDto->getGenus());
        $fruit->setFruityviceId($fruitDto->getFruityviceId());
        $fruit->setFruitOrder($fruitDto->getFruitOrder());
        $fruit->setCalories($fruitDto->getCalories());
        $fruit->setFat($fruitDto->getFat());
        $fruit->setSugar($fruitDto->getSugar());
        $fruit->setCarbohydrates($fruitDto->getCarbohydrates());
        $fruit->setProtein($fruitDto->getProtien());

        $sum = $fruitDto->getCalories() + $fruitDto->getFat()
            + $fruitDto->getSugar() + $fruitDto->getCarbohydrates()
            + $fruitDto->getProtien();
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
        $fruitResult = [
            'data' => [],
            'totalResult' => 0
        ];
        try {
            $userId = 1;
            $fruitResult = $this->fruitRepository->search($userId, $page, $limit, $filter);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $fruitResult;
    }
}
