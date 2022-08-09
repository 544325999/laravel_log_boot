#### providers
- `RedisJsonStore`: 修改 `redis` 默认存储结构
- `SqlProvider`: `sql` 执行记录
- `LogProvider`: 请求和响应记录

- 默认为 `stream`, `errorLog`, 可自动重写后将 `handler` 写进配置项即可
- 默认为所有 `handler` 均采用 `BufferHandler` 重写启用
- 请求执行 `log` 在包内采用全局中间件注册


## Installation
composer.json
```json
"repositories": {
    "laravel_log_boot": {
    "type": "git",
    "url": "git@github.com:544325999/laravel_log_boot.git"
    }
}
```
```shell
composer require MasterKong/boot
```

```php
// copy config/log_boot.php app/config/log_boot.php

// AppServiceProvider.php
$this->app->register(\MasterKong\Boot\Providers\MasterKongProvider::class)
// Kernel.php
use MasterKong\Boot\Middleware\ActionLog;

protected $middleware = [
              ActionLog::class
];
```
