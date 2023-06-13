$(document).ready(function (){
  const btnEditarRegistros = $(".btnEditarRegistro");

  btnEditarRegistros.off("click").on("click", function (e) {
    const nomeItem = $($(this).parent().parent().children()[0]).text();
    const idItem = $($(this).parent().parent()).attr("idr");
    const nomeTabela = $('input[name="checks"]:checked + label:first').text().trim().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

    const saveButton = $(".save-button");

    saveButton.off("click").on("click", function(e) {
      e.preventDefault();
      const idForm = $(this).parent().parent().parent().attr("id");

      const quantidade = $(`#${idForm} input[name="quantidade"]`).val();

      console.log(quantidade)

      const dataAjax = {
        table: nomeTabela,
        id: idItem,
        quantidade
      }
  
      const params = $.param(dataAjax);

      $.ajax({
        type: "POST",
        url: "estoque-atualizar",
        data: params,
        dataType: 'json',
        success: function (response) {
          console.log(response);
          location.reload(true);
        },
        error: function(response){
          console.log(response);
        }
      });

      console.log(nomeItem);
    });
  })
})

