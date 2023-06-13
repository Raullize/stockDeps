$(document).ready(function (){
  const btnDeletar = $(".botao-deletar");

  btnDeletar.off("click").on("click", function(e){
    $('body').addClass('modal-open');
    $("#myModal").css("display", "flex");
    const nomeItem = $($(this).parent().parent().children()[0]).text();
    const idItem = $($(this).parent().parent()).attr("idr");
    $(".itemExcluir").text(nomeItem);

    //fiz esse esquema pra poder passar o nome da tabela sem ter que atribuir a um type hidden
    const primeiroLabel = $('input[name="checks"] + label:first').text().trim().toLowerCase();
    const nomeTabela = $('input[name="checks"]:checked + label:first').text().trim().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

    console.log(idItem)
    const dataAjax = {
      table: nomeTabela,
      id: idItem
    }

    const params = $.param(dataAjax);
    
    $("#confirmarExcluir").off("click").on("click", function(){
      console.log(params)
      $.ajax({
        type: "POST",
        url: "estoque-deletar",
        data: params,
        dataType: "json",
        success: function (response) {
          location.reload(true);
        }, 
        error: function (response){
          console.log(response)
        }
      });
    })


  })

  $(".close, .cancelarExcluir").click(function() {
      $("#myModal").css("display", "none");
  });
  
  
})