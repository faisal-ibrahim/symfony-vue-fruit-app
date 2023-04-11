<?php

namespace App\Controller;


use App\Service\FruitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/fruit', name: 'fruit')]
class FruitController extends AbstractController
{
    public function __construct(
        private FruitService $fruitService
    ) {
    }

    #[Route('/search', name: 'fruit_search')]
    public function search(Request $request): JsonResponse
    {
        $filter = [
            'family' => $request->query->get('family'),
            'name' => $request->query->get('name'),
        ];

        $page = $request->query->get('page');
        $limit = $request->query->get('limit');

        $data = $this->fruitService->search($page, $limit, $filter);

        $responseData = [
            'status' => true,
            'data' => $data
        ];

        return $this->json(
            $responseData,
            headers: ['Content-Type' => 'application/json;charset=UTF-8']
        );
    }
}
