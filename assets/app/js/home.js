const lavaRoupasQtd = document.getElementById('lava-roupas-qtd');
const lavaLoucasQtd = document.getElementById('lava-loucas-qtd');
const lavaCarrosQtd = document.getElementById('lava-carros-qtd');
const limpezaAmbienteQtd = document.getElementById('limpeza-ambiente-qtd');
const outrosQtd = document.getElementById('outros-qtd');

const totalProdutos = document.getElementById('total-produtos-qtd');

const qtdClientes = document.getElementById('qtd-clientes');

function adicionaQtdProdutos(produtos) {
  if (produtos){
    lavaRoupasQtd.innerHTML =  "Lava roupas: "  + produtos.filter(produto => produto.idCategoria === 10).length;
    lavaLoucasQtd.innerHTML =   "Lava louças: "  + produtos.filter(produto => produto.idCategoria === 20).length;
    lavaCarrosQtd.innerHTML =    "Lava carros: "  +produtos.filter(produto => produto.idCategoria === 30).length;
    limpezaAmbienteQtd.innerHTML =  "Limpeza ambiente: "  +  produtos.filter(produto => produto.idCategoria === 40).length;
    outrosQtd.innerHTML =  "Outros: "  +  produtos.filter(produto => produto.idCategoria === 50).length;
    totalProdutos.innerHTML = "Total: " +produtos.length}
  }

function contaClientes(clientes) {
  if(clientes){
    qtdClientes.innerHTML = clientes.length;
  }
}

 adicionaQtdProdutos(produtos)
 
contaClientes(clientes)
