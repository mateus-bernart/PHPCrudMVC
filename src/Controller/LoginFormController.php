<?php 

declare(strict_types=1);

namespace Alura\Mvc\Controller;

class LoginFormController implements Controller
{
    public function processaRequisicao(): void
    {
        require __DIR__ . '/../../Views/login-form.php';
    }
}

?>