<?php
  require_once("../../includes/padrao.inc.php");
  $acao         = $_POST['acaotelefone'];
  //$id           = $_POST['IdTelefone'];
  $telefone     = $_POST['txttelefone'];

if( $acao == 0 ){
	$existe = mysqli_query($conexao,"SELECT * FROM tbtelefonesavisos WHERE numero = '$telefone'");
	if (mysqli_num_rows($existe)>0){
		echo "3";
		exit();
	}
	
	$sql = "INSERT INTO tbtelefonesavisos(numero) VALUES ('$telefone')";
	$inserir = mysqli_query($conexao,$sql) 
		or die($sql."<br/>".mysqli_error($conexao));
   
	if ($inserir){ echo "1"; }
}
else{
	$sql = "UPDATE tbtelefonesavisos SET  numero= '$telefone' WHERE numero = '$telefone'";
	$atualizar = mysqli_query($conexao,$sql);

	if ($atualizar){ echo "2"; }
}