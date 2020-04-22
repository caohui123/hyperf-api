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

use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Hyperf\Contract\TranslatorInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

abstract class AbstractController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

     /**
     * @Inject
     * @var TranslatorInterface
     */
    protected $translator;

    public function success($data, $message = 'success')
    {
        $code = $this->response->getStatusCode();
        return ['msg' => $message, 'code' => $code, 'data' => $data];
    }
    
    public function failed($message = 'Request format error!')
    {
        return ['msg' => $message, 'code' => 500, 'data' => ''];
    }
}
