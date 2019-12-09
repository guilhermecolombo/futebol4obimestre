<?php
	
	header ("Content-Type: Application/json");
	
	include("conexao.php");
	
	$p = $_POST["pg"];
		
	$sql = "SELECT 	id_jogador as id_jogador,
					jogador.nome_jogador as nome_jogador,
					jogador.email as email,
					jogador.sexo as sexo,
					jogador.data_nascimento as data_nascimento,
					jogador.posicao as posicao,
					cidade.nome_cidade as nome_cidade,
					time.nome_time as nome_time
					FROM jogador INNER JOIN cidade ON jogador.cod_cidade=cidade.id_cidade
					 INNER JOIN time ON jogador.cod_time=time.id_time";
	
	if(isset($_POST["nome_filtro"])){
		$nome = $_POST["nome_filtro"];
		$sql .= " WHERE jogador.nome_jogador LIKE '%$nome%'";
	}
	
	$sql .= " ORDER BY nome_jogador LIMIT $p,5";
	
	$resultado = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
	
	while ($linha = mysqli_fetch_assoc($resultado)){
		$matriz[] = $linha;
	}

	echo json_encode($matriz);

?>