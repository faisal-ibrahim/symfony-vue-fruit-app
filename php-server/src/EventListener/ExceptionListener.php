<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        // Get the exception object from the event
        $exception = $event->getThrowable();

        // Create the JSON response
        $response = new JsonResponse([
            'message' => $exception->getMessage()
        ]);

        // Set the response on the event
        $event->setResponse($response);
    }
}
