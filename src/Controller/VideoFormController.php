<?php 

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoFormController implements Controller{

    public function __construct(private VideoRepository $videoRepository) {}

    public function processaRequisicao(): void {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->find($id);
        }

         require_once __DIR__ . '../../Views/video-form.php';

}
}

?>