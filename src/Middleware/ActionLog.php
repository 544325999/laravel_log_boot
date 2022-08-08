<?php
/**
 * 记录 请求和响应
 */
namespace MasterKong\Boot\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use MasterKong\Boot\Processors\HeaderProcessor;
use MasterKong\Boot\Processors\RequestProcessor;
use MasterKong\Boot\Processors\ResponseProcessor;

class ActionLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app('request')->headers->set('X-Request-Start-Time', microtime(true));
        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach (config('log_boot.ignore_url') as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Handle an response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     */
    public function terminate($request, $response)
    {
        if (! $this->inExceptArray($request)) {
            $this->RequestInterpolation($request);
            $this->ResponseInterpolation($response, app('request')->headers->get('X-Request-Start-Time', 0));
        }

        return $response;
    }

    /**
     * 记录请求内容
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function RequestInterpolation($request)
    {
        Log::error(call_user_func(new HeaderProcessor(null, config('log_boot.log_request_extra_headers'))) . '[HEADER]');
        Log::error(call_user_func(new RequestProcessor(), $request) . '[REQUEST]');
    }

    /**
     * 记录响应
     *
     * @param \Illuminate\Http\Response $response
     */
    protected function ResponseInterpolation($response, $startTime = 0)
    {
        if (config('log_boot.log_response')) {
            Log::error(
                $response->getStatusCode() . '[STATUSCODE] ' .
                (microtime(true) - $startTime) . '[RUNTIME] ' .
                call_user_func(new ResponseProcessor, $response) . "[RESPONSE] \n-------"
            );
        } else {
            Log::error(
                $response->getStatusCode() . '[STATUSCODE] ' .
                (microtime(true) - $startTime) . "[RUNTIME] \n-------"
            );
        }
    }
}
