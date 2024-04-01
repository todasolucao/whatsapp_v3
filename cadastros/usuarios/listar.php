<?php require_once("../../includes/padrao.inc.php"); ?>


<!-- Htmls Novos -->
<div class="topLine">
    <div class="titlesTable w20p">Nome do usuário</div>
    <div class="titlesTable w20p">Login</div>
    <div class="titlesTable w10p" align="center">Ativo</div>
    <div class="titlesTable" align="center">Perfil</div>
    <div class="titlesTable w20p">Departamentos</div>
    <div class="titlesTable w10p">Ações</div>
    <div style="clear: both;"></div>
</div>

<ul uk-accordion style="margin-top: 0;">

<?php	 
    // Monto os options dos Departamentos //
    $options = '<select name="sltDepartamentos" id="sltDepartamentos" class="uk-select" style="width:75%;height:25px;margin-top:-15px;clear: both;font-size:12px;padding:0">
                    <option value="0">Departamento</option>';

    $departamentos = mysqli_query(
        $conexao
        , "SELECT * FROM tbdepartamentos"
    );

    while ($optDepartamentos = mysqli_fetch_array($departamentos)){
        $options .= '<option value="'.$optDepartamentos["id"].'"> '.$optDepartamentos["departamento"].'</option>';
    }

	$options .= '</select>';
    // FIM Monto os options dos Departamentos //

    // Busncando os Usuários cadastrados //
    $l = 1;

    $usuarios = mysqli_query(
        $conexao
        , "SELECT * FROM tbusuario ORDER BY id"
    );
    
    while ($ListaUsuarios = mysqli_fetch_array($usuarios)){
        if( $ListaUsuarios["situacao"] == 'A' ){
            $ativo = '<span class="uk-margin-small-right" uk-icon="check"></span>'; 
        }
        else{ $ativo = 'Inativo'; }

        if($ListaUsuarios["perfil"] == '0'){ $perfil= 'ADM.'; }
        else if($ListaUsuarios["perfil"] == '2'){ $perfil = 'COOR.'; }
        else{ $perfil = 'OP.'; }

        echo '<li id="linha'.$l.'">
                <input type="hidden" name="IdUsuario" id="IdUsuario" value="'.$ListaUsuarios["id"].'" />
                <a class="uk-accordion-title titlesTable w20p pl1m" href="#" style="cursor:pointer"><label style="margin-top:-7px;cursor:pointer">'. $ListaUsuarios["nome"].'</label></a>
                <div class="titlesTable w20p"><label style="margin-top:-7px;">'.$ListaUsuarios["login"].'</label></div>
                <div class="titlesTable w10p" align="center"><label style="margin-top:-7px;">'.$ativo.'</label></div>
                <div class="titlesTable" align="center"><label style="margin-top:-7px;">'.$perfil.'</label></div>
                <div class="titlesTable w20p">
                    '.$options.'
                    <button class="add btnIncluirDepartamento" style="margin-top:-7px;" title="Adicionar"><span uk-icon="plus-circle"></span></button>
                </div>
                
                <div class="titlesTable  w10p">
                    <button class="add" title="Excluir" style="margin-top:-7px;"><span uk-icon="trash" class="ConfirmaExclusaoUsuario"></span></button>
                    <button class="add" title="Editar" style="margin-top:-7px;"><span uk-icon="pencil" class="botaoAlterarUsuario"></span></button>
                </div>
                <div style="clear: both;"></div>
                <div class="uk-accordion-content">
                    <ul class="sublist">';
			
				$departamentos = mysqli_query($conexao, "select d.id, d.departamento from tbusuariodepartamento ud
                    INNER JOIN tbdepartamentos d on d.id = ud.id_departamento
                    where ud.id_usuario = '".$ListaUsuarios["id"]."'");
		
				if (mysqli_num_rows($departamentos)==0){
				    echo '<li>
                        <div><font color="red"><b>Usuário não vinculado a nenhum departamento</b></font></div>
                        <div></div>
                    </li>';	
	            }

        while ($listaDepartamentos = mysqli_fetch_array($departamentos)){
            //Listo os Departamentos Vinculados ao Usuário
            echo '<li>
                    <input type="hidden" name="IdDepartamento" id="IdDepartamento" value="'.$listaDepartamentos["id"].'" />
                    <input type="hidden" name="IdUsuario" id="IdUsuario3" value="'.$ListaUsuarios["id"].'" />
                    <div style="width: 80%">&nbsp;&nbsp;<font color="darkblue"><b>'.$listaDepartamentos["departamento"].'</b></font></div>
                    <div><button class="btnVinculaUsuario">Remover</button></div>
                </li>';
        }
            
            echo '</ul>
                </div>
            </li>';
          $l = $l+1;
      }
    // FIM Busncando os Usuários cadastrados //		
?>

<p>* Clique em cima do nome do usuário para verificar quais departamentos ele está vinculado.</p>

</ul>

<script>
    // JavaScript Document
$( document ).ready(function() {		
	// Exclusão de Usuário //
	$('.ConfirmaExclusaoUsuario').on('click', function (){
	    var id = $(this).parent().parent().parent("li").find('#IdUsuario').val();
		abrirModal("#modalUsuarioExclusao");
		$("#IdUsuario2").val(id);
	});

	// Remoção do Cadastro //
	$('#btnConfirmaRemoveUsuario').on('click', function (){
		$("#btnConfirmaRemoveUsuario").attr('value', 'Removendo ...');
        $('#btnConfirmaRemoveUsuario').attr('disabled', true);

		var idUsuario = $("#IdUsuario2").val();

		$.post("cadastros/usuarios/excluir.php",{IdUsuario:idUsuario},function(resultado){             
			var mensagem  = "<strong>Usuário Removido com sucesso!</strong>";
			var mensagem2 = 'Falha ao Remover Usuário!';
		//	alert(resultado);			
			if (resultado == 4) {
				mostraDialogo("Você não pode Remover o Administrador Principal", "warning", 2500);	
                $("#btnConfirmaRemoveUsuario").attr('value', 'Remover');
                $('#btnConfirmaRemoveUsuario').attr('disabled', false);
			}else if (resultado == 3) {
				mostraDialogo("Você não pode Remover seu Próprio usuário", "warning", 2500);	
                $("#btnConfirmaRemoveUsuario").attr('value', 'Remover');
                $('#btnConfirmaRemoveUsuario').attr('disabled', false);
			}else if (resultado == 2) {
				mostraDialogo(mensagem, "success", 2500);	
                $("#btnConfirmaRemoveUsuario").attr('value', 'Remover');
                $('#btnConfirmaRemoveUsuario').attr('disabled', false);
				$.ajax("cadastros/usuarios/listar.php").done(function(data) {
					$('#ListarUsuario').html(data);
				});
			}
			else{ mostraDialogo(mensagem2, "danger", 2500); }

			// Fechando a Modal de Confirmação //
			$("#btnConfirmaRemoveUsuario").attr('value', 'Confirmar Exclusão!');
            $('#btnConfirmaRemoveUsuario').attr('disabled', false);			
			$('#modalUsuarioExclusao').attr('style', 'display: none');
		});
	});
	// FIM Remoção do Cadastro //
	
	// Alteração de Usuário //
	$('.botaoAlterarUsuario').on('click', function (){
		// Busco os dados do Produto Selecionado  
		var codigo = $(this).parent().parent().parent("li").find('input:hidden').val();

		// Alterando Displays //
		$("#FormUsuarios").css("display","block");
		$("#ListaUsuarios").css("display","none");

		// Alterando o Título do Cadastro //
		$("#titleCadastroUser").html("Alteração de Usuário");

		$.getJSON('cadastros/usuarios/carregardados.php?codigo='+codigo, function(registro){			
			// Carregando os Dados //
			$("#id_usuarios").val(registro.id);
			$("#nome_usuario").val(registro.nome);
			$("#login").val(registro.login);
			$("#senha").val(registro.senha);
			$("#perfil").val(registro.perfil);
			if (registro.situacao=='A'){
				$("#usuario_ativo").prop("checked", true);
			}else{
				$("#usuario_ativo").prop("checked",false);
			}
		});
			  
		// Mudo a Ação para Alterar    
		$("#acaoUsuario").val("2");
		$("#nome_usuario").focus();
	});
	// FIM Alteração de Usuário //

	// Fechar Cadastro do Usuário //
	$('#btnFecharCadastroUsuario').on('click', function (){
		$("#ListaUsuarios").css("display","block");
		$("#FormUsuarios").css("display","none");
	});
	$('#btnCancelaRemoveUsuario').on('click', function (){
		// Fechando a Modal de Confirmação //
		$('#modalUsuarioExclusao').attr('style', 'display: none');
		
		$("#ListaUsuarios").css("display","block");
		$("#FormUsuarios").css("display","none");
	});
	// FIM Fechar Cadastro do Usuário //
	
	// Remover Vínculo do Usuário //
	$('.btnVinculaUsuario').on('click', function (){
		if( confirm('Deseja remover o departamento selecionado a este usuário?') ){					
			var idUsuario = $(this).closest("li").find('#IdUsuario3').val()
				, idDepartamento = $(this).closest("li").find('#IdDepartamento').val();

			$.post("cadastros/usuarios/excluirVinculo.php"
				, {IdUsuario:idUsuario,idDepartamento:idDepartamento}
				, function(resultado){
				var mensagem  = "<strong>Vinculo com departamento Removido com sucesso!</strong>";
				var mensagem2 = 'Falha ao Remover Vinculo do Departamento!';
				
				if( resultado == 2 ){
					mostraDialogo(mensagem, "success", 2500);	

					$.ajax("cadastros/usuarios/listar.php").done(function(data) {
						$('#ListarUsuario').html(data);
					});
				}
				else{ mostraDialogo(mensagem, "danger", 2500); }
			});
		}
  	});
	// FIM Remover Vínculo do Usuário //
	
	// Incluir Vínculo do Usuário //
	$('.btnIncluirDepartamento').on('click', function (){
	 	var idUsuario      = $(this).closest("li").find('#IdUsuario').val()
	 		, idDepartamento = $(this).closest("li").find('#sltDepartamentos').val();

		// Validando a escolha do Departamento //
		if( idDepartamento === "0" ){
			mostraDialogo("Por favor, escolha corretamente um Departamento!", "danger", 2500);
		}
		else{
			$.post("cadastros/usuarios/salvarVinculo.php"
				, {IdUsuario:idUsuario,idDepartamento:idDepartamento}
				, function(resultado){
					var mensagem  = "<strong>Vinculo com departamento Cadastrado com sucesso!</strong>";
					var mensagem2 = 'Falha ao Remover Vinculo do Departamento!';
					var mensagem3 = 'Usuário já vinculado a este Departamento!';

				if( resultado == 1 ){
					mostraDialogo(mensagem, "success", 2500);

					$.ajax("cadastros/usuarios/listar.php").done(function(data) {
                        $('#ListarUsuario').html(data);
                    });
				}
				else if( resultado == 2 ){ mostraDialogo(mensagem3, "danger", 2500); }
				else{ mostraDialogo(mensagem, "danger", 2500); }
			});
		}
  	});
  	// Incluir Vínculo do Usuário //
});
</script>