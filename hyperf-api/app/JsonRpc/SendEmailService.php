<?php
declare(strict_types=1);

namespace App\JsonRpc;

use Hyperf\RpcClient\AbstractServiceClient;

/**
 * 服务消费者
 */
class SendEmailService extends AbstractServiceClient
{
    /**
     * 定义对应服务提供者的服务名称
     * @var string
     */
    protected $serviceName = 'SendEmailService';
    
    /**
     * 定义对应服务提供者的服务协议
     * @var string
     */
    protected $protocol = 'jsonrpc-http';

    public function sendEmail(string $email, string $locale , string $sign): array
    {
        return $this->__request(__FUNCTION__, compact('email','locale','sign'));
    }


}