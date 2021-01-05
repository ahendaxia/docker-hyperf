<?php

declare(strict_types=1);

namespace App\JsonRpc;

use Hyperf\RpcServer\Annotation\RpcService;

/**
 * @RpcService(name="OtherService", protocol="jsonrpc-http", server="jsonrpc-http", publishTo="consul")
 */
class OtherService
{

    public function other(int $b): int
    {
        $b++;
        return $b;
    }
}