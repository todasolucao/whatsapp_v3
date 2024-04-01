<?php require_once("../../includes/padrao.inc.php"); ?>
<script>
// JavaScript Document
$( document ).ready(function() {
	$('.ConfirmaExclusaoTelefone').on('click', function (){
		var id = $(this).parent().parent().parent("li").find('#IdTelefone').val();
		abrirModal("#modalTelefoneExclusao");
		$("#IdTelefone2").val(id);
	});

	// Mudo a Aba quando der dois cliques em uma das linhas da tabela //
	$('#btnConfirmaRemoveTelefone').on('click', function (){
		$("#btnConfirmaRemoveTelefone").attr('value', 'Removendo ...');
        $('#btnConfirmaRemoveTelefone').attr('disabled', true);

	    var IdTelefone = $("#IdTelefone2").val();

		$.post("cadastros/telefoneaviso/excluir.php",{IdTelefone:IdTelefone},function(resultado){
			var mensagem  = "<strong>Telefone Removido com sucesso!</strong>";
			var mensagem2 = 'Falha ao Remover Telefone!';
			if (resultado = 2) {
				mostraDialogo(mensagem, "success", 2500);

				$.ajax("cadastros/telefoneaviso/listar.php").done(function(data) {
					$('#ListarTelefone').html(data);
				});
			}
			else{ mostraDialogo(mensagem, "danger", 2500); }

			// Fechando a Modal de Confirmação //
			$('#modalTelefoneExclusao').attr('style', 'display: none');
		});
	});
	
	$('.botaoAlterarTelefone').on('click', function (){
		// Busco os dados do Produto Selecionado  
		var codigo = $(this).parent().parent().parent("li").find('input:hidden').val();

		// Alterando Displays //
		$("#FormTelefone").css("display","block");
		$("#ListaTelefones").css("display","none");

		// Alterando o Título do Cadastro //
		$("#titleCadastroTelefone").html("Alteração de Telefone");


		$.getJSON('cadastros/telefoneaviso/carregardados.php?codigo='+codigo, function(registro){
			$("#txttelefone").val(registro.numero);
		});

		// Mudo a Ação para Alterar    
		$("#acaotelefone").val("2");
		$("#txttelefone").focus();
	});  
	
	// Fechar Cadastro //
	$('#btnFecharCadastroTelefone').on('click', function (){
		$("#ListaTelefones").css("display","block");
		$("#FormTelefone").css("display","none");
	});
	$('#btnCancelaRemoveTelefone').on('click', function (){
		// Fechando a Modal de Confirmação //
		$('#modalTelefoneExclusao').attr('style', 'display: none');
		
		$("#ListaTelefones").css("display","block");
		$("#FormTelefone").css("display","none");
	});
	// FIM Fechar Cadastro //
});

</script>

<!-- Htmls Novos -->
<div class="topLine">
    <div class="titlesTable w65p">Telefone</div>
    <div class="titlesTable">Ações</div>
    <div style="clear: both;"></div>
</div>

<ul uk-accordion style="margin-top: 0;">

  <?php
    $l = 1;

    $telefones = mysqli_query(
      $conexao
      , "SELECT * FROM tbtelefonesavisos"
    );

    while ($ListaTelefones = mysqli_fetch_array($telefones)){
      echo '<li id="linha'.$l.'">
              <input type="hidden" name="IdTelefone" id="IdTelefone" value="'.$ListaTelefones["numero"].'" />
              <div class="titlesTable w65p">'. $ListaTelefones["numero"].'</div>
              <div class="titlesTable">
                  <button class="add" style="padding: 0 10px;" title="Excluir"><span uk-icon="trash" class="ConfirmaExclusaoTelefone"></span></button>
                  <button class="add" style="padding: 0 10px;" title="Editar"><span uk-icon="pencil" class="botaoAlterarTelefone"></span></button>
              </div>
              <div style="clear: both;"></div>
          </li>';
        
      $l++;
    }
  ?>

</ul>