<?php

declare(strict_types=1);

namespace App\Beer\Domain\Repository;

use App\Beer\Domain\Entity\Beer;
use App\Beer\Domain\Exception\NotFoundException;
use loophp\collection\Contract\Collection;

interface BeerRepositoryInterface
{
    /**
     * @throws NotFoundException
     */
    public function getById(int $id): Beer;

    /**
     * @throws NotFoundException
     *
     * @return Collection<int, Beer>
     */
    public function searchByFood(string $food): Collection;
}
