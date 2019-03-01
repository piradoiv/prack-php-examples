<?php

namespace Prack;

use \Psr\Http\Message\RequestInterface as RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request
{
    private $identifier;
    private $method;
    private $pathInfo;
    private $body;

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function withIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function withMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    public function getPathInfo()
    {
        return $this->pathInfo;
    }

    public function withPathInfo($pathInfo)
    {
        $this->pathInfo = $pathInfo;
        return $this;
    }

    public function buildFromEnvironment(Array $environment)
    {
        $this->withMethod($environment['REQUEST_METHOD'] ?: null)
            ->withPathInfo($environment['PATH_INFO'] ?: null);

        return $this;
    }
}