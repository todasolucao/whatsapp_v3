<?php
	require_once("../includes/padrao.inc.php");
	
	//Inicia o Atendimento
	//Recupero os dados do atendimento selecionado
	$s_celular_atendimento = $_POST["numero"]; //Pego o número do atendimento
	$s_id_atendimento = $_POST["id_atendimento"];
	$s_nome = $_POST["nome"];
	$idCanal = isset($_REQUEST["id_canal"]) ? $_REQUEST["id_canal"] : "";
	//Dados do Atendente
	$id_atend = $_SESSION["usuariosaw"]["id"];
	$nome_atend = $_SESSION["usuariosaw"]["nome"];
	$nomeDepartamento = $_SESSION["usuariosaw"]["nomeDepartamento"];

	$I_QTDE_REG=0;

	//Verifico se este atendimento já não foi iniciado por outro atendente
		$qryaux = mysqli_query(
			$conexao
			, "SELECT id 
				FROM tbatendimento 
					WHERE situacao = 'A' and id = '".$s_id_atendimento."' AND numero = '".$s_celular_atendimento."' AND canal = '".$idCanal."'"
		);

		if( mysqli_num_rows($qryaux) > 0 ){
			echo "3"; //Retorna 3 para não puxar o Atendimento novamente  
			exit();
		}
	///Fim da Verificação de atendimento já iniciado por outro atendente

	$qryaux = mysqli_query(
		$conexao
		, "UPDATE tbatendimento 
			SET situacao = 'A',
				id_atend = '".$id_atend."' ,
				nome_atend = '".$nome_atend."'				
				WHERE id = '".$s_id_atendimento."' AND numero = '".$s_celular_atendimento."' AND canal = '".$idCanal."'" );

	// Recupera a Sequência da próxima Mensagem //
	$newSequence = newSequence($conexao, $s_id_atendimento, $s_celular_atendimento, $idCanal);
	// FIM Recupera a Sequência da próxima Mensagem //
  
	$strMensagem = '';
	//Exibir mensagem de Número de Protocolo
	if ($_SESSION["parametros"]["nao_usar_menu"]==0){
		//BUsco o Número de protocolo
		$qryprotocolo = mysqli_query(
			$conexao
			, "SELECT protocolo from tbatendimento							
					WHERE id = '".$s_id_atendimento."' AND numero = '".$s_celular_atendimento."' AND canal = '".$idCanal."'" );

        $protocoolo = mysqli_fetch_assoc($qryprotocolo);
		//Adiciono no BAnco a mensagem com o Número de protocolo
		$strMensagem .= "Seu Protocolo de Atendimento é ".$protocoolo["protocolo"].". <br>";
	}
	
	// Monta a Mensagem de Início //
	$strMensagem .= "Olá você está no setor ".$nomeDepartamento.", me chamo ". $nome_atend." em que posso lhe ajudar?";

	$qryaux = mysqli_query(
		$conexao
		, "INSERT INTO tbmsgatendimento(id, seq, numero, msg, nome_chat, situacao, dt_msg, hr_msg, id_atend, canal)
			VALUES('".$s_id_atendimento."', '".$newSequence."', '".$s_celular_atendimento."', '".$strMensagem."', '".$nome_atend."', 'E', NOW(), CURTIME(), '".$id_atend."', '".$idCanal."')"
	);