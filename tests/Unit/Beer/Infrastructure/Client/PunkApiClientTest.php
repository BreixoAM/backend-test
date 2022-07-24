<?php

namespace App\Tests\Unit\Beer\Infrastructure\Client;

use App\Beer\Domain\Entity\Beer as BeerEntity;
use App\Beer\Domain\Exception\NotFoundException;
use App\Beer\Domain\Factory\BeerFactory;
use App\Beer\Infrastructure\Client\PunkApiClient;
use Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PunkApiClientTest extends TestCase
{
    use ProphecyTrait;

    private const PUNK_API_URL = 'fake_url';
    private const ID = 1;
    private const FOOD = 'test_food';

    private PunkApiClient $punkApiClient;

    /**
     * @var ObjectProphecy<HttpClientInterface>
     */
    private ObjectProphecy $httpClientProphecy;

    /**
     * @var ObjectProphecy<BeerFactory>
     */
    private ObjectProphecy $beerFactoryProphecy;

    public function setUp(): void
    {
        $this->httpClientProphecy = $this->prophesize(HttpClientInterface::class);
        $this->beerFactoryProphecy = $this->prophesize(BeerFactory::class);

        $this->punkApiClient = new PunkApiClient(
            $this->httpClientProphecy->reveal(),
            $this->beerFactoryProphecy->reveal(),
            self::PUNK_API_URL
        );
    }

    /** @test */
    public function getByIdReturnsBeerEntity(): void
    {
        $beerEntity = $this->prophesize(BeerEntity::class)->reveal();
        $beerData = ['fake' => 'data'];

        $responseProphecy = $this->prophesize(ResponseInterface::class);
        $responseProphecy
            ->toArray()
            ->willReturn([$beerData]);

        $url = self::PUNK_API_URL.'/'.self::ID;
        $this->httpClientProphecy
            ->request('GET', $url)
            ->shouldBeCalledOnce()
            ->willReturn($responseProphecy);

        $this->beerFactoryProphecy
            ->createEntityFromData($beerData)
            ->shouldBeCalledOnce()
            ->willReturn($beerEntity);

        $resultBeerEntity = $this->punkApiClient->getById(self::ID);

        self::assertSame($beerEntity, $resultBeerEntity);
    }

    /** @test */
    public function getByIdThrowsNotFoundException(): void
    {
        $url = self::PUNK_API_URL.'/'.self::ID;
        $this->httpClientProphecy
            ->request('GET', $url)
            ->shouldBeCalledOnce()
            ->willThrow(new Exception('Error'));

        $this->expectException(NotFoundException::class);

        $this->punkApiClient->getById(self::ID);
    }

    /** @test */
    public function searchByFoodReturnsBeerEntity(): void
    {
        $beerEntity = $this->prophesize(BeerEntity::class)->reveal();
        $beerData = ['fake' => 'data'];

        $responseProphecy = $this->prophesize(ResponseInterface::class);
        $responseProphecy
            ->toArray()
            ->willReturn([$beerData]);

        $url = self::PUNK_API_URL.'?food='.self::FOOD;
        $this->httpClientProphecy
            ->request('GET', $url)
            ->shouldBeCalledOnce()
            ->willReturn($responseProphecy);

        $this->beerFactoryProphecy
            ->createEntityFromData($beerData)
            ->shouldBeCalledOnce()
            ->willReturn($beerEntity);

        $result = $this->punkApiClient->searchByFood(self::FOOD);

        self::assertCount(1, $result);
    }

    /** @test */
    public function searchByFoodThrowsNotFoundException(): void
    {
        $url = self::PUNK_API_URL.'?food='.self::FOOD;
        $this->httpClientProphecy
            ->request('GET', $url)
            ->shouldBeCalledOnce()
            ->willThrow(new Exception('Error'));

        $this->expectException(NotFoundException::class);

        $this->punkApiClient->searchByFood(self::FOOD);
    }
}
