<?php

declare(strict_types=1);

namespace App\Service;

use App\Dtos\FruitDto;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchFruits
{
    public function __construct(
        private readonly FruitService $fruitService,
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
        private readonly MailerService $mailerService
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

                $this->mailerService->sendEmail(
                    to: "user@email.com",
                    subject: "Fruit fetching completed!",
                    text: "Dear user,\n\nYour operation of fetching fruits from the 'fruityvice.com' " .
                    "has been completed. Total $fetchCount fruits has been fetched and total $upsertCount has " .
                    "been inserted/updated into the application database."
                );
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
