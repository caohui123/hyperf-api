<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    'consumers' => [
        [
            // The service name, this name should as same as with the name of service provider.
            'name' => 'ContractService',
            'nodes' => [
                ['host' => '127.0.0.1', 'port' => 9531]
            ],
        ],
        [
            // The service name, this name should as same as with the name of service provider.
            'name' => 'ExchangeService',
            'nodes' => [
                ['host' => '127.0.0.1', 'port' => 9532]
            ],
        ],
        [
            // The service name, this name should as same as with the name of service provider.
            'name' => 'TradeService',
            'nodes' => [
                ['host' => '127.0.0.1', 'port' => 9533]
            ],
        ],
        [
            // The service name, this name should as same as with the name of service provider.
            'name' => 'SendEmailService',
            'nodes' => [
                ['host' => '127.0.0.1', 'port' => 9534]
            ],
        ],
        [
            // The service name, this name should as same as with the name of service provider.
            'name' => 'SendSmsService',
            'nodes' => [
                ['host' => '127.0.0.1', 'port' => 9535]
            ],
        ],
    ],
];
