<?php
namespace App\JsonRpc;

use Hyperf\Di\Annotation\Inject;
use Hyperf\DbConnection\Db;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * @RpcService(name="ContractService", protocol="jsonrpc-http", server="jsonrpc-http")
 */
class ContractService {

    public function createOrder(array $order) :array
    {
        return [
        	'code' => 200,
            'method' => 'createOrder',
            'message' => "下单成功",
            'order' => $order,
        ];
    }
}