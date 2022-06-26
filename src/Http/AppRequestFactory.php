<?php

namespace App\Http;

use Cake\Http\ServerRequest;
use Laminas\Diactoros\Uri;

class AppRequestFactory
{
    /**
     * @param \Swoole\Http\Request $request
     * @return ServerRequest
     */
    public function build(\Swoole\Http\Request $request): ServerRequest
    {
        $uri = new Uri($request->server['request_uri']);
        if ($request->get) {
            $uri = $uri->withQuery(http_build_query($request->get));
        }

        return new ServerRequest([
            'query' => $request->get ?? [],
            'post' => $request->post ?? [],
            'files' => $request->files ?? [],
            'cookies' => $request->cookie ?? [],
            'environment' => [
                'REQUEST_METHOD' => $request->getMethod(),
            ],
            'uri' => $uri,
            'input' => $request->getContent(),
        ]);
    }
}
