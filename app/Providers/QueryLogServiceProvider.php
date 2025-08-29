<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class QueryLogServiceProvider extends ServiceProvider
{
    protected array $queries = [];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.debug')) {
            DB::listen(function ($query) {
                $this->queries[] = [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time
                ];
            });

            app()->terminating(function () {
                if (! empty($this->queries)) {
                    $totalTime = array_sum(array_column($this->queries, 'time'));
                    $totalQueries = count($this->queries);

                    $logBlock = "\n========== SQL QUERIES ==========\n";
                    $logBlock .= "Total Queries: {$totalQueries} | Total Time: {$totalTime} ms\n";
                    $logBlock .= "---------------------------------\n";

                    foreach ($this->queries as $index => $query) {
                        $bindings = json_encode($query['bindings']);
                        $time = number_format($query['time'], 2);
                        $sql = $query['sql'];

                        $logBlock .= sprintf(
                            "[%02d] (%.2f ms) %s | bindings: %s\n",
                            $index + 1,
                            $time,
                            $sql,
                            $bindings
                        );
                    }

                    $logBlock .= "=================================\n";

                    Log::channel('daily')->info($logBlock);
                }
            });
        }
    }
}
