<?php

declare(strict_types=1);

namespace App\Beer\Application\Service;

use App\Beer\Application\Factory\BeerFactory;
use App\Beer\Application\Model\Beer as beerModel;
use App\Beer\Domain\Entity\Beer as BeerEntity;
use App\Beer\Domain\Repository\BeerRepositoryInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class BeerService
{
    public function __construct(
        private SerializerInterface $serializer,
        private BeerRepositoryInterface $beerRepository,
        private BeerFactory $beerFactory
    ) {
    }

    public function getById(int $id, string $groups = 'details'): string
    {
        $beerEntity = $this->beerRepository->getById($id);
        $beerModel = $this->beerFactory->createModelFromEntity($beerEntity);

        return $this->serializer->serialize(
            $beerModel,
            JsonEncoder::FORMAT,
            ['groups' => $groups]
        );
    }

    public function searchByFood(string $food, string $groups = 'list'): string
    {
        $beers = $this->beerRepository->searchByFood($food);

        $beersCollection = $beers->map(function (BeerEntity $beerEntity): BeerModel {
            return $this->beerFactory->createModelFromEntity($beerEntity);
        });

        return $this->serializer->serialize(
            $beersCollection,
            JsonEncoder::FORMAT,
            ['groups' => $groups]
        );
    }
}
