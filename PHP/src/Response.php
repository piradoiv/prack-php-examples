<?php

namespace Prack;

use Psr\Http\Message\StreamInterface;

class Response implements \Psr\Http\Message\ResponseInterface
{
    private $identifier;
    private $body = '';
    private $code = 200;
    private $headers = [];

    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function withIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers ?: [];
    }

    public function hasHeader($name)
    {
        return in_array($name, array_keys($this->headers));
    }

    public function getHeader($name)
    {
        return $this->headers[$name] ?: null;
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        unset($this->headers[$name]);
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getEncodedBody()
    {
        return base64_encode($this->body);
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function withStringBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function getStatusCode()
    {
        return $this->code;
    }

    public function withStatus($code, $reasonPhrase = '')
    {
        $this->code = $code;
        return $this;
    }

    public function getReasonPhrase()
    {
        // TODO: Implement getReasonPhrase() method.
    }
}
