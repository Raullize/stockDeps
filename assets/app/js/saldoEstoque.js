const tabelaSaldo = document.getElementById("tabela-saldo");
const botaoFiltrar = document.getElementById("botao-filtrar");
const formSaldo = document.getElementById('form-saldo');
const selectCategoriaSaldo = document.getElementById('dropdown-categorias-saldo');



function adicionaProdutosListaSaldo(categoriaSelecionada) {
  let produtosFiltrados = [];
  let idCategorias;

  if (categoriaSelecionada == 10) {
    idCategorias = 10;
  } else if (categoriaSelecionada == 20) {
    idCategorias = 20;
  } else if (categoriaSelecionada == 30) {
    idCategorias = 30;
  } else if (categoriaSelecionada == 40) {
    idCategorias = 40;
  } else if (categoriaSelecionada == 50) {
    idCategorias = 50;
  }
  produtosFiltrados = produtos.filter(produto => produto.idCategoria === idCategorias);

  let tabela = "";

  for (let i = 0; i < produtosFiltrados.length; i++) {
    
      
    tabela += `
      <tr> 
        <td> ${produtosFiltrados[i].nome} </td> 
        <td> R$${produtosFiltrados[i].preco} </td> 
        <td> a</td> 
        <td> 
          <button class="botao-editar mx-2" data-nome="${produtosFiltrados[i].nome}"  data-preco="${produtosFiltrados[i].preco}" data-quantidade="${produtosFiltrados[i].quantidade}" data-descricao="${produtosFiltrados[i].descricao}">
          EDITAR</button>
          <button class="botao-deletar">DELETAR</button>
        </td>
      </tr>
      `;}
       return tabela;
  }
  
 



botaoFiltrar.addEventListener("click", function () {
  const categoriaSelecionada = selectCategoriaSaldo.value;
  if (produtos.length > 0) {
    tabelaSaldo.innerHTML = ""; // Limpa os options anteriores
    tabelaSaldo.insertAdjacentHTML('beforeend', adicionaProdutosListaSaldo(categoriaSelecionada,entradas,saidas)); // Adiciona os novos options
  }
})



formSaldo.addEventListener('submit', function (event) {
  event.preventDefault();
});