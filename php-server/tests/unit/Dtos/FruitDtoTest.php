<?php

declare(strict_types=1);

namespace App\Tests\unit\Dtos;

use PHPUnit\Framework\TestCase;
use App\Dtos\FruitDto;

final class FruitDtoTest extends TestCase
{
    public function testCanCreateFruitDtoInstance(): void
    {
        $fruitDto = new FruitDto(
            'Apple1',
            'Rosaceae',
            'Malus',
            1234,
            'Rosales',
            52.0,
            0.2,
            10.4,
            14.0,
            0.3
        );

        $this->assertInstanceOf(FruitDto::class, $fruitDto);
    }

    public function testGetters(): void
    {
        $fruitDto = new FruitDto(
            'Apple',
            'Rosaceae',
            'Malus',
            1,
            'Rosales',
            52.1,
            0.2,
            10.3,
            13.8,
            0.3
        );

        $this->assertEquals('Apple', $fruitDto->getName());
        $this->assertEquals('Rosaceae', $fruitDto->getFamily());
        $this->assertEquals('Malus', $fruitDto->getGenus());
        $this->assertEquals(1, $fruitDto->getFruityviceId());
        $this->assertEquals('Rosales', $fruitDto->getFruitOrder());
        $this->assertEquals(52.1, $fruitDto->getCalories());
        $this->assertEquals(0.2, $fruitDto->getFat());
        $this->assertEquals(10.3, $fruitDto->getSugar());
        $this->assertEquals(13.8, $fruitDto->getCarbohydrates());
        $this->assertEquals(0.3, $fruitDto->getProtien());
    }
}
