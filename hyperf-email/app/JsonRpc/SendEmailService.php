<?php
namespace App\JsonRpc;

use App\Service\SendEmailService as EmailJobService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\DbConnection\Db;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * @RpcService(name="SendEmailService", protocol="jsonrpc-http", server="jsonrpc-http")
 */
class SendEmailService {

    /**
     * @Inject
     * @var EmailJobService
     */
    protected $service;

    public function sendEmail(string $email, string $locale , string $sign) :array
    {
        $result = $this->service->push([
            'email' => $email,
            'locale' => $locale,
            'sign' => $sign,
        ]);

        if ($result) {
            return ['code' => 200 , 'msg' => '发送成功'];
        } else {
            return ['code' => 500 , 'msg' => '发送失败'];
        }

    }
}