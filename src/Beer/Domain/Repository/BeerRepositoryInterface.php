<?php

declare(strict_types=1);

namespace App\Beer\Domain\Repository;

use App\Beer\Domain\Entity\Beer;
use loophp\collection\Contract\Collection;

interface BeerRepositoryInterface
{
    public function getById(int $id): Beer;

    /**
     * @return Collection<int, Beer>
     */
    public function searchByFood(string $food): Collection;
}
