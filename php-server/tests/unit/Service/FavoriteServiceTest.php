<?php

declare(strict_types=1);

namespace App\Tests\unit\Service;

use App\Entity\FavoriteFruit;
use App\Entity\Fruit;
use App\Repository\FavoriteFruitRepository;
use App\Repository\FruitRepository;
use App\Service\FavoriteService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class FavoriteServiceTest extends TestCase
{
    private FavoriteService $favoriteService;

    private FruitRepository $fruitRepository;

    private FavoriteFruitRepository $favoriteFruitRepository;

    private LoggerInterface $logger;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fruitRepository = $this->createMock(FruitRepository::class);
        $this->favoriteFruitRepository = $this->createMock(FavoriteFruitRepository::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->favoriteService = new FavoriteService(
            $this->fruitRepository,
            $this->favoriteFruitRepository,
            $this->logger
        );
    }

    public function testGetReturnsArrayOfFruits(): void
    {
        $this->fruitRepository
            ->expects($this->once())
            ->method('getFavoriteFruit')
            ->with(1)
            ->willReturn(['apple', 'banana']);

        $result = $this->favoriteService->get(0, 10);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('apple', $result[0]);
        $this->assertEquals('banana', $result[1]);
    }

    public function testAddThrowsBadRequestExceptionWhenFruitNotFound(): void
    {
        $fruitId = 1;

        $this->fruitRepository
            ->expects($this->once())
            ->method('findOneById')
            ->with($fruitId)
            ->willReturn(null);

        $this->expectException(BadRequestException::class);

        $this->favoriteService->add($fruitId);
    }

    public function testAddThrowsBadRequestExceptionWhenMaxFavoriteFruitReached(): void
    {
        $fruitId = 1;
        $userId = 1;

        $fruit = new Fruit();

        $this->fruitRepository
            ->expects($this->once())
            ->method('findOneById')
            ->with($fruitId)
            ->willReturn($fruit);

        $this->favoriteFruitRepository
            ->expects($this->once())
            ->method('findByUserId')
            ->with($userId)
            ->willReturn([
                'fruit1', 'fruit2', 'fruit3', 'fruit4', 'fruit5',
                'fruit6', 'fruit7', 'fruit8', 'fruit9', 'fruit10']);

        $this->expectException(BadRequestException::class);

        $this->favoriteService->add($fruitId);
    }

    public function testAddDoesNotSaveWhenFruitAlreadyAdded(): void
    {
        $fruitId = 1;
        $userId = 1;

        $fruit = new Fruit();
        $fruit->setName("Name");

        $favoriteFruit = new FavoriteFruit();
        $favoriteFruit->setUserId($userId);
        $favoriteFruit->setFruit($fruit);

        $this->fruitRepository
            ->expects($this->once())
            ->method('findOneById')
            ->with($fruitId)
            ->willReturn($fruit);

        $this->favoriteFruitRepository
            ->expects($this->once())
            ->method('findByUserId')
            ->with($userId)
            ->willReturn([$favoriteFruit]);

        $this->favoriteService->add($fruitId);


        $this->favoriteFruitRepository
            ->expects($this->never())
            ->method('save');
    }

    public function testAddSavesFavoriteFruit(): void
    {
        $fruitId = 1;
        $userId = 1;

        $fruit = new Fruit();
        $fruit->setName("Name");

        $this->fruitRepository
            ->expects($this->once())
            ->method('findOneById')
            ->with($fruitId)
            ->willReturn($fruit);

        $this->favoriteFruitRepository
            ->expects($this->once())
            ->method('findByUserId')
            ->with($userId)
            ->willReturn([]);

        $this->favoriteFruitRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(function ($favoriteFruit) use ($userId, $fruit) {
                return $favoriteFruit instanceof FavoriteFruit
                    && $favoriteFruit->getUserId() === $userId
                    && $favoriteFruit->getFruit() === $fruit;
            }), true);

        $this->favoriteService->add($fruitId);
    }

    public function testRemove(): void
    {
        $fruitId = 1;
        $userId = 1;

        $favoriteFruit = $this->createMock(FavoriteFruit::class);

        $this->favoriteFruitRepository
            ->expects($this->once())
            ->method('findOneByUserIdFruitId')
            ->with($userId, $fruitId)
            ->willReturn($favoriteFruit);

        $this->favoriteFruitRepository
            ->expects($this->once())
            ->method('remove')
            ->with($favoriteFruit);

        $this->favoriteService->remove($fruitId);
    }

    public function testRemoveWithValidFruitId(): void
    {
        $fruitId = 123;
        $userId = 1;

        $favoriteFruit = $this->createMock(FavoriteFruit::class);

        $this->favoriteFruitRepository
            ->expects($this->once())
            ->method('findOneByUserIdFruitId')
            ->with($userId, $fruitId)
            ->willReturn($favoriteFruit);

        $this->favoriteFruitRepository
            ->expects($this->once())
            ->method('remove')
            ->with($favoriteFruit);

        $this->favoriteService->remove($fruitId);
    }

    public function testRemoveWithInvalidFruitId(): void
    {
        $fruitId = 123;
        $userId = 1;

        $this->favoriteFruitRepository
            ->expects($this->once())
            ->method('findOneByUserIdFruitId')
            ->with($userId, $fruitId)
            ->willReturn(null);

        $this->favoriteFruitRepository
            ->expects($this->never())
            ->method('remove');

        $this->favoriteService->remove($fruitId);
    }
}
