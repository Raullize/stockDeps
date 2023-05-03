
const modal = document.getElementById('modal');
const botoesEditar = document.getElementsByClassName('botao-editar');
const botaoCancelar = document.getElementById('cancel-button');


botaoCancelar.addEventListener('click', function () {
  modal.style.display = "none";
})

botaoFiltrar.addEventListener('click', function () {
  // Adicione o evento de clique nos botões de edição
  for (let i = 0; i < botoesEditar.length; i++) {
    botoesEditar[i].addEventListener('click', function () {
      // Recupere as informações do produto do botão
      const nome = this.dataset.nome;
      const preco = parseFloat(this.dataset.preco.replace(",", ".")).toFixed(2);
      const quantidade = parseInt(this.dataset.quantidade);
      // Defina os valores dos campos de entrada do modal
      document.getElementById('nome').value = nome;
      document.getElementById('preco').value = preco.toString().replace(",", "."); // Formatar e substituir ponto por vírgula
      document.getElementById('quantidade').value = quantidade;

      // Exiba o modal
      modal.style.display = "flex";
    });
  }

})

