<?php

declare(strict_types=1);

namespace App\Beer\Infrastructure\Client;

use App\Beer\Domain\Entity\Beer;
use App\Beer\Domain\Exception\NotFoundException;
use App\Beer\Domain\Factory\BeerFactory;
use App\Beer\Domain\Repository\BeerRepositoryInterface;
use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInstance;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class PunkApiClient implements BeerRepositoryInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private BeerFactory $beerFactory,
        private string $punkApiUrl
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function getById(int $id): Beer
    {
        $url = $this->punkApiUrl."/{$id}";

        try {
            $response = $this->client->request('GET', $url);
            $content = $response->toArray()[0];
        } catch (Throwable $e) {
            throw new NotFoundException($e->getMessage());
        }

        return $this->beerFactory->createEntityFromData($content);
    }

    /**
     * @return CollectionInstance<int, Beer>
     *
     * @throws NotFoundException
     */
    public function searchByFood(string $food): CollectionInstance
    {
        $url = $this->punkApiUrl."?food={$food}";

        try {
            $response = $this->client->request('GET', $url);

            return Collection::fromIterable($response->toArray())
                ->map(function ($beerData): Beer {
                    return $this->beerFactory->createEntityFromData($beerData);
                });
        } catch (Throwable $e) {
            throw new NotFoundException($e->getMessage());
        }
    }
}
