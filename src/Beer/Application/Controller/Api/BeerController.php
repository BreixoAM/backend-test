<?php

declare(strict_types=1);

namespace App\Beer\Application\Controller\Api;

use App\Beer\Application\Service\BeerService;
use App\Beer\Domain\Exception\NotFoundException;
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
        private readonly BeerService $beerService
    ) {
    }

    #[Route('/{id}', name: 'get_beer', requirements: ['id' => '\d+'], methods: 'get')]
    public function getBeer(int $id, Request $request): Response
    {
        try {
            $beer = $this->beerService->getById($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException();
        }

        return JsonResponse::fromJsonString($beer);
    }

    #[Route('/search', name: 'search_beer', methods: 'get')]
    public function searchBeer(Request $request): Response
    {
        $food = $request->query->get('food');
        if (!is_string($food)) {
            throw new BadRequestException('Food parameter not provided');
        }

        try {
            $beers = $this->beerService->searchByFood($food);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException();
        }

        return JsonResponse::fromJsonString($beers);
    }
}
