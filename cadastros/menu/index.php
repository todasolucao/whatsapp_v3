
<script>
    $(document).ready(function() {	
        $.ajax("cadastros/menu/listar.php").done(function(data) {
          $('#ListarMenu').html(data);
        });

        // Fechar a Janela //
		$('.fechar').on("click", function(){ fecharModal(); });
    });
</script>

<div class="box-modal" id="FormMenu" style="display: none;">
    <form method="post" id="gravaMenu" name="gravaMenu" action="cadastros/menu/salvar.php">
        <h2 class="title" id="titleCadastroMenu">Adicionar Novo Menu</h2>
        <div class="">
            <input type="hidden" value="0" name="acaomenu" id="acaomenu" />

            <div class="uk-width-1-1@m">
                <div class="uk-form-label">Menu Superior</div>
                <input type="hidden" name="id" id="id" value="0">
                <select name="id_menu" id="id_menu" class="uk-select">                    
                    <?php
                       require_once("combomenu.php");
                    ?>
                    
                </select>
            </div>

            <div class="uk-width-1-1@m">
                <div class="uk-form-label"> Descrição do Item do Menu </div>
                <input type="text" id="txtmenu" name="txtmenu" class="uk-input" placeholder="Descrição do Item do Menu" />
                <div id="valida_menu" style="display: none" class="msgValida">
                    Por favor, informe a Descrição do Item do Menu.
                </div>
            </div>
        </div>
    </form>

    <p class="uk-text-right" style="margin-top:1rem">
        <button id="btnFecharCadastroMenu" class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
        <input id="btnGravarMenu" class="uk-button uk-button-primary " type="submit" value="Salvar">
    </p>
</div>

<div class="box-modal" id="ListaMenus">
    <h2 class="title">Menus Cadastrados <a id="btnNovoMenu" href="#" class="uk-align-right" uk-icon="plus-circle" title="Novo Menu"></a></h2>

    <div class="panel-body" id="ListarMenu">				
        <!-- Menus Cadastrados -->
    </div>

    <p class="uk-text-right" style="margin-top:1rem">
        <button class="uk-button uk-button-default uk-modal-close fechar" type="button">Cancelar</button>
    </p>
</div>
<script>
    // JavaScript Document
$( document ).ready(function() {
	
	// Adicionar Novo Registro //
	$('#btnNovoMenu').click(function(e){
		e.preventDefault();
		$("#gravaMenu")[0].reset();
		$("#FormMenu").css("display","block");
		$("#ListaMenus").css("display","none");
		$("#acaomenu").val("0");
	});
	// Adicionar Novo Registro //

    // Salvando um Registro //
	$('#btnGravarMenu').click(function(e){
		e.preventDefault();	

		var mensagem  = "<strong>Menu Cadastrado com sucesso!</strong>";
		var mensagem2 = 'Falha ao Efetuar Cadastro!';
		var mensagem3 = 'Menu Já Cadastrado!';
		var mensagem4 = 'Menu Atualizado com Sucesso!';
		

		$("input:text").css({"border-color" : "#999"});
		$(".msgValida").css({"display" : "none"});
	    
		if ($.trim($("#txtmenu").val()) == ''){
			$("#valida_menu").css({"display" : "inline", "color" : "red"});
			$("#txtmenu").css({"border-color" : "red"});
			$("#txtmenu").focus();
			return false;
		}

		//$('#id_menu').prop('disabled', false);
 
	    $('#gravaMenu').ajaxForm({
			resetForm: false, 			  
			beforeSend:function() { 
				$("#btnGravarMenu").attr('value', 'Salvando ...');
				$('#btnGravarMenu').attr('disabled', true);
				$('#btnFecharCadastro').attr('disabled', true);
				$('#FormMenu').find('input').prop('disabled', true);
			},
			success: function( retorno ){
			//	alert("Sucesso"+retorno);
				if (retorno == 1) { mostraDialogo(mensagem, "success", 2500); }
				else if (retorno == 2){ mostraDialogo(mensagem4, "success", 2500); }
				else if (retorno == 3){ mostraDialogo(mensagem3, "danger", 2500); }
				else if (retorno == 4){ mostraDialogo(mensagem4, "success", 2500); }
				else if (retorno == 5){ mostraDialogo(mensagem5, "danger", 2500); }
				else{ 
				//	alert(retorno);
					
				//	mostraDialogo(mensagem2+retorno, "danger", 2500); 
				}
                
				$.ajax("cadastros/menu/listar.php").done(function(data) {
					$('#ListarMenu').html(data);
				});
				//Atualizo a lista
				$.ajax("cadastros/menu/combomenu.php").done(function(data) {
					$('#id_menu').html(data);
				});
			},		 
			complete:function(retorno) {
		//		alert("Completo"+retorno);
				$("#btnGravarMenu").attr('value', 'Salvar');
				$('#btnGravarMenu').attr('disabled', false);
				$('#FormMenu').find('input, button').prop('disabled', false);
				$("#ListaMenus").css("display","block");
				$("#FormMenu").css("display","none");
				
			},
			error: function (retorno) {
			//	alert("Erro"+retorno);
				 mostraDialogo(mensagem5, "danger", 2500);
			 
		}
		}).submit();
	});
	// FIM Salvando um Registro //  


	$.ajax("cadastros/menu/combomenu.php").done(function(data) {
		$('#id_menu').html(data);
	});


});
</script>