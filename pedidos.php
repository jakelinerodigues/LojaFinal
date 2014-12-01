<?php
session_start();
  // importa o código dos scripts
  require_once 'lib/constantes.php';
  require_once 'lib/database.php';

if (!isset($_SESSION['id_usuario'])){
  header('location:' . URL_BASE .
    'login.php');
}
// se uma ação foi informada na URL
if (isset($_GET['acao']))
{
  // captura a ação informada do array superglobal $_GET[]
  $acao = $_GET['acao'];
}

// se não foi informada ação
if(!isset($acao))
{
  // assume ação padrão (listar)
  $acao = 'departamento';
}

switch($acao)
{
  case 'departamento':
    listarDepartamentos();
    break;
  case 'produtos':
    listaProdutosFromDepartamento();
    break;
  case 'produto':
    listaProduto();
    break;
  case 'finalizar':
    finalizar();
    break;
  case 'excluir':
    removerItem();
    break;
  case 'final':
    espelhoPedido();
    break;
  case 'novo':
    unset ($_SESSION['pedido']);
    header('location:' . URL_BASE .'pedidos.php?acao=departamento');
    break;
  default:
    // encerra (mata) o script exibindo mensagem de erro
    die('Erro: Ação inexistente!');
} // fim do switch...case

function listarDepartamentos(){
  // monta a consulta para recuperar a listagem de usuários ordenada pelo nome
  $consulta = "
    select * from departamentos order by nome
  ";
  // executa a consulta sql
  consultar($consulta);
  // declara um vetor de registros para passar para a view (gui)
  $registros = array();
  // percorre o resultset retornado pela consulta extraindo um a um os registros retornados
  while ($registro = proximo_registro())
  {
    // acrescenta o registro ao vetor
    array_push($registros, $registro);
  }
  // define o título da página
  $titulo_pagina = 'Escolha um departamento';
  // carrega o arquivo com a listagem de clientes (gui)
  require_once 'gui/pedidos/lista_departamentos.php';
}

function listaProdutosFromDepartamento(){
  $departamento = $_GET['departamento'];

  if(!$departamento){
    header('location:' . URL_BASE .
      'pedidos.php?acao=departamento');
  }

  $consulta = "
    select * from produtos where id_departamento = {$departamento} order by nome
  ";
  // executa a consulta sql
  consultar($consulta);
  // declara um vetor de registros para passar para a view (gui)
  $registros = array();
  // percorre o resultset retornado pela consulta extraindo um a um os registros retornados
  while ($registro = proximo_registro())
  {
    // acrescenta o registro ao vetor
    array_push($registros, $registro);
  }
  // define o título da página
  $titulo_pagina = 'Escolha um produto';
  require_once 'gui/pedidos/lista_produtos.php';
}

function listaProduto(){
  $id = $_GET['id'];

  if(!$id){
    header('location:' . URL_BASE .
      'pedidos.php?acao=departamento');
  }

  // captura o id passado na URL
  $id = $_GET['id'];

  // executa a consulta
  db_select('produtos','*',array('id'=>$id));

  // captura o registro retornado pela consulta
  $registro = proximo_registro();

  // extrai as informações em variáveis avulsas

  $registro['departamento'] = getDepartamento($registro['id_departamento']);


  // define o título da página
  $titulo_pagina = 'Detalhes do produto';
  // carrega o formulário para alterar o usuário
  require_once('gui/pedidos/detalhes_produto.php');

}

function getDepartamento($id){
  $consulta = "
    select nome from departamentos
    where id = $id
    order by nome
  ";

  consultar($consulta);

  $registro = proximo_registro();
  return $registro['nome'];
}

function finalizar(){
  if($_POST){
    salvarProdutos();
  }
  $pedido = getPedido();

  $titulo_pagina = 'Carrinho';
  // carrega o formulário para alterar o usuário
  require_once('gui/pedidos/carrinho.php');

}

function espelhoPedido(){
  $pedido = getPedido();

  $titulo_pagina = 'Espelho';
  // carrega o formulário para alterar o usuário
  require_once('gui/pedidos/espelho.php');

}

function salvarProdutos(){
  $produto = $_POST['produto'];
  $produto_nome = $_POST['produto_nome'];
  $quantidade = $_POST['quantidade'];
  $valor = $_POST['preco'];


  $pedido = getPedido();
  if($quantidade){
    if(isset($pedido[$produto])){
      $item_pedido = $pedido[$produto];
    }else{
      $item_pedido = array('id'=>'','quantidade'=>0);
    }
    $item_pedido['id'] = $produto;
    $item_pedido['produto'] = $produto_nome;
    $item_pedido['quantidade'] += $quantidade;
    $item_pedido['preco'] = $valor;
    $item_pedido['valor_total'] = $item_pedido['quantidade']*$item_pedido['preco'];
    $pedido[$produto] = $item_pedido;
    salvarPedido($pedido);
  }else{
    echo "<h3>Não foi informada quantidade para o produto</h3>";
  }


}

function getPedido(){
  if(isset($_SESSION['pedido'])){
    return json_decode($_SESSION['pedido'],true);
  }else{
    return array();
  }
}
function salvarPedido($pedido){
  $_SESSION['pedido'] = json_encode($pedido);
}
function removerItem(){
  $id = $_GET['id'];

  $pedido = getPedido();

  unset($pedido[$id]);

  salvarPedido($pedido);
  header('location:' . URL_BASE .
    'pedidos.php?acao=finalizar');
}
