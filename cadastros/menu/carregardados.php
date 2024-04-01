<?php 
    require_once("../../includes/padrao.inc.php");
	
	$codigo    = $_GET["codigo"];
	$tabela    = "tbmenu";

    $dados     = mysqli_query($conexao,"select * from $tabela where id = '$codigo'");
	$resultado = mysqli_fetch_object($dados);

    echo json_encode($resultado);