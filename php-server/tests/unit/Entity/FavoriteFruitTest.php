<?php

declare(strict_types=1);

namespace App\Tests\unit\Entity;

use App\Entity\FavoriteFruit;
use App\Entity\Fruit;
use PHPUnit\Framework\TestCase;

final class FavoriteFruitTest extends TestCase
{
    private FavoriteFruit $FavoriteFruit;
    private Fruit $fruit;
    private int $userId = 1;

    protected function setUp(): void
    {
        $this->fruit = new Fruit();
        $this->FavoriteFruit = new FavoriteFruit();
    }

    public function testGetId()
    {
        $this->assertNull($this->FavoriteFruit->getId());
    }

    public function testGetAndSetFruit()
    {
        $this->FavoriteFruit->setFruit($this->fruit);

        $this->assertInstanceOf(Fruit::class, $this->FavoriteFruit->getFruit());
    }

    public function testGetAndSetUserId()
    {
        $this->FavoriteFruit->setUserId($this->userId);

        $this->assertEquals($this->userId, $this->FavoriteFruit->getUserId());
    }
}
