<?php
	
	header ("Content-Type: Application/json");
	
	include("conexao.php");
	
	$p = $_POST["pg"];
		
	$sql = "SELECT id_cidade as id_cidade,
	cidade.nome_cidade as nome_cidade,
	estado.uf as uf
	FROM cidade INNER JOIN estado ON cod_estado=id_estado"; 
	
	if(isset($_POST["nome_filtro"])){
		$nome = $_POST["nome_filtro"];
		$sql .= " WHERE cidade.nome_cidade LIKE '%$nome%'";
	}
	
	$sql .= " ORDER BY nome_cidade LIMIT $p,5";
	
	$resultado = mysqli_query($conexao,$sql) or die(mysqli_error($conexao));
	
	while ($linha = mysqli_fetch_assoc($resultado)){
		$matriz[] = $linha;
	}
	
	echo json_encode($matriz);

?>