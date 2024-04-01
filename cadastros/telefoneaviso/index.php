<script>
    $(document).ready(function() {	
        $.ajax("cadastros/telefoneaviso/listar.php").done(function(data) {
          $('#ListarTelefone').html(data);
        });

        // Fechar a Janela //
		$('.fechar').on("click", function(){ fecharModal(); });

        // Adicionar Novo Registro //
	$('#btnNovoTelefone').click(function(e){
		e.preventDefault();
		$("#gravaTelefone")[0].reset();
		$("#FormTelefone").css("display","block");
		$("#ListaTelefones").css("display","none");
		$("#acaotelefone").val("0");
	});
	// Adicionar Novo Registro //

    // Salvando um Registro //
	$('#btnGravarTelefone').click(function(e){
		e.preventDefault();

		var mensagem  = "<strong>Telefone Cadastrado com sucesso!</strong>";
		var mensagem2 = 'Falha ao Efetuar Cadastro!';
		var mensagem3 = 'Telefone Já Cadastrado!';
		var mensagem4 = 'Telefone Atualizado com Sucesso!';

		$("input:text").css({"border-color" : "#999"});
		$(".msgValida").css({"display" : "none"});
	    
		if ($.trim($("#txttelefone").val()) == ''){
			$("#valida_telefone").css({"display" : "inline", "color" : "red"});
			$("#txttelefone").css({"border-color" : "red"});
			$("#txttelefone").focus();
			return false;
		}

		$('#id_telefone').prop('disabled', false);

	    $('#gravaTelefone').ajaxForm({
			resetForm: false, 			  
			beforeSend:function() { 
				$("#btnGravarTelefone").attr('value', 'Salvando ...');
				$('#btnGravarTelefone').attr('disabled', true);
				$('#btnFecharCadastro').attr('disabled', true);
				$('#FormTelefone').find('input').prop('disabled', true);
			},
			success: function( retorno ){
                
				if (retorno == 1) { mostraDialogo(mensagem, "success", 2500); }
				else if (retorno == 2){ mostraDialogo(mensagem4, "success", 2500); }
				else if (retorno == 3){ mostraDialogo(mensagem3, "danger", 2500); }
				else if (retorno == 4){ mostraDialogo(mensagem4, "success", 2500); }
				else if (retorno == 5){ mostraDialogo(mensagem5, "danger", 2500); }
				else{ mostraDialogo(mensagem2, "danger", 2500); }

              
				$.ajax("cadastros/telefoneaviso/listar.php").done(function(data) {
					$('#ListarTelefone').html(data);
				});
			},		 
			complete:function(retorno) {              
				$("#btnGravarTelefone").attr('value', 'Salvar');
				$('#btnGravarTelefone').attr('disabled', false);
				$('#FormTelefone').find('input, button').prop('disabled', false);
				$("#ListaTelefones").css("display","block");
				$("#FormTelefone").css("display","none");
             
			},
			error: function (retorno) { mostraDialogo(mensagem5, "danger", 2500); }
		}).submit();
	});
	// FIM Salvando um Registro //  

        
    });
</script>

<div class="box-modal" id="FormTelefone" style="display: none;">
    <form method="post" id="gravaTelefone" name="gravaTelefone" action="cadastros/telefoneaviso/salvar.php">
        <h2 class="title" id="titleCadastroTelefone">Adicionar Telefone para receber notificações de funcionamento</h2>
        <div class="">
            <input type="hidden" value="0" name="acaotelefone" id="acaotelefone" />


            <div class="uk-width-1-1@m">
                <div class="uk-form-label">Telefone </div>
                <input type="text" id="txttelefone" name="txttelefone" class="uk-input" placeholder="Telefone" />
                <div id="valida_telefone" style="display: none" class="msgValida">
                    Por favor, informe o Telefone.
                </div>
            </div>
        </div>
    </form>

    <p class="uk-text-right" style="margin-top:1rem">
        <button id="btnFecharCadastroTelefone" class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
        <input id="btnGravarTelefone" class="uk-button uk-button-primary " type="submit" value="Salvar">
    </p>
</div>

<div class="box-modal" id="ListaTelefones">
    <h2 class="title">Telefones Cadastrados <a id="btnNovoTelefone" href="#" class="uk-align-right" uk-icon="plus-circle" title="Novo Telefone"></a></h2>

    <div class="panel-body" id="ListarTelefone">				
        <!-- Menus Cadastrados -->
    </div>

    <p class="uk-text-right" style="margin-top:1rem">
        <button class="uk-button uk-button-default uk-modal-close fechar" type="button">Cancelar</button>
    </p>
</div>
