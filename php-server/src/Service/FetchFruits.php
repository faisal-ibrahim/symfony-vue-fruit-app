<?php

namespace App\Service;

use App\Dtos\FruitDto;
use App\Service\FruitService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchFruits
{
    public function __construct(
        private FruitService $fruitService,
        private HttpClientInterface $client,
        private LoggerInterface $logger
    ) {
    }

    public function fetch(): array
    {
        $fetchCount = 0;
        $upsertCount = 0;

        try {
            //Fetch fruits from fruityvice
            $response = $this->client->request(
                'GET',
                'https://fruityvice.com/api/fruit/all'
            );

            //If the request is successful
            if ($response->getStatusCode() == 200) {
                $fruitsArray = $response->toArray();
                $fetchCount = count($fruitsArray);

                //Insert each fruit into database
                foreach ($fruitsArray as $fruit) {
                    $fruitDto = new FruitDto(
                        $fruit['name'],
                        $fruit['family'],
                        $fruit['genus'],
                        $fruit['id'],
                        $fruit['order'],
                        $fruit['nutritions']['calories'],
                        $fruit['nutritions']['fat'],
                        $fruit['nutritions']['sugar'],
                        $fruit['nutritions']['carbohydrates'],
                        $fruit['nutritions']['protein'],
                    );

                    //Save into database
                    if ($this->fruitService->createOrUpdate($fruitDto)) {
                        $upsertCount++;
                    }
                }
            } else {
                $this->logger->error('Error on fetching fruits');
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return [
            'fetchCount' => $fetchCount,
            'upsertCount' => $upsertCount,
        ];
    }
}
