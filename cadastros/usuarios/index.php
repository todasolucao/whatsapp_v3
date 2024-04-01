
<script>
    $( document ).ready(function(){
        $.ajax("cadastros/usuarios/listar.php").done(function(data) {
            $('#ListarUsuario').html(data);
        });

        // Fechar a Janela //
		$('.fechar').on("click", function(){ fecharModal(); });


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
	   
		var mensagemErro = 'Falha ao Efetuar Cadastro!';
	  
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
				if (retorno == 1) { mostraDialogo("<strong>Usuário Cadastrado com sucesso!</strong>", "success", 2500); }
				else if (retorno == 2){ mostraDialogo('Usuário Atualizado com Sucesso!', "success", 2500); }
				else if (retorno == 3){ mostraDialogo('Usuário Já Cadastrado com este Login!', "warning", 2500); }
				else if (retorno == 4){ mostraDialogo('Você não pode desativar seu próprio Usuário!', "warning", 2500); return false }
				else if (retorno == 5){ mostraDialogo('Você não pode desativar o Administrador principal!', "danger", 2500); return false }
				else{ mostraDialogo(mensagemErro+retorno, "danger", 2500); }

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
				mostraDialogo(mensagemErro, "danger", 2500);
            }
		}).submit();
		// FIM Gravando os dados do Usuário //
	});
	// FIM Cadastro/Alteração de Usuário //
});



</script>

<div class="box-modal" id="FormUsuarios" style="display: none;">    
    <h2 class="title" id="titleCadastroUser">Adicionar Novo Usuário</h2>
    <div class="">
        <form method="post" id="gravaUsuario" name="gravaUsuario" action="cadastros/usuarios/salvar.php">
            <input type="hidden" id="id_usuarios" name="id_usuarios" value="0" />
            <input type="hidden" value="0" name="acaoUsuario" id="acaoUsuario" />

            <div class="uk-width-1-1@m">
                <div class="uk-form-label"> Nome </div>
                <input type="text" id="nome_usuario" name="nome_usuario" class="uk-input" placeholder="Nome de Exibição no CHAT" />
                <div id="valida_nome" style="display: none" class="msgValida">
                    Por favor, informe o nome que será exibido nas conversas.
                </div>
            </div>

            <div class="uk-width-1-1@m">
                <div class="uk-form-label"> Login </div>
                <input type="text" id="login" name="login" class="uk-input" placeholder="Login" />
                <div id="valida_login" style="display: none" class="msgValida">
                    Por favor, informe o Login que será utilizado no acesso.
                </div>
            </div>

            <div class="uk-width-1-1@m">
                <div class="uk-form-label"> Senha </div>
                <input type="password" id="senha" name="senha" class="uk-input" />
                <div id="valida_senha" style="display: none" class="msgValida">
                    Por favor, informe a senha que será utilizado no acesso.
                </div>
            </div>

            <div class="uk-width-1-1@m">
                <div class="uk-form-label"> Nível de Usuário </div>
                <select name="perfil" id="perfil" class="uk-select">
                    <option value="0">Administrador</option>
                    <option value="2">Coordenador</option>
                    <option value="1">Operador</option>
                </select>
                <div id="valida_senha" style="display: none" class="msgValida">
                    Por favor, informe a senha que será utilizado no acesso.
                </div>
            </div>
              
            <div class="uk-width-1-1@m" style="margin-top:1rem">
						<input class="uk-checkbox" type="checkbox" id="usuario_ativo" name="usuario_ativo" checked>  Ativo
			</div>
        </form>
    </div>

    <p class="uk-text-right" style="margin-top:1rem">
        <button id="btnFecharCadastroUsuario" class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
        <input id="btnGravarUsuario" class="uk-button uk-button-primary " type="submit" value="Salvar">
    </p>
</div>

<div class="box-modal" id="ListaUsuarios">
    <h2 class="title">Usuários Cadastrados <a id="btnNovoUsuario" href="#" class="uk-align-right" uk-icon="plus-circle" title="Novo usuário"></a></h2>

    <div class="panel-body" id="ListarUsuario">				
        <!-- Usuários Cadastrados -->
    </div>

    <p class="uk-text-right" style="margin-top:1rem">
        <button class="uk-button uk-button-default uk-modal-close fechar" type="button">Cancelar</button>
    </p>
</div>

<script type='text/javascript' src="cadastros/usuarios/acoes.js"></script>