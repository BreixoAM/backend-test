<?php

namespace App\Tests\Unit\Beer\Domain\Factory;

use App\Beer\Domain\Entity\Beer as BeerEntity;
use App\Beer\Domain\Factory\BeerFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class BeerFactoryTest extends TestCase
{
    use ProphecyTrait;

    private const ID = 1;
    private const NAME = 'Name';
    private const DESCRIPTION = 'Description';
    private const IMAGE_URL = 'Image url';
    private const TAG_LINE = 'Tag line';
    private const FIRST_BREWED = 'First brewed';

    private BeerFactory $beerFactory;

    public function setUp(): void
    {
        $this->beerFactory = new BeerFactory();
    }

    /** @test */
    public function createModelFromEntityReturnsExpectedResult(): void
    {
        $data = [
            'id' => self::ID,
            'name' => self::NAME,
            'description' => self::DESCRIPTION,
            'image_url' => self::IMAGE_URL,
            'tagline' => self::TAG_LINE,
            'first_brewed' => self::FIRST_BREWED,
        ];

        $resultBeerEntity = $this->beerFactory->createEntityFromData($data);

        self::assertSame(BeerEntity::class, get_class($resultBeerEntity));
        self::assertSame(self::ID, $resultBeerEntity->getId());
        self::assertSame(self::NAME, $resultBeerEntity->getName());
        self::assertSame(self::DESCRIPTION, $resultBeerEntity->getDescription());
        self::assertSame(self::IMAGE_URL, $resultBeerEntity->getImageUrl());
        self::assertSame(self::TAG_LINE, $resultBeerEntity->getTagLine());
        self::assertSame(self::FIRST_BREWED, $resultBeerEntity->getFirstBrewed());
    }
}
