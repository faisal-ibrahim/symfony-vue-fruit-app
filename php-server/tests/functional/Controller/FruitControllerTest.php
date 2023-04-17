<?php

declare(strict_types=1);

namespace App\Tests\functional\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FruitControllerTest extends WebTestCase
{
    public function testSearchFruits(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/fruits/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Test with filter values
        $client->request('GET', '/api/fruits/?family=Citrus&name=Orange&page=1&limit=10');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
}
