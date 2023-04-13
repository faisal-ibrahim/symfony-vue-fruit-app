<?php

declare(strict_types=1);

namespace App\Tests\unit\Command;

use App\Command\FetchFruitsCommand;
use App\Service\FetchFruits;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class FetchFruitsCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $fetchFruitsMock = $this->createMock(FetchFruits::class);
        $fetchFruitsMock
            ->expects($this->once())
            ->method('fetch')
            ->willReturn(['fetchCount' => 10, 'upsertCount' => 5]);

        $command = new FetchFruitsCommand($fetchFruitsMock);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Fetched = 10', $output);
        $this->assertStringContainsString('Inserted/Updated = 5', $output);
    }
}
