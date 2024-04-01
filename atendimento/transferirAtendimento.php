<?php
	  require_once("../includes/padrao.inc.php");

	  $s_celular_atendimento = $_POST["numero"];
	  $s_id_atendimento      = $_POST["id_atendimento"];	
	  $idCanal               = isset($_REQUEST["id_canal"]) ? $_REQUEST["id_canal"] : "";

	  $id_departamento       = $_SESSION["usuariosaw"]["idDepartamento"];
	  $id_usuario            = $_SESSION["usuariosaw"]["id"];	   
	  $nomeDepartamento      = $_SESSION["usuariosaw"]["nomeDepartamento"]; 
      $nomeUsuario           = $_SESSION["usuariosaw"]["nome"];
	  $s_nome                = $_POST["nome"];
	  @$departamento          = $_POST["departamento"];
	  @$usuario               = $_POST["usuario"];
	  
	if ($_POST["paramim"]=='S'){
	      mysqli_query($conexao, "call prc_transfere_atendimento ('$s_id_atendimento', '$s_celular_atendimento', '$id_usuario', '0', '0', 'Atender')");
	      echo $s_id_atendimento;
	}else{
	      mysqli_query($conexao, "call prc_transfere_atendimento ('$s_id_atendimento', '$s_celular_atendimento', '$id_usuario', '$departamento', '$usuario', 'Transferir')");
	      echo 1;
	}