<?php
//客户端连接consul配置
$registry = [
    'protocol' => 'consul',
    'address' => 'http://consul-server-leader:8500',
];
return [
    'consumers' => [
        [
            'name' => "OtherService",
            'registry' => $registry,
        ],
    ],
];