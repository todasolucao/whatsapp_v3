<?php
	require_once("../includes/padrao.inc.php");
  	
	//Inicia o Atendimento
  	//Recupero os dados do atendimento selecionado
	$s_celular_atendimento = $_POST["numero"]; //Pego o número do atendimento
	$s_nome = $_POST["nome"];
	//Gero o número de atendimento

	// Verifica antes se já não tem um Atendimento em Curso //
		$qryAtendimentoAtivo = mysqli_query($conexao, "SELECT nome_atend FROM `tbatendimento` WHERE `numero` = '".$s_celular_atendimento."' AND `situacao` NOT IN('F') LIMIT 1;");
		$objAtendimentoAtivo = mysqli_fetch_object($qryAtendimentoAtivo);

		if( intval(mysqli_num_rows($qryAtendimentoAtivo)) === 0 ){
			$qryaux = mysqli_query(
				$conexao
				, "SELECT coalesce(max(id),0)+1 SEQ 
					FROM tbatendimento
						WHERE numero = '$s_celular_atendimento'"
			);

			$listaqryaux = mysqli_fetch_array($qryaux);
			$I_SEQ = $listaqryaux['SEQ'];
			$s_id_atendimento = $I_SEQ;
			// Fim da Geração do Id de Atendimento //

			//Dados do Atendente
			$id_atend = $_SESSION["usuariosaw"]["id"];
			$nome_atend = $_SESSION["usuariosaw"]["nome"];

			//Agora ao inciar exibe o setor do usuário pertence no início
			$qryDeptoUsuario = mysqli_query($conexao, "select * from tbusuariodepartamento where id_usuario = '$id_atend' ");
			$arrDeptoUsuario = mysqli_fetch_array($qryDeptoUsuario);
			$idDepartamento = $arrDeptoUsuario["id_departamento"];

			//Verifico se já possui um atendimento aberto para o usuário selecionado, se já Houver eu não inicio um novo atendimento
			$qryaux = mysqli_query(
				$conexao
				, "SELECT id 
					FROM tbatendimento 
						WHERE situacao = 'A' AND numero = '$s_celular_atendimento'"
			);

			if( mysqli_num_rows($qryaux) > 0 ){
				if( $qryaux ){
					$idAtendimento = mysqli_fetch_array($qryaux);
					echo $idAtendimento["id"]; 
				}
				else{ echo "erro"; }
				exit();
			}
			// FIM da verificação de existencia de atendimento em aberto

		// Seleciona o último ID Canal utilizado pelo cliente ou define o ID Canal Padrão //
			$qryIDCanal = mysqli_query($conexao, "SELECT canal FROM `tbatendimento` WHERE `numero` = '".$s_celular_atendimento."' ORDER BY id DESC LIMIT 1;");
			$objIDCanal = mysqli_fetch_object($qryIDCanal);

			if( intval(mysqli_num_rows($qryIDCanal)) > 0 ){
				$idCanal = $objIDCanal->canal;
			}
			// Defini o ID Canal Padrão //
			else{ $idCanal = "1"; }
		// FIM Seleciona o último ID Canal utilizado pelo cliente ou define o ID Canal Padrão //

		// if( intval(mysqli_num_rows($qryAtendimentoAtivo)) === 0 ){

			$qryaux = mysqli_query(
				$conexao
				, "INSERT INTO tbatendimento (id,situacao,nome,id_atend,nome_atend,numero,setor,dt_atend,hr_atend, canal)
					VALUES('".$s_id_atendimento."','A','".$s_nome."','".$id_atend."','".$s_nome."','".$s_celular_atendimento."','".$idDepartamento."',CURDATE(),CURTIME(), '".$idCanal."')"
			) or die(mysqli_error($conexao));

			if( $qryaux ){ echo $s_id_atendimento; }
			else{ echo "erro"; }
		}
		else{ echo "Já existe um atendimento deste cliente com o(a) atendente " . $objAtendimentoAtivo->nome_atend; }
	// FIM Verifica antes se já não tem um Atendimento em Curso //