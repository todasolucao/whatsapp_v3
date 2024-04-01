<?php 
  require_once("../../includes/padrao.inc.php"); 

  $arquivo		= "images/sem_foto.png";
?>



<script type='text/javascript' src="cadastros/respostasautomaticas/acoes.js"></script>
<script>
  $(document).ready(function() {
    $.ajax("cadastros/respostasautomaticas/listar.php").done(function(data) {
      $('#ListarRespostaAutomatica').html(data);
    });

    // Fechar a Janela //
    $('.fechar').on("click", function() {
      fecharModal();
    });
  });
</script>

<div class="box-modal" id="FormRespostaAutomatica" style="display: none;">
  <form method="post" enctype="multipart/form-data" id="gravaRespostaAutomatica" name="gravaRespostaAutomatica" action="cadastros/respostasautomaticas/salvar.php">
    <h2 class="title" id="titleCadastroRespostaAutomatica">Adicionar Nova Resposta Automática</h2>
    <div class="">
      <input type="hidden" value="0" name="acaoRespostaAutomatica" id="acaoRespostaAutomatica">

      <div class="uk-width-1-1@m">
        <div class="uk-width-1-1@m" style="width: 74%; float: left;">
          <div class="uk-form-label"> Escolha um item de Menu! </div>
          <select name="menu_resposta" id="menu_resposta" class="uk-select">
            <?php
            $menus = mysqli_query($conexao, "SELECT id, descricao FROM tbmenu");
            while ($listarMenus = mysqli_fetch_object($menus)) {
              echo '<option value="' . $listarMenus->id . '">' . $listarMenus->descricao . '</option>';
            }
            ?>
          </select>
          <div id="valida_menu_resposta" style="display: none" class="msgValida">
            Por favor, Selecione um item de Menu.
          </div>
        </div>

        <div class="uk-width-1-1@m" style="width: 25%; float: right;">
          <div class="uk-form-label"> Ação </div>
          <select name="menu_acao" id="menu_acao" class="uk-select">
            <option value="0">Nenhuma</option>
            <option value="1">Devolve Menu</option>
            <option value="2">Devolve Menu Sem titulo</option>
            <option value="9">Encerra Atendimento</option>
          </select>
          <div id="valida_menu_acao" style="display: none" class="msgValida">
            Por favor, Selecione uma Ação para ser executada após a Resposta Automática.
          </div>
        </div>
      </div>
      <br>
      <div class="uk-width-1-1@m">
        <div class="uk-form-label"> Resposta Automática </div>
        <input type="text" id="respostaautomatica" name="respostaautomatica" class="uk-input" placeholder="Resposta Automática" maxlength="999" />
        <div id="valida_respostaautomatica" style="display: none" class="msgValida">
          Por favor, informe a Resposta Automática.
        </div>
      </div>

      <div class="uk-width-1-1@m" style=" float: left;">
					<div class="uk-form-label"> <b>Arquivo de envio Automatico</b> </div>
					
          <div class="col-md-2">
            <h2 class="title" id="arquivo_carregado"></h2>						
					</div>

					<div class="col-md-10" align="left" style="margin-top: 15px;">
						<div class="uk-form-file">
							<input type="file" name="foto" id="foto" />
			
						</div>		
					</div>

			</div>
   

  
    </div>
  </form>

  <p class="uk-text-right" style="margin-top:1rem">
    <button id="btnFecharCadastroRespostaAutomatica" class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
    <input id="btnGravarRespostaAutomatica" class="uk-button uk-button-primary " type="submit" value="Salvar">
  </p>
</div>

<div class="box-modal" id="ListaRespostasAutomaticas">
  <h2 class="title">Respostas Automáticas Cadastrados <a id="btnNovoRespostaAutomatica" href="#" class="uk-align-right" uk-icon="plus-circle" title="Nova Resposta Automática"></a></h2>

  <div class="panel-body" id="ListarRespostaAutomatica">
    <!-- Menus Cadastrados -->
  </div>

  <p class="uk-text-right" style="margin-top:1rem">
    <button id="btnCancelarRespostasAutomaticas" class="uk-button uk-button-default uk-modal-close fechar" type="button">Cancelar</button>
  </p>
</div>