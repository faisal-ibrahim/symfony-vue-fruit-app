<?php

declare(strict_types=1);

namespace App\Tests\functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class FavoriteControllerTest extends WebTestCase
{
    public function testGetFavoriteFruits(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/favorites/');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testAddFavoriteFruits(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/favorites/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $this->assertStringContainsString('Successfully added as favorite', $client->getResponse()->getContent());
    }

    public function testDeleteFavoriteFruits(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/favorites/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $this->assertStringContainsString('Successfully removed from favorite', $client->getResponse()->getContent());
    }
}
