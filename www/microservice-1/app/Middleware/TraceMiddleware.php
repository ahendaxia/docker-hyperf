<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Middleware;

use Hyperf\Tracer\SpanStarter;
use Hyperf\Utils\Coroutine;
use OpenTracing\Span;
use OpenTracing\Tracer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TraceMiddleware implements MiddlewareInterface
{
    use SpanStarter;

    /**
     * @var Tracer
     */
    private $tracer;

    public function __construct(Tracer $tracer)
    {
        $this->tracer = $tracer;
    }

    /**
     * Process an incoming server request.
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $span = $this->buildSpan($request);

//        defer(function () {
//            $this->tracer->flush();
//        });
        try {
            $response = $handler->handle($request);
        } finally {
            if(isset($request->getHeader("user-agent")[0]) && $request->getHeader("user-agent")[0]!='Consul Health Check'){
                $span->finish();
                $this->tracer->flush();
            }
        }

        return $response;
    }

    protected function buildSpan(ServerRequestInterface $request): Span
    {
        $uri = $request->getUri();
        $span = $this->startSpan('request');
        $span->setTag('coroutine.id', (string) Coroutine::id());
        $span->setTag('request.path', (string) $uri);
        $span->setTag('request.method', $request->getMethod());
        foreach ($request->getHeaders() as $key => $value) {
            $span->setTag('request.header.' . $key, implode(', ', $value));
        }
        return $span;
    }
}
