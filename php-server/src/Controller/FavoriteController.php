<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\FavoriteService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/favorites', name: 'fruit')]
class FavoriteController extends AppController
{
    public function __construct(private readonly FavoriteService $favoriteService)
    {
    }

    #[Route('/', methods: ['GET'], name: 'get_favorite_fruits')]
    public function get(Request $request): JsonResponse
    {
        $page = (int)($request->query->get('page'));
        $limit = (int)$request->query->get('limit');

        $data = $this->favoriteService->get($page, $limit);

        return $this->jsonResponse(data: $data);
    }

    #[Route('/{id}', name: 'add_favorite_fruits', methods: ['POST'])]
    public function add(int $id): JsonResponse
    {
        $fruitName = $this->favoriteService->add($id);

        return $this->jsonResponse(message: "$fruitName is successfully added as your favorite fruit.");
    }

    #[Route('/{id}', name: 'delete_favorite_fruits', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $fruitName = $this->favoriteService->remove($id);

        return $this->jsonResponse(message: "$fruitName has been removed from your favorite fruit list.");
    }
}
