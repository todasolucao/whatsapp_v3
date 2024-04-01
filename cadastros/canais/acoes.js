// JavaScript Document
$( document ).ready(function() {	
	// Adicionar Novo Registro //
		$('#btnNovoUsuario').click(function(e){
			e.preventDefault();
			$("#gravaUsuario")[0].reset();
			$("#FormUsuarios").css("display","block");
			$("#ListaUsuarios").css("display","none");
			$("#acaoUsuario").val("0");

			// Remove a opção de seleção do tipo de usário ADM //
			if( $("#perfilUsuario").val() !== 0 ){
				var selectobject = document.getElementById("perfil");

				for (var i=0; i<selectobject.length; i++) {
					if (selectobject.options[i].value == '0'){ selectobject.remove(i); }
				}
			}
		});
	// Adicionar Novo Registro //

     // Cadastro/Alteração de Usuário //
	 $('#btnGravarUsuario').click(function(e){
	   	e.preventDefault();
	   
		var mensagem  = "<strong>Usuário Cadastrado com sucesso!</strong>";
		var mensagem2 = 'Falha ao Efetuar Cadastro!';
		var mensagem3 = 'Usuário Já Cadastrado com este Login!';
		var mensagem4 = 'Usuário Atualizado com Sucesso!';
	  
		$("input:text").css({"border-color" : "#999"});
		$(".msgValida").css({"display" : "none"});
	    
		if ($.trim($("#nome_usuario").val()) == ''){
			$("#valida_nome").css({"display" : "inline", "color" : "red"});
			$("#nome_usuario").css({"border-color" : "red"});
			$("#nome_usuario").focus();
			return false;
		}

		if ($.trim($("#login").val()) == ''){	
			$("#valida_login").css({"display" : "inline", "color" : "red"});
			$("#login").css({"border-color" : "red"});
			$("#login").focus();
			return false;
		}	

		if ($.trim($("#senha").val()) == ''){	
			$("#valida_senha").css({"display" : "inline", "color" : "red"});
			$("#senha").css({"border-color" : "red"});
			$("#senha").focus();
			return false;
		}

		// Gravando os dados do Usuário //
	    $('#gravaUsuario').ajaxForm({
			resetForm: false,
        	beforeSend:function() {
				$("#btnGravarUsuario").attr('value', 'Salvando ...');
				$('#btnGravarUsuario').attr('disabled', true);
				$('#btnFecharCadastro').attr('disabled', true);
				$('#FormUsuarios').find('input').prop('disabled', true);
        	},
			success: function( retorno ){
				if (retorno == 1) { mostraDialogo(mensagem, "success", 2500); }
				else if (retorno == 2){ mostraDialogo(mensagem4, "success", 2500); }
				else if (retorno == 3){ mostraDialogo(mensagem3, "danger", 2500); }
				else if (retorno == 4){ mostraDialogo(mensagem4, "success", 2500); }
				else if (retorno == 5){ mostraDialogo(mensagem5, "danger", 2500); }
				else{ mostraDialogo(mensagem2, "danger", 2500); }

				$.ajax("cadastros/usuarios/listar.php").done(function(data) {
					$('#ListarUsuario').html(data);
				});
			},		 
			complete:function() {
				$("#btnGravarUsuario").attr('value', 'Salvar');
				$('#btnGravarUsuario').attr('disabled', false);
				$('#FormUsuarios').find('input, button').prop('disabled', false);
				$("#ListaUsuarios").css("display","block");
				$("#FormUsuarios").css("display","none");
		 	},
		 	error: function (retorno) {
				mostraDialogo(mensagem5, "danger", 2500);
            }
		}).submit();
		// FIM Gravando os dados do Usuário //
	});
	// FIM Cadastro/Alteração de Usuário //
});