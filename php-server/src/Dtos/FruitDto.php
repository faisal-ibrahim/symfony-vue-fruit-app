<?php

declare(strict_types=1);

namespace App\Dtos;

class FruitDto
{
    public function __construct(
        private string $name,
        private string $family,
        private string$genus,
        private int $fruityviceId,
        private string $fruitOrder,
        private float $calories,
        private float $fat,
        private float $sugar,
        private float $carbohydrates,
        private float $protien,
    ) {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFamily(): string
    {
        return $this->family;
    }

    public function getGenus(): string
    {
        return $this->genus;
    }

    public function getFruityviceId(): int
    {
        return $this->fruityviceId;
    }

    public function getFruitOrder(): string
    {
        return $this->fruitOrder;
    }

    public function getCalories(): float
    {
        return $this->calories;
    }

    public function getFat(): float
    {
        return $this->fat;
    }

    public function getSugar(): float
    {
        return $this->sugar;
    }

    public function getCarbohydrates(): float
    {
        return $this->carbohydrates;
    }

    public function getProtien(): float
    {
        return $this->protien;
    }

}