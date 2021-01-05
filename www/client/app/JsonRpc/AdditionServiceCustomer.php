<?php

declare(strict_types=1);

namespace App\JsonRpc;

use Hyperf\RpcClient\AbstractServiceClient;

/**
 * 服务消费者
 */
class AdditionServiceCustomer extends AbstractServiceClient
{
    /**
     * 定义对应服务提供者的服务名称
     * @var string
     */
    protected $serviceName = 'AdditionService';

    /**
     * 定义对应服务提供者的服务协议
     * @var string
     */
    protected $protocol = 'jsonrpc-http';

    /**
     * 调用服务方式
     * @var string
     */
    protected $loadBalancer = 'round-robin';

    public function add(int $a, int $b): int
    {
        $b--;
        return (int)$this->__request(__FUNCTION__, compact('a', 'b'));
    }
}