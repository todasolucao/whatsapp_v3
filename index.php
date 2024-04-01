<?php require("includes/conexao.php"); ?>
<html class="" dir="ltr" loc="pt-BR" lang="pt-BR">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Atendimento Online</title>
	<meta name="viewport" content="width=device-width">
	<link rel="icon" type="image/png" href="<?php echo $url_base; ?>img/favicon.png">
	<link rel="stylesheet" type="text/css" href="<?php echo $url_base; ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $url_base; ?>css/style.css">
	<link rel="stylesheet" href="<?php echo $url_base; ?>css/custom.css">
	<script src="<?php echo $url_base; ?>js/jquery-3.6.0.min.js"></script>
	<script>
		$(function () {
			$('.senha').click(function () {
				$('.viewCampo').slideToggle();
				$(this).toggleClass('active');
				return false;
			});
			$('#usuario').focus();
		});
	</script>
</head>
<body class="login">
	<div class="colluns">
		<div class="col">
			<div class="content-login">
				<form id="FormLogin" method="post">
				<img src="<?php echo $url_base; ?>img/logo_erpcerto.jpg" width="100%">
					<label>Usuário</label>
					<input type="text" name="usuario" id="usuario" placeholder="Digite seu usuário" class="form-control">
					<label>Senha</label>
					<input type="password" name="senha" id="senha" placeholder="Digite sua senha" class="form-control login-form">
					<input type="button" id="btnLogin" value="Entrar" name="" class="btn btn-azul">
				</form>

				<?php

				  //Verifico se possui parametros Cadastrado
				  $parametros = mysqli_query($conexao, "select * from tbparametros limit 1" ) or die (mysqli_error($conexao));
				  if (mysqli_num_rows( $parametros)<1){ //Se não possuir algum usuário
					$insereParametro = mysqli_query($conexao, "INSERT INTO tbparametros (id, msg_inicio_atendimento, msg_aguardando_atendimento, msg_fim_atendimento, msg_sem_expediente, msg_desc_inatividade, imagem_perfil, title, minutos_offline, color, nome_atendente, chat_operadores, atend_triagem, historico_conversas, iniciar_conversa, enviar_resprapida_aut, enviar_audio_aut, qrcode, op_naoenv_ultmsg, exibe_foto_perfil, alerta_sonoro, mostra_todos_chats, transferencia_offline) VALUES
					(1, 'Olá,seja bem-vindo(a) ao *Auto atendimento* 😄 _Selecione uma das opções a baixo para continuar o atendimento_ 😉', 
					'Seu atendimento foi transferido para *<<setor>>*.', 'O seu atendimento foi finalizado, agradecemos pelo seu contato, tenha um ótimo dia 😉*', 
					'Nosso horario de funcionamento é de segunda a sexta das 07:30 às 18:00 e aos sábados das 08:00 às 12:00, responderemos seu chamado assim que possivel!', '', 
					'', 'Sistema de Atendimento', '5', '#ff9214', 0, 1, 1, 1, 0, 0, 0, 1, 0, 0, 1, 0, 1);")or die (mysqli_error($conexao)); 
					 echo "<font color='red'>Parametros padrões configurados</font><br>";
				  }

				   //Verifico se possui Horarios de Funcionamento Cadastrados
				   $parametros = mysqli_query($conexao, "select * from tbhorarios limit 1" ) or die (mysqli_error($conexao));
				   if (mysqli_num_rows( $parametros)<1){ 
				     //Se não possuir algum usuário
					 $insereParametro = mysqli_query($conexao, "INSERT INTO tbhorarios (id, dia_semana, hr_inicio, hr_fim, fechado) VALUES
					 (1, 6, NULL, NULL, 1),
					 (2, 0, '07:30:00', '17:30:00', 0),
					 (3, 1, '07:30:00', '17:30:00', 0),
					 (4, 2, '07:30:00', '17:30:00', 0),
					 (5, 3, '07:30:00', '17:30:00', 0),
					 (6, 4, '07:30:00', '17:30:00', 0),
					 (7, 5, '08:30:00', '12:00:00', 0);")or die (mysqli_error($conexao)); 
					  echo "<font color='red'>Horarios de funcionamento padrões configurados</font><br>";
				   }
			
				  //Verifico se possui algum usuário, se não possuir, crio um novo usuário
				  $usuarios = mysqli_query($conexao, "select * from tbusuario limit 1" ) or die (mysqli_error($conexao));
                     if (mysqli_num_rows($usuarios)<1){ //Se não possuir algum usuário
                       $insereUsuario = mysqli_query($conexao, "insert into tbusuario VALUES (0, 'Administrador','admin', '123456', 'A', null, 'Administrador', 0, now())")or die (mysqli_error($conexao)); 
                            echo "<font color='red'>Usuário padrão:admin Senha: 123456 </font>";
                     }
				?>
			</div>
		</div>
	</div>

	<script src="<?php echo $url_base; ?>js/main.js"></script>
	<script src="<?php echo $url_base; ?>js/login.js"></script>
</body>
</html>