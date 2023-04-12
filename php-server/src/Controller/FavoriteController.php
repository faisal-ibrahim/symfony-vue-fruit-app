<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\FavoriteService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/favorite', name: 'fruit')]
class FavoriteController extends AppController
{
    public function __construct(private FavoriteService $favoriteService) {
    }

    #[Route('/', methods: ['GET'], name: 'get_favorite_fruits')]
    public function get(Request $request): JsonResponse
    {
        $page = $request->query->get('page');
        $limit = $request->query->get('limit');

        $data = $this->favoriteService->get($page, $limit);

        return $this->jsonResponse(data: $data);
    }

    #[Route('/{id}', name: 'add_favorite_fruits', methods: ['POST'])]
    public function add(int $id): JsonResponse
    {
        $this->favoriteService->add($id);

        return $this->jsonResponse(message: 'Successfully added as favorite');
    }

    #[Route('/{id}', name: 'delete_favorite_fruits', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->favoriteService->remove($id);

        return $this->jsonResponse(message: 'Successfully removed from favorite');
    }
}
