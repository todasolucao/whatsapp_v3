<?php require_once("../../includes/padrao.inc.php"); ?>
<script type='text/javascript' src="cadastros/departamentos/acoesListar.js"></script>

<!-- Htmls Novos -->
<div class="topLine">
    <div class="titlesTable w45p">Menu</div>
    <div class="titlesTable w45p">Departamento</div>
    <div class="titlesTable">Ações</div>
    <div style="clear: both;"></div>
</div>

<ul uk-accordion style="margin-top: 0;">

  <?php
    $l = 1;

    $departamentos = mysqli_query(
      $conexao
      , "SELECT td.id, tm.descricao as menu, td.departamento FROM tbdepartamentos td left join tbmenu tm on tm.id = td.id_menu order by id"
    );

    while ($ListaDepartamentos = mysqli_fetch_array($departamentos)){	
      echo '<li id="linha'.$l.'">
              <input type="hidden" name="IdDepartamento" id="IdDepartamento" value="'.$ListaDepartamentos["id"].'" />
              <div class="titlesTable w45p">'. $ListaDepartamentos["menu"].'</div>
              <div class="titlesTable w45p">'. $ListaDepartamentos["departamento"].'</div>
              <div class="titlesTable">
                  <button class="add" style="padding: 0 10px;" title="Excluir"><span uk-icon="trash" class="ConfirmaExclusaoDepartamento"></span></button>
                  <button class="add" style="padding: 0 10px;" title="Editar"><span uk-icon="pencil" class="btnAlterarDepartamento"></span></button>
              </div>
              <div style="clear: both;"></div>
          </li>';
        
      $l++;
    }
  ?>

</ul>