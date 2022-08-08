<?php
/**
 *  Response 请求处理
 */

namespace MasterKong\Boot\Processors;

use Symfony\Component\HttpFoundation\Response;

class ResponseProcessor
{
    /**
     * 增加请求数据到 log 记录
     */
    public function __invoke(Response $response)
    {
        return $response->getContent();
    }
}
