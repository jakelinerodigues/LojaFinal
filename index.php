<?php
	session_start();

	require_once('lib/constantes.php');
	require_once('lib/funcoes.php');
	require_once('lib/acesso.php');

	verificar_login();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Loja virtual - Área Administrativa - Início</title>
		<meta charset="utf-8">
		<style type="text/css">
			@import "<?php echo URL_BASE; ?>css/estilos.css";
		</style>
	</head>
	<body>
		<div class="container">
			<h1>Menu principal</h1>
			<nav>
				<li><a href="<?php echo URL_BASE;?>">Início</a></li>
				<li><a href="<?php echo URL_BASE.'pedidos.php';?>">Pedidos</a></li>
				<li><a href="<?php echo URL_BASE.'produtos.php';?>">Produtos</a></li>
				<li><a href="<?php echo URL_BASE.'departamentos.php'?>">Departamentos</a></li>
				<li><a href="<?php echo URL_BASE.'clientes.php';?>">Clientes</a></li>
				<li><a href="<?php echo URL_BASE.'usuarios.php';?>">Usuários</a></li>
				<li><a href="<?php echo URL_BASE.'login.php?acao=sair';?>">Sair</a></li>
			</nav>
		</div>
	</body>
</html>