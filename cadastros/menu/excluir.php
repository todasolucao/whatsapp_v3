<?php
  require_once("../../includes/padrao.inc.php");

  $id = $_POST['IdMenu'];

  $sql = "DELETE FROM tbmenu WHERE id = '$id'";
	$excluir = mysqli_query($conexao,$sql);

  if ($excluir){ echo "2"; }
  else{ echo "1"; }