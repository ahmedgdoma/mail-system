<?php

use components\rabbitmq\Consumers\SendEmailConsumer;
use components\rabbitmq\Consumers\SheetProcessConsumer;
use mikemadisonweb\rabbitmq\Configuration;

return [
    'class' => Configuration::class,
    'connections' => [
        [
            // You can pass these parameters as a single `url` option: https://www.rabbitmq.com/uri-spec.html
            'host' => 'mail_rabbitmq',
            'port' => '5672',
            'user' => 'rabbitmq',
            'password' => 'rabbitmq',
            'vhost' => '/',
        ]
    ],
    'exchanges' => [
        [
            'name' => 'exchange',
            'type' => 'direct'
        ],
        [
            'name' => 'exchange2',
            'type' => 'direct'
        ],
    ],
    'bindings' => [
        [
            'queue' => 'sheet_process',
            'exchange' => 'exchange',
            'routing_keys' => ['sheet_process'],
        ],
        [
            'queue' => 'send_email',
            'exchange' => 'exchange2',
            'routing_keys' => ['send_email'],
        ],
    ],
    'queues' => [
        [
            'name' => 'sheet_process',
        ],
        [
            'name' => 'send_email',
        ],
    ],
    'producers' => [
        [
            'name' => 'sheet_process',
        ],
        [
            'name' => 'send_email',
        ],
    ],
    'consumers' => [
        [
            'name' => 'sheet_process',
            'callbacks' => [
                'sheet_process' => SheetProcessConsumer::class,
            ],
        ],
        [
            'name' => 'send_email',
            'callbacks' => [
                'send_email' => SendEmailConsumer::class,
            ],
        ],
    ],
];