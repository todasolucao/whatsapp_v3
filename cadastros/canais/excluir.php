<?php
  require_once("../../includes/padrao.inc.php");

  $id = $_POST['IdUsuario'];

  $sql = "delete from tbusuario where id = '$id'";
  $excluir = mysqli_query($conexao,$sql);
   
  if( $excluir ){
    // Apago os Vinculos desse usuário com os departamentos //
    $excluir = mysqli_query($conexao,"delete from tbusuariodepartamento where id_usuario = '$id'");
    echo "2"; 
  }
  else{ echo "1"; }