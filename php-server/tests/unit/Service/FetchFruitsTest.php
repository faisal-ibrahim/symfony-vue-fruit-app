<?php

declare(strict_types=1);

namespace App\Tests\unit\Service;

use App\Dtos\FruitDto;
use App\Service\FetchFruits;
use App\Service\FruitService;
use App\Service\MailerService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class FetchFruitsTest extends TestCase
{
    private FruitService $fruitService;
    private HttpClientInterface $client;
    private LoggerInterface $logger;
    private MailerService $mailerService;

    protected function setUp(): void
    {
        $this->fruitService = $this->createMock(FruitService::class);
        $this->client = $this->createMock(HttpClientInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->mailerService = $this->createMock(MailerService::class);
    }

    public function testFetchReturnsCorrectValues()
    {
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock
            ->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $fruitArray = [
            [
                'name' => 'Apple',
                'family' => 'Rosaceae',
                'genus' => 'Malus',
                'id' => 123,
                'order' => 'Rosales',
                'nutritions' => [
                    'calories' => 52,
                    'fat' => 0.2,
                    'sugar' => 10.4,
                    'carbohydrates' => 14,
                    'protein' => 0.3,
                ]
            ]
        ];

        $responseMock
            ->expects($this->once())
            ->method('toArray')
            ->willReturn($fruitArray);

        $this->client
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'https://fruityvice.com/api/fruit/all')
            ->willReturn($responseMock);

        $this->fruitService
            ->expects($this->once())
            ->method('createOrUpdate')
            ->with(new FruitDto(
                'Apple',
                'Rosaceae',
                'Malus',
                123,
                'Rosales',
                52,
                0.2,
                10.4,
                14,
                0.3,
            ))
            ->willReturn(true);

        $this->mailerService
            ->expects($this->once())
            ->method('sendEmail')
            ->with(
                $this->equalTo('user@email.com'),
                $this->equalTo('Fetching fruits'),
                $this->equalTo("Dear User,\n\nThe operation of fetching fruit has been completed.")
            );

        $fetchFruits = new FetchFruits(
            $this->fruitService,
            $this->client,
            $this->logger,
            $this->mailerService
        );

        $result = $fetchFruits->fetch();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('fetchCount', $result);
        $this->assertArrayHasKey('upsertCount', $result);
        $this->assertEquals(1, $result['fetchCount']);
        $this->assertEquals(1, $result['upsertCount']);
    }

    public function testFetchLogsErrorOnNon200Response()
    {
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock
            ->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(500);

        $this->client
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'https://fruityvice.com/api/fruit/all')
            ->willReturn($responseMock);

        $this->logger
            ->expects($this->once())
            ->method('error')
            ->with('Error on fetching fruits');

        $fetchFruits = new FetchFruits(
            $this->fruitService,
            $this->client,
            $this->logger,
            $this->mailerService
        );

        $result = $fetchFruits->fetch();

        $this->assertEquals([
            'fetchCount' => 0,
            'upsertCount' => 0,
        ], $result);
    }
}