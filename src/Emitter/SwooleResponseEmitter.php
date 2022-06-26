<?php

namespace App\Emitter;

use Cake\Http\Cookie\Cookie;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @property \Swoole\Http\Response $swooleResponse
 */
class SwooleResponseEmitter implements EmitterInterface
{
    /**
     * @param \Swoole\Http\Response $swooleResponse
     */
    public function __construct(\Swoole\Http\Response $swooleResponse)
    {
        $this->swooleResponse = $swooleResponse;
    }

    /**
     * Emit the CakePHP using swoole response
     */
    public function emit(ResponseInterface $response): bool
    {
        if ($response->getStatusCode() === 302) {
            $this->swooleResponse->redirect($response->getHeader('Location')[0] ?? '');

            return true;
        }
        $cookies = [];
        if (method_exists($response, 'getCookieCollection')) {
            $cookies = iterator_to_array($response->getCookieCollection());
        }
        foreach ($response->getHeaders() as $name => $values ){
            if (strtolower($name) === 'set-cookie') {
                $cookies = array_merge($cookies, $values);
                continue;
            }
            $this->swooleResponse->setHeader($name, $values);
        }

        foreach ($cookies as $cookie) {
            $this->setCookie($cookie);
        }
        //For now, only need to send html
        $this->swooleResponse->end((string)$response->getBody());

        return true;
    }

    /**
     * Helper methods to set cookie.
     *
     * @param \Cake\Http\Cookie\CookieInterface|string $cookie Cookie.
     * @return bool
     */
    protected function setCookie($cookie): bool
    {
        if (is_string($cookie)) {
            $cookie = Cookie::createFromHeaderString($cookie, ['path' => '']);
        }

        $path = $cookie->getPath();
        $sameSite = $cookie->getSameSite();
        if ($sameSite !== null) {
            $path .= '; samesite=' . $sameSite;
        }

        return $this->swooleResponse->cookie(
            $cookie->getName(),
            $cookie->getScalarValue(),
            $cookie->getExpiresTimestamp() ?: 0,
            $path,
            $cookie->getDomain(),
            $cookie->isSecure(),
            $cookie->isHttpOnly()
        ) !== false;
    }
}
