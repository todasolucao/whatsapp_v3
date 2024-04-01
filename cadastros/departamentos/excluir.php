<?php
  require_once("../../includes/padrao.inc.php");

  $id = $_POST['IdDepartamento'];

  $sql = "DELETE FROM tbdepartamentos WHERE id = '$id'";
	$excluir = mysqli_query($conexao,$sql);

  if( $excluir ){ echo "2"; }
  else{ echo "1"; }