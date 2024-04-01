<?php
  session_start();
  require_once("../../includes/padrao.inc.php");

  $id = $_POST['IdUsuario'];

  if ($_SESSION["usuariosaw"]["id"] == $id){
    echo '3'; //Retorno 3 e aviso que não pode excluir a si próprio
    exit();
  }
  

  if ($_SESSION["usuariosaw"]["perfil"] == 0){
    //Busco o nome do usuario para saber se é o admin
    $usuario = mysqli_query($conexao,"select login from tbusuario where id = '$id'") or die(mysqli_error($conexao));
     $usuarioSelecionado = mysqli_fetch_assoc($usuario);
    if ($usuarioSelecionado["login"]=='admin'){
      echo '4'; //Retorno 4 e aviso que não pode excluir o Administrador Principal
       exit();
    }
    
  }

  $sql = "delete from tbusuario where id = '$id'";
  $excluir = mysqli_query($conexao,$sql);
   
  if( $excluir ){
    // Apago os Vinculos desse usuário com os departamentos //
    $excluir = mysqli_query($conexao,"delete from tbusuariodepartamento where id_usuario = '$id'");
    echo "2"; 
  }
  else{ echo "1"; }