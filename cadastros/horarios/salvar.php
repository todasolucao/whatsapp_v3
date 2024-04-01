<?php
	require_once("../../includes/padrao.inc.php");
	$acao	= $_POST['acaohorario'];
	$id		= $_POST['idHorario'];
	$dia	= $_POST['dia_semana'];
	$hrIni	= $_POST['hr_inicio'];
	$hrFim	= $_POST['hr_fim'];
	$closed	= isset($_POST['fechado']) ? $_POST['fechado'] : "0";

	// Verifica se já existe //
	$existe = mysqli_query( $conexao, "SELECT 1 FROM tbhorarios WHERE dia_semana = '".$dia."' AND id NOT IN('".$id."')");
	if( mysqli_num_rows($existe) > 0 ){ echo "3"; }
	else{
		if( $acao == 0 ){
			// Iniciando a SQL //
			$sql = "INSERT INTO tbhorarios (dia_semana, hr_inicio, hr_fim, fechado) VALUES('".$dia."',";

			// Tratando a possibilidade de não existir um Horário de Atendimento //
			if( $hrIni !== "" ){ $sql .= "'".$hrIni."', "; }
			else { $sql .= "NULL,"; }
			if( $hrFim !== "" ){ $sql .= "'".$hrFim."', "; }
			else { $sql .= "NULL,"; }
			// FIM Tratando a possibilidade de não existir um Horário de Atendimento //

			// Finalizando a SQL //
			$sql .= "'".$closed."')";

			$inserir = mysqli_query($conexao, $sql)
				or die( $sql."<br/>".mysqli_error($conexao) );
		
			if ($inserir){ echo "1"; }
			else{ echo "3"; }
		}
		else{
			// Iniciando a SQL //
			$sql = "UPDATE tbhorarios SET dia_semana = '".$dia."', ";

			// Tratando a possibilidade de não existir um Horário de Atendimento //
			if( $hrIni !== "" ){ $sql .= "hr_inicio = '".$hrIni."',"; }
			else { $sql .= "hr_inicio = NULL,"; }
			if( $hrFim !== "" ){ $sql .= "hr_fim = '".$hrFim."',"; }
			else { $sql .= "hr_fim = NULL,"; }
			// FIM Tratando a possibilidade de não existir um Horário de Atendimento //

			// Finalizando a SQL //
			$sql .= " fechado = '".$closed."' where id = '$id'";

			$atualizar = mysqli_query($conexao,$sql)
				or die( $sql."<br/>".mysqli_error($conexao) );
	
			if ($atualizar){ echo "2"; }
			else{ echo "3"; }
		}
	}