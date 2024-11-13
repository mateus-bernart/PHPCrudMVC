<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteVideoController implements RequestHandlerInterface
{

    public function __construct(private VideoRepository $videoRepository) {}

    use FlashMessageTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        //array de query params (GET).
        $queryParams = $request->getQueryParams();
        $id =  filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false && $id === null) {
            $this->addErrorMessage('Id inválido');
            return new Response(302, ['Location' => '/']);
        }

        $success = $this->videoRepository->remove($id);

        //function retorna booleano
        if ($success === false) {
            $this->addErrorMessage('Id inválido');
            return new Response(302, ['Location' => '/']);
        } else {
            return new Response(302, ['Location' => '/']);
        }
    }
}
