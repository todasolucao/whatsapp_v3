// JavaScript Document
$( document ).ready(function() {
	$('.ConfirmaExclusaoDepartamento').on('click', function (){
		var id = $(this).parent().parent().parent("li").find('#IdDepartamento').val();
		abrirModal("#modalDepartamentoExclusao");
		$("#IdDepartamento2").val(id);
	});

	//Mudo a Aba quando der dois cliques em uma das linhas da tabela
	$('#btnConfirmaRemoveDepartamento').on('click', function (){
		$("#btnConfirmaRemoveDepartamento").attr('value', 'Removendo ...');
		$('#btnConfirmaRemoveDepartamento').attr('disabled', true);

		var idDepartamento = $("#IdDepartamento2").val();

		$.post("cadastros/departamentos/excluir.php",{IdDepartamento:idDepartamento},function(resultado){
			var mensagem  = "<strong>Departamento Removido com sucesso!</strong>";
			var mensagem2 = 'Falha ao Remover Departamento!';

			if (resultado = 2) {
				mostraDialogo(mensagem, "success", 2500);

				$.ajax("cadastros/departamentos/listar.php").done(function(data) {
					$('#ListarDepartamento').html(data);
				});
			}
			else{ mostraDialogo(mensagem, "danger", 2500); }

			// Fechando a Modal de Confirmação //
			$('#modalDepartamentoExclusao').attr('style', 'display: none');
		});
	});
	
	$('.btnAlterarDepartamento').on('click', function (){
		// Busco os dados do Produto Selecionado  
		var codigo = $(this).parent().parent().parent("li").find('input:hidden').val();

		// Alterando Displays //
		$("#FormDepartamento").css("display","block");
		$("#ListaDepartamentos").css("display","none");

		// Alterando o Título do Cadastro //
		$("#titleCadastroDepartamento").html("Alteração de Departamento");

		$.getJSON('cadastros/departamentos/carregardados.php?codigo='+codigo
			, function(registro){
			$("#id_departamento").val(registro.id);
			$("#menu").val(registro.id_menu);
			$("#departamento").val(registro.departamento);
		});

		// Mudo a Ação para Alterar    
		$("#acao").val("2");
		$("#departamento").focus();
	});  
	
	// Fechar Cadastro //
	$('#btnFecharCadastroDepartamento').on('click', function (){
		$("#ListaDepartamentos").css("display","block");
		$("#FormDepartamento").css("display","none");
	});
	$('#btnCancelaRemoveDepartamento').on('click', function (){
		// Fechando a Modal de Confirmação //
		$('#modalDepartamentoExclusao').attr('style', 'display: none');
		
		$("#ListaDepartamentos").css("display","block");
		$("#FormDepartamento").css("display","none");
	});
	// FIM Fechar Cadastro //
});