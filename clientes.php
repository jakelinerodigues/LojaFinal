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
			listarClientes();
			break;
		case 'incluir':
			addClientes();
			break;
		case 'alterar':
			editClientes();
			break;
		case 'gravar':
			saveClientes();
			break;
		case 'excluir':
			deleteClientes();
			break;
		default:
			// encerra (mata) o script exibindo mensagem de erro
			die('Erro: Ação inexistente!');
	} // fim do switch...case

	//funções extraidas

	function listarClientes(){
		// monta a consulta para recuperar a listagem de usuários ordenada pelo nome
		$consulta = "
			select * from clientes order by nome
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
		$titulo_pagina = 'Lista de clientes';
		// carrega o arquivo com a listagem de clientes (gui)
		require_once 'gui/lista_clientes.php';
	}

	function addClientes(){
		// define o título da página
		$titulo_pagina = 'Novo cliente';
		// carrega arquivo com o formulário para incluir novo usuário
		require_once 'gui/form_clientes.php';
		// interrompe o switch...case
	}

	function editClientes(){
		// se não informou id na URL
		if (!isset($_GET['id']))
		{
			// encerra (mata) o script com mensagem de erro
			die('Erro: O código do cliente a alterar não foi
			informado.');
		}

		// captura o id passado na URL
		$id = $_GET['id'];

		db_select('clientes','*',array('id'=>$id));

		// captura o registro retornado pela consulta
		$registro = proximo_registro();

		// extrai as informações em variáveis avulsas
		$nome = $registro['nome'];
		$email = $registro['email'];
		$senha = $registro['senha'];

		// define o título da página
		$titulo_pagina = 'Alterar cliente';
		// carrega o formulário para alterar o usuário
		require_once('gui/form_clientes.php');
	}

	function saveClientes(){
		//capturar dados do formulário
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		$dados = array(
			'nome' =>$nome,
			'email'=>$email,
			'senha'=>$senha
		);
		if (!isset($_POST['id'])){ // Se for novo
			db_insert('clientes',$dados);
			$msg_erro = 'Não foi possível inserir.';
		} else { // Se for edição
			db_update('clientes',$dados,array('id'=>$_POST['id']));
			$msg_erro = 'Não foi possível alterar.';
		}
		// verifica se a operação foi bem sucedida
		if(linhas_afetadas() > 0)
		{
			// redireciona para a listagem de usuários
			header('location:' . URL_BASE .
				'clientes.php?acao=listar');
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

	function deleteClientes(){
		// se não informou id na URL
		if (!isset($_GET['id']))
		{
			// encerra (mata) o script com mensagem de erro
			die('Erro: O código do cliente a excluir não foi
				informado.');
		}

		// captura o id passado na URL
		$id = $_GET['id'];
		db_delete('clientes',array('id'=>$id));
		// verifica se a exclusão foi bem sucedida
		if(linhas_afetadas() > 0)
		{
			// redireciona para a listagem de usuários
			header('location:' . URL_BASE .
				'clientes.php?acao=listar');
			// encerra a execução do script
			exit;
		}
		else {
			// exibe mensagem de erro
			echo "Erro: Não foi possível excluir.";
			exit;
		}
	}
