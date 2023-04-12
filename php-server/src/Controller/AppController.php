<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AppController extends AbstractController
{
    public function jsonResponse(string $message = '', mixed $data = []): JsonResponse
    {
        $responseData = [
            'message' => $message,
            'data' => $data
        ];

        return $this->json(
            $responseData,
            headers: ['Content-Type' => 'application/json;charset=UTF-8']
        );
    }
}
