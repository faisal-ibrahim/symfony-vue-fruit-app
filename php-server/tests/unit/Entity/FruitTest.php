<?php

declare(strict_types=1);

namespace App\Tests\unit\Entity;

use App\Entity\Fruit;
use PHPUnit\Framework\TestCase;

final class FruitTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $fruit = new Fruit();

        $fruit->setFruityviceId(123);
        $this->assertEquals(123, $fruit->getFruityviceId());

        $fruit->setName('Apple');
        $this->assertEquals('Apple', $fruit->getName());

        $fruit->setFamily('Rosaceae');
        $this->assertEquals('Rosaceae', $fruit->getFamily());

        $fruit->setFruitOrder('Rosales');
        $this->assertEquals('Rosales', $fruit->getFruitOrder());

        $fruit->setGenus('Malus');
        $this->assertEquals('Malus', $fruit->getGenus());

        $fruit->setCalories(95);
        $this->assertEquals(95, $fruit->getCalories());

        $fruit->setFat(1.3);
        $this->assertEquals(1.3, $fruit->getFat());

        $fruit->setSugar(19);
        $this->assertEquals(19, $fruit->getSugar());

        $fruit->setCarbohydrates(25);
        $this->assertEquals(25, $fruit->getCarbohydrates());

        $fruit->setProtein(0.5);
        $this->assertEquals(0.5, $fruit->getProtein());

        $fruit->setNutritionSum(20);
        $this->assertEquals(20, $fruit->getNutritionSum());

        $fruit->setIsFavorite(true);
        $this->assertEquals(true, $fruit->getIsFavorite());
    }
}
