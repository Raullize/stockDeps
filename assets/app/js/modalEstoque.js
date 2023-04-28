document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById('modal');
    const botoesEditar = document.getElementsByClassName('botao-editar');
    const botaoCancelar = document.getElementById('cancel-button');
    
    botaoCancelar.addEventListener('click', function() {
        modal.style.display = "none";
    })

    for (let i = 0; i < botoesEditar.length; i++) {
      botoesEditar[i].addEventListener('click', function() {
        modal.style.display = "flex";
      });
    }
  });
  