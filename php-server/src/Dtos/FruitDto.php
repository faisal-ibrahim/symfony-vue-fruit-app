<?php

declare(strict_types=1);

namespace App\Dtos;

class FruitDto
{
    public function __construct(
        private readonly string $name,
        private readonly string $family,
        private readonly string $genus,
        private readonly int    $fruityviceId,
        private readonly string $fruitOrder,
        private readonly float  $calories,
        private readonly float  $fat,
        private readonly float  $sugar,
        private readonly float  $carbohydrates,
        private readonly float  $protien,
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
