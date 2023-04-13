<?php

declare(strict_types=1);

namespace App\Tests\unit\Entity;

use App\Entity\FavoriteFruits;
use App\Entity\Fruit;
use PHPUnit\Framework\TestCase;

final class FavoriteFruitsTest extends TestCase
{
    private FavoriteFruits $favoriteFruits;
    private Fruit $fruit;
    private int $userId = 1;

    protected function setUp(): void
    {
        $this->fruit = new Fruit();
        $this->favoriteFruits = new FavoriteFruits();
    }

    public function testGetId()
    {
        $this->assertNull($this->favoriteFruits->getId());
    }

    public function testGetAndSetFruit()
    {
        $this->favoriteFruits->setFruit($this->fruit);

        $this->assertInstanceOf(Fruit::class, $this->favoriteFruits->getFruit());
    }

    public function testGetAndSetUserId()
    {
        $this->favoriteFruits->setUserId($this->userId);

        $this->assertEquals($this->userId, $this->favoriteFruits->getUserId());
    }
}
