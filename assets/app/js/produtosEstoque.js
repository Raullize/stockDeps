const tabelaProdutos = document.getElementById("tabela-produtos");

function adicionaProdutosLista(produtos) {
  return `
    <tr> 
      <td> ${produtos.nome} </td> 
      <td> 
        <button class="botao-deletar"> DELETAR </button> 
      </td> 
    </tr>
  `;
}

document.addEventListener("DOMContentLoaded", function () {
  if(produtos.length > 0) {
  produtos.forEach(function (produtos) {
    tabelaProdutos.insertAdjacentHTML('beforeend', adicionaProdutosLista(produtos));
  });
  }
});
