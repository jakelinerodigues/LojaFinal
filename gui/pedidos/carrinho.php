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
      <table>
        <thead>
          <tr>
            <td>
              Produto
            </td>
            <td>
              Quantidade
            </td>
            <td>
              Preco
            </td>
            <td>
              Valor Total
            </td>
            <td>
              Ação
            </td>
          </tr>
        </thead>
        <tbody>
          <?php foreach($pedido as $item_pedido): ?>
          <tr>
            <td>
              <?php echo $item_pedido['produto']; ?>
            </td>
            <td>
              <?php echo $item_pedido['quantidade']; ?>
            </td>
            <td>
              <?php echo $item_pedido['preco']; ?>
            </td>
            <td>
              <?php echo $item_pedido['valor_total']; ?>
            </td>
            <td>
              <?php
                echo "<a href='javascript:if(confirm(\"Confirma a exclusão?\")){document.location=\"" . URL_BASE . "pedidos.php?acao=excluir&id={$item_pedido['id']}\";}'>X</a>";
              ?>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      <button type="button"
      onclick="document.location='<?=URL_BASE;?>pedidos.php?acao=departamento';">
      Adicionar Novo Produto</button>
      <button type="button"
      onclick="document.location='<?=URL_BASE;?>pedidos.php?acao=final';">
      Finalizar</button>
    </div>
  </body>
</html>
