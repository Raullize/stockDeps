const lavaRoupasQtd = document.getElementById('lava-roupas-qtd');
const lavaLoucasQtd = document.getElementById('lava-loucas-qtd');
const lavaCarrosQtd = document.getElementById('lava-carros-qtd');
const limpezaAmbienteQtd = document.getElementById('limpeza-ambiente-qtd');
const totalProdutos = document.getElementById('total-produtos-qtd');

const qtdClientes = document.getElementById('qtd-clientes');


function adicionaQtdProdutos(produtos) {
    lavaRoupasQtd.innerHTML =  "Lava roupas: "  + produtos.filter(produto => produto.idCategoria === 1).length;
    lavaLoucasQtd.innerHTML =   "Lava louças: "  + produtos.filter(produto => produto.idCategoria === 2).length;
    lavaCarrosQtd.innerHTML =    "Lava carros: "  +produtos.filter(produto => produto.idCategoria === 3).length;
    limpezaAmbienteQtd.innerHTML =  "Limpeza ambiente: "  +  produtos.filter(produto => produto.idCategoria === 4).length;
    totalProdutos.innerHTML = "Total: " +produtos.length
  }

function contaClientes(clientes) {
    qtdClientes.innerHTML = clientes.length;
}

 adicionaQtdProdutos(produtos)
 contaClientes(clientes)

