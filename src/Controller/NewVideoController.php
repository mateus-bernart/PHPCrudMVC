<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use finfo;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $videoRepository) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        $url = filter_var($requestBody['url'], FILTER_VALIDATE_URL);

        if ($url === false) {
            $this->addErrorMessage('Url Inválida');
            return new Response(302, ['Location' => '/']);
        }

        $titulo = filter_var($requestBody['titulo']);
        if ($titulo === false) {
            $this->addErrorMessage('Titulo não informado');
            return new Response(302, ['Location' => '/']);
        }

        $video = new Video($url, $titulo);

        //extrair para uma classe que faz upload de arquivos.

        //transformar nomes para serem mais faceis de identificar pela url (slug - pesquisar)

        $files = $request->getUploadedFiles();
        /** @var UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];


        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);

            
            if (str_starts_with($mimeType, 'image/')) {
                //Nome seguro, nome de um arquivo (segurança)
                $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                $uploadedImage->moveTo(
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->videoRepository->add($video);

        if ($success === false) {
            $this->addErrorMessage('Erro ao cadastrar vídeo');
            return new Response(302, ['Location' => '/novo-video']);
        }

        return new Response(302, ['Location' => '/']);
    }
}
