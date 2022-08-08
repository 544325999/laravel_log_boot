<?php
/**
 * Request 请求处理
 */

namespace MasterKong\Boot\Processors;

use Monolog\Utils;
use Illuminate\Http\Request;

class RequestProcessor
{
    /**
     * 增加请求数据到 log 记录
     */
    public function __invoke(Request $request)
    {
        return json_encode($request->except(config('log_boot.ignore_input_fields')), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
