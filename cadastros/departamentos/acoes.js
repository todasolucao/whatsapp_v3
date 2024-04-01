// JavaScript Document
$( document ).ready(function() {		  
	// Adicionar Novo Registro //
	$('#btnNovoDepartamento').click(function(e){
		e.preventDefault();
		$("#gravaDepartamento")[0].reset();
		$("#FormDepartamento").css("display","block");
		$("#ListaDepartamentos").css("display","none");
		$("#acao").val("0");
	});
	// Adicionar Novo Registro //

     // Novo Registro //
	 $('#btnGravarDepartamento').click(function(e){
	   e.preventDefault();

		var mensagem  = "<strong>Departamento Cadastrado com sucesso!</strong>";
		var mensagem2 = 'Falha ao Efetuar Cadastro!';
		var mensagem3 = 'Departamento Já Cadastrado!';
		var mensagem4 = 'Departamento Atualizado com Sucesso!';
		var mensagem5 = 'Já existe um departamento vinculado ao Item de Menu Selecionado!';
		var mensagem6 = 'Existe uma resposta Automática vinculada ao Item de Menu Selecionado!';

		$("input:text").css({"border-color" : "#999"});
		$(".msgValida").css({"display" : "none"});

		if ($.trim($("#menu").val()) == ''){	
			$("#valida_menu").css({"display" : "inline", "color" : "red"});			
			$("#menu").css({"border-color" : "red"});
			$("#menu").focus();
		//	return false;
		}

		if ($.trim($("#departamento").val()) == ''){	
			$("#valida_numero").css({"display" : "inline", "color" : "red"});
			$("#departamento").css({"border-color" : "red"});
			$("#departamento").focus();
			return false;
		}		 
	  
		$('#gravaDepartamento').ajaxForm({
			resetForm: false,
			beforeSend:function() {
				$("#btnGravarDepartamento").attr('value', 'Salvando ...');
				$('#btnGravarDepartamento').attr('disabled', true);
				$('#btnFecharCadastro').attr('disabled', true);
				$('#FormDepartamento').find('input').prop('disabled', true);
			},
			success: function( retorno ){			
				// Mensagem de Cadastro efetuado
				if (retorno == 1) { mostraDialogo(mensagem, "success", 2500); }
				// Mensagem de Atualização Efetuada
				else if (retorno == 2){ mostraDialogo(mensagem4, "success", 2500); }
				// Departamento já existe
				else if (retorno == 3){ mostraDialogo(mensagem3, "danger", 2500); }
				// Já existe um departamento cadastrado para este menu
				else if (retorno == 4){ mostraDialogo(mensagem5, "danger", 2500); }
				// Já existe uma resposta automática Cadastrada para o Item de Menu selecionado
				else if (retorno == 5){ mostraDialogo(mensagem6, "danger", 2500); }
				// Mensagem de Falha no Cadastro
				else{ mostraDialogo(mensagem2, "danger", 2500); }

				$.ajax("cadastros/departamentos/listar.php").done(function(data) {
					$('#ListarDepartamento').html(data);
				});
			},
			complete:function(retorno) {			
				$("#btnGravarDepartamento").attr('value', 'Salvar');
				$('#btnGravarDepartamento').attr('disabled', false);
				$('#FormDepartamento').find('input, button').prop('disabled', false);
				$("#ListaDepartamentos").css("display","block");
				$("#FormDepartamento").css("display","none");
			},
			error: function (retorno) { mostraDialogo(mensagem5, "danger", 2500); }
		}).submit();
	 });
	// FIM Novo Registro //
});