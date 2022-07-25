<?php

namespace App\Tests\Unit\Beer\Application\Service;

use App\Beer\Application\Factory\BeerFactory;
use App\Beer\Application\Model\Beer as BeerModel;
use App\Beer\Application\Service\BeerService;
use App\Beer\Domain\Entity\Beer as BeerEntity;
use App\Beer\Domain\Repository\BeerRepositoryInterface;
use loophp\collection\Collection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class BeerServiceTest extends TestCase
{
    use ProphecyTrait;

    private const ID = 1;
    private const FOOD = 'strawberry';

    private BeerService $beerService;

    /**
     * @var ObjectProphecy<SerializerInterface>
     */
    private ObjectProphecy $serializerProphecy;

    /**
     * @var ObjectProphecy<BeerRepositoryInterface>
     */
    private ObjectProphecy $beerRepositoryProphecy;

    /**
     * @var ObjectProphecy<BeerFactory>
     */
    private ObjectProphecy $beerFactoryProphecy;

    /**
     * @var ObjectProphecy<BeerEntity>
     */
    private ObjectProphecy $beerEntityProphecy;

    /**
     * @var ObjectProphecy<BeerModel>
     */
    private ObjectProphecy $beerModelProphecy;

    public function setUp(): void
    {
        $this->serializerProphecy = $this->prophesize(SerializerInterface::class);
        $this->beerRepositoryProphecy = $this->prophesize(BeerRepositoryInterface::class);
        $this->beerFactoryProphecy = $this->prophesize(BeerFactory::class);

        $this->beerService = new BeerService(
            $this->serializerProphecy->reveal(),
            $this->beerRepositoryProphecy->reveal(),
            $this->beerFactoryProphecy->reveal()
        );

        $this->beerEntityProphecy = $this->prophesize(BeerEntity::class);
        $this->beerModelProphecy = $this->prophesize(BeerModel::class);
    }

    /** @test */
    public function getByIdReturnsExpectedSerializedData(): void
    {
        $serializedData = 'Serialized data';

        $this->beerRepositoryProphecy
            ->getById(self::ID)
            ->shouldBeCalledOnce()
            ->willReturn($this->beerEntityProphecy);

        $this->beerFactoryProphecy
            ->createModelFromEntity($this->beerEntityProphecy->reveal())
            ->shouldBeCalledOnce()
            ->willReturn($this->beerModelProphecy);

        $this->serializerProphecy
            ->serialize($this->beerModelProphecy->reveal(), JsonEncoder::FORMAT, ['groups' => 'details'])
            ->shouldBeCalledOnce()
            ->willReturn($serializedData);

        $resultSerializedData = $this->beerService->getById(self::ID);

        self::assertSame($serializedData, $resultSerializedData);
    }

    /** @test */
    public function searchByFoodReturnsExpectedSerializedData(): void
    {
        $serializedData = 'Serialized data';

        $beerEntity1 = $this->beerEntityProphecy->reveal();
        $beerEntities = Collection::fromIterable([$beerEntity1])->squash();

        $this->beerRepositoryProphecy
            ->searchByFood(self::FOOD)
            ->shouldBeCalledOnce()
            ->willReturn($beerEntities);

        $this->beerFactoryProphecy
            ->createModelFromEntity($beerEntity1)
            ->shouldBeCalledOnce()
            ->willReturn($this->beerModelProphecy);

        $this->serializerProphecy
            ->serialize(Argument::any(), JsonEncoder::FORMAT, ['groups' => 'list'])
            ->shouldBeCalledOnce()
            ->willReturn($serializedData);

        $resultSerializedData = $this->beerService->searchByFood(self::FOOD);

        self::assertSame($serializedData, $resultSerializedData);
    }
}
