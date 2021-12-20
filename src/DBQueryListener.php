<?php

namespace Oh86\Sqllog;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class DBQueryListener
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->config = config('sqllog');
    }

    /**
     * Handle the event.
     *
     * @param  QueryExecuted  $event
     * @return void
     */
    public function handle($event)
    {
        if(!$this->config['slow']){
            return;
        }

        if($event->time < $this->config['slow_time']){
            return;
        }

        foreach($event->bindings as &$arg){
            if(is_string($arg)){
                $arg = "'" . $arg . "'";
            }
        }

        $content['sql'] = sprintf(str_replace('?', '%s', str_replace('%', '%%', $event->sql)), ...$event->bindings);

        if($this->config['debug_backtrace']){
            $e = new \Exception("sql execute too slow");
            $content['debug_backtrace'] = $e->getTraceAsString();
        }

        Log::debug('cost:' . $event->time . "ms", $content);
    }
}
