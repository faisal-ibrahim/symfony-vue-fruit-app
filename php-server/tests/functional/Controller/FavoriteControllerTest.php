<?php

namespace App\Tests\functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FavoriteControllerTest extends WebTestCase
{
    public function testGetFavoriteFruits(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/favorites/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAddFavoriteFruits(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/favorites/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteFavoriteFruits(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/favorites/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

