<?php

include("conexao.php");

$coluna = $_POST["coluna"];
$valor = $_POST["valor"];
$id = $_POST["id"];

$update = "UPDATE estado SET $coluna='$valor' WHERE id_estado='$id'";

mysqli_query($conexao,$update) or die (mysqli_error($conexao));

echo "1";

?>