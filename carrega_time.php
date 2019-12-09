<?php
	
	header ("Content-Type: Application/json");
	
	include("conexao.php");
	
	$p = $_POST["pg"];
		
	$sql = "SELECT id_time as id_time,
	time.nome_time as nome_time,
	cidade.nome_cidade as nome_cidade
	FROM time INNER JOIN cidade ON cod_cidade=id_cidade";
	
	if(isset($_POST["nome_filtro"])){
		$nome = $_POST["nome_filtro"];
		$sql .= " WHERE time.nome_time LIKE '%$nome%'";
	}
	
	$sql .= " ORDER BY nome_time LIMIT $p,5";
	
	$resultado = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
	
	while ($linha = mysqli_fetch_assoc($resultado)){
		$matriz[] = $linha;
	}
	
	echo json_encode($matriz);

?>