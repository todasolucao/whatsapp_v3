// JavaScript Document
$( document ).ready(function() {
    // Adicionar Novo Registro //
		$('#btnNovoRespostaAutomatica').click(function(e){
			e.preventDefault();
			$("#gravaRespostaAutomatica")[0].reset();
			$("#FormRespostaAutomatica").css("display","block");
			$("#ListaRespostasAutomaticas").css("display","none");
			$("#acaoRespostaAutomatica").val("0");
		});
	// Adicionar Novo Registro //

    // Cadastro/Alteração de Usuário //
	$('#btnGravarRespostaAutomatica').click(function(e){
        e.preventDefault();
	   
        var mensagem  = "<strong>Resposta Automatica Cadastrada com sucesso!</strong>";
        var mensagem2 = 'Falha ao Efetuar Cadastro!';
        var mensagem3 = 'Resposta Automática Já Cadastrado!';
        var mensagem4 = 'Resposta Automática Atualizada com Sucesso!';
        var mensagem5 = 'Já existe um departamento vinculado ao Item de Menu Selecionado!';
        var mensagem6 = 'Existe uma resposta Automática vinculada ao Item de Menu Selecionado!';
  
        $("input:text").css({"border-color" : "#999"});
        $(".msgValida").css({"display" : "none"});
	    
        if ($.trim($("#menu_resposta").val()) == ''){	
            $("#valida_menu_resposta").css({"display" : "inline", "color" : "red"});			
            $("#menu_resposta").css({"border-color" : "red"});
            $("#menu_resposta").focus();
            return false;
        }	

        if ($.trim($("#respostaautomatica").val()) == ''){	
            $("#valida_respostaautomatica").css({"display" : "inline", "color" : "red"});
            $("#respostaautomatica").css({"border-color" : "red"});
            $("#respostaautomatica").focus();
            return false;
        }
	  
	    $('#gravaRespostaAutomatica').ajaxForm({
		    resetForm: false, 			  
            beforeSend:function() { 
                $("#btnGravarRespostaAutomatica").attr('value', 'Salvando ...');
				$('#FormRespostaAutomatica').find('input, button').prop('disabled', true);
            },
            success: function( retorno ){
                // Mensagem de Cadastro efetuado //
                if (retorno == 1) { mostraDialogo(mensagem, "success", 2500); }
                // Mensagem de Atualização Efetuada //
                else if (retorno == 2){ mostraDialogo(mensagem4, "success", 2500); }
                // Departamento já existe //
                else if (retorno == 3){ mostraDialogo(mensagem3, "danger", 2500); }
                // Já existe um departamento cadastrado para este menu //
                else if (retorno == 4){ mostraDialogo(mensagem5, "danger", 2500); }
                // Já existe uma resposta automática Cadastrada para o Item de Menu selecionado //
                else if (retorno == 5){ mostraDialogo(mensagem6, "danger", 2500); }
                // Mensagem de Falha no Cadastro //
                else{ mostraDialogo(mensagem2, "danger", 2500); }

                $.ajax("cadastros/respostasautomaticas/listar.php").done(function(data) {
                    $('#ListarRespostaAutomatica').html(data);
                });
            },		 
		    complete:function() {
                $("#btnGravarRespostaAutomatica").attr('value', 'Salvar');
				$('#FormRespostaAutomatica').find('input, button').prop('disabled', false);
				$("#ListaRespostasAutomaticas").css("display","block");
				$("#FormRespostaAutomatica").css("display","none");
            },
            error: function (retorno) { mostraDialogo(mensagem5, "danger", 2500); }
	    }).submit();
	});
    // FIM Novo Registro //
});