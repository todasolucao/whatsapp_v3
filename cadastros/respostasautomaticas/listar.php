<?php require_once("../../includes/padrao.inc.php"); ?>
<script type='text/javascript' src="cadastros/respostasautomaticas/acoesListar.js"></script>

<!-- Htmls Novos -->
<div class="topLine">
  <div class="titlesTable w24p">Menu</div>
  <div class="titlesTable w10p">Arquivo</div>
  <div class="titlesTable w60p">Respostas Automáticas</div>
  
  <div class="titlesTable">Ações</div>
  <div style="clear: both;"></div>
</div>

<ul uk-accordion style="margin-top: 0;">
  <?php
    $l = 1;

    $respostasautomaticas = mysqli_query(
      $conexao
      , "SELECT tr.id_menu, tm.descricao AS menu, tr.descricao AS resposta, tr.arquivo 
          FROM tbrespostasautomaticas tr 
            INNER JOIN tbmenu tm ON(tm.id = tr.id_menu)
              ORDER BY id"
    );

    while ($ListaRespostasAutomaticas = mysqli_fetch_array($respostasautomaticas)){	
      $ListaRespostasAutomaticas["menu"] = (strlen($ListaRespostasAutomaticas["menu"]) > 30) ? substr($ListaRespostasAutomaticas["menu"],0,30)." ..." : $ListaRespostasAutomaticas["menu"];
      $ListaRespostasAutomaticas["resposta"] = (strlen($ListaRespostasAutomaticas["resposta"]) > 75) ? substr($ListaRespostasAutomaticas["resposta"],0,75)." ..." : $ListaRespostasAutomaticas["resposta"];

      $UsaArquivo="NAO";
      if ($ListaRespostasAutomaticas["arquivo"]!=""){
        $UsaArquivo="SIM";
      }
      
      echo '<li id="linha'.$l.'">
              <input type="hidden" name="IdRespostaAutomatica" id="IdRespostaAutomatica" value="'.$ListaRespostasAutomaticas["id_menu"].'" />
              <div class="titlesTable w24p">'.$ListaRespostasAutomaticas["menu"].'</div>
              <div class="titlesTable w10p">'.$UsaArquivo.'</div>
              <div class="titlesTable w60p">'.$ListaRespostasAutomaticas["resposta"].'</div>
              
              <div class="titlesTable">
                  <button class="add" style="padding: 0 10px;" title="Excluir"><span uk-icon="trash" class="btnExcluirRespostaAutomatica"></span></button>
                  <button class="add" style="padding: 0 10px;" title="Editar"><span uk-icon="pencil" class="btnAlterarRespostaAutomatica"></span></button>
              </div>
              <div style="clear: both;"></div>
          </li>';
        
      $l++;
    }
  ?>
</ul>