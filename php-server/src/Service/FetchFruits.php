<?php

namespace App\Service;

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
                    //Adjust response according  to database
                    $fruit['fruityvice_id'] = $fruit['id'];
                    unset($fruit['id']);

                    $fruit['fruit_order'] = $fruit['order'];
                    unset($fruit['order']);

                    $nutritions = $fruit['nutritions'];
                    $fruit = array_merge($fruit, $nutritions);
                    unset($fruit['nutritions']);

                    //Save into database
                    if ($this->fruitService->createOrUpdate($fruit)) {
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
