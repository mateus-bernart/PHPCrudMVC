<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutController implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //Exclui o id da sessão
        // session_destroy();
        unset($_SESSION['logado']);
        return new Response(302, ['Location' => '/login']);
    }
}
