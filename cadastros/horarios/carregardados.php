<?php 
    require_once("../../includes/padrao.inc.php");
	
	$codigo    = $_GET["codigo"];
	$tabela    = "tbhorarios";

    $dados     = mysqli_query( $conexao
                    , "SELECT id, dia_semana, DATE_FORMAT(hr_inicio,'%H:%i') AS hr_inicio, DATE_FORMAT(hr_fim, '%H:%i') AS hr_fim, fechado 
                            FROM $tabela WHERE id = '$codigo'"
    );
	$resultado = mysqli_fetch_object($dados);

    echo json_encode($resultado);