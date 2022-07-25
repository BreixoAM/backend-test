<?php

declare(strict_types=1);

namespace App\Beer\Application\Factory;

use App\Beer\Application\Model\Beer as beerModel;
use App\Beer\Domain\Entity\Beer as BeerEntity;

class BeerFactory
{
    public function createModelFromEntity(BeerEntity $beerEntity): beerModel
    {
        $beerModel = new BeerModel();
        $beerModel->setId($beerEntity->getId());
        $beerModel->setName($beerEntity->getName());
        $beerModel->setDescription($beerEntity->getDescription());
        $beerModel->setImageUrl($beerEntity->getImageUrl());
        $beerModel->setTagLine($beerEntity->getTagLine());
        $beerModel->setFirstBrewed($beerEntity->getFirstBrewed());

        return $beerModel;
    }
}
