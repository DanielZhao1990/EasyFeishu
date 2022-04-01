<?php

namespace EasyFeishu\token;

use Psr\Http\Message\RequestInterface;

interface AccessTokenInterface
{
    public function getToken(): array;

    /**
     * @return AccessTokenInterface
     */
    public function refresh(): self;

    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface;
}
