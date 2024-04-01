// JavaScript Document
$( document ).ready(function() {
	$('.ConfirmaExclusaoHorario').on('click', function (){
		var id = $(this).parent().parent().parent("li").find('#IdHorario').val();
		abrirModal("#modalHorarioAtendimentoExclusao");
		$("#IdHorario2").val(id);
	});

	// Mudo a Aba quando der dois cliques em uma das linhas da tabela //
	$('#btnConfirmaRemoveHorario').on('click', function (){
		$("#btnConfirmaRemoveHorario").attr('value', 'Removendo ...');
        $('#btnConfirmaRemoveHorario').attr('disabled', true);

	    var idHorario = $("#IdHorario2").val();

		$.post("cadastros/horarios/excluir.php",{IdHorario:idHorario},function(resultado){
			var mensagem  = "<strong>Horario Removido com sucesso!</strong>";
			var mensagem2 = 'Falha ao Remover Horario!';

			if (resultado = 2) {
				mostraDialogo(mensagem, "success", 2500);

				$.ajax("cadastros/horarios/listar.php").done(function(data) {
					$('#ListarHorario').html(data);
				});
			}
			else{ mostraDialogo(mensagem, "danger", 2500); }

			// Fechando a Modal de Confirmação //
			$('#modalHorarioAtendimentoExclusao').attr('style', 'display: none');
		});
	});
	
	$('.botaoAlterarHorario').on('click', function (){
		// Busco os dados do Produto Selecionado  
		var codigo = $(this).parent().parent().parent("li").find('input:hidden').val();

		// Alterando Displays //
		$("#FormHorario").css("display","block");
		$("#ListaHorarios").css("display","none");

		// Alterando o Título do Cadastro //
		$("#titleCadastroHorario").html("Alteração de Horario");

		$.getJSON('cadastros/horarios/carregardados.php?codigo='+codigo, function(registro){
			$("#idHorario").val(registro.id);
			$("#dia_semana").val(registro.dia_semana);
			$("#hr_inicio").val(registro.hr_inicio);
			$("#hr_fim").val(registro.hr_fim);
			
			if( registro.fechado === "1" ){ $("#fechado").prop( "checked", true ); }
			else{ $("#fechado").prop( "checked", false ); }
		});

		// Mudo a Ação para Alterar    
		$("#acaohorario").val("2");
		$("#dia_semana").focus();
	});  
	
	// Fechar Cadastro //
	$('#btnFecharCadastroHorario').on('click', function (){
		$("#ListaHorarios").css("display","block");
		$("#FormHorario").css("display","none");
	});
	$('#btnCancelaRemoveHorario').on('click', function (){
		// Fechando a Modal de Confirmação //
		$('#modalHorarioAtendimentoExclusao').attr('style', 'display: none');
		
		$("#ListaHorarios").css("display","block");
		$("#FormHorario").css("display","none");
	});
	// FIM Fechar Cadastro //
});