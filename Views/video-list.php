<?php 
require_once __DIR__ . '/inicio-html.php'; 
//** @var Video[] $videoList */
?>
<ul class="videos__container" alt="videos alura">
<?php
        // Verifica se o parâmetro 'sucesso' existe na URL
        if (isset($_GET['sucesso'])) {
            $sucesso = $_GET['sucesso'];
            
            // Verifica o valor e exibe o alert apropriado
            if ($sucesso == 1) {
                echo "<script>alert('Operação realizada com sucesso!');window.location.href='/';</script>";
            } elseif ($sucesso == 0) {
                echo "<script>alert('Ocorreu um erro na operação.');window.location.href='/';</script>";
            }
            
        }
        
        ?>    
<?php foreach ($videoList as $video): ?>
        
        <li class="videos__item">
            <iframe width="100%" height="72%" src=" <?= $video->url; ?>"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
            <div class="descricao-video">
                <img src="./img/logo.png" alt="logo canal alura">
                <h3><?= $video->title; ?></h3>
                <div class="acoes-video">
                    <a href="./editar-video?id=<?= $video->id; ?>">Editar</a>
                    <a href="./remover-video?id=<?= $video->id; ?>">Excluir</a>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
        
    </ul>
    <?php require_once __DIR__ . '/fim-html.php'; 
