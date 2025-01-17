<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Exception\Handler;

use App\Constants\ResponseCode;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        return $response->withHeader('Server', 'Hyperf')->withHeader('Content-Type', 'application/json')->withStatus(500)->withBody(new SwooleStream(json_encode([
            'code' => $throwable->getCode() ? $throwable->getCode() : ResponseCode::CODE_SERVER_ERROR,
            'msg' =>  $throwable->getCode() ? $throwable->getMessage() : ResponseCode::getMessage(ResponseCode::CODE_SERVER_ERROR)
        ])));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
