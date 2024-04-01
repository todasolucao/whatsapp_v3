// JavaScript Document
$( document ).ready(function() {
  $('#colorpicker').farbtastic('#color');

  // Novo Registro //
    $('#btnGravarConfiguracoes').click(function(e){
      e.preventDefault();

      var mensagem  = "<strong>Configurações Gravadas com sucesso!</strong>";
      var mensagem2 = 'Falha ao Efetuar Cadastro!';	 		 

      $('#gravaConfiguracoes').ajaxForm({
        resetForm: false, 			  
        beforeSend:function() {
          $("#btnGravarConfiguracoes").attr('value', 'Salvando ...');
          $('#FormConfiguracoes').find('input, button').prop('disabled', true);
        },
        success: function( retorno ){
          // Mensagem de Atualização efetuado
          if (retorno == 1) { mostraDialogo(mensagem, "success", 2500); }
          // Mensagem de Erro durante a Atualização 
          else{ mostraDialogo(mensagem2, "danger", 2500); }

          // Altera a Cor da Tarja //
          $(".backgroundLine").removeAttr( "style");
          $(".backgroundLine").attr("style", "background: " + $("#color").val());
        },		 
        complete:function() {
          $("#btnGravarConfiguracoes").attr('value', 'Salvar Alterações');
          $('#FormConfiguracoes').find('input, button').prop('disabled', false);
        },
        error: function (retorno) { mostraDialogo(mensagem2, "danger", 2500); }
      }).submit();
    });
  // FIM Novo Registro //
	
	
	 //Ações para Efetuar o corte da imagem
	$image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:500,
      height:400
    }
  });

  $('#foto').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){});
    }
    reader.readAsDataURL(this.files[0]);
    abrirModal('#modalUpload');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"cadastros/configuracoes/upload.php",
        type: "POST",
        data:{"image": response},
        success:function(data){
          // $('#uploadimageModal').modal('hide');
          $('#modalUpload').hide();
          $("#foto_carregada").attr("src",data);
          $("#foto2").val(data);
        }
      });
    })
  });

  // Cancelando o Upload da Imagem //
  $('#btnCancelaUpload').on('click', function (){
    // Fechando a Modal de Confirmação //
    $('#modalUpload').attr('style', 'display: none');
  });
});