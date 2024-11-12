<?php

declare(strict_types=1);

namespace Alura\Mvc\Helper;

trait HtmlRendererTrait
{

    //retorna o conteúdo
    private  function renderTemplate(string $templateName, array $context = []): string
    {
        $templatePath = __DIR__ . '/../../Views/';

        //extrai para variaveis chaves de um array associativo, para implantar no html.
        extract($context);

        // Inicializa um buffer de saída (local onde vai armazenando tudo que vai ser exibido na tela)
        ob_start();
        require_once $templatePath . $templateName . '.php';

        return ob_get_clean();
    }
}
