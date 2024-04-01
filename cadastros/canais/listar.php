<?php require_once("../../includes/padrao.inc.php"); ?>
<script type='text/javascript' src="cadastros/canais/acoesListar.js"></script>

<!-- Htmls Novos -->
<div class="topLine">
    <div class="titlesTable w10p">Id</div>
    <div class="titlesTable w60p">Nome</div>
    <div class="titlesTable w20p">Tipo</div>
    <div class="titlesTable w10p">Ações</div>
    <div style="clear: both;"></div>
</div>

<ul uk-accordion style="margin-top: 0;">

<?php
    // Busncando os Usuários cadastrados //
    $l = 1;

    $query = mysqli_query($conexao, "SELECT * FROM tbcanais");
    
    while ($registros = mysqli_fetch_object($query)){
        if( $registros->oficial == 0 ){ $registros->oficial = "*"; }
        else { $registros->oficial = ""; }

        echo '<li id="linha'.$l.'">
                <input type="hidden" name="IdCanal" id="IdCanal" value="'.$registros->id.'" />
                <div class="titlesTable w10p">'.$registros->id.'</div>
                <div class="titlesTable w60p">'. $registros->nome.' '. $registros->oficial .'</div>
                <div class="titlesTable w20p">'. getCanal($conexao, $registros->id).'</div>
                <div class="titlesTable w10p">
                    <button class="add" style="padding: 0 10px;" title="Excluir"><span uk-icon="trash" class="ConfirmaExclusaoCanal"></span></button>
                    <button class="add" style="padding: 0 10px;" title="Editar"><span uk-icon="pencil" class="botaoAlterarCanal"></span></button>
                    </div>
                <div style="clear: both;"></div>
            </li>';
          $l = $l+1;
      }
    // FIM Busncando os Usuários cadastrados //		
?>

</ul>