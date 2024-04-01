<?php
require_once("../../includes/padrao.inc.php");

$senha = $_POST["senha"];
$id = $_SESSION["usuariosaw"]["id"];


$sql = "UPDATE tbusuario SET senha = '".$senha."' where id = '".$id."'";

$atualizar = mysqli_query($conexao, $sql) or die($sql . "<br />" . mysqli_error($conexao));

if( $atualizar ){ echo "1"; }
else{ echo "9"; }