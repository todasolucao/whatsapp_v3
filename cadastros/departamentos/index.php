<?php require_once("../../includes/padrao.inc.php"); ?>
<script type='text/javascript' src="cadastros/departamentos/acoes.js"></script>
<script>
    $( document ).ready(function() {	
        $.ajax("cadastros/departamentos/listar.php").done(function(data) {
          $('#ListarDepartamento').html(data);
        });

        // Fechar a Janela //
        $('.fechar').on("click", function(){ fecharModal(); });
    });
</script>

<div class="box-modal" id="FormDepartamento" style="display: none;">
    <form method="post" id="gravaDepartamento" name="gravaDepartamento" action="cadastros/departamentos/salvar.php">
      <input type="hidden" value="0" name="acao" id="acao" />
      <input type="hidden" id="id_departamento" name="id_departamento" value="0" />

      <h2 class="title" id="titleCadastroDepartamento">Adicionar Novo Departamento</h2>
      <div class="">
        <div class="uk-width-1-1@m">
          <div class="uk-form-label"> Escolha um item de Menu! </div>
          <select name='menu' id="menu" class='uk-select'>
            <option value=''></option>
            <?php
              $menus = mysqli_query($conexao, "SELECT * FROM tbmenu");

              while ($ListarDepartamentos = mysqli_fetch_array($menus)){
                echo '<option value="'.$ListarDepartamentos["id"].'">'.$ListarDepartamentos["descricao"].'</option>';
              }
            ?>      
          </select>
          <div id="valida_menu" style="display: none" class="msgValida">
            Por favor, Selecione um item de Menu.
          </div>
        </div>

        <div class="uk-width-1-1@m">
          <div class="uk-form-label"> Descrição do Departamento </div>
          <input type="text" id="departamento" name="departamento" class="uk-input" placeholder="Descrição do Departamento" />
          <div id="valida_nome" style="display: none" class="msgValida">
            Por favor, informe a Descrição do departamento.
          </div>
        </div>
      </div>
    </form>

    <p class="uk-text-right" style="margin-top:1rem">
        <button id="btnFecharCadastroDepartamento" class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
        <input id="btnGravarDepartamento" class="uk-button uk-button-primary " type="submit" value="Salvar">
    </p>
</div>

<div class="box-modal" id="ListaDepartamentos">
    <h2 class="title">Departamentos Cadastrados <a id="btnNovoDepartamento" href="#" class="uk-align-right" uk-icon="plus-circle" title="Novo Departamento"></a></h2>

    <div class="panel-body" id="ListarDepartamento">				
        <!-- Departamentos Cadastrados -->
    </div>

    <p class="uk-text-right" style="margin-top:1rem">
        <button class="uk-button uk-button-default uk-modal-close fechar" type="button">Cancelar</button>
    </p>
</div>