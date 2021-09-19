<?php

namespace App\System\Endpoint;


use App\Exceptions\ValidationException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class Endpoint
 * @package App\Endpoints
 */
abstract class Endpoint
{
    /**
     * @var array<Client>
     */
    protected static $clients;

    /**
     * @var Response|null
     */
    private $latestResponse;

    /**
     * @param $baseUri
     * @return Client
     */
    public function createClient($baseUri)
    {
        $config = config('endpoints.default');

        if (empty(static::$clients[$baseUri])) {
            static::$clients[$baseUri] = new Client([
                'base_uri' => $baseUri,
                'headers' => ['Content-Type' => 'application/json'],
                'cookies' => $config['cookies'],
                'decode_content' => $config['decode_content'],
                'verify' => $config['verify'],
                'expect' => '',
            ]);
        }

        /**
         * @var Client $client
         */
        return static::$clients[$baseUri];
    }

    /**
     * @param ApiRequest $apiRequest
     * @return array
     * @throws \Exception
     */
    public function send(ApiRequest $apiRequest)
    {
        $client = $this->createClient($apiRequest->getUrl()->getBaseUri());

        // Merge certificated auth.
        if ($apiRequest->getAuthType() and $apiRequest->getAuthData() === null) {
            $credentials = $this->retrieveCredentials($apiRequest);
            $apiRequest->setAuthData($credentials);
        }

        $response = $this->request($client, $apiRequest->getMethod(), $apiRequest->getUrl()->getPath(), [
                'query' => $apiRequest->getUrl()->getQuery(),
                'json' => $apiRequest->getBody(),
                'headers' => $apiRequest->getHeader(),
            ] + $apiRequest->getOptions()
        );

        $this->latestResponse = $response;

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    /**
     * Get latest endpoint response.
     * @return Response|null
     */
    public function getLatestResponse()
    {
        return $this->latestResponse;
    }

    /**
     * @param Client $client
     * @param string $method
     * @param string $path
     * @param array $options
     * @return Response
     * @throws AuthenticationException
     * @throws ValidationException
     */
    protected function request(Client $client, $method, $path, $options)
    {
        try {
            /**
             * @var Response $response
             */
            $response = $client->request($method, $path, $options);

            return $response;
        } catch (Exception $exception) {
            $response = method_exists($exception, 'getResponse') ? $exception->getResponse() : null;

            $this->handle($exception, $response);
        }
    }

    /**
     * Try get old auth data
     * Certificated
     *
     * @param ApiRequest $apiRequest
     * @return array|object
     */
    abstract public function retrieveCredentials($apiRequest);

    /**
     * Handle errors.
     *
     * @param Exception $exception
     * @param Response|null $response
     * @throws AuthenticationException
     * @throws ValidationException|Exception
     */
    public function handle (Exception $exception, $response = null)
    {
        // $response = $exception->getResponse();

        switch ($exception->getCode()) {
            case 422:
                throw new ValidationException([$exception->getMessage()]);
                break;

            case 401:
                throw new AuthenticationException($exception->getMessage());
                break;

            case 404:
                throw new NotFoundHttpException($exception->getMessage());
                break;

            default:
                throw $exception;
        }
    }
}
