<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        'eventy' => [
            'driver' => 'single',
            'path' => storage_path('logs/eventy.log'),
            'level' => 'debug',
        ],

        'eventyfalse' => [
            'driver' => 'single',
            'path' => storage_path('logs/eventy_false.log'),
            'level' => 'debug',
        ],

        'callscript' => [
            'driver' => 'single',
            'path' => storage_path('logs/callscript.log'),
            'level' => 'debug',
        ],

         'callfree' => [
            'driver' => 'single',
            'path' => storage_path('logs/callfree.log'),
            'level' => 'debug',
        ],
        
        'callfreescript' => [
            'driver' => 'single',
            'path' => storage_path('logs/callfreescript.log'),
            'level' => 'debug',
        ],
        
        'checkhttpstatus' => [
            'driver' => 'single',
            'path' => storage_path('logs/checkhttpstatus.log'),
            'level' => 'debug',
        ],

        'recurring' => [
            'driver' => 'single',
            'path' => storage_path('logs/recurring.log'),
            'level' => 'debug',
        ],
        
        'recurring_invoice' => [
            'driver' => 'single',
            'path' => storage_path('logs/recurring_invoice.log'),
            'level' => 'debug',
        ],

        'callscriptrecurring' => [
            'driver' => 'single',
            'path' => storage_path('logs/callscriptrecurring.log'),
            'level' => 'debug',
        ],

        'upgrade' => [
            'driver' => 'single',
            'path' => storage_path('logs/upgrade.log'),
            'level' => 'debug',
        ],

        'scriptupgrade' => [
            'driver' => 'single',
            'path' => storage_path('logs/scriptupgrade.log'),
            'level' => 'debug',
        ],
        
        'firstpayment' => [
            'driver' => 'single',
            'path' => storage_path('logs/firstpayment.log'),
            'level' => 'debug',
        ],

        'logfirstpayment' => [
            'driver' => 'single',
            'path' => storage_path('logs/logfirstpayment.log'),
            'level' => 'debug',
        ],

        'inquiry' => [
            'driver' => 'single',
            'path' => storage_path('logs/inquiry.log'),
            'level' => 'debug',
        ],

        'inquiry_res' => [
            'driver' => 'single',
            'path' => storage_path('logs/inquiry_res.log'),
            'level' => 'debug',
        ],

        'manualcreate' => [
            'driver' => 'single',
            'path' => storage_path('logs/manualcreate.log'),
            'level' => 'debug',
        ],

        'callscriptmanual' => [
            'driver' => 'single',
            'path' => storage_path('logs/callscriptmanual.log'),
            'level' => 'debug',
        ],

        'checkhttpstatusmanual' => [
            'driver' => 'single',
            'path' => storage_path('logs/checkhttpstatusmanual.log'),
            'level' => 'debug',
        ],

        'updatemanual' => [
            'driver' => 'single',
            'path' => storage_path('logs/updatemanual.log'),
            'level' => 'debug',
        ],

        'scriptupgrademanual' => [
            'driver' => 'single',
            'path' => storage_path('logs/scriptupgrademanual.log'),
            'level' => 'debug',
        ],

        'inquiry_req' => [
            'driver' => 'single',
            'path' => storage_path('logs/inquiry_req.log'),
            'level' => 'debug',
        ],

        'downgrade_req' => [
            'driver' => 'single',
            'path' => storage_path('logs/downgrade_req.log'),
            'level' => 'debug',
        ],

        'scriptdowngrade' => [
            'driver' => 'single',
            'path' => storage_path('logs/scriptdowngrade.log'),
            'level' => 'debug',
        ],

        'recurring_reject' => [
            'driver' => 'single',
            'path' => storage_path('logs/recurring_reject.log'),
            'level' => 'debug',
        ],

        'recurring_reject_upstatus' => [
            'driver' => 'single',
            'path' => storage_path('logs/recurring_reject_upstatus.log'),
            'level' => 'debug',
        ],

         'repayment' => [
            'driver' => 'single',
            'path' => storage_path('logs/repayment.log'),
            'level' => 'debug',
        ],

         'scriptrepayment' => [
            'driver' => 'single',
            'path' => storage_path('logs/scriptrepayment.log'),
            'level' => 'debug',
        ],

        'repayment_updatestatus' => [
            'driver' => 'single',
            'path' => storage_path('logs/repayment_updatestatus.log'),
            'level' => 'debug',
        ],
        
        'repayment_callreceive' => [
            'driver' => 'single',
            'path' => storage_path('logs/repayment_callreceive.log'),
            'level' => 'debug',
        ],

    ],
    

];
