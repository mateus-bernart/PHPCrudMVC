<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\HtmlRendererTrait;
use Alura\Mvc\Repository\VideoRepository;

class VideoFormController implements Controller
{
    use HtmlRendererTrait;
    public function __construct(private VideoRepository $videoRepository) {}

    public function processaRequisicao(): void
    {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        /** @var ?Video $video */
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->find($id);
        }

        echo $this->renderTemplate('video-form', [
            'video' => $video
        ]);
    }
}
