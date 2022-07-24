<?php

namespace App\Tests\Unit\Beer\Application\Factory;

use App\Beer\Application\Factory\BeerFactory;
use App\Beer\Domain\Entity\Beer as BeerEntity;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

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

    /**
     * @var ObjectProphecy<BeerEntity>
     */
    private ObjectProphecy $beerEntityProphecy;

    public function setUp(): void
    {
        $this->beerFactory = new BeerFactory();
        $this->beerEntityProphecy = $this->prophesizeBeerEntity();
    }

    /** @test */
    public function createModelFromEntityReturnsExpectedResult(): void
    {
        $resultBeerModel = $this->beerFactory->createModelFromEntity($this->beerEntityProphecy->reveal());

        self::assertSame(self::ID, $resultBeerModel->getId());
        self::assertSame(self::NAME, $resultBeerModel->getName());
        self::assertSame(self::DESCRIPTION, $resultBeerModel->getDescription());
        self::assertSame(self::IMAGE_URL, $resultBeerModel->getImageUrl());
        self::assertSame(self::TAG_LINE, $resultBeerModel->getTagLine());
        self::assertSame(self::FIRST_BREWED, $resultBeerModel->getFirstBrewed());
    }

    /**
     * @return ObjectProphecy<BeerEntity>
     */
    private function prophesizeBeerEntity(): ObjectProphecy
    {
        $beerEntityProphecy = $this->prophesize(BeerEntity::class);
        $beerEntityProphecy->getId()->willReturn(self::ID);
        $beerEntityProphecy->getName()->willReturn(self::NAME);
        $beerEntityProphecy->getDescription()->willReturn(self::DESCRIPTION);
        $beerEntityProphecy->getImageUrl()->willReturn(self::IMAGE_URL);
        $beerEntityProphecy->getTagLine()->willReturn(self::TAG_LINE);
        $beerEntityProphecy->getFirstBrewed()->willReturn(self::FIRST_BREWED);

        return $beerEntityProphecy;
    }
}
