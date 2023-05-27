const tabelaProdutos = document.getElementById("tabela-produtos");
const tabelaEntradas = document.getElementById("tabela-entradas"); 
const tabelaSaidas = document.getElementById("tabela-saidas"); 

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

function adicionaProdutosEntradas(entradas, produtos) {
  let tr = '';
  for (let i = 0; i < entradas.length; i++) {
    for (let j = 0; j < produtos.length; j++) {
      if (entradas[i].idProdutos == produtos[j].id) {
        var nomeProduto = produtos[j].nome;
        tr += `
          <tr> 
            <td>${nomeProduto}</td> 
            <td>${entradas[i].quantidade}</td> 
            <td>
              <button class="botao-editar" data-nome="${nomeProduto}" data-preco="${entradas[i].preco}" data-quantidade="${entradas[i].quantidade}">EDITAR</button>
            </td>
          </tr>
        `;
      }
    }
  }
  return tr;
}


function adicionaProdutosSaidas(saidas, produtos, clientes) {
  let tr = '';
  for (let i = 0; i < saidas.length; i++) {
    // Busca o nome do cliente a partir do seu id
    let clienteAtual = clientes.find(c => c.id === saidas[i].idClientes);
    let nomeCliente = clienteAtual ? clienteAtual.nome : '';

    for (let j = 0; j < produtos.length; j++) {
      if (saidas[i].idProdutos == produtos[j].id) {
        var nomeProduto = produtos[j].nome;
        tr += `
          <tr> 
            <td> ${nomeProduto} </td> 
            <td> ${saidas[i].quantidade} </td> 
            <td> ${nomeCliente} </td> 
            <td> 
            <td> <button class="botao-editar" data-nome="${nomeProduto}"  data-preco="${saidas[i].preco}" data-quantidade="${saidas[i].quantidade}" 
            data-quantidade="${nomeCliente}">EDITAR</button></td>
            </td> 
          </tr>
        `;
      }
    }
  }
  return tr;
}


document.addEventListener("DOMContentLoaded", function () {
  tabelaSaidas.insertAdjacentHTML('beforeend',adicionaProdutosSaidas(saidas, produtos, clientes));
  tabelaEntradas.insertAdjacentHTML('beforeend', adicionaProdutosEntradas(entradas, produtos));
  if(produtos.length > 0) {
  produtos.forEach(function (produtos) {
    tabelaProdutos.insertAdjacentHTML('beforeend', adicionaProdutosLista(produtos));
    
  });
  }
});



