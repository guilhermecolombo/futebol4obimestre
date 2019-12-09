<?php
	include("conexao.php");
	
	$id = $_POST["id"];

	$remover = "DELETE FROM time WHERE id_time ='$id'";

	mysqli_query($conexao,$remover)
			or die("0");
	echo "1";
?>