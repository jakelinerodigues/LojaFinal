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
      <h3>
        Cliente
      </h3>
      <?php echo $_SESSION['nome_usuario']?>
      <hr />
      <h3>
        Produtos
      </h3>
      <hr />
      <table>
        <thead>
          <tr>
            <td>
              Nome
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
          </tr>
        </thead>
        <tbody>
          <?php $total = 0; ?>
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
          </tr>
          <?php $total += $item_pedido['valor_total']?>
          <?php endforeach ?>
          <tr>
            <td colspan='4'>Total do Pedido:
              R$ <?php echo number_format($total,2,',','.') ?>
            </td>
          </tr>
        </tbody>
      </table>
      <button type="button"
      onclick="document.location='<?=URL_BASE;?>pedidos.php?acao=novo';">
      Novo Pedido</button>
    </div>
  </body>
</html>
