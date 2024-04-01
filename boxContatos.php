<div id="box-contatos">
	<div class="box-azul">
		<p class="suport">
			<img src="img/ico-addcontato.svg" class="ico-image"> <span class="title" style="font-size:1rem">Lista de contatos (<span id="qtdeContatos"></span>)</span>
			<span class="voltar"></span>
		</p>
		<a id="aModalContatosBoxContatos" href="javascript:;" onclick="abrirModal('#modalContato')" class="uk-bottom uk-bottom-line" style="position:relative;top:-10px">Adicionar Contato</a>
	</div>
	<div class="card-geral">
		<div tabindex="-1" class="_3CPl4">
			<div class="gQzdc" style="display:flex">
				<div style="margin-left: 12px;">
					<button class="C28xL" style="top: 8px;left: 20px;">
						<div class="_1M3wR _3M2St">
							<span data-icon="search">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
									<path fill="#263238" fill-opacity=".3" d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.808 0a3.605 3.605 0 1 1 0-7.21 3.605 3.605 0 0 1 0 7.21z"></path>
								</svg>
							</span>
						</div>
					</button>
					<label style="float:left">
						<input type="text" id="pesquisaContato" name="pesquisaContato" class="uk-input" data-tab="2" placeholder="Pesquisar por contato" style="padding-left: 35px;">
					</label>
					<label style="float:left">
				   	   <select class="uk-select" id="etiqueta" style="width:50px">						   
						  <?php
							$menus = mysqli_query($conexao, "SELECT * FROM tbetiquetas");

							while ($ListarDepartamentos = mysqli_fetch_array($menus)){
								echo '<option value="'.$ListarDepartamentos["cor"].'" style="background-color:'.$ListarDepartamentos["cor"].'">   </option>';
							}
							?>      
						</select>		
					</select> 

					</label>
				</div>
			</div>
		</div>
		
		<div id="ListaViewContatos" style="height:77vh; overflow: auto; background-color:#FFF;">
			<!-- Lista de Contatos -->
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		// Carregamento das Modais //
			// Modal Contato //
			$("#aModalContatosBoxContatos").on("click", function() {
				$.ajax("cadastros/contatos/index.php").done(function(data) {
					$('#modalContato').html(data);
				});
			});
		// FIM Carregamento das Modais //
		$("#etiqueta").change(function(){
			$("#etiqueta").css("background-color",$(this).val());
			$('#msgContatos').html("Carregando...");

		  var etiqueta = $("#etiqueta option:selected").val();
		   $.post("atendimento/contatos.php", {
				 etiqueta:etiqueta
				}, function(retorno) {
					$('#ListaViewContatos').html(retorno);
			});
		})
	});
</script>