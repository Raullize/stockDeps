const lavaRoupasQtd = document.getElementById('lava-roupas-qtd');
const lavaLoucasQtd = document.getElementById('lava-loucas-qtd');
const lavaCarrosQtd = document.getElementById('lava-carros-qtd');
const limpezaAmbienteQtd = document.getElementById('limpeza-ambiente-qtd');
const outrosQtd = document.getElementById('outros-qtd');

const totalProdutos = document.getElementById('total-produtos-qtd');

const qtdClientes = document.getElementById('qtd-clientes');
const qtdVendas = document.getElementById('qtd-vendas');
const rankingCategorias = document.getElementById('ranking-categorias'); 

function adicionaQtdProdutos(produtos) {
  if (produtos) {
    lavaRoupasQtd.innerHTML = "Lava roupas: " + produtos.filter(produto => produto.idCategoria === 10).length;
    lavaLoucasQtd.innerHTML = "Lava louças: " + produtos.filter(produto => produto.idCategoria === 20).length;
    lavaCarrosQtd.innerHTML = "Lava carros: " + produtos.filter(produto => produto.idCategoria === 30).length;
    limpezaAmbienteQtd.innerHTML = "Limpeza ambiente: " + produtos.filter(produto => produto.idCategoria === 40).length;
    outrosQtd.innerHTML = "Outros: " + produtos.filter(produto => produto.idCategoria === 50).length;
    totalProdutos.innerHTML = "Total: " + produtos.length
  }
}

function adicionarRankingCategorias(saidas,produtos) {
  const lavaRoupas = idCategorias === 10 ? idCategorias : null;
  const lavaLoucas = idCategorias === 20 ? idCategorias : null;
  const lavaCarros = idCategorias === 30 ? idCategorias : null;
  const limpezaAmbiente = idCategorias === 40 ? idCategorias : null;
  const outros = idCategorias === 50 ? idCategorias : null;
  if (saidas) {
    rankingLavaRoupas = "Lava roupas: " + saidas.filter(saida => saida.idProdutos === lavaRoupas).length;
    rankinglavaLoucas = "Lava louças: " + saidas.filter(saida => saida.idProdutos === lavaLoucas).length;
    rankinglavaCarros = "Lava carros: " + saidas.filter(saida => saida.idProdutos === lavaCarros).length;
    rankinglimpezaAmbiente = "Limpeza ambiente: " + saidas.filter(saida => saida.idProdutos === limpezaAmbiente).length;
    rankingoutros = "Outros: " + saidas.filter(saida => saida.idProdutos === outros).length;
    rankingCategorias.innerHTML = "Total: " + produtos.length
  }
}

function adicionarRankingCategoriasTeste(saidas, produtos) {
  const categorias = [
    { id: 10, nome: 'Lava roupas' },
    { id: 20, nome: 'Lava louças' },
    { id: 30, nome: 'Lava carros' },
    { id: 40, nome: 'Limpeza ambiente' },
    { id: 50, nome: 'Outros' }
  ];
  
  const categoriasOrdenadas = categorias.sort((a, b) => {
    const qtdA = saidas.filter(saida => saida.idProdutos === a.id).length;
    const qtdB = saidas.filter(saida => saida.idProdutos === b.id).length;
    return qtdB - qtdA;
  });
  
  let ranking = '';
  for (let i = 0; i < 3 && i < categoriasOrdenadas.length; i++) {
    ranking += categoriasOrdenadas[i].nome + ': ' + saidas.filter(saida => saida.idProdutos === categoriasOrdenadas[i].id).length + '<br>';
  }
  
  rankingCategorias.innerHTML = ranking;
}


function contaClientes(clientes) {
  if (clientes) {
    qtdClientes.innerHTML = clientes.length;
  }
}

function contaVendas(saidas) {
  if (saidas) {
    qtdVendas.innerHTML = saidas.length;
  }
}


adicionaQtdProdutos(produtos)

contaClientes(clientes)
