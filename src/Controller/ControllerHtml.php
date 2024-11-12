<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

abstract class ControllerHtml
{
    private const TEMPLATE_PATH = __DIR__ . '/../../Views/';

    //retorna o conteúdo
    protected function renderTemplate(string $templateName, array $context = []): string
    {
        //extrai para variaveis chaves de um array associativo, para implantar no html.
        extract($context);

        // Inicializa um buffer de saída (local onde vai armazenando tudo que vai ser exibido na tela)
        ob_start();
        require_once self::TEMPLATE_PATH . $templateName . '.php';

        return ob_get_clean();
    }
}
