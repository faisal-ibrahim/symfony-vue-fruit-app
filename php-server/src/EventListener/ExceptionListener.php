<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Psr\Log\LoggerInterface;

class ExceptionListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        // Get the exception object from the event
        $exception = $event->getThrowable();

        //Log non http exception
        if (empty($exception->getCode()) || $exception->getCode() == 0) {
            $this->logger->error($exception->getMessage());
        }

        // Create the JSON response
        $response = new JsonResponse([
            'message' => $exception->getMessage()
        ]);

        // Set the response on the event
        $event->setResponse($response);
    }
}
