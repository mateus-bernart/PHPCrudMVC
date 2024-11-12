<?php

declare(strict_types=1);


namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class NewJsonVideoController extends Controller
{

    public function __construct(private VideoRepository $videoRepository) {}

    public function processaRequisicao(): void
    {
        //acessa o corpo de uma requisição.
        $request = file_get_contents('php://input');
        //decodifica string em json
        $videoData = json_decode($request, true);
        $video = new Video($videoData['url'], $videoData['title']);
        $this->videoRepository->add($video);
        
        http_response_code(201);
    }
}
