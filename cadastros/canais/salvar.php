<?php
require_once("../../includes/padrao.inc.php");

$acao           = $_POST['acaoUsuario'];
$id             = $_POST['id_usuarios'];
$nome           = $_POST['nome_usuario'];
$login          = $_POST['login'];
$senha          = $_POST["senha"];
$perfil         = $_POST["perfil"];

if( $acao == 0 ){
	$existe = mysqli_query($conexao, "SELECT * FROM tbusuario WHERE login = '".$login."'");

	if( mysqli_num_rows($existe) > 0 ){
		echo "3";
		exit();
	}

	//A: ATIVO; I: INATIVO
	$sql = "INSERT INTO tbusuario (nome, login, senha, situacao, nome_chat, perfil) VALUES ('".$nome."', '".$login."','".$senha."', 'A', '".$nome."', '".$perfil."')";
	$inserir = mysqli_query($conexao, $sql)
		or die($sql . "<br />" . mysqli_error($conexao));

	if( $inserir ){
		echo "1";
	}
}
else{
	$sql = "UPDATE tbusuario SET nome = '".$nome."', senha = '".$senha."', login = '".$login."', nome_chat = '".$nome."', perfil = '".$perfil."' where id = '".$id."'";
	$atualizar = mysqli_query($conexao, $sql)
		or die($sql . "<br />" . mysqli_error($conexao));
   
	if( $atualizar ){
		echo "2";
   	}
}