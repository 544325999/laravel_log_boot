<?php
/**
 * 记录 log
 */

namespace MasterKong\Boot\Providers;

use Illuminate\Support\ServiceProvider;

class LogProvider extends ServiceProvider
{
    /**
     * 默认 handlers
     *
     * @var array
     */
    protected $baseHandlers = ['errorLog'];

    public function register()
    {
        $this->app->configureMonologUsing(
            function ($monolog) {
                $level = env('APP_LOG_LEVEL', 'debug');
                $handlers = array_unique(array_merge(config('log_boot.handlers', []), $this->baseHandlers));

                foreach ($handlers as $handler) {
                    if (class_exists($handler = $this->getHandler($handler))) {
                        $monolog->pushHandler((new $handler())->getHandler($level));
                    }
                }

                return $monolog;
            }
        );
    }

    /**
     * get the handler class
     *
     * @param string $handler
     */
    protected function getHandler($handler)
    {
        return 'MasterKong\\Boot\\Handlers\\' . ucfirst($handler);
    }
}
