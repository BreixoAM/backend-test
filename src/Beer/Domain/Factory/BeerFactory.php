<?php

declare(strict_types=1);

namespace App\Beer\Domain\Factory;

use App\Beer\Domain\Entity\Beer;

class BeerFactory
{
    /**
     * @param array{
     *     'id': int, 'name': ?string, 'description': ?string, 'image_url': ?string,
     *     'image_url': ?string, 'tagline': ?string, 'first_brewed': ?string
     * } $data
     */
    public function createEntityFromData(array $data): Beer
    {
        $beer = new Beer();
        $beer->setId($data['id']);
        $beer->setName($data['name']);
        $beer->setDescription($data['description']);
        $beer->setImageUrl($data['image_url']);
        $beer->setTagLine($data['tagline']);
        $beer->setFirstBrewed($data['first_brewed']);

        return $beer;
    }
}
