// JavaScript Document
$( document ).ready(function() {
	var behavior = function (val) { return '00:00'; }
	, options = {
        onKeyPress: function (val, e, field, options) {
            field.mask(behavior.apply({}, arguments), options);
        }
    };

    $('#hr_inicio').mask(behavior, options);
	$('#hr_fim').mask(behavior, options);
	
	// Adicionar Novo Registro //
	$('#btnNovoHorario').click(function(e){
		e.preventDefault();
		$("#gravaHorario")[0].reset();
		$("#FormHorario").css("display","block");
		$("#ListaHorarios").css("display","none");
		$("#acaohorario").val("0");
	});
	// Adicionar Novo Registro //

    // Salvando um Registro //
	$('#btnGravarHorario').click(function(e){
		e.preventDefault();

		var mensagem1 = "<strong>Horário Cadastrado com sucesso!</strong>";
		var mensagem2 = '<strong>Horário Atualizado com sucesso!</strong>';
		var mensagem3 = 'Cadastro/Alteração não efetuada! O Dia da Semana já possui um horário cadastrado!';
		var mensagem9 = 'Erro ao efetuar o Cadastro/Alteração!';

		$("input:text").css({"border-color" : "#999"});
		$(".msgValida").css({"display" : "none"});
	    
		if ($.trim($("#dia_semana").val()) == '9'){
			$("#valida_dia_semana").css({"display" : "inline", "color" : "red"});
			$("#dia_semana").css({"border-color" : "red"});
			$("#dia_semana").focus();
			return false;
		}

		// Valida os Horários de Início e Fim apenas se 'Fechado' for 'false' //
		if( $("#fechado").prop("checked") === false ){
			if ($.trim($("#hr_inicio").val()) == ''){
				$("#valida_hr_inicio").css({"display" : "inline", "color" : "red"});
				$("#hr_inicio").css({"border-color" : "red"});
				$("#hr_inicio").focus();
				return false;
			}
	
			if ($.trim($("#hr_fim").val()) == ''){
				$("#valida_hr_fim").css({"display" : "inline", "color" : "red"});
				$("#hr_fim").css({"border-color" : "red"});
				$("#hr_fim").focus();
				return false;
			}
		}

	    $('#gravaHorario').ajaxForm({
			resetForm: false, 			  
			beforeSend:function() { 
				$("#btnGravarHorario").attr('value', 'Salvando ...');
				$('#btnGravarHorario').attr('disabled', true);
				$('#btnFecharCadastro').attr('disabled', true);
				$('#FormHorario').find('input').prop('disabled', true);
			},
			success: function( retorno ){
				if (retorno == 1) { mostraDialogo(mensagem1, "success", 2500); }
				else if (retorno == 2){ mostraDialogo(mensagem2, "success", 2500); }
				else if (retorno == 3){ mostraDialogo(mensagem3, "danger", 2500); }
				else{ mostraDialogo(mensagem9, "danger", 2500); }

				$.ajax("cadastros/horarios/listar.php").done(function(data) {
					$('#ListarHorario').html(data);
				});
			},		 
			complete:function() {
				$("#btnGravarHorario").attr('value', 'Salvar');
				$('#btnGravarHorario').attr('disabled', false);
				$('#FormHorario').find('input, button').prop('disabled', false);
				$("#ListaHorarios").css("display","block");
				$("#FormHorario").css("display","none");
			},
			error: function (retorno) { mostraDialogo(mensagem9, "danger", 2500); }
		}).submit();
	});
	// FIM Salvando um Registro //  
});