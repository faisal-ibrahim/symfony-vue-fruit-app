<?php

declare(strict_types=1);

namespace App\Tests\functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FruitControllerTest extends WebTestCase
{
    public function testGetFavoriteFruits(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/fruits/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
