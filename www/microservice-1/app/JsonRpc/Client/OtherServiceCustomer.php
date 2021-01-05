<?php

declare(strict_types=1);

namespace App\JsonRpc\Client;

use Hyperf\RpcClient\AbstractServiceClient;

/**
 * 服务消费者
 */
class OtherServiceCustomer extends AbstractServiceClient
{
    /**
     * 定义对应服务提供者的服务名称
     * @var string
     */
    protected $serviceName = 'OtherService';

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

    public function other(int $b): int
    {
        var_dump($b);
        return $this->__request(__FUNCTION__, compact('b'));
    }
}