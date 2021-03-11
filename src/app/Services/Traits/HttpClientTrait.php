<?php

namespace App\Services\Traits;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait HttpClientTrait
{
    private string $apiBaseUrl;
    private int $requestTimeout = 8;
    private array $headers;
    private string $token;

    /**
     * @param $url
     * @return $this
     */
    private function setBaseUrl($url): self
    {
        $this->apiBaseUrl = $url . '/' ;
        return $this;
    }

    /**
     * @param string $url
     * @param array $params
     * @return Response|null
     */
    private function httpGet(string $url, array $params = []): ?Response
    {
        $url = $this->getUrl($url);
        $client = $this->createClient();
        $res = $client->get($url, $params);

        if ($this->requestExceptionHandler($res, $url)) {
            return null;
        }

        return $res;
    }

    /**
     * @param string $url
     * @param array $params
     * @return object
     */
    private function httpGetObject(string $url, array $params = []): object
    {
        $response = $this->httpGet($url, $params);
        if ($response === null) {
            return (object) [];
        }

        return $response->object();
    }

    /**
     * @param string $url
     * @param array $params
     * @return string
     */
    private function httpGetBody(string $url, array $params = []): string
    {
        $response = $this->httpGet($url, $params);
        if ($response === null) {
            return "";
        }

        return $response->body();
    }

    /**
     * @param string $url
     * @return string
     */
    private function getUrl(string $url): string
    {
        return $this->apiBaseUrl . $url;
    }

    /**
     * @return PendingRequest
     */
    private function createClient(): PendingRequest
    {
        $client = Http::timeout($this->requestTimeout)
            ->withOptions(['verify' => false]);

        $client->withHeaders(['accept' => 'application/json']);

        return $client;
    }

    /**
     * @param Response $response
     * @param string $url
     * @return bool
     * @throws HttpException
     */
    private function requestExceptionHandler(Response $response, string $url): bool
    {
        if ($response->clientError() || $response->serverError()) {
            return true;
        }

        return false;
    }
}
