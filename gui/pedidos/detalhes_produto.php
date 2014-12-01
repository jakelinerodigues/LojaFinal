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
      <fieldset>
        <legend>Dados do produto</legend>
        <div class="form-group">
          <label for="nome">Nome:</label>
          <span><?php echo $registro['nome']?></span>
        </div>
        <div class="form-group">
          <label for="id_departamento">Departamento:</label>
          <span><?php echo $registro['departamento'];?></span>
        </div>
        <div class="form-group">
          <label for="detalhes">Detalhes:</label>
          <span><?php echo $registro['detalhes'];?></span>
        </div>
        <div class="form-group">
          <label for="preco">Preço:</label>
          <span><?php echo $registro['preco'];?></span>
        </div>
      </fieldset>
      <form method="post"
      action="<?php echo URL_BASE; ?>pedidos.php?acao=finalizar">
        <fieldset>
          <legend>Comprar</legend>
          <input type='hidden' name='produto' value='<?php echo $registro['id']?>'>
          <input type='hidden' name='produto_nome' value='<?php echo $registro['nome']?>'>
          <input type='hidden' name='preco' value='<?php echo $registro['preco']?>'>
          <div class="form-group">
            <label for="nome">Quantidade:</label>
            <input type="text" name="quantidade" id="quantidade" value="">
          </div>
          <button type="submit">Adicionar ao Carrinho</button>
          <button type="button"
          onclick="document.location='<?=URL_BASE;?>pedidos.php?acao=produtos&departamento=<?php echo $registro['id_departamento']?>';">
          Voltar</button>
        </fieldset>
      </form>
    </div>
  </body>
</html>
