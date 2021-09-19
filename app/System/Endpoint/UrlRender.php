<?php

namespace App\System\Endpoint;

use App\Utilities\Str;

/**
 * Class UrlRender
 * @package App\System\Endpoint
 */
class UrlRender
{
    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     */
    protected $query;

    /**
     * UrlRender constructor.
     * @param $baseUri
     * @param $path
     * @param array $params
     * @param array $query
     */
    public function __construct($baseUri, $path, $query = [], $params = [])
    {
        $this->baseUri = trim($baseUri, '/');
        $this->path = '/' . trim($path, '/');
        $this->params = $params;
        $this->query = $query;
    }

    /**
     * @param $url
     * @return UrlRender
     */
    public static function fromString($url)
    {
        $urlParser = parse_url($url);

        $baseUri = "{$urlParser['scheme']}//:{$urlParser['host']}";
        if (isset($urlParser['port'])) {
            $baseUri .= ":{$urlParser['port']}";
        }

        $path = rtrim($urlParser['path']);

        $query = explode('=', $urlParser['query']);

        return new static($baseUri, $path, $query);
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     * @return UrlRender
     */
    public function setBaseUri(string $baseUri): UrlRender
    {
        $this->baseUri = $baseUri;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        $path = $this->path;

        if ($this->params) {
            $path = Str::bind($this->path, $this->params);
        }

        return $path;
    }

    /**
     * @param string $path
     * @return UrlRender
     */
    public function setPath(string $path): UrlRender
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return UrlRender
     */
    public function setParams(array $params): UrlRender
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @param array $query
     * @return UrlRender
     */
    public function setQuery(array $query): UrlRender
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param $query
     * @return UrlRender
     */
    public function mergeQuery(array $query): UrlRender
    {
        $this->query = array_merge($this->query, $query);
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $query = http_build_query($this->getQuery());

        return "{$this->getBaseUri()}{$this->getPath()}?{$query}";
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUrl();
    }
}
