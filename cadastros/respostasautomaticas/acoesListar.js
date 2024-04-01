// JavaScript Document
$( document ).ready(function() {	
	$('.btnExcluirRespostaAutomatica').on('click', function (){
        var id = $(this).parent().parent().parent("li").find('#IdRespostaAutomatica').val();
		abrirModal("#modalRespostaAutomaticaExclusao");
		$("#IdRespostaAutomatica2").val(id);
    });	  

	// Remoção do Cadastro //
	$('#btnConfirmaExclusaoRespostaAutomatica').on('click', function (){
        $("#btnConfirmaExclusaoRespostaAutomatica").attr('value', 'Removendo ...');
        $('#btnConfirmaExclusaoRespostaAutomatica').attr('disabled', true);

	    var id = $("#IdRespostaAutomatica2").val();
		
        $.post("cadastros/respostasautomaticas/excluir.php",{idRespostaAutomatica:id},function(resultado){
            var mensagem  = "<strong>Resposta Automática Removido com sucesso!</strong>";
            var mensagem2 = 'Falha ao Remover Resposta Automática!';
	            
            if (resultado = 2) {
                mostraDialogo(mensagem, "success", 2500);

                $.ajax("cadastros/respostasautomaticas/listar.php").done(function(data) {
                    $('#ListarRespostaAutomatica').html(data);
                });
            }
            else{ mostraDialogo(mensagem2, "danger", 2500); }

            // Fechando a Modal de Confirmação //
            $('#modalRespostaAutomaticaExclusao').attr('style', 'display: none');
        });			  
    });
    // FIM Remoção do Cadastro //
	
    // Alteração de Cadastro //
	$('.btnAlterarRespostaAutomatica').on('click', function (){
        // Busco os dados do Produto Selecionado  
        var codigo = $(this).parent().parent().parent("li").find('input:hidden').val();

        // Alterando Displays //
        $("#FormRespostaAutomatica").css("display","block");
        $("#ListaRespostasAutomaticas").css("display","none");

        // Alterando o Título do Cadastro //
        $("#titleCadastroRespostaAutomatica").html("Alteração de Resposta Automática");
        
	    $.getJSON('cadastros/respostasautomaticas/carregardados.php?codigo='+codigo, function(registro){
            $("#menu_resposta").val(registro.id_menu);
            $("#menu_acao").val(registro.acao);            
            $("#respostaautomatica").val(registro.descricao);
            
            
            if (registro.arquivo!=null && registro.arquivo!=""){
                $("#arquivo_carregado").html("Existe um arquivo carregado");
                $("#arquivo_carregado").css({ 'color': 'red', 'font-size': '150%' });
            } else {             
                $("#arquivo_carregado").html("Não Existe um arquivo carregado");
                $("#arquivo_carregado").css({ 'color': 'black', 'font-size': '150%' });
            }
            $("#foto").val('');
            
        });
              
        // Mudo a Ação para Alterar    
		$("#acaoRespostaAutomatica").val("2");
		$("#menu_resposta").focus();
	});
    // FIM Alteração de Cadastro //

	// Fechar Cadastro //
	$('#btnFecharCadastroRespostaAutomatica').on('click', function (){
		$("#ListaRespostasAutomaticas").css("display","block");
		$("#FormRespostaAutomatica").css("display","none");
	});
	$('#btnCancelaExclusaoRespostaAutomatica').on('click', function (){
		// Fechando a Modal de Confirmação //
		$('#modalRespostaAutomaticaExclusao').attr('style', 'display: none');
		
		$("#ListaRespostasAutomaticas").css("display","block");
		$("#FormRespostaAutomatica").css("display","none");
	});
	// FIM Fechar Cadastro //
});