<?php
/**
 * Header 响应处理
 */

namespace MasterKong\Boot\Processors;

use Monolog\Utils;

class HeaderProcessor
{
    // 记录的 headers 信息
    protected $extraFields = [
        'url'         => 'REQUEST_URI',
        'ip'          => 'REMOTE_ADDR',
        'http_method' => 'REQUEST_METHOD',
        'server'      => 'SERVER_NAME',
        'referrer'    => 'HTTP_REFERER',
        'user-agent'  => 'HTTP_USER_AGENT',
        'accept'      => 'HTTP_ACCEPT',
    ];

    /**
     * @param array|\ArrayAccess $serverData  Array or object w/ ArrayAccess that provides access to the $_SERVER data
     * @param array|null         $extraFields Field names and the related key inside $serverData to be added. If not provided it defaults to: url, ip, http_method, server, referrer
     */
    public function __construct($serverData = null, array $extraFields = [])
    {
        if (null === $serverData) {
            $this->serverData = &$_SERVER;
        }

        if ([] !== $extraFields) {
            $this->extraFields = array_merge($this->extraFields, $extraFields);
        }
    }

    /**
     * 增加请求数据到 log 记录
     */
    public function __invoke()
    {
        return json_encode($this->appendExtraFields(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function appendExtraFields()
    {
        foreach ($this->extraFields as $extraName => $serverName) {
            isset($this->serverData[$serverName]) ? $extra[$extraName] = $this->serverData[$serverName] : null;
        }

        return $extra;
    }
}
