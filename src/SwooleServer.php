<?php

namespace App;

use App\Emitter\SwooleResponseEmitter;
use App\Http\AppRequestFactory;
use Cake\Core\HttpApplicationInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\EventDispatcherTrait;
use Cake\Event\EventInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Http\Runner;

class SwooleServer
{
    use EventDispatcherTrait;

    /**
     * @var \Cake\Core\HttpApplicationInterface
     */
    protected $app;

    /**
     * @var \Cake\Http\Runner
     */
    protected $runner;
    /**
     * @var Swoole\Http\Server
     */
    protected $http;
    /**
     * @var AppRequestFactory
     */
    protected $requestFactory;

    /**
     * Constructor
     *
     * @param \Cake\Core\HttpApplicationInterface $app The application to use.
     * @param \Cake\Http\Runner|null $runner Application runner.
     */
    public function __construct(HttpApplicationInterface $app, ?Runner $runner = null)
    {
        $this->app = $app;
        $this->runner = $runner ?? new Runner();
        $this->requestFactory = new AppRequestFactory();
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->bootstrap();
        $this->http = new \Swoole\Http\Server("0.0.0.0", 9501);
        $this->http->on(
            "request",
            function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
                $middleware = $this->app->middleware(new MiddlewareQueue());
                if ($this->app instanceof PluginApplicationInterface) {
                    $middleware = $this->app->pluginMiddleware($middleware);
                }

                try {
                    $CakeResponse = $this->runner->run(
                        $middleware,
                        $this->requestFactory->build($request),
                        $this->app
                    );
                    (new SwooleResponseEmitter($response))->emit($CakeResponse);
                } catch (\Throwable $e ) {
                    debug($e);
                }
            }
        );
        $this->http->start();
    }

    /**
     * Application bootstrap wrapper.
     *
     * Calls the application's `bootstrap()` hook. After the application the
     * plugins are bootstrapped.
     *
     * @return void
     */
    protected function bootstrap(): void
    {
        $this->app->bootstrap();
        if ($this->app instanceof PluginApplicationInterface) {
            $this->app->pluginBootstrap();
        }
    }

    /**
     * Wrapper for creating and dispatching events.
     *
     * Returns a dispatched event.
     *
     * @param string $name Name of the event.
     * @param array|null $data Any value you wish to be transported with this event to
     * it can be read by listeners.
     * @param object|null $subject The object that this event applies to
     * ($this by default).
     * @return \Cake\Event\EventInterface
     */
    public function dispatchEvent(string $name, ?array $data = null, ?object $subject = null): EventInterface
    {
        if ($subject === null) {
            $subject = $this;
        }

        /** @var \Cake\Event\EventInterface $event */
        $event = new $this->_eventClass($name, $subject, $data);
        $this->getEventManager()->dispatch($event);

        return $event;
    }
}
