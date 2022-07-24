<?php

declare(strict_types=1);

namespace App\Beer\Application\Controller\Api;

use App\Beer\Application\Service\BeerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/beers')]
class BeerController extends AbstractController
{
    public function __construct(
        private BeerService $beerService
    ) {
    }

    #[Route('/search', name: 'search_beer', methods: 'get')]
    public function searchBeer(Request $request): Response
    {
        $food = $request->query->get('food');
        if (!is_string($food)) {
            throw new BadRequestException('Food parameter not provided');
        }

        return JsonResponse::fromJsonString(
            $this->beerService->searchByFood($food)
        );
    }

    #[Route('/{id}', name: 'get_beer', methods: 'get')]
    public function getBeer(int $id, Request $request): Response
    {
        return JsonResponse::fromJsonString(
            $this->beerService->getById($id)
        );
    }
}
