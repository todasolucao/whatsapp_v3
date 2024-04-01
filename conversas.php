<?php 
require_once("includes/padrao.inc.php"); 
?>
<html class="js adownload cssanimations csstransitions webp webp-alpha webp-animation webp-lossless wf-roboto-n4-active wf-opensans-n4-active wf-opensans-n6-active wf-roboto-n3-active wf-roboto-n5-active wf-active" dir="ltr" loc="pt-BR" lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $_SESSION["parametros"]["title"]; ?></title>
    <meta name="viewport" content="width=device-width">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/uikit.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.form.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/js_modal.js"></script>
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <script src="js/funcionalidade.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script src="js/notification.js"></script>
    <script>
        $(document).ready(function() {
                // Pesquisa de Contatos //
                // Carregando a Lista de Contatos, ao pesquisar um nome //
                $("#pesquisaContato").keypress(function() { atualizaContatos(); });

                // Carregando a Lista de Contatos, no click do icon de Contatos //
                $('#contatos-bt-lista').click(function () { atualizaContatos(); });
                // FIM Pesquisa de Contatos //

            function atualizaAtendimentos() {
                var id = $("#id_usuariologado").val();
                var qtdTriagem = $("#qtdTriagem").val();
                var qtdPendentes = $("#qtdPendentes").val();
                var qtdAtendendo = $("#qtdAtendendo").val();
                var qtdNewMsgTriagem = $("#qtdNewMsgTriagem").val();
                var qtdNewMsgPendentes = $("#qtdNewMsgPendentes").val();
                var qtdNewMsgAtendendo = $("#qtdNewMsgAtendendo").val();
                var perfilUsuario = $("#perfilUsuario").val();
                var qtdNovas = parseInt(qtdNewMsgTriagem)+parseInt(qtdNewMsgPendentes)+parseInt(qtdNewMsgAtendendo);

                // Atualiza o Title com a Quantidade de Mensagens //
                if( parseInt(qtdNovas) === 0 ){
                    $(document).attr("title", $("#parametrosTitle").val());
                }
                else{ $(document).attr("title", "("+qtdNovas+") " + $("#parametrosTitle").val()); }
                // FIM Atualiza o Title com a Quantidade de Mensagens //
                
                
                // Busco a QTD de Triagem //
                if( $("#qtdTriagem").length ){
                    $.post("atendimento/qtdTriagem.php", {
                        id: id
                    }, function(retorno) {
                        var auxQtdNewMsgTriagem = 0;

                        if( retorno.trim() != "0" ){
                            var qtde = retorno.split("#");
                            var find = /@/g;

                            if( find.test(qtde[1]) ){
                                var atendimentosNovasMsg = (qtde[1]).split("[@]");

                                for(let i = 0; i < (atendimentosNovasMsg.length)-1; i++) {
                                    var dados = (atendimentosNovasMsg[i]).split("[&]");

                                    $("#not" + dados[0]).html('<span class="OUeyt messages-count-new">' + dados[1] + '</span>');
                                    $("#msg" + dados[0]).html(dados[2]);

                                    // Verifica se não é Vazio //
                                    if( dados.length > 3 ){
                                        if( dados[3].trim() != "" ){ $("#hor"+dados[0]).html(dados[3].replace("_",":")); }
                                    }
                                }
                            }

                            retorno = qtde[0];
                            auxQtdNewMsgTriagem = (qtde[2] !== undefined) ? qtde[2] : 0;
                        }

                        if( ( parseInt(retorno) != parseInt(qtdTriagem) )
                            || ( parseInt(auxQtdNewMsgTriagem) != parseInt(qtdNewMsgTriagem) ) ){
                            $.ajax("atendimento/triagem.php").done(function(data) {
                                $('#ListaTriagem').html(data);
                            });

                            $("#qtdTriagem").val(retorno);
                            $("#qtdNewMsgTriagem").val(auxQtdNewMsgTriagem);
                        }
                    });
				}
				
                // Busco a Qtd de Atendimentos Pendentes //
                if( $("#qtdPendentes").length ){
                    $.post("atendimento/qtdPendentes.php", {
                        id: id
                    }, function(retorno) {
                        var auxQtdNewMsgPendentes = 0;

                        if( retorno.trim() != "0" ){
                            var qtde = retorno.split("#");
                            var find = /@/g;

                            if( find.test(qtde[1]) ){
                                var atendimentosNovasMsg = (qtde[1]).split("[@]");

                                for(let i = 0; i < (atendimentosNovasMsg.length)-1; i++) {
                                    var dados = (atendimentosNovasMsg[i]).split("[&]");
                                    
                                    $("#not"+dados[0]).html('<span class="OUeyt messages-count-new">'+dados[1]+'</span>');
                                    $("#msg"+dados[0]).html(dados[2]);
                                    
                                    // Verifica se não é Vazio //
                                    if( dados[3].trim() != "" ){ $("#hor"+dados[0]).html(dados[3].replace("_",":")); }
                                }
                            }

                            retorno = qtde[0];
                            auxQtdNewMsgPendentes = (qtde[2] !== undefined) ? qtde[2] : 0;
                        }

                        if( ( parseInt(retorno) != parseInt(qtdPendentes) )
                            || ( parseInt(auxQtdNewMsgPendentes) != parseInt(qtdNewMsgPendentes) ) ){
                            $.ajax("atendimento/pendentes.php").done(function(data) {
                                $('#ListaPendentes').html(data);
                                notifyMe("img/uptalk-logo.png", "Notificação", "Nova mensagem aguardando atendimento!", "");
                            });

                            $("#qtdPendentes").val(retorno);
                            $("#qtdNewMsgPendentes").val(auxQtdNewMsgPendentes);
                        }
                    });
                }
                // FIM Busco a Qtd de Atendimentos Pendentes //

                // Conversas em Atendimento //
                if( $("#qtdAtendendo").length ){
                    $.post("atendimento/qtdAtendendo.php", {
                        id: id
                    }, function(retorno) {
                        var auxQtdNewMsgAtendendo = 0;

                        if( retorno.trim() != "0" ){
                            var qtde = retorno.split("#");
                            var find = /@/g;

                            if( find.test(qtde[1]) ){
                                var atendimentosNovasMsg = (qtde[1]).split("[@]");

                                for(let i = 0; i < (atendimentosNovasMsg.length)-1; i++) {
                                    var dados = (atendimentosNovasMsg[i]).split("[&]");
                                    
                                    $("#not"+dados[0]).html('<span class="OUeyt messages-count-new">'+dados[1]+'</span>');
                                    $("#msg"+dados[0]).html(dados[2]);

                                    // Verifica se não é Vazio //
                                    if( dados[3].trim() != "" ){ $("#hor"+dados[0]).html(dados[3].replace("_",":")); }
                                }
                            }

                            retorno = qtde[0];
                            auxQtdNewMsgAtendendo = (qtde[2] !== undefined) ? qtde[2] : 0;
                        }
                        
                        if( ( parseInt(retorno) != parseInt(qtdAtendendo) )
                            || ( parseInt(auxQtdNewMsgAtendendo) != parseInt(qtdNewMsgAtendendo) ) ){
                            $.ajax("atendimento/atendendo.php").done(function(data) {
                                $('#ListaEmAtendimento').html(data);
                            });
                            $("#qtdAtendendo").val(retorno);
                            $("#qtdNewMsgAtendendo").val(auxQtdNewMsgAtendendo);
                        }
                    });
                }
                // FIM Conversas em Atendimento //
            }

            // Atualiza a Lista de Atendimentos //
                var intervalo = setInterval(function() { atualizaAtendimentos(); }, 15000);
                atualizaAtendimentos();
            // FIM Atualiza a Lista de Atendimentos //

            // Atualiza o 'Timestamp' do Usuário para identificar se ele está logado //
                var idTimestampUsuario = setInterval(function() { 
                    updateTimestampUser();
                }, 300000);
                
                function updateTimestampUser(){
                    $.ajax("cadastros/usuarios/gravaTimestamp.php").done(
						function(timestamp) {}
                    );
                }

                // Chama na primeira vez em que a página é Carregada //
                updateTimestampUser();
            // FIM Atualiza o 'Timestamp' do Usuário para identificar se ele está logado //
        });
    </script>
</head>

<body class="web">
        <!-- Campos Input Hidden --> 
        <input type="hidden" id="qtdTriagem" name="qtdTriagem" value='0' />
        <input type="hidden" id="qtdPendentes" name="qtdPendentes" value="0" />
        <input type="hidden" id="qtdAtendendo" name="qtdAtendendo" value='0' />
        <input type="hidden" id="qtdNewMsgTriagem" name="qtdNewMsgTriagem" value='0' />
        <input type="hidden" id="qtdNewMsgPendentes" name="qtdNewMsgPendentes" value='0' />
        <input type="hidden" id="qtdNewMsgAtendendo" name="qtdNewMsgAtendendo" value='0' />
        <input type="hidden" id="id_usuariologado" name="id_usuariologado" value="<?php echo $_SESSION["usuario"]["id"]; ?>" />
        <input type="hidden" id="perfilUsuario" name="perfilUsuario" value="<?php echo $_SESSION["usuario"]["perfil"]; ?>" />
        <input type="hidden" id="chatOperadores" name="chatOperadores" value="<?php echo $_SESSION["parametros"]["chat_operadores"]; ?>" />
        <input type="hidden" id="atendTriagem" name="atendTriagem" value="<?php echo $_SESSION["parametros"]["atend_triagem"]; ?>" />
        <input type="hidden" id="historicoConversas" name="historicoConversas" value="<?php echo $_SESSION["parametros"]["historico_conversas"]; ?>" />
        <input type="hidden" id="parametrosTitle" name="parametrosTitle" value="<?php echo $_SESSION["parametros"]["title"]; ?>" />
        <input type="hidden" id="parametrosIniciarConversa" name="parametrosIniciarConversa" value="<?php echo $_SESSION["parametros"]["iniciar_conversa"]; ?>" />
        <input type="hidden" id="parametrosRespRapidaAut" name="parametrosRespRapidaAut" value="<?php echo $_SESSION["parametros"]["enviar_resprapida_aut"]; ?>" />
        <input type="hidden" id="parametrosEnvioAudioAut" name="parametrosEnvioAudioAut" value="<?php echo $_SESSION["parametros"]["enviar_audio_aut"]; ?>" />
        <input type="hidden" id="parametrosQRCode" name="parametrosQRCode" value="<?php echo $_SESSION["parametros"]["qrcode"]; ?>" />
        <input type="hidden" id="parametrosOpNaoEnvUltMensagem" name="parametrosOpNaoEnvUltMensagem" value="<?php echo $_SESSION["parametros"]["op_naoenv_ultmsg"]; ?>" />
        <input type="hidden" id="parametrosMostraTodosChats" name="parametrosMostraTodosChats" value="<?php echo $_SESSION["parametros"]["mostra_todos_chats"]; ?>" />
        <input type="hidden" id="parametrosTransferOffline" name="parametrosTransferOffline" value="<?php echo $_SESSION["parametros"]["transferencia_offline"]; ?>" />
        <input type="hidden" id="countViewQRCode" name="countViewQRCode" value="0" />
        <input type="hidden" id="s_id_atendimento" name="s_id_atendimento" />
        <input type="hidden" id="s_id_canal" name="s_id_canal" />
        <input type="hidden" id="s_numero" name="s_numero" />
        <input type="hidden" id="s_nome" name="s_nome" />
        <input type="hidden" id="gravando" name="gravando" value="0" />
        <input type="hidden" id="carregaWebChat" name="carregaWebChat" value="0" />
        <input type="hidden" id="audio64" name="audio64" />
        <input type="hidden" id="myInterval" />
        <input type="file" id="upload" name="upload" class="imginput" style="display: none;" />
    <!-- FIM Campos Input Hidden -->

    <div id="app">
        <div class="backgroundLine" style="background: <?php echo $_SESSION["parametros"]["color"]; ?>;"></div>
        <div class="_1FKgS app-wrapper-web bFqKf">
            <span>
                <!-- Span Contato -->
                <!-- FIM Span Contato -->
            </span>

            <div tabindex="-1" class="app _3dqpi two" id="app-content">
                <div class="MZIyP">
                    <div class="_3q4NP k1feT">
                        <span>
                            <!-- Dados do Usuário -->
                            <?php require_once("dadosUsuario.php"); ?>
                            <!-- FIM Dados do Usuário -->
                        </span>
                        <span>
                            <!-- Nova Conversa -->
                            <!-- FIM Nova Conversa -->
                        </span>
                    </div>
                </div>
                
                <!-- ÁREA DOS CONTATOS -->
                <div class="_3q4NP k1feT">  <!-- Preciso tonar esse trecho responsivo //André Luiz 14/11/2022 -->
                    <div id="side" class="swl8g">
                        <header class="_3auIg">
                            <div class="_2umId">
                                <div class="_1WliW" id="my-photo" style="height: 40px; width: 40px; cursor: pointer;">
                                    <img src="#" class="Qgzj8 gqwaM" style="display:none;">
                                    <div class="_3ZW2E">
                                        <span data-icon="default-user">
                                            <img src="<?php echo $_SESSION["parametros"]["imagem_perfil"]; ?>" class="rounded-circle user_img_msg">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="_20NlL">
                                <div class="_3Kxus">
                                    <ul class="user-options" style="padding-left: 15px !important">                                                                       
                                         <!-- Conexão -->
                                         <li class="tooltip btNovaConversa" style="z-index:0">
                                            <a href="javascript:;" id="btnConexao">
                                                <i id="btnConexaoColor" class="fas fa-signal itemIcon"></i>
                                            </a>
                                            <span class="tooltiptext tooltip-bottom" id="spanConectado"></span>
                                        </li>
                   
                                        <!-- Contatos -->
                                        <li class="tooltip btNovaConversa" id="contatos-bt-lista" style="z-index:0">
                                            <i class="far fa-address-book itemIcon" style="color: dodgerblue;"></i>
                                            <span class="tooltiptext tooltip-bottom">Lista de contatos</span>
                                        </li>
                                        <!-- Configurações -->
                                        <li id="menu-options" class="" style="position: relative; display: none;z-index:0">                                 
                                            <i class="fas fa-cog itemIcon" style="font-size: 1em; margin-top: 2px"></i>  
                                                                         
                                            <div class="message-menu-opt" style="position:absolute;top: 46px; right: -75px; display: block; width: 200px; display:none" id="poup2">
                                                <ul>     
                                                    <li id="liCanais" style="display: none;"><a id="aModalCanais" href="javascript:;" onclick="abrirModal('#modalCanal');">Canais</a></li>
                                                    <li id="liMenus" style="display: none;"><a id="aModalMenus" href="javascript:;" onclick="abrirModal('#modalMenu');">Menus</a></li>
                                                    <li id="liDepartamentos" style="display: none;"><a id="aModalDepartamentos" href="javascript:;" onclick="abrirModal('#modalDepartamento');">Departamentos</a></li>
                                                    <li id="liRespostasRapidas" style="display: none;"><a id="aModalRespostasRapidas" href="javascript:;" onclick="abrirModal('#modalRespostaRapida');">Respostas Rápidas</a></li>
                                                    <li id="liRespostasAutomaticas" style="display: none;"><a id="aModalRespostasAutomaticas" href="javascript:;" onclick="abrirModal('#modalRespostaAutomatica');">Respostas Automáticas</a></li>
                                                    <li id="liHorariosAtendimentos" style="display: none;"><a id="aModalHorariosAtendimentos" href="javascript:;" onclick="abrirModal('#modalHorarioAtendimento');">Horário de Atendimento</a></li>
                                                    <li id="liUsuarios" style="display: none;"><a id="aModalUsuarios" href="javascript:;" onclick="abrirModal('#modalUsuario');">Usuários</a></li>
                                                    <li id="liConfiguracoes" style="display: none;"><a id="aModalConfiguracoes" href="javascript:;" onclick="abrirModal('#modalConfiguracao');">Configurações</a></li>
                                                    <li id="liDashboards" style="display: none;"><a id="aModalDashboards" href="javascript:;" onclick="abrirModal('#modalDashboard');">Dashboard</a></li>
                                                    <li id="liTelefones" style="display: none;"><a id="aModalTelefones" href="javascript:;" onclick="abrirModal('#modalTelefone');">Telefones Notificações</a></li>
                                                </ul>
                                            </div> 
                                        </li>
                                        <!-- Módulos -->
                                        <?php 
                                            // Mostro os itens caso exista algum dos módulos instalados //
                                            if( is_dir("modulos/baseconhecimento") ){
                                        ?>
                                                <li class="tooltip btNovaConversa" style="z-index:0">
                                                    <a id="aModalBaseConhecimento" onclick="abrirModal('#modalBaseConhecimento');">
                                                        <i class="fas fa-database itemIcon" style="color: dodgerblue;"></i>
                                                        <span class="tooltiptext tooltip-bottom">Base de Conhecimento</span>
                                                    </a>                                                   
                                                </li>
                                        <?php } ?>
                                        <!-- Histórico de atendimentos -->                                        
                                        <li id="historico-atendimentos" class="tooltip btNovaConversa" style="display:none;z-index:0 !important;">
                                            <i id="iModalRelatorio" class="fas fa-history itemIcon" style="color: blueviolet;" onclick="abrirModal('#modalRelatorio');"></i>
                                            <span class="tooltiptext tooltip-bottom">Histórico</span>
                                        </li>
                                        <li class="tooltip btNovaConversa" style="z-index:0 !important;">
                                            <i id="iModalRedefinirSenha" class="fas fa-lock itemIcon" onclick="abrirModal('#modalRedefinirSenha');" style="padding-top:4px;"></i>
                                            <span class="tooltiptext tooltip-bottom">Mudar Senha</span>
                                        </li>  
                                        
                                           <!-- Sair -->
                                     <li class="tooltip btNovaConversa" style="z-index:0">
                                            <a href="logOff.php">
                                                <i class="fas fa-sign-out-alt itemIcon" style="color: red;"></i>                                               
                                            </a>
                                            <span class="tooltiptext tooltip-bottom">Logout</span>
                                        </li>   
                                    </ul>
                                        
                                    <!-- Box Operadores -->
                                    <!-- FIM Box Operadores -->

                                    <!-- Lista de contatos-->
                                    <?php require_once("boxContatos.php"); ?>
                                    <!-- FIM Lista de contatos-->
                                </div>
                            </div>
                        </header>
                        <!-- Area de Notificações -->
                        <!-- FIM Area de Notificações -->
                        <div tabindex="-1" class="_3CPl4">
                            <!-- Filtros -->
                            <?php //require_once("filtrosConversas.php"); ?>
                            <!-- FIM Filtros -->
                        </div>
                        <div class="_1NrpZ" id="pane-side" data-list-scroll-container="true">
                            <div tabindex="-1" data-tab="3">
                                <div>
                                        <!-- Conversas -->
                                        <div class="RLfQR" style="/* height: auto; */display: contents;">
                                            <span><i title="Atendimentos sem Setor"></i>Atendimentos sem Setor</span>
                                        </div>
                                        <div id="ListaTriagem" class="RLfQR" style="/* height: auto; */display: contents;">
                                            <!-- Lista os Atendimentos Triagem Sem Departamento -->
                                        </div>
                                    <div class="RLfQR" style="/* height: auto; */display: contents;">
                                        <span><i title="Atendimentos em Espera"></i>Atendimentos em Espera</span>
                                    </div>
                                    <div id="ListaPendentes" class="RLfQR" style="/* height: auto; */display: contents;">
                                        <!-- Lista os Atendimentos Em Espera -->
                                    </div>
                                    <div class="RLfQR" style="/* height: auto; */display: contents;">
                                        <span><i title="Atendimentos em Andamento"></i>Atendimentos em Andamento</span>
                                    </div>
                                    <div id="ListaEmAtendimento" class="RLfQR" style="/* height: auto; */display: contents;">
                                        <!-- Lista os Atendimentos Atuais -->
                                    </div>
                                    <!-- FIM Conversas -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FECHA ÁREA DOS CONTATOS -->

                <!-- ÁREA PRINCIPAL DOS COMENTÁRIOS -->
                <div class="_3q4NP _1Iexl mostrar">
                    <div id="btManipulaChat" class="action_arrow" title="" aria-expanded="false">
                        <div class="changebtchat">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
                                <path fill="#FFF" d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="home" class="_3qlW9">
                        <!-- Conecta Celular -->
                        <!-- FIM Conecta Celular -->
                        <div id="AtendimentoAberto" class="_1GX8_">
                            <!-- Conversa Atual -->
                        </div>
                    </div>
                    <!-- Área do Chat entre Operadores -->
                    <?php require_once("webchat/index.php"); ?>
                    <!-- FIM Área do Chat entre Operadores -->
                </div>
                <!-- FIM ÁREA PRINCIPAL DOS COMENTÁRIOS -->
            </div>
        </div>

        <?php require_once("modais/modais.php"); ?>
    </div>


 <!-- Bootstrap -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            // Habilita a opção de Configurações apenas para os Administradores //         
            if( $("#perfilUsuario").val() != 1 ){
                $("#menu-options").attr('style','display: block');
                $("#historico-atendimentos").attr('style','display: block');
           

                // Habilitando o Cadastro de Usuários //
                $("#liUsuarios").attr('style','display: block');
                $("#liTelefones").attr('style','display: block');

                // Libera os demais Menus caso acesso de Administrador //
                if( $("#perfilUsuario").val() == 0 ){
                    $("#liCanais").attr('style','display: block');
                    $("#liMenus").attr('style','display: block');
                    $("#liDepartamentos").attr('style','display: block');
                    $("#liRespostasRapidas").attr('style','display: block');
                    $("#liRespostasAutomaticas").attr('style','display: block');
                    $("#liHorariosAtendimentos").attr('style','display: block');
                    $("#liConfiguracoes").attr('style','display: block');
                    $("#liDashboards").attr('style','display: block');
                    
                }
            }

            // Verifica a Conexão do Bot //
                function verificaConexao() {
                    $.post("includes/conectado.php", {}, function(retorno) {
                        retorno = JSON.parse(retorno);

                        // Definição de Variável //
                        var color, label;

                        // Verifica se está ou não Conectado //
                        if( retorno.status === 9 ){
                            color = 'red';
                            label = 'Desconectado';

                            // Verifica Parâmetro para Habilitar a Tela de Leitura do QRCode //
                            if( $("#parametrosQRCode").val() === "1" ){
                                $("#btnConexao").attr( "onclick", "abrirModal('#modalQRCode')" );
                                setTimeout(function() { $('#btnConexao').click(); }, 500);
                            }
                        }
                        else {
                            color = 'green';
                            label = 'Conectado';
                            $("#btnConexao").removeAttr("onclick");

                            // Verifica o valor de 'countViewQRCode' antes de fechar a Modal //
                            if( parseInt($("#countViewQRCode").val()) !== 0 ){
                                // Fecha a Janela //
                                fecharModal();

                                // Zera o Contador //
                                $("#countViewQRCode").val(0);
                            }
                        }

                        // Envia Dados para o HTML //
                        $("#btnConexaoColor").attr('style', 'color: ' + color);
                        $("#spanConectado").text(label);
                    });
                }
            // FIM Verifica a Conexão do Bot //

            // Chamada da Verificação de Conexão //
                var intervalConnection = setInterval(function() { verificaConexao(); }, 15000);
                verificaConexao();
            // FIM Chamada da Verificação de Conexão //



            // Atualiza o QRCode //
                function getQRCode() {
                    var countViewQRCode = $("#countViewQRCode").val();

                    // Verifica Parâmetro para Habilitar a Tela de Leitura do QRCode //
                    if( $("#parametrosQRCode").val() === "1" 
                        // Só inicia a Leitura do QRCode se 'qrcode' for inicializada. Possue stop no valor '60' - Só executa durante 60 segundos //    
                        && countViewQRCode > 0 ){
                        $.post("includes/qrcode.php", {count: countViewQRCode}, function(retorno) {
                            retorno = JSON.parse(retorno);

                            // Verifica se está ou não Conectado //
                            if( retorno.status === 9 ){
                                if( retorno.qrcode !== 9 ){
                                    // Atualiza a Variável 'qrcode' //
                                    $("#btnConexao").removeAttr( "src");
                                    $("#imgQRCode").attr( "src", "data:image/png;base64," + retorno.qrcode);

                                    // Fechar a Janela //
                                    if( retorno.count === 0 ){ fecharModal(); }
                                }
                                // Server Bot Offline //
                                else{ $("#serverBotOffline").attr('style', 'display: block'); }

                                // Atualizando o Contador //
                                $("#countViewQRCode").val(retorno.count);
                            }
                            else{
                                // Envia Dados para o HTML //
                                $("#btnConexaoColor").attr('style', 'color: green');
                                $("#spanConectado").text("Conectado");

                                // Fecha a Janela //
                                fecharModal();
                                
                                // Zera o Contador //
                                $("#countViewQRCode").val("0");
                            }
                        });
                    }
                }
            // FIM Atualiza o QRCode //

            // Chamada da Atualização o QRCode //
                var intervalQRCode = setInterval(function() { getQRCode(); }, 1000);
            // FIM Chamada da Atualização o QRCode //

            // Carregamento das Modais //
                // Modal Canais //
                $("#aModalCanais").on("click", function() {
                    $.ajax("cadastros/canais/index.php").done(function(data) {
                        $('#modalCanal').html(data);
                    });
                });

                // Modal Menus //
                $("#aModalMenus").on("click", function() {
                    $.ajax("cadastros/menu/index.php").done(function(data) {
                        $('#modalMenu').html(data);
                    });
                });

                // Modal Departamentos //
                $("#aModalDepartamentos").on("click", function() {
                    $.ajax("cadastros/departamentos/index.php").done(function(data) {
                        $('#modalDepartamento').html(data);
                    });
                });

                // Modal Respostas Rapidas //
                $("#aModalRespostasRapidas").on("click", function() {});

                // Modal Respostas Automaticas //
                $("#aModalRespostasAutomaticas").on("click", function() {
                    $.ajax("cadastros/respostasautomaticas/index.php").done(function(data) {
                        $('#modalRespostaAutomatica').html(data);
                    });
                });

                // Modal Horarios Atendimentos //
                $("#aModalHorariosAtendimentos").on("click", function() {
                    $.ajax("cadastros/horarios/index.php").done(function(data) {
                        $('#modalHorarioAtendimento').html(data);
                    });
                });

                // Modal Usuarios //
                $("#aModalUsuarios").on("click", function() {
                    $.ajax("cadastros/usuarios/index.php").done(function(data) {
                        $('#modalUsuario').html(data);
                    });
                });

                // Modal Configurações //
                $("#aModalConfiguracoes").on("click", function() {
                    $.ajax("cadastros/configuracoes/index.php").done(function(data) {
                        $('#modalConfiguracao').html(data);
                    });
                });
                
                // Modal Dashboards //
                $("#aModalDashboards").on("click", function() {});

                // Modal Relatorio //
                $("#iModalRelatorio").on("click", function() {
                    $.ajax("cadastros/relatorios/index.php").done(function(data) {
                        $('#modalRelatorio').html(data);
                    });
                });

                // Modal QRCode //
                $("#btnConexao").on("click", function() {
                    $("#countViewQRCode").val("1");
                });

                // Modal Base de Conhecimento //
                $("#aModalBaseConhecimento").on("click", function() {
                    $.ajax("modulos/baseconhecimento/index.php").done(function(data) {
                        $('#modalBaseConhecimento').html(data);
                    });
                });

                // Modal Telefones //
                $("#aModalTelefones").on("click", function() {
                    $.ajax("cadastros/telefoneaviso/index.php").done(function(data) {
                        $('#modalTelefone').html(data);
                    });
                });

               // Modal Redefinir Senha //
               $("#iModalRedefinirSenha").on("click", function() {
                    $.ajax("cadastros/usuarios/redefinirSenha.php").done(function(data) {
                        $('#modalRedefinirSenha').html(data);
                    });
                });
            // FIM Carregamento das Modais //

            // Habilita o sistema de Abas //
                $("#tabs").tabs();
                $("#tabs2").tabs();
                $("#tabs3").tabs();
                $("#tabs4").tabs();
            // FIM Habilita o sistema de Abas //
        });
    </script>
</body>
</html>