<?php

declare(strict_types=1);

namespace App\JsonRpc;


use App\JsonRpc\Client\OtherServiceCustomer;
use Hyperf\Di\Annotation\Inject;
use Hyperf\RpcServer\Annotation\RpcService;

/**
 * @RpcService(name="AdditionService", protocol="jsonrpc-http", server="jsonrpc-http", publishTo="consul")
 */
class AdditionService
{
    /**
     * @Inject()
     * @var OtherServiceCustomer
     */
    private $otherServiceCustomer;

    public function add(int $a, int $b): int
    {
        $b = $this->otherServiceCustomer->other($b);
        return (int)($a + $b);
    }
}