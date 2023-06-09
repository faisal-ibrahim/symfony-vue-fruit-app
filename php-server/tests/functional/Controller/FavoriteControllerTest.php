<?php

declare(strict_types=1);

namespace App\Tests\functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class FavoriteControllerTest extends WebTestCase
{
    public function testGetFavoriteFruit(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/favorites/');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testAddFavoriteFruit(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/favorites/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $this->assertStringContainsString(
            'Fruit-0 is successfully added as your favorite fruit.',
            $client->getResponse()->getContent()
        );
    }

    public function testDeleteFavoriteFruit(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/favorites/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $this->assertStringContainsString(
            'Fruit-0 has been removed from your favorite fruit list.',
            $client->getResponse()->getContent()
        );
    }
}
