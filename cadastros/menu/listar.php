<?php require_once("../../includes/padrao.inc.php"); ?>

<!-- Htmls Novos -->
<div class="topLine">
    <div class="titlesTable w45p">Menu Superior</div>
    <div class="titlesTable w45p">Menu</div>
    <div class="titlesTable">Ações</div>
    <div style="clear: both;"></div>
</div>

<ul uk-accordion style="margin-top: 0;">

  <?php
    $l = 1;

    $menus = mysqli_query(
      $conexao
      , "SELECT menu.id, menu.descricao, coalesce(submenu.descricao,'Nenhum') as pai FROM tbmenu menu left join tbmenu submenu on submenu.id = menu.pai ORDER BY id;"
    );

    while ($ListaMenus = mysqli_fetch_array($menus)){
      echo '<li id="linha'.$l.'">
              <input type="hidden" name="IdMenu" id="IdMenu" value="'.$ListaMenus["id"].'" />
              <div class="titlesTable w45p">'. $ListaMenus["pai"].'</div>
              <div class="titlesTable w45p">'. $ListaMenus["descricao"].'</div>
              <div class="titlesTable">
                  <button class="add" style="padding: 0 10px;" title="Excluir"><span uk-icon="trash" class="ConfirmaExclusaoMenu"></span></button>
                  <button class="add" style="padding: 0 10px;" title="Editar"><span uk-icon="pencil" class="botaoAlterarMenu"></span></button>
              </div>
              <div style="clear: both;"></div>
          </li>';
        
      $l++;
    }
  ?>
</ul>

<script>
// JavaScript Document
$( document ).ready(function() {
	$('.ConfirmaExclusaoMenu').on('click', function (){
		var id = $(this).parent().parent().parent("li").find('#IdMenu').val();
		abrirModal("#modalMenuExclusao");
		$("#IdMenu2").val(id);   
	});

	// Mudo a Aba quando der dois cliques em uma das linhas da tabela //
	$('#btnConfirmaRemoveMenu').on('click', function (){
		$("#btnConfirmaRemoveMenu").attr('value', 'Removendo ...');
        $('#btnConfirmaRemoveMenu').attr('disabled', true);

	    var idMenu = $("#IdMenu2").val();

		$.post("cadastros/menu/excluir.php",{IdMenu:idMenu},function(resultado){
			var mensagem  = "<strong>Menu Removido com sucesso!</strong>";
			var mensagem2 = 'Falha ao Remover Menu!';

			if (resultado = 2) {
				mostraDialogo(mensagem, "success", 2500);
				

				$.ajax("cadastros/menu/listar.php").done(function(data) {
					$("#btnConfirmaRemoveMenu").attr('value', 'Confirmar Exclusão!');
				    $('#btnConfirmaRemoveMenu').attr('disabled', false);
					$('#ListarMenu').html(data);
				});
       

			}
			else{ mostraDialogo(mensagem, "danger", 2500); }

			// Fechando a Modal de Confirmação //
			$('#modalMenuExclusao').attr('style', 'display: none');
		});
	});
	
	$('.botaoAlterarMenu').on('click', function (){
		// Busco os dados do Produto Selecionado  
		var codigo = $(this).parent().parent().parent("li").find('input:hidden').val();

		// Alterando Displays //
		$("#FormMenu").css("display","block");
		$("#ListaMenus").css("display","none");

     //atualizo o combo com as opções d emenu superio
     $.ajax("cadastros/menu/combomenu.php").done(function(data) {
					$('#id_menu').html(data);
				});

		// Alterando o Título do Cadastro //
		$("#titleCadastroMenu").html("Alteração de Menu");

		$.getJSON('cadastros/menu/carregardados.php?codigo='+codigo, function(registro){

			$("#id").val(registro.id);
			$("#id_menu").val(registro.pai);
			$("#txtmenu").val(registro.descricao);
		});

		// Mudo a Ação para Alterar    
		$("#acaomenu").val("2");
		$("#txtmenu").focus();
	});  
	
	// Fechar Cadastro //
	$('#btnFecharCadastroMenu').on('click', function (){
		$("#ListaMenus").css("display","block");
		$("#FormMenu").css("display","none");
	});
	$('#btnCancelaRemoveMenu').on('click', function (){
		// Fechando a Modal de Confirmação //
		$('#modalMenuExclusao').attr('style', 'display: none');
		
		$("#ListaMenus").css("display","block");
		$("#FormMenu").css("display","none");
	});
	// FIM Fechar Cadastro //
});

</script>