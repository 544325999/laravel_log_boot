<?php

return [
    // 日志文件路径
    'path' => storage_path('logs/log_file.log'),

    // 日志处理器
    'handlers' => [
        'stream'
    ],

    // 是否记录 sql 执行记录
    'log_sql_details' => true,
    // 忽略 url
    'ignore_url' => [
        //  for example: '/test'
    ],

    //忽略请求字段
    'ignore_input_fields' => [
        'password',
        'confirm_password',
    ],

    // 额外记录 headers
    'log_request_extra_headers' => [
        // for example: deviceId
    ],

    // 是否记录response
    'log_response' => true,
];
