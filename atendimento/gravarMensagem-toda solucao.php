<?php
	require_once("../includes/padrao.inc.php");
	
	// Declaração de Variáveis //
		$strNumero = $_POST["numero"];
		$idAtendimento = $_POST["id_atendimento"];
		$idCanal = isset($_POST["id_canal"]) ? $_POST["id_canal"] : "";
		$strMensagem = $_POST["msg"];
		$strResposta = $_POST["Resposta"];
		$idResposta  = $_POST["idResposta"];
		$nomeDepartamento = $_SESSION["usuariosaw"]["nomeDepartamento"];
		$possuiAnexo = false;
		$binario = '';
		$nomeArquivo = '';
		$tipo = '';
		$situacao = ( strpos($strMensagem, 'BEGIN:VCARD') !== false ) ? ((intval($idCanal) > 1 ? "E" : "N" ) ) : "E"; // O Marcelino precisa disso! Pois no Delphi ainda não funciona o envio de Contato!
		$intUserId = $_SESSION["usuariosaw"]["id"];
		$strUserNome = $_SESSION["usuariosaw"]["nome"];
		$newSequence = newSequence($conexao, $idAtendimento, $strNumero, $idCanal);
	// Declaração de Variáveis //

	// Verifica se existe um Upload //
		if( isset($_FILES["upload"]) && !empty($_FILES['upload']) ){
			$possuiAnexo = true;
			// Gravo o Binario do Anexo
			$file_tmp = $_FILES["upload"]["tmp_name"];
			$nomeArquivo = $_FILES['upload']["name"];
			$fileType = $_FILES['upload']["type"];
			
			// Mensagem de Voz - Áudio //
			if( $fileType == "audio/mpeg" ){
				$tipo = 'PTT';
				$nomeArquivo = "audio_" . $idAtendimento . "_" . $newSequence . ".mp3";
			}
			// Demais Arquivos //
			else{ $tipo = strtoupper(substr($_FILES['upload']['type'],0,5)); }
			
			// Lemos o  conteudo do arquivo usando afunção do PHP file_get_contents //
			$binario = file_get_contents($file_tmp);

			// evitamos erro de sintaxe do MySQL
			$binario = mysqli_real_escape_string($conexao,$binario);
		}
	// FIM Verifica se existe um Upload //

    //exibir o nome do Atendente em cada mensagem enviada
    if ($_SESSION["parametros"]["nome_atendente"]){	
		$strMensagem = quebraDeLinha("*".$strUserNome." [".$nomeDepartamento."]* <br>". $strMensagem ) ;	
	}
	else{ $strMensagem = quebraDeLinha($strMensagem); }

	// faz o insert apenas da Imagem, sem atendente
	$inseremsg = mysqli_query(
		$conexao, 
		"INSERT INTO tbmsgatendimento(id,seq,numero,msg, resp_msg, nome_chat,situacao, dt_msg,hr_msg,id_atend,canal, chatid_resposta)
			VALUES('".$idAtendimento."','".$newSequence."' ,'".$strNumero."', (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$strMensagem."), '".$strResposta."',
					'".$strUserNome."' ,'".$situacao."',CURDATE(),CURTIME(),'".$intUserId."','".$idCanal."', '".$idResposta."')"
	);

	// Insere o Anexo se houver
	if( $possuiAnexo ){
		$sqlInsertTbAnexo = "INSERT INTO tbanexos(id,seq,numero,arquivo,nome_arquivo,nome_original,tipo_arquivo,canal)
								VALUES ('".$idAtendimento."','".$newSequence."','".$strNumero."','".$binario."','".$nomeArquivo."',
									'".$nomeArquivo."','".$tipo."','".$idCanal."')";

		$insereAnexo = mysqli_query($conexao, $sqlInsertTbAnexo)
			or die($sqlInsertTbAnex."<br/>".mysqli_error($conexao));
	}
	
	if( $inseremsg ){ echo "1"; }
	else{ echo "0"; }