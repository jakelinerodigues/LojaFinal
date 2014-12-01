<?php
	require_once 'constantes.php';
	/**
	* Funções para manipulação de banco de dados MySQL
	* Obs: as funções usadas neste exemplo, são consideradas depreciadas.
	* Para desenvolvimento de aplicação real, deveriam ser usadas outras
	* opções de manipulação de banco de dados do PHP (extensão MySQLi ou PDO,
	* por exemplo).
	* O objetivo do uso das funções desatualizadas é manter a simplicidade
	* do código, sem envolver conceitos de Orientação a Objetos.
	*/


	// variável para manter o resultado de consultas realizadas
	$result = null;

	// extabelece a conexão com o servidor MySQL e mantém o ponteiro da conexão na variável $conn
	$conn = mysqli_connect(HOST, USER, PASSWORD);

	// se $conn = FALSE, significa que não foi possível conectar
	if (!$conn)
	{
		// encerra (mata) o script com a mensagem de erro
		die('Erro: Não foi possível conectar ao servidor MySQL.');
	}

	// se não for possível selecionar a base de dados
	if(!mysqli_select_db($conn, DB))
	{
		// encerra (mata) o script com a mensagem de erro
		die('Erro: Não foi possível selecionar a base de dados ' . DB);
	}

	// função para executar uma consulta SQL
	function consultar($sql)
	{
		global $conn, $result;
		// mantém o resultado da consulta na variável $result
		$result = mysqli_query($conn,$sql);

		if (!$result)
		{
			die('Erro: Problema ao executar a consulta:<br><p><code>' . $sql . '</code></p><br>'.mysql_error());
		}
	}

	// função para extrair um registro do resultado retornado pela consulta
	function proximo_registro()
	{
		global $result;
		// retorna um array associativo, com o índice do elemento sendo o nome do campo e o valor do elemento, o valor do campo retornado
		return mysqli_fetch_assoc($result);
	}

	// função para retornar o número de linhas afetadas por uma consulta SQL (INSERT, UPDATE ou DELETE)
	function linhas_afetadas()
	{
		global $conn;

		return mysqli_affected_rows($conn);
	}

	function db_select($from,$select = '*',$where = Null){
		if(is_array($select)){
			$select = implede(', ',$select);
		}
		if(is_array($where)){
			$where = whereParaString($where);
		}
		$consulta = 'SELECT '.$select.' FROM '.$from;
		if($where){
			$consulta .= ' WHERE '.$where;
		}

		consultar($consulta);
	}
	function db_insert($from,$insert){
		if(is_array($insert)){
			$insert = insertParaString($insert);
		}

		$consulta = 'INSERT INTO '.$from.' '.$insert;

		consultar($consulta);
	}
	function db_update($from,$update,$where){
		if(is_array($update)){
			$update = updateParaString($update);
		}
		if(is_array($where)){
			$where = whereParaString($where);
		}
		$consulta = 'UPDATE '.$from.' SET '.$update;
		if($where){
			$consulta .= ' WHERE '.$where;
		}

		consultar($consulta);
	}
	function db_delete($from,$where){
		if(is_array($where)){
			$where = whereParaString($where);
		}

		$consulta = 'DELETE FROM '.$from;
		if($where){
			$consulta .= ' WHERE '.$where;
		}

		consultar($consulta);
	}

	function insertParaString($list){
		$n_coluns;
		$n_valores;
		foreach ($list as $k => $v){
			$n_coluns[] = "$k";
			$n_valores[] = "'$v'";
		}
		$n_coluns = implode(', ',$n_coluns);
		$n_valores = implode(', ',$n_valores);
		$string = "(".$n_coluns.") VALUES (".$n_valores.")";
		return $string;
	}
	function updateParaString($list){
		$n_list;
		foreach ($list as $k => $v){
			$n_list[] = "$k = '$v'";
		}
		$string = implode(', ',$n_list);
		return $string;
	}
	function whereParaString($list){
		$n_list;
		foreach ($list as $k => $v){
			$n_list[] = "$k = $v";
		}
		$string = implode(' AND ',$n_list);
		return $string;
	}
