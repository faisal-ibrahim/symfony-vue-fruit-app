<?php

namespace App\Tests\unit\Service;

use PHPUnit\Framework\TestCase;
use App\Service\FruitService;
use App\Dtos\FruitDto;
use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Psr\Log\LoggerInterface;

class FruitServiceTest extends TestCase
{
    private FruitRepository $fruitRepository;
    private LoggerInterface $logger;
    private FruitService $fruitService;

    protected function setUp(): void
    {
        $this->fruitRepository = $this->createMock(FruitRepository::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->fruitService = new FruitService($this->fruitRepository, $this->logger);
    }

    public function testSearchShouldReturnFruitsMatchingFilter()
    {
        $page = 1;
        $limit = 10;
        $filter = ['family' => 'Rosaceae'];

        $fruitResult = [
            'data' => [new Fruit(), new Fruit()],
            'totalResult' => 2
        ];

        $this->fruitRepository->expects($this->once())
            ->method('search')
            ->with(1, $page, $limit, $filter)
            ->willReturn($fruitResult);

        $this->assertEquals($fruitResult, $this->fruitService->search($page, $limit, $filter));
    }
}
