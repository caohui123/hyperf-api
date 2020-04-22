<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Container\ContainerInterface;
use Hyperf\Logger\LoggerFactory;

class LoggerService
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerFactory $loggerFactory)
    {
        // 第一个参数对应日志的 name, 第二个参数对应 config/autoload/logger.php 内的 key
        $this->logger = $loggerFactory->get('log', 'default');
    }

    public function info($message, array $context = array())
    {
        // Do somthing.
        $this->logger->info($message,$context);
    }

    public function error($message, array $context = array())
    {
        // Do somthing.
        $this->logger->error($message,$context);
    }
}
