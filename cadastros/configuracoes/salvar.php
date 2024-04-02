<?php
   require_once("../../includes/padrao.inc.php");

   $msg_aguardando_atendimento   = quebraDeLinha($_POST['msg_aguardando_atendimento']);
   $msg_inicio_atendimento       = quebraDeLinha($_POST['msg_inicio_atendimento']);
   $msg_fim_atendimento          = quebraDeLinha($_POST['msg_fim_atendimento']);
   $msg_sem_expediente           = quebraDeLinha($_POST['msg_sem_expediente']);
   $msg_desc_inatividade         = quebraDeLinha($_POST['msg_desc_inatividade']);
   $title                        = $_POST['title'];
   $minutosOffline               = $_POST['minutos_offline'];
   $color                        = $_POST['color'];
   $nome_atendente               = !empty($_POST['nome_atendente']) ? $_POST['nome_atendente'] : "0";
   $chat_operadores              = !empty($_POST['chat_operadores']) ? $_POST['chat_operadores'] : "0";
   $atend_triagem                = !empty($_POST['atend_triagem']) ? $_POST['atend_triagem'] : "0";
   $historico_conversas          = !empty($_POST['historico_conversas']) ? $_POST['historico_conversas'] : "0";
   $iniciar_conversa             = !empty($_POST['iniciar_conversa']) ? $_POST['iniciar_conversa'] : "0";
   $env_resprapida_aut           = !empty($_POST['enviar_resprapida_aut']) ? $_POST['enviar_resprapida_aut'] : "0";
   $enviar_audio_aut             = !empty($_POST['enviar_audio_aut']) ? $_POST['enviar_audio_aut'] : "0";
   $qrcode                       = !empty($_POST['qrcode']) ? $_POST['qrcode'] : "0";
   $op_naoenv_ultmsg             = !empty($_POST['op_naoenv_ultmsg']) ? $_POST['op_naoenv_ultmsg'] : "0";
   $exibir_foto_perfil           = !empty($_POST['exibir_foto_perfil']) ? $_POST['exibir_foto_perfil'] : "0";
   $alerta_sonoro                = !empty($_POST['alerta_sonoro']) ? $_POST['alerta_sonoro'] : "0";
   $mostra_todos_chats           = !empty($_POST['mostra_todos_chats']) ? $_POST['mostra_todos_chats'] : "0";
   $transferencia_offline        = !empty($_POST['transferencia_offline']) ? $_POST['transferencia_offline'] : "0";
   $envia_uma_msg_sem_expediente = !empty($_POST['envia_uma_msg_sem_expediente']) ? $_POST['envia_uma_msg_sem_expediente'] : "0";
   $nao_usar_menu                = !empty($_POST['nao_usar_menu']) ? $_POST['nao_usar_menu'] : "0";
   $departamento_atendente       = !empty($_POST['departamento_atendente']) ? $_POST['departamento_atendente'] : "0";
   $contar_tempo_espera_so_dos_clientes = !empty($_POST['contar_tempo_espera_so_dos_clientes']) ? $_POST['contar_tempo_espera_so_dos_clientes'] : "0";
   $historico_atendimento        = !empty($_POST['historico_atendimento']) ? $_POST['historico_atendimento'] : "0";
   $usar_protocolo               = !empty($_POST['usar_protocolo']) ? $_POST['usar_protocolo'] : "0";
   $tipo_menu                    = !empty($_POST['tipo_menu']) ? $_POST['tipo_menu'] : "0";
    $menu_historico              = !empty($_POST['menu_historico']) ? $_POST['menu_historico'] : "0";
    $andamento                   = $_POST['andamento'];
    $espera                      = $_POST['espera'];
    $sem_setor                   = $_POST['sem_setor'];
    $nao_aceitar_audio           = !empty($_POST['nao_aceitar_audio']) ? $_POST['nao_aceitar_audio'] : "0";
    $menu_oculto                 = 0;
    $msg_nao_aceita_audio        = quebraDeLinha($_POST['msg_nao_aceita_audio']);
    $nao_exibir_triagem          = $_POST['nao_exibir_triagem'];

$foto                         = $_POST["foto2"];

// Atualiza a cor da tarja na Sessão //
$_SESSION["parametros"]["color"] = $color;

// Atualiza o parametro na Sessão //
$_SESSION["parametros"]["mostra_todos_chats"] = $mostra_todos_chats;

// Verifico se já existe um departamento com o mesmo nome Cadastrado
$existe = mysqli_query($conexao,"select * from tbparametros ");

if( mysqli_num_rows($existe) <= 0 ){
    $sql = "INSERT tbparametros VALUES (1
         , (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_inicio_atendimento.")
         , (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_aguardando_atendimento.")
         , (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_fim_atendimento.")
         , (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_sem_expediente.")
         , (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_desc_inatividade.")
         , '".$title."'
         , '".$minutosOffline."'
         , '".$color."'
         , '".$nome_atendente."'
         , '".$chat_operadores."'
         , '".$atend_triagem."'
         , '".$historico_conversas."'
         , '".$iniciar_conversa."'
         , '".$env_resprapida_aut."'
         , '".$enviar_audio_aut."'
         , '".$qrcode."'
         , '".$op_naoenv_ultmsg."'
         , '".$exibir_foto_perfil."'
         , '".$alerta_sonoro."'
         , '".$mostra_todos_chats."'
         , '".$transferencia_offline."'
         , '".$envia_uma_msg_sem_expediente."'
         , '".$nao_usar_menu."'
         , '".$departamento_atendente."'
         , '".$contar_tempo_espera_so_dos_clientes."'
         , '".$historico_atendimento."'
         , '".$usar_protocoloo."'
         , '".$tipo_menu."'
                , '".$andamento."'
                , '".$espera."'
                , '".$sem_setor."'
                , '".$nao_aceitar_audio."'
                , '".$menu_oculto."'
                , (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_nao_aceita_audio.")
                , '".$menu_historico."'
                , '".$nao_exibir_triagem."'";

    if( $foto != "" ){
        $sql .= ",'".$foto."')";
    }
    else{ $sql .= ")"; }

    $atualizar = mysqli_query($conexao,$sql);

    if ($atualizar){ echo "1"; }
   }
   else{
       $sql = "UPDATE tbparametros SET  msg_inicio_atendimento = (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_inicio_atendimento.")
                  , msg_aguardando_atendimento = (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_aguardando_atendimento.")
                  , msg_fim_atendimento        = (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_fim_atendimento.")
                  , msg_sem_expediente = (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_sem_expediente.")
                  , msg_desc_inatividade = (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_desc_inatividade.")
                  , title = '".$title."'
                  , minutos_offline = '".$minutosOffline."'
                  , color = '".$color."'
                  , nome_atendente = '".$nome_atendente."'
                  , chat_operadores = '".$chat_operadores."'
                  , atend_triagem = '".$atend_triagem."'
                  , historico_conversas = '".$historico_conversas."'
                  , iniciar_conversa = '".$iniciar_conversa."'
                  , enviar_resprapida_aut = '".$env_resprapida_aut."'
                  , enviar_audio_aut = '".$enviar_audio_aut."'
                  , qrcode = '".$qrcode."'
                  , op_naoenv_ultmsg = '".$op_naoenv_ultmsg."'
                  , exibe_foto_perfil = '".$exibir_foto_perfil."'
                  , alerta_sonoro = '".$alerta_sonoro."'
                  , mostra_todos_chats = '".$mostra_todos_chats."'
                  , transferencia_offline = '".$transferencia_offline."'
                  , envia_uma_msg_sem_expediente = '".$envia_uma_msg_sem_expediente."'
                  , nao_usar_menu = '".$nao_usar_menu."'
                  , contar_tempo_espera_so_dos_clientes = '".$contar_tempo_espera_so_dos_clientes."'
                  , departamento_atendente = '".$departamento_atendente."'
                  , historico_atendimento = '".$historico_atendimento."'
                  , usar_protocolo = '".$usar_protocolo."'
                  , tipo_menu = '".$tipo_menu."'
                  , andamento = '".$andamento."'
                  , espera = '".$espera."'
                  , sem_setor = '".$sem_setor."'
                  , nao_aceitar_audio = '".$nao_aceitar_audio."'
                  , menu_oculto = '".$menu_oculto."'
                  , msg_nao_aceita_audio = (CONCAT_WS(REPLACE('\\\ n', ' ', ''), ".$msg_nao_aceita_audio.")
                  , menu_historico = '".$menu_historico."'
                  , nao_exibir_triagem = '".$nao_exibir_triagem."'";


       if( $foto != "" ){
           $sql .= ", imagem_perfil = '".$foto."';";
       }
       else{ $sql .= ";"; }

       $atualizar = mysqli_query($conexao,$sql)
       or die($sql."<br/>".mysqli_error($conexao));

       if ($atualizar){ echo "1"; }
   }