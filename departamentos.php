<?php
	// importa o código dos scripts
	require_once 'lib/constantes.php';
	require_once 'lib/database.php';

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
		$acao = 'listar';
	}

	switch($acao)
	{
		case 'listar':
			listarDepartamentos();
			break;
		case 'incluir':
			incluirDepartamentos();
			break;
		case 'alterar':
			editarDepartamentos();
			break;
		case 'gravar':
			gravarDepartamentos();
			break;
		case 'excluir':
			excluirDepartamentos();
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
		$titulo_pagina = 'Lista de departamentos';
		// carrega o arquivo com a listagem de clientes (gui)
		require_once 'gui/lista_departamentos.php';
	}
	function incluirDepartamentos(){
		// define o título da página
		$titulo_pagina = 'Novo departamento';
		// carrega arquivo com o formulário para incluir novo usuário
		require_once 'gui/form_departamentos.php';
		// interrompe o switch...case
	}
	function editarDepartamentos(){
		// se não informou id na URL
		if (!isset($_GET['id']))
		{
			// encerra (mata) o script com mensagem de erro
			die('Erro: O código do departamento a alterar não foi
			informado.');
		}

		// captura o id passado na URL
		$id = $_GET['id'];

		// executa a consulta
		db_select('departamentos','*',array('id'=>$id));

		// captura o registro retornado pela consulta
		$registro = proximo_registro();

		// extrai as informações em variáveis avulsas
		$nome = $registro['nome'];

		// define o título da página
		$titulo_pagina = 'Alterar departamento';
		// carrega o formulário para alterar o usuário
		require_once('gui/form_departamentos.php');
	}
	function gravarDepartamentos(){
		//capturar dados do formulário
		$nome = $_POST['nome'];

		$dados = array('nome'=>$nome);

		if (!isset($_POST['id']))
		{
		// monta consulta sql para realização a inserção
			db_insert('departamentos',$dados);
			$msg_erro = 'Não foi possível inserir.';
		}
		else
		{
			db_update('departamentos',$dados,array('id'=>$_POST['id']));
			$msg_erro = 'Não foi possível alterar.';
		}

		// verifica se a operação foi bem sucedida
		if(linhas_afetadas() > 0)
		{
			// redireciona para a listagem de usuários
			header('location:' . URL_BASE .
				'departamentos.php?acao=listar');
			// finaliza a execução do script
			exit;
		}
		else {
			// exibe mensagem de erro
			echo 'Erro: ' . $msg_erro;
			// finaliza a execução do script
			exit;
		}
	}
	function excluirDepartamentos(){
		// se não informou id na URL
		if (!isset($_GET['id']))
		{
			// encerra (mata) o script com mensagem de erro
			die('Erro: O departamento do cliente a excluir não foi
				informado.');
		}

		// captura o id passado na URL
		$id = $_GET['id'];

		db_delete('departamentos',array('id'=>$id));

		// verifica se a exclusão foi bem sucedida
		if(linhas_afetadas() > 0)
		{
			// redireciona para a listagem de usuários
			header('location:' . URL_BASE .
				'departamentos.php?acao=listar');
			// encerra a execução do script
			exit;
		}
		else {
			// exibe mensagem de erro
			echo "Erro: Não foi possível excluir.";
			exit;
		}
	}
