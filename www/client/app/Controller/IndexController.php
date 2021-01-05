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

namespace App\Controller;

use App\JsonRpc\AdditionServiceCustomer;
use App\JsonRpc\MultiplicationServiceCustomer;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Logger\Logger;
use Hyperf\Logger\LoggerFactory;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\Info;
use OpenApi\Annotations\Parameter;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;

/**
 * @AutoController()
 * Class IndexController
 * @package App\Controller
 * @Info(title="My First API", version="0.1")
 */
class IndexController extends AbstractController
{
    /**
     * @Get(
     *     path="/customer/info",
     *     summary="用户的个人信息",
     *     description="这不是个api接口,这个返回一个页面",
     *     @Parameter(name="userId", in="query", @Schema(type="string"), required=true, description="用户ID"),
     *     @Response(
     *      response="200",
     *      description="An example resource"
     *     )
     * )
     */
    public function index(\Hyperf\HttpServer\Contract\ResponseInterface $response,LoggerFactory $loggerFactory)
    {
//        $openapi = \OpenApi\scan('/var/www/app/Controller/');
//        return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Content-Type', 'application/x-yaml')->withBody(new SwooleStream($openapi->toYaml()));exit;
//        return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Content-Type', 'application/x-yaml')->withContent($openapi->toYaml());exit;
//        $logger = $loggerFactory->get('log', 'default');
//        $logger->error(111);
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    public function add(AdditionServiceCustomer $addition)
    {
        $a = (int)$this->request->input('a', 1);
        $b = (int)$this->request->input('b', 2);

        return [
            'a' => $a,
            'b' => $b,
            'add' => $addition->add($a, $b)
        ];
    }

    public function multiply(MultiplicationServiceCustomer $multiplicaton)
    {
        $a = (int)$this->request->input('a', 1);
        $b = (int)$this->request->input('b', 2);

        return [
            'a' => $a,
            'b' => $b,
            'multiply' => $multiplicaton->multiply($a, $b)
        ];
    }
}
