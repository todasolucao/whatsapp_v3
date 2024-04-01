<script type='text/javascript' src="cadastros/horarios/acoes.js"></script>
<script>
    $( document ).ready(function() {	
        $.ajax("cadastros/horarios/listar.php").done(function(data) {
          $('#ListarHorario').html(data);
        });

        // Fechar a Janela //
		$('.fechar').on("click", function(){ fecharModal(); });
    });
</script>

<div class="box-modal" id="FormHorario" style="display: none;">
    <form method="post" id="gravaHorario" name="gravaHorario" action="cadastros/horarios/salvar.php">
        <h2 class="title" id="titleCadastroHorario">Adicionar Novo Horário</h2>
        <div class="">
        <input type="hidden" value="0" name="acaohorario" id="acaohorario" />
        <input type="hidden" value="0" name="idHorario" id="idHorario" />

            <div class="uk-width-1-1@m">
                <div class="uk-form-label"> Dia da Semana! </div>
                <select name="dia_semana" id="dia_semana" class="uk-select">
                    <option value="9">Informe o Dia da Semana</option>
                    <option value="6">Domingo</option>
                    <option value="0">Segunda</option>
                    <option value="1">Terça</option>
                    <option value="2">Quarta</option>
                    <option value="3">Quinta</option>
                    <option value="4">Sexta</option>
                    <option value="5">Sábado</option>
                </select>
                <div id="valida_dia_semana" style="display: none" class="msgValida">
                    Por favor, Informe o Dia da Semana.
                </div>
            </div>

            <div class="uk-width-1-1@m">
                <div class="uk-form-label"> Horário de Início </div>
                <input type="text" id="hr_inicio" name="hr_inicio" class="uk-input" placeholder="Informe o Horário de Início" />
                <div id="valida_hr_inicio" style="display: none" class="msgValida">
                    Por favor, Informe o Horário de Início.
                </div>
            </div>

            <div class="uk-width-1-1@m">
                <div class="uk-form-label"> Horário de Fim </div>
                <input type="text" id="hr_fim" name="hr_fim" class="uk-input" placeholder="Informe o Horário de Fim" />
                <div id="valida_hr_fim" style="display: none" class="msgValida">
                    Por favor, Informe o Horário de Fim.
                </div>
            </div><br />

            <div class="uk-width-1-1@m">
				<input class="uk-checkbox" type="checkbox" id="fechado" name="fechado" value="1" /> Fechado (Não atende neste dia)?
			</div><br />
        </div>
    </form>

    <p class="uk-text-right" style="margin-top:1rem">
        <button id="btnFecharCadastroHorario" class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
        <input id="btnGravarHorario" class="uk-button uk-button-primary " type="submit" value="Salvar">
    </p>
</div>

<div class="box-modal" id="ListaHorarios">
    <h2 class="title">Horários Cadastrados <a id="btnNovoHorario" href="#" class="uk-align-right" uk-icon="plus-circle" title="Novo Horario"></a></h2>

    <div class="panel-body" id="ListarHorario">				
        <!-- Horários Cadastrados -->
    </div>

    <p class="uk-text-right" style="margin-top:1rem">
        <button class="uk-button uk-button-default uk-modal-close fechar" type="button">Cancelar</button>
    </p>
</div>