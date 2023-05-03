const tabelaSaldo = document.getElementById("tabela-saldo");
const botaoFiltrar = document.getElementById("botao-filtrar");
const form = document.getElementById('form-saldo');
const selectCategoriaSaldo = document.getElementById('dropdown-categorias-saldo');


function adicionaProdutosListaSaldo(categoriaSelecionada) {
  let produtosFiltrados = [];
  let idCategorias;

  if (categoriaSelecionada === "Lava roupas") {
    idCategorias = 1;
  } else if (categoriaSelecionada === "Lava louças") {
    idCategorias = 2;
  } else if (categoriaSelecionada === "Lava carros") {
    idCategorias = 3;
  } else if (categoriaSelecionada === "Limpeza de ambiente") {
    idCategorias = 4;
  }
  produtosFiltrados = produtos.filter(produto => produto.idCategoria === idCategorias);

  let tabela = "";
  for (let i = 0; i < produtosFiltrados.length; i++) {
    tabela += `
      <tr> 
        <td> ${produtosFiltrados[i].nome} </td> 
        <td> R$${produtosFiltrados[i].preco} </td> 
        <td> ${produtosFiltrados[i].quantidade} </td> 
        <td> <button class="botao-editar" data-nome="${produtosFiltrados[i].nome}"  data-preco="${produtosFiltrados[i].preco}" data-quantidade="${produtosFiltrados[i].quantidade}">EDITAR</button></td>
      </tr>
      `;
  }
  return tabela;
 
}

botaoFiltrar.addEventListener("click", function() {
  const categoriaSelecionada = selectCategoriaSaldo.value;
  
    tabelaSaldo.innerHTML = ""; // Limpa os options anteriores
    tabelaSaldo.insertAdjacentHTML('beforeend', adicionaProdutosListaSaldo(categoriaSelecionada)); // Adiciona os novos options
})



form.addEventListener('submit', function (event) {
  event.preventDefault();


});