<?php

return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            'ui' => [
                'name' => 'Vanilo',
                'url' => '/admin/product'
            ]
        ],
        Vanilo\Framework\Providers\ModuleServiceProvider::class => [
            'currency'    => [
                'code'   => 'CLP',
                'sign'   => 'CLP $',
                // For the format_price() template helper method:
                'format' => 'CLP $ %d' // see sprintf. Amount is the first argument, currency is the second
                /* EURO example:
                'code'   => 'EUR',
                'sign'   => '€',
                'format' => '%1$g%2$s'
                */
            ]
        ]
    ]
];
