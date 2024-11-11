<?php 

declare(strict_types=1);

namespace Alura\Mvc\Controller;

class LogoutController implements Controller
{
    public function processaRequisicao(): void
    {
        //Exclui o id da sessão
        // session_destroy();
        unset($_SESSION['logado']);
        header('Location: /login');
    }
}

?>