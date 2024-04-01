<?php
  require_once("../../includes/padrao.inc.php");

  $id = $_POST['IdHorario'];

  $sql = "DELETE FROM tbhorarios WHERE id = '$id'";
	$excluir = mysqli_query($conexao,$sql);

  if ($excluir){ echo "2"; }
  else{ echo "1"; }