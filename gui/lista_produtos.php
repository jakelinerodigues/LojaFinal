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
						<th>Código</th><th>Nome</th><th>Departamento</th><th>Preço</th><th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($registros as $registro)
						{
							echo "
								<tr>
									<td>" . $registro['id'] . "</td>
									<td>{$registro['nome_produto']}</td>
									<td>{$registro['nome_departamento']}</td>
									<td>{$registro['preco']}</td>
									<td class='acoes'>
										<a href='" . URL_BASE . "produtos.php?acao=alterar&id={$registro['id']}'>A</a>&nbsp;&nbsp;
										<a href='javascript:if(confirm(\"Confirma a exclusão?\")){document.location=\"" .
										URL_BASE . "produtos.php?acao=excluir&id={$registro['id']}\";}'>E</a>
									</td>
								</tr>
							";
						}
					?>
				</tbody>
			</table>
			<div class="form-group"><button type="button"
				onclick="document.location='<?=URL_BASE;?>produtos.php?acao=incluir';">Novo</button></div>
		</div><!-- container -->
	</body>
</html>