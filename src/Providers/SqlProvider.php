<?php
/**
 * 记录 sql 执行
 */
namespace MasterKong\Boot\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;

class SqlProvider extends ServiceProvider
{
    /**
     * 执行记录 sql
     */
    public function boot()
    {
        $this->app->events->listen(QueryExecuted::class, function (QueryExecuted $query) {
            Log::error('execute sql: ' . vsprintf(str_replace("?", "'%s'", str_replace('%', '%%', $query->sql)), $query->bindings) . '. time(ms): ' . $query->time);
        });
    }
}
