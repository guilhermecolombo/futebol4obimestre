<?php
	include("conexao.php");
	
	$id = $_POST["id"];

	$remover = "DELETE FROM estado WHERE id_estado ='$id'";

	mysqli_query($conexao,$remover)
			or die("0");
	echo "1";
?>