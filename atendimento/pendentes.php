<?php
	// Requires //
	require_once("../includes/padrao.inc.php");

    // Definições de Variáveis //
		$id_usuario = isset($_SESSION["usuariosaw"]["id"]) ? $_SESSION["usuariosaw"]["id"] : "";
		$htmlConversas = "";
		$ultHora = null;
		$ultMsg = null;
	// FIM Definições de Variáveis //

    $filtroDepartamento = '';

	if ($_SESSION["usuariosaw"]["perfil"] > 0){
       $filtroDepartamento = ' AND ta.setor IN(SELECT id_departamento FROM tbusuariodepartamento WHERE id_usuario = '.$id_usuario.')';
	}

							
	$qryAtendPend = mysqli_query(
		$conexao
		, "SELECT taa.id, taa.numero, ta.nome, CASE WHEN  tc.nome IS NULL then ta.nome when tc.nome = '' then ta.nome else tc.nome END  AS nomeContato, ta.canal, td.id AS idDepartamento, td.departamento, tfp.foto AS foto_perfil 
		   , tbe.cor, tbe.descricao as etiqueta
			FROM tbatendimentoaberto taa
				INNER JOIN tbatendimento ta ON taa.id = ta.id and taa.numero = ta.numero
				INNER JOIN tbdepartamentos td ON td.id = ta.setor
				LEFT JOIN tbcontatos tc ON taa.numero = tc.numero
				LEFT JOIN tbfotoperfil tfp ON tfp.numero = taa.numero
				LEFT JOIN tbetiquetas tbe on tbe.id = tc.idetiqueta
					WHERE situacao = 'P' AND ta.setor IN(
						SELECT id_departamento 
							FROM tbusuariodepartamento 

					) 
								$filtroDepartamento
						ORDER BY ta.dt_atend, ta.hr_atend"
	);

	if( mysqli_num_rows($qryAtendPend) == 0 ){
		echo "<font size=\"2\" color=\"#CCC\"><b>&nbsp;&nbsp;&nbsp;&nbsp;Nenhum atendimento pendente</b></font>";
	}
	

	// Aqui faz a listagem dos Atendimentos Pendentes //
	while( $registros = mysqli_fetch_object($qryAtendPend) ){
		
		
		// Busco a QTD de mensagens novas //
		$qtdNovas = mysqli_query(
			$conexao
			, "SELECT count(id) AS qtd_novas 
				FROM tbmsgatendimento 
					WHERE numero = '".$registros->numero."' AND id = '".$registros->id."' AND id_atend = 0 AND visualizada = false"
		);
		
		$not = mysqli_fetch_array($qtdNovas);

		if( $not["qtd_novas"] > 0 ){
			$notificacoes = $not["qtd_novas"];

			// Dispara o Alerta Sonoro - Se definido no Painel de Configurações //
			if( $_SESSION["parametros"]["alerta_sonoro"] ){
				echo '<iframe src="https://player.vimeo.com/video/402630730?autoplay=1&loop=0&autopause=1" style="display: none" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';
			}
		}
		else{ $notificacoes = ""; }
		// Fim da NOtificação Sonora

		// Verificando a última Mensagem //
			$qryUltMsg = mysqli_query(
				$conexao
				, "SELECT msg, DATE_FORMAT(hr_msg, '%H:%i') AS hora,
				 TIMESTAMPDIFF(MINUTE, dt_msg,
							NOW()) AS MINUTOS_MSG
				  FROM tbmsgatendimento 
					WHERE numero = '".$registros->numero."' AND id = '".$registros->id."'
						ORDER BY seq DESC
							LIMIT 1"
			);

			// Verifica se Existe Resultado //
			if( mysqli_num_rows($qryUltMsg) > 0 ){
				$arrUltMsg = mysqli_fetch_array($qryUltMsg);
				$ultHora = $arrUltMsg['hora'];
				$ultMsg	= $arrUltMsg['msg'];



				 //Trato a hora da Última mensagem de acordo com o Parametro
				//Verifico se é para Exibir o tempo da Última mensagem apenas quando for enviada pelos Clientes
				if( $_SESSION["parametros"]["contar_tempo_espera_so_dos_clientes"] ){
					$qryHoraUltMsg = mysqli_query(
						$conexao
						, "SELECT DATE_FORMAT(hr_msg, '%H:%i') AS hora,
								TIMESTAMPDIFF(MINUTE, dt_msg,
									NOW()) AS MINUTOS_MSG
						
						FROM tbmsgatendimento 
							WHERE numero = '".$registros->numero."' AND id = '".$registros->id."' and id_atend = '0'
								ORDER BY seq DESC
									LIMIT 1"
					);	//Passo o ID_ATEND Zero para pegar a hora da mensagem enviada pelo Cliente
					
					$arrUltHoraCliente = mysqli_fetch_array($qryHoraUltMsg);
					$ultHora = $arrUltHoraCliente['hora'];
				}

				
				// Encurta a MSG caso ela possua mais que 40 caracteres //
				if( strlen($ultMsg) > 40 ){ $ultMsg = substr($ultMsg, 0, 40) . "..."; }
			}
		// FIM Verificando a última Mensagem //

		// Tratamento do Nome //
			if( $registros->nomeContato !== "" ){
				 $registros->nome = $registros->nomeContato; 
			}
		// FIM Tratamento do Nome //

               //Mostro a etiqueta de acordo com a selecionada no
		$etiqueta = '';
		//BUsco as etiquetas vinculadas ao numero
		$qryEtiquetas = mysqli_query($conexao,"select te.cor, te.descricao as etiqueta from tbetiquetascontatos tec
		inner join tbetiquetas te on te.id = tec.id_etiqueta
		where tec.numero = '$registros->numero'");

		while( $registrosEtiqueta = mysqli_fetch_object($qryEtiquetas) ){

		if ($registrosEtiqueta->cor != ''){
			$etiqueta .= '<i class="fas fa-tag" style="color:'.$registrosEtiqueta->cor.'" alt="'.$registrosEtiqueta->etiqueta.'" title="'.$registrosEtiqueta->etiqueta.'"></i>';
		}

	}

		//MOstro o relógio indicando a qtd de minutos sem atendimento
		@$msgtempoEspera = trataTempoOciosodoAtendente($arrUltMsg['MINUTOS_MSG']);
		@$tempoOcioso = '<i class="fas fa-solid fa-clock  fa-1x" alt="'.$msgtempoEspera[0].'"  title="'.$msgtempoEspera[0].'" style="margin-left:1px;'.$msgtempoEspera[1].'"></i>';


		// Pego a foto de perfil //
		$cordefundo = rand ( 100000 , 999999 );
		$estiloPerfil = 'style="font-size: 1.3em;display: -webkit-flex;
			display: -ms-flexbox;
				   display: flex;
	   
		   -webkit-align-items: center;
			 -webkit-box-align: center;
			-ms-flex-align: center;
			   align-items: center;
		   
		 justify-content: center;color:white; background-color:'.@$cordefundo.'"';
		if( $_SESSION["parametros"]["exibe_foto_perfil"] ){
			$fotoPerfil = getFotoPerfil($conexao, $registros->numero);
			if (strlen($fotoPerfil)<5){
                $perfil = RetornaNomeAbreviado($registros->nome); 
			}else{
				$perfil = '<img src="'.$fotoPerfil.'" class="rounded-circle user_img">';
				$estiloPerfil = 'style="color:white; background-color:'.@$cordefundo.'"';
			}				
		}
		else{ 
			$perfil = RetornaNomeAbreviado($registros->nome); 	
			
		}

		echo '<div class="contact-item linkDivPendente">
				<input type="hidden" id="numero" value="'.$registros->numero.'">
				<input type="hidden" id="id_atendimento" value="'.$registros->id.'">
				<input type="hidden" id="nome" value="'.limpaNome($registros->nome).'">
				<input type="hidden" id="id_canal" value="'.$registros->canal.'">

				<div class="dIyEr">
					<div class="_1WliW" style="height: 49px; width: 49px;">
						<img src="#" class="Qgzj8 gqwaM photo" style="display:none;">
						<div class="_3ZW2E" '.$estiloPerfil.'>
						   '.$perfil.'
						</div>
					</div>
				</div>
				<div class="_3j7s9">
					<div class="_2FBdJ">
						<div class="_25Ooe">
							<span dir="auto" title="'.limpaNome($registros->nome).' '.Mask($registros->numero).'" class="_1wjpf">
							    '.$tempoOcioso.'
							    '.getCanal($conexao, $registros->canal).limpaNome($registros->nome).'
								'.$etiqueta.'								
							</span>
						</div>
						<div class="_3Bxar">
							<span class="_3T2VG" id="hor'.$registros->numero.'">'.$ultHora.'</span>
						</div>
					</div>
					<div class="_1AwDx">
						<div class="_itDl">
							<!-- Wagner: Feature ainda não implementada!  <span title="digitando…" class="vdXUe _1wjpf typing" style="display:none">digitando…</span> -->
							
							<span class="_2_LEW last-message">
								<div class="_1VfKB">
									<!--
									<span data-icon="status-dblcheck" class="">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" width="18" height="18">
											<path fill="#263238" fill-opacity=".4" d="M17.394 5.035l-.57-.444a.434.434 0 0 0-.609.076l-6.39 8.198a.38.38 0 0 1-.577.039l-.427-.388a.381.381 0 0 0-.578.038l-.451.576a.497.497 0 0 0 .043.645l1.575 1.51a.38.38 0 0 0 .577-.039l7.483-9.602a.436.436 0 0 0-.076-.609zm-4.892 0l-.57-.444a.434.434 0 0 0-.609.076l-6.39 8.198a.38.38 0 0 1-.577.039l-2.614-2.556a.435.435 0 0 0-.614.007l-.505.516a.435.435 0 0 0 .007.614l3.887 3.8a.38.38 0 0 0 .577-.039l7.483-9.602a.435.435 0 0 0-.075-.609z"></path>
										</svg>
									</span>
									-->
								</div>
								<span dir="ltr" class="_1wjpf _3NFp9" id="msg'.$registros->numero.'">'.$ultMsg.'</span>
								<div class="_3Bxar">
									<span>
										<div class="_15G96" id="not'.$registros->numero.'">'.$notificacoes.'</div>
									</span>
								</div>
							</span>
						</div>
					</div>
				</div>
			</div>';

		// Gravo em uma Sessão o Setor do Atendimento //
		$_SESSION["usuariosaw"]["idDepartamento"] = $registros->idDepartamento;
        $_SESSION["usuariosaw"]["nomeDepartamento"] = $registros->departamento;
	}
?>

<script>
	$(document).ready(function(){		
		$('.linkDivPendente').click(function(){
			// Para inibir múltiplos clicks no Atendimento //
			var find = /carregando/g;
			var larguradatela = $(window).width();

			// Limpa o campo Número e Nome //
				if( $("#transferirParaMim") !== undefined ){
					// Limpando os Hiddens de Controle //
						$("#s_numero").val("");
						$("#s_id_atendimento").val("");
						$("#s_id_canal").val("");
						$("#s_nome").val("");
					// FIM Limpando os Hiddens de Controle //
				}
			// FIM Limpa o campo Número e Nome //

			if( !find.test($(this).attr('class')) ){
				var numero = $(this).find("#numero").val();
				var id_atendimento = $(this).find("#id_atendimento").val();
				var nome = $(this).find("#nome").val();
				var id_canal = $(this).find("#id_canal").val();
				var compareA = numero + id_canal;
				var compareB = $("#s_numero").val() + $("#s_id_canal").val();

				// Só permite carregar a conversa se a mensma ainda não foi carregada //
				if( compareA !== compareB ){
					$('#AtendimentoAberto').html("Carregando conversa ... Aguarde um momento, por favor!");
					$('.linkDivPendente').removeClass( "active" );
					$(this).addClass( "active carregando" );
					
					// Faz a Inicialização do atendimento //
					$.post("atendimento/iniciarAtendimento.php",{id_atendimento:id_atendimento,id_canal:id_canal,numero:numero,nome:nome}, function(retorno){
						// Atualizando a Lista de Atendimentos Pendentes //
						$.ajax("atendimento/pendentes.php").done(function(data) {
							$("#ListaPendentes").html(data);
						});

						// Atualizando a Lista de Atendimentos em Andamento //
						$.ajax("atendimento/atendendo.php").done(function(data) {
							$("#ListaEmAtendimento").html(data);
						});

						// Tratamento de retorno com Conversa já em Atendimento (outro Operador) //
						if( retorno == 3 ){
							mostraDialogo("Este Atendimento já está sendo atendido", "danger", 2500);
							return false;
						}

						// Mostro a Conversa //
						$.ajax("atendimento/conversa.php?id="+id_atendimento+"&id_canal="+id_canal+"&numero="+numero+"&nome="+encodeURIComponent(nome)).done(
							function(data) {
							if (larguradatela < 801){ //Se a tela for menor qu 800pixels minimizo os atendimentos para ficar mais responsivo							
							       $('#btnMinimuiConversas').click();							
						     }
							$('#AtendimentoAberto').html(data);
							$('.linkDivPendente').removeClass( "carregando" );
						});
					});
					// FIM Faz a Inicialização do atendimento //
				}
				// FIM Só permite carregar a conversa se a mensma ainda não foi carregada //
			}
			// FIM Para inibir múltiplos clicks no Atendimento //
		});
	});
</script>