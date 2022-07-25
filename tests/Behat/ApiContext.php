<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class ApiContext implements Context
{
    private ResponseInterface $response;

    public function __construct(
        private readonly HttpClientInterface $client
    ) {
    }

    /**
     * @Given I send a :method request to :url
     */
    public function iSendARequestToWithBody(string $method, string $url): void
    {
        $url = 'http://localhost'.$url;
        $this->response = $this->client->request('GET', $url);
    }

    /**
     * @Then the response status code should be :expectedResponseCode
     */
    public function theResponseStatusCodeShouldBe(string $expectedResponseCode): void
    {
        Assert::assertSame((int) $expectedResponseCode, $this->response->getStatusCode());
    }

    /**
     * @Then the response content should be:
     */
    public function theResponseContentShouldBe(string $string): void
    {
        Assert::assertEquals(
            json_decode((string) $string, true, 512, JSON_THROW_ON_ERROR),
            json_decode((string) $this->response->getContent(), true, 512, JSON_THROW_ON_ERROR),
            'The response is not equals'
        );
    }
}
