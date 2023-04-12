<?php

namespace App\Controller;

use App\Service\FruitService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/fruit', name: 'fruit')]
class FruitController extends AppController
{
    public function __construct(
        private FruitService $fruitService
    ) {
    }

    #[Route('/', methods: ['GET'], name: 'fruit_search')]
    public function search(Request $request): JsonResponse
    {
        $filter = [
            'family' => $request->query->get('family'),
            'name' => $request->query->get('name'),
        ];

        $page = $request->query->get('page');
        $limit = $request->query->get('limit');

        $data = $this->fruitService->search($page, $limit, $filter);

        return $this->jsonResponse(data: $data);
    }
}
