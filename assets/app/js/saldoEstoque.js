const tabelaSaldo = document.getElementById("tabela-saldo");
const botaoFiltrar = document.getElementById("botao-filtrar");
const formSaldo   = document.getElementById('form-saldo');
const selectCategoriaSaldo = document.getElementById('dropdown-categorias-saldo');


function adicionaProdutosListaSaldo(categoriaSelecionada) {
  let produtosFiltrados = [];
  let idCategorias;

  if (categoriaSelecionada === "Lava Roupas") {
    idCategorias = 10;
  } else if (categoriaSelecionada === "Lava Louças") {
    idCategorias = 20;
  } else if (categoriaSelecionada === "Lava Carros") {
    idCategorias = 30;
  } else if (categoriaSelecionada === "Limpeza de Ambiente") {
    idCategorias = 40;
  }else if (categoriaSelecionada === "Outros") {
    idCategorias = 50;
  }
  produtosFiltrados = produtos.filter(produto => produto.idCategoria === idCategorias);

  let tabela = "";
  for (let i = 0; i < produtosFiltrados.length; i++) {
    tabela += `
      <tr> 
        <td> ${produtosFiltrados[i].nome} </td> 
        <td> R$${produtosFiltrados[i].preco} </td> 
        <td> ${produtosFiltrados[i].quantidade} </td> 
        <td> <button class="botao-editar" data-nome="${produtosFiltrados[i].nome}"  data-preco="${produtosFiltrados[i].preco}" data-quantidade="${produtosFiltrados[i].quantidade}" data-descricao="${produtosFiltrados[i].descricao}">EDITAR</button></td>
      </tr>
      `;
  }
  return tabela;
 
}

botaoFiltrar.addEventListener("click", function() {
  const categoriaSelecionada = selectCategoriaSaldo.value;
    if(produtos.length > 0) {
    tabelaSaldo.innerHTML = ""; // Limpa os options anteriores
    tabelaSaldo.insertAdjacentHTML('beforeend', adicionaProdutosListaSaldo(categoriaSelecionada)); // Adiciona os novos options
    }  
  })



formSaldo.addEventListener('submit', function (event) {
  event.preventDefault();


});