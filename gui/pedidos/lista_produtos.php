<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title><?php echo $titulo_pagina; ?></title>
    <meta charset="utf-8">
    <style type="text/css">
      @import "<?php echo URL_BASE; ?>css/estilos.css";
    </style>
  </head>
  <body>
    <div class="container">
      <h1><?php echo $titulo_pagina; ?></h1>
      <ul>
        <?php foreach($registros as $registro) : ?>
          <li>
            <?php
              echo "<a href='" . URL_BASE . "pedidos.php?acao=produto&id={$registro['id']}'>{$registro['nome']}</a>";
            ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <button type="button"
      onclick="document.location='<?=URL_BASE;?>pedidos.php?acao=departamento';">
      Voltar</button>
    </div><!-- container -->
  </body>
</html>
