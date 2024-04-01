<script type='text/javascript' src="cadastros/canais/acoes.js"></script>
<script>
    $( document ).ready(function(){
        $.ajax("cadastros/canais/listar.php").done(function(data) {
            $('#ListarCanal').html(data);
        });

        // Fechar a Janela //
		$('.fechar').on("click", function(){ fecharModal(); });
	});
</script>

<div class="box-modal" id="FormCanais" style="display: none;">    
    <h2 class="title" id="titleCadastroUser">Adicionar Novo Canal</h2>
    <div class="">
        <form method="post" id="gravaCanal" name="gravaCanal" action="cadastros/canais/salvar.php">
            <input type="hidden" id="id_canais" name="id_canais" value="0" />
            <input type="hidden" value="0" name="acaoCanal" id="acaoCanal" />

            <div class="uk-width-1-1@m">
                <div class="uk-form-label"> Nome </div>
                <input type="text" id="nome_canal" name="nome_canal" class="uk-input" placeholder="Nome de Exibição no CHAT" />
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
                <div class="uk-form-label"> Nível de Canal </div>
                <select name="perfil" id="perfil" class="uk-select">
                    <option value="0">Administrador</option>
                    <option value="2">Coordenador</option>
                    <option value="1">Operador</option>
                </select>
                <div id="valida_senha" style="display: none" class="msgValida">
                    Por favor, informe a senha que será utilizado no acesso.
                </div>
            </div>
        </form>
    </div>

    <p class="uk-text-right" style="margin-top:1rem">
        <button id="btnFecharCadastroCanal" class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
        <input id="btnGravarCanal" class="uk-button uk-button-primary " type="submit" value="Salvar">
    </p>
</div>

<div class="box-modal" id="ListaCanais">
    <h2 class="title">Canais Cadastrados <a id="btnNovoCanal" href="#" class="uk-align-right" uk-icon="plus-circle" title="Novo Canal"></a></h2>

    <div class="panel-body" id="ListarCanal">				
        <!-- Canais Cadastrados -->
    </div>

    <p class="uk-text-right" style="margin-top:1rem">
        <button class="uk-button uk-button-default uk-modal-close fechar" type="button">Cancelar</button>
    </p>
</div>