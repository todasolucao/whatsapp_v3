<?php require_once("../../includes/padrao.inc.php"); ?>
<script type='text/javascript' src="cadastros/horarios/acoesListar.js"></script>

<!-- Htmls Novos -->
<div class="topLine">
    <div class="titlesTable w25p">Dia da Semana</div>
    <div class="titlesTable">Hora de Início</div>
    <div class="titlesTable">Hora de Fim</div>
    <div class="titlesTable w25p">Aberto</div>
    <div class="titlesTable">Ações</div>
    <div style="clear: both;"></div>
</div>

<ul uk-accordion style="margin-top: 0;">

  <?php
    $l = 1;

    $arrFechado = array("0" => "Sim", "1" => "Não");
    $arrDiaDaSemana = array("6" => "Domingo", "0" => "Segunda", "1" => "Terça", "2" => "Quarta", "3" => "Quinta", "4" => "Sexta", "5" => "Sábado");

    $registros = mysqli_query(
      $conexao
      , "SELECT id, dia_semana, DATE_FORMAT(hr_inicio,'%H:%i') AS hr_inicio, DATE_FORMAT(hr_fim, '%H:%i') AS hr_fim, fechado FROM tbhorarios ORDER BY dia_semana"
    );

    while ($arrRegistros = mysqli_fetch_array($registros)){
      echo '<li id="linha'.$l.'">
              <input type="hidden" name="IdHorario" id="IdHorario" value="'.$arrRegistros["id"].'" />
              <div class="titlesTable w25p">'.$arrDiaDaSemana[$arrRegistros["dia_semana"]].'</div>
              <div class="titlesTable">'.$arrRegistros["hr_inicio"].'</div>
              <div class="titlesTable">'.$arrRegistros["hr_fim"].'</div>
              <div class="titlesTable w25p">'.$arrFechado[$arrRegistros["fechado"]].'</div>
              <div class="titlesTable">
                <button class="add" style="padding: 0 10px;" title="Excluir"><span uk-icon="trash" class="ConfirmaExclusaoHorario"></span></button>
                <button class="add" style="padding: 0 10px;" title="Editar"><span uk-icon="pencil" class="botaoAlterarHorario"></span></button>
              </div>
              <div style="clear: both;"></div>
          </li>';
        
      $l++;
    }
  ?>

</ul>