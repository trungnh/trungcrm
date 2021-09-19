<?php

namespace App\System\Endpoint;

use Illuminate\Support\Arr;

/**
 * Class ApiRequest
 * @package App\Utilities
 */
class ApiRequest
{
    public static $config = 'endpoints';

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var UrlRender
     */
    protected $url;

    /**
     * @var array
     */
    protected $body = [];

    /**
     * @var array
     */
    protected $header = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var null|string
     */
    protected $authType;

    /**
     * @var null|array|string
     */
    protected $authData;

    /**
     * Requirement constructor.
     * @param string $method
     * @param UrlRender|array|string $url
     * @param array $body
     * @param array $header
     * @param array $options
     * @throws \Exception
     */
    public function __construct($method, $url, array $body = [], array $header = [], array $options = [])
    {
        $this->method = $method;

        if ($url instanceof UrlRender) {
            $this->url = $url;
        } elseif (is_string($url)) {
            $this->url = UrlRender::fromString($url);
        } elseif (is_array($url)) {
            $this->url = new UrlRender($url['baseUri'], $url['path'], $url['query'], $url['params']);
        } else {
            throw new \Exception('Url is invalid;');
        }

        $this->body = $body;

        $this->header = $header;

        $this->options = $options;
    }

    /**
     * Create instance Requirement use config
     * @param string $key Format 'feature->function'
     * @return ApiRequest
     * @throws \Exception
     */
    public static function fromConfig($key): ApiRequest
    {
        $config = config(self::$config . '.' . $key);

        $query = Arr::get($config, 'query', []);
        $body = Arr::get($config, 'body', []);
        $header = Arr::get($config, 'header', []);
        $authType = Arr::get($config, 'auth_type', null);

        $instance = new static(
            $config['method'],
            new UrlRender($config['base_uri'], $config['path'], $query),
            $body,
            $header
        );

        $instance->setAuthType($authType);

        return $instance;
    }

    /**
     * @param $query
     * @return ApiRequest
     */
    public function mergeQuery(array $query): ApiRequest
    {
        $this->url->mergeQuery($query);
        return $this;
    }

    /**
     * @param $body
     * @return ApiRequest
     */
    public function mergeBody(array $body): ApiRequest
    {
        $this->body = array_merge($this->body, $body);
        return $this;
    }

    /**
     * @param $header
     * @return ApiRequest
     */
    public function mergeHeaders(array $header): ApiRequest
    {
        $this->header = array_merge($this->header, $header);
        return $this;
    }

    /**
     * @param $options
     * @return ApiRequest
     */
    public function mergeOptions(array $options): ApiRequest
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return ApiRequest
     */
    public function setMethod(string $method): ApiRequest
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return UrlRender
     */
    public function getUrl(): UrlRender
    {
        return $this->url;
    }

    /**
     * @param UrlRender $url
     * @return ApiRequest
     */
    public function setUrl(UrlRender $url): ApiRequest
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set params.
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->getUrl()->setParams($params);

        return $this;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     * @return ApiRequest
     */
    public function setBody(array $body): ApiRequest
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * @param array $header
     * @return ApiRequest
     */
    public function setHeader(array $header): ApiRequest
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return ApiRequest
     */
    public function setOptions(array $options): ApiRequest
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return null
     */
    public function getAuthType()
    {
        return $this->authType;
    }

    /**
     * @return array|string|null
     */
    public function getAuthData()
    {
        return $this->authData;
    }

    /**
     * @param string $type
     * @return ApiRequest
     */
    public function setAuthType($type): ApiRequest
    {
        $this->authType = $type;

        return $this;
    }

    /**
     * @param $certificated
     * @return $this
     */
    public function setAuthData($certificated)
    {
        switch ($this->authType) {
            case 'basic':
                $this->header['Authorization'] = 'Basic ' . base64_encode("$certificated[0]:$certificated[1]");
                break;

            case 'bearer':
                $this->header['Authorization'] = "Bearer {$certificated}";
                break;

            case 'token_field':
                $this->body['token'] = $certificated;
                break;

            case 'credentials':
                $this->body['password'] = $certificated[0];
                $this->body['username'] = $certificated[1];
                break;

            case null:
                if (isset($this->header['Authorization'])) {
                    unset($this->header['Authorization']);
                }
                break;
        }

        $this->authData = $certificated;

        return $this;
    }
}
