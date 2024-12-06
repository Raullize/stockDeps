const BASE_URL = '/stockDeps';

let produtos = [];
let entradas = [];
let saidas = [];
let categorias = [];
let clientes = [];
let fornecedores = [];
let chartCategorias = null;

async function fetchProdutos() {
  const response = await fetch(`${BASE_URL}/getProdutos`);
  produtos = await response.json();
}

async function fetchEntradas() {
  const response = await fetch(`${BASE_URL}/getEntradas`);
  entradas = await response.json();  // Defina a variável `entradas` no escopo global
  console.log(entradas); 
  calcularLucro(entradas, saidas);
}

async function fetchSaidas() {
  const response = await fetch(`${BASE_URL}/getSaidas`);
  saidas = await response.json(); 
  calcularLucro(entradas, saidas);
}

async function fetchCategorias() {
  const response = await fetch(`${BASE_URL}/getCategorias`);
  categorias = await response.json();
  atualizarGraficoCategorias(categorias);
}

async function fetchClientes() {
  const response = await fetch(`${BASE_URL}/getClientes`);
  clientes = await response.json();
  preencherClientes(clientes);
}

async function fetchFornecedores() {
  const response = await fetch(`${BASE_URL}/getFornecedores`);
  fornecedores = await response.json();
  preencherFornecedores(fornecedores);
}

async function loadDashboardData() {
  await fetchProdutos();
  await fetchEntradas();
  await fetchSaidas();
  await fetchCategorias();
  await fetchClientes();
  await fetchFornecedores();
  atualizarCaixas(produtos, entradas, saidas);
  atualizarProdutosMaisVendidos();
  atualizarGraficoCategorias(categorias);
}

function preencherClientes(clientes) {
  const totalClientes = clientes.length || 0; // Garante que será 0 se o array estiver vazio
  document.getElementById('total-clientes').textContent = totalClientes;
}

function preencherFornecedores(fornecedores) {
  const totalFornecedores = fornecedores.length || 0; // Garante que será 0 se o array estiver vazio
  document.getElementById('total-fornecedores').textContent = totalFornecedores;
}


function atualizarCaixas(produtos, entradas, saidas) {
  const totalProdutos = produtos.length;
  const produtosEmEstoque = produtos.filter(produto => produto.quantidade > 0).length;
  const estoqueBaixo = produtos.filter(produto => produto.quantidade > 0 && produto.quantidade < 5).length;
  const semEstoque = produtos.filter(produto => produto.quantidade === 0).length;
  const totalEntradas = entradas.length || 0;
  const totalSaidas = saidas.length || 0;


  document.querySelector(".card-title + h3").textContent = totalProdutos;
  document.querySelector(".bg-success h3").textContent = produtosEmEstoque;
  document.querySelector(".bg-warning h3").textContent = estoqueBaixo;
  document.querySelector(".bg-danger h3").textContent = semEstoque;
  document.querySelector(".bg-info h3").textContent = totalEntradas;
  document.querySelector(".bg-light h3").textContent = totalSaidas;
}

function atualizarProdutosMaisVendidos() {
  const vendasPorProduto = saidas.reduce((mapa, saida) => {
    if (!mapa[saida.idProdutos]) {
      mapa[saida.idProdutos] = { quantidade: 0, vendas: 0 };
    }
    mapa[saida.idProdutos].quantidade += saida.quantidade;
    mapa[saida.idProdutos].vendas += 1;
    return mapa;
  }, {});

  const maisVendidos = Object.entries(vendasPorProduto)
    .map(([idProduto, dados]) => {
      const produto = produtos.find(p => p.id == idProduto);
      return {
        nome: produto ? produto.nome : 'Desconhecido',
        quantidade: dados.quantidade,
        vendas: dados.vendas
      };
    })
    .sort((a, b) => b.quantidade - a.quantidade)
    .slice(0, 5);

  const produtosMaisVendidosList = document.querySelector("#produtos-mais-vendidos");
  produtosMaisVendidosList.innerHTML = maisVendidos
    .map(item => `
          <li class="list-group-item">
              ${item.nome}
              <span class="badge bg-success float-end">
                  ${item.quantidade} vendido(s) - ${item.vendas} venda(s)
              </span>
          </li>
      `)
    .join("");
}

function atualizarGraficoCategorias(categorias) {
  if (!categorias || categorias.length === 0) {
    console.error("Categorias inválidas ou não carregadas.");
    return;
  }

  const categoriasContagem = produtos.reduce((mapa, produto) => {
    if (!mapa[produto.idCategoria]) {
      mapa[produto.idCategoria] = 0;
    }
    mapa[produto.idCategoria] += 1;
    return mapa;
  }, {});

  const categoriasLabels = Object.keys(categoriasContagem).map(id => {
    const categoria = categorias.find(c => c.id == id);
    return categoria ? categoria.nome : `Categoria ${id}`;
  });

  const categoriasData = Object.values(categoriasContagem);

  // Gerar cores distintas usando HSL
  const gerarCoresDistintas = (quantidade) => {
    const cores = [];
    const intervalo = 360 / quantidade; // Espaçamento igual no espectro de cores
    for (let i = 0; i < quantidade; i++) {
      const hue = Math.round(i * intervalo); // Variar o tom (hue)
      cores.push(`hsl(${hue}, 70%, 60%)`); // Saturação fixa e brilho médio
    }
    return cores;
  };

  const categoriasCores = gerarCoresDistintas(categoriasLabels.length);

  // Verificar se já existe um gráfico e destruí-lo antes de criar um novo
  if (chartCategorias) {
    chartCategorias.destroy();
  }

  const ctxCategorias = document.getElementById("chart-categorias").getContext("2d");
  chartCategorias = new Chart(ctxCategorias, {
    type: "doughnut",
    data: {
      labels: categoriasLabels,
      datasets: [{
        data: categoriasData,
        backgroundColor: categoriasCores,
      }],
    },
    options: {
      plugins: {
        legend: {
          position: 'bottom',
        },
      },
    },
  });
}

async function calcularLucro() {
  const periodo = document.getElementById('periodo').value;

  const entradasFiltradas = filtrarPorPeriodo(entradas, periodo);
  const saidasFiltradas = filtrarPorPeriodo(saidas, periodo);

  // Lucro bruto depende apenas de saídas
  const lucroBruto = calcularLucroBruto(saidasFiltradas);

  // Lucro líquido = lucro bruto - custos (entradas)
  const lucroLiquido = calcularLucroLiquido(entradasFiltradas, saidasFiltradas);

  document.getElementById('lucro-bruto').textContent = `R$ ${lucroBruto.toFixed(2)}`;
  document.getElementById('lucro-liquido').textContent = `R$ ${lucroLiquido.toFixed(2)}`;
}


function filtrarPorPeriodo(transacoes, periodo) {
  const agora = new Date();
  let dataLimite;

  switch (periodo) {
      case 'dia':
          dataLimite = new Date(agora.setDate(agora.getDate() - 1)); 
          break;
      case 'semana':
          dataLimite = new Date(agora.setDate(agora.getDate() - 7)); 
          break;
      case 'mes':
          dataLimite = new Date(agora.setMonth(agora.getMonth() - 1)); 
          break;
      case 'ano':
          dataLimite = new Date(agora.setFullYear(agora.getFullYear() - 1)); 
          break;
      default:
          return transacoes; 
  }

  return transacoes.filter(transacao => new Date(transacao.data) >= dataLimite);
}


function calcularLucroBruto(saidas) {
  if (saidas.length === 0) return 0; // Sem vendas, lucro bruto é zero
  return saidas.reduce((total, saida) => {
    const preco = parseFloat(saida.preco) || 0;
    const quantidade = parseInt(saida.quantidade) || 0;
    return total + (preco * quantidade);
  }, 0);
}

function calcularLucroLiquido(entradas, saidas) {
  const lucroBruto = calcularLucroBruto(saidas);

  const totalEntradas = entradas.reduce((total, entrada) => {
    const preco = parseFloat(entrada.preco) || 0;
    const quantidade = parseInt(entrada.quantidade) || 0;
    return total + (preco * quantidade);
  }, 0);

  return lucroBruto - totalEntradas; // Receita - Custo
}

window.onload = async () => {
  await loadDashboardData();
  calcularLucro(); 
};
