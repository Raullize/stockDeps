const BASE_URL = '/stockDeps/app';

let produtos = [];
let entradas = [];
let saidas = [];
let categorias = [];
let clientes = [];
let fornecedores = [];
let chartCategorias = null;

// Função para animar a contagem dos números
function animateCounter(element, finalValue) {
  const duration = 1500; // Duração da animação em milissegundos
  const startTime = performance.now();
  const startValue = 0;
  
  function updateCounter(currentTime) {
    const elapsedTime = currentTime - startTime;
    const progress = Math.min(elapsedTime / duration, 1);
    
    // Easing function para uma animação mais suave
    const easeOutQuad = progress => 1 - (1 - progress) * (1 - progress);
    const easedProgress = easeOutQuad(progress);
    
    const currentValue = Math.floor(startValue + (finalValue - startValue) * easedProgress);
    element.textContent = currentValue;
    
    if (progress < 1) {
      requestAnimationFrame(updateCounter);
    } else {
      element.textContent = finalValue; // Garante que o valor final seja exato
    }
  }
  
  requestAnimationFrame(updateCounter);
}

// Função para animar valores monetários
function animateMoneyCounter(element, finalValue) {
  const duration = 1500; // Duração da animação em milissegundos
  const startTime = performance.now();
  const startValue = 0;
  
  function updateCounter(currentTime) {
    const elapsedTime = currentTime - startTime;
    const progress = Math.min(elapsedTime / duration, 1);
    
    // Easing function para uma animação mais suave
    const easeOutQuad = progress => 1 - (1 - progress) * (1 - progress);
    const easedProgress = easeOutQuad(progress);
    
    const currentValue = startValue + (finalValue - startValue) * easedProgress;
    element.textContent = `R$ ${currentValue.toFixed(2)}`;
    
    if (progress < 1) {
      requestAnimationFrame(updateCounter);
    } else {
      element.textContent = `R$ ${finalValue.toFixed(2)}`; // Garante que o valor final seja exato
    }
  }
  
  requestAnimationFrame(updateCounter);
}

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
  try {
    await Promise.all([
      fetchAndUpdateData('produtos', atualizarProdutos),
      fetchAndUpdateData('entradas', atualizarEntradas),
      fetchAndUpdateData('saidas', atualizarSaidas),
      fetchAndUpdateData('clientes', atualizarClientes),
      fetchAndUpdateData('fornecedores', atualizarFornecedores),
      fetchCategorias(),
    ]);
    atualizarCaixas();
    atualizarProdutosMaisVendidos();
    atualizarGraficoCategorias(categorias);
    calcularValorEstoque();
    carregarProdutosBaixoEstoque();
  } catch (error) {
    console.error('Erro ao carregar os dados do dashboard:', error);
  }
}

async function fetchAndUpdateData(resource, updateFunction) {
  try {
    const response = await fetch(`${BASE_URL}/get${capitalize(resource)}`);
    const data = await response.json();
    updateFunction(data);
  } catch (error) {
    console.error(`Erro ao buscar ${resource}:`, error);
    updateFunction([]); // Atualiza com array vazia em caso de erro
  }
}

function atualizarProdutos(data) {
  produtos = data || [];
  const totalProdutos = produtos.length || 0;
  const produtosComEstoque = produtos.filter(p => p.quantidade > 0).length;
  const produtosBaixoEstoque = produtos.filter(p => p.quantidade > 0 && p.quantidade <= 1).length;
  const produtosSemEstoque = produtos.filter(p => p.quantidade == 0).length;
  
  // Animar contadores
  animateCounter(document.getElementById('total-produtos'), totalProdutos);
  animateCounter(document.getElementById('produtos-estoque'), produtosComEstoque);
  animateCounter(document.getElementById('estoque-baixo'), produtosBaixoEstoque);
  animateCounter(document.getElementById('produtos-sem-estoque'), produtosSemEstoque);
}

function atualizarEntradas(data) {
  entradas = data || [];
  animateCounter(document.getElementById('total-entradas'), entradas.length || 0);
}

function atualizarSaidas(data) {
  saidas = data || [];
  animateCounter(document.getElementById('total-saidas'), saidas.length || 0);
}

function atualizarClientes(data) {
  clientes = data || [];
  animateCounter(document.getElementById('total-clientes'), clientes.length || 0);
}

function atualizarFornecedores(data) {
  fornecedores = data || [];
  animateCounter(document.getElementById('total-fornecedores'), fornecedores.length || 0);
}

function atualizarCaixas() {
  atualizarProdutos(produtos);
  atualizarEntradas(entradas);
  atualizarSaidas(saidas);
  atualizarClientes(clientes);
  atualizarFornecedores(fornecedores);
}

function capitalize(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
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
        unidade_medida: produto ? produto.unidade_medida : '', // Adiciona unidade de medida
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
                ${parseFloat(Number(item.quantidade).toFixed(3))} ${item.unidade_medida} vendido(s) - ${item.vendas} venda(s)
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

function calcularLucroBruto(saidas) {
  if (saidas.length === 0) return 0; // Sem vendas, lucro bruto é zero
  return saidas.reduce((total, saida) => {
    const preco = parseFloat(saida.preco.toString().replace(',', '.')) || 0;
    const quantidade = parseFloat(saida.quantidade.toString().replace(',', '.')) || 0;
    return total + (preco * quantidade);
  }, 0);
}

function calcularLucroLiquido(entradas, saidas) {
  const lucroBruto = calcularLucroBruto(saidas);

  // Calcular o custo das mercadorias vendidas (CMV)
  // Vamos usar apenas as entradas que correspondem aos produtos vendidos
  let custoMercadoriaVendida = 0;
  const produtosVendidos = new Map(); // Mapa para rastrear produtos vendidos e suas quantidades

  // Primeiro, identificamos todos os produtos vendidos e suas quantidades
  saidas.forEach(saida => {
    const produtoId = saida.idProdutos;
    const quantidade = parseFloat(saida.quantidade.toString().replace(',', '.')) || 0;
    
    // Adicionamos ao mapa ou incrementamos a quantidade
    if (produtosVendidos.has(produtoId)) {
      produtosVendidos.set(produtoId, produtosVendidos.get(produtoId) + quantidade);
    } else {
      produtosVendidos.set(produtoId, quantidade);
    }
  });

  // Para cada produto vendido, calculamos o custo com base nas entradas
  produtosVendidos.forEach((quantidadeVendida, produtoId) => {
    // Filtrar entradas do produto atual
    const entradasDoProduto = entradas.filter(entrada => entrada.idProdutos == produtoId);
    
    if (entradasDoProduto.length > 0) {
      // Se houver entradas, calculamos o preço médio de entrada
      const valorTotalEntradas = entradasDoProduto.reduce((total, entrada) => {
        const preco = parseFloat(entrada.preco.toString().replace(',', '.')) || 0;
        return total + preco;
      }, 0);
      
      const precoMedio = valorTotalEntradas / entradasDoProduto.length;
      custoMercadoriaVendida += precoMedio * quantidadeVendida;
    } else {
      // Se não houver entradas registradas, estimamos com base no preço atual do produto
      // (Isso é uma aproximação, idealmente sempre teríamos registros de entrada)
      // Neste caso, assumimos lucro zero para este produto
    }
  });

  return lucroBruto - custoMercadoriaVendida;
}

async function calcularValorEstoque() {
  try {
    const produtosResponse = await fetch(`${BASE_URL}/getProdutos`);
    const entradasResponse = await fetch(`${BASE_URL}/getEntradas`);
    const produtos = await produtosResponse.json();
    const entradas = await entradasResponse.json();

    let valorTotal = 0;

    produtos.forEach(produto => {
      // Buscamos as entradas para este produto
      const entradasProduto = entradas.filter(entrada => entrada.idProdutos == produto.id);
      
      if (entradasProduto.length > 0) {
        // Se houver entradas, usamos o preço médio de entrada
        const valorTotalEntradas = entradasProduto.reduce((total, entrada) => {
          return total + (parseFloat(entrada.preco.toString().replace(',', '.')) || 0);
        }, 0);
        
        const precoMedio = valorTotalEntradas / entradasProduto.length;
        valorTotal += precoMedio * parseFloat(produto.quantidade.toString().replace(',', '.') || 0);
      } else {
        // Se não houver entradas, usamos o preço de saída como estimativa
        valorTotal += parseFloat(produto.preco.toString().replace(',', '.') || 0) * parseFloat(produto.quantidade.toString().replace(',', '.') || 0);
      }
    });

    // Atualizar com animação
    animateMoneyCounter(document.getElementById('valor-estoque'), valorTotal);
  } catch (error) {
    console.error('Erro ao calcular valor do estoque:', error);
    document.getElementById('valor-estoque').textContent = 'R$ 0,00';
  }
}

function calcularLucroPorPeriodo(periodo) {
  const now = new Date(); // Data atual

  // Define o intervalo com base no período selecionado
  let dataInicio = new Date();
  switch (periodo) {
    case 'dia':
      dataInicio.setDate(now.getDate() - 1); // Último dia
      break;
    case 'semana':
      dataInicio.setDate(now.getDate() - 7); // Última semana
      break;
    case 'duasSemanas':
      dataInicio.setDate(now.getDate() - 14); // Últimas 2 semanas
      break;
    case 'mes':
      dataInicio.setMonth(now.getMonth() - 1); // Último mês
      break;
    default:
      dataInicio = null; // Período total
  }

  // Converte strings de `created_at` para objetos Date e filtra os dados
  const entradasFiltradas = dataInicio
    ? entradas.filter((entrada) => new Date(entrada.created_at) >= dataInicio)
    : entradas;

  const saidasFiltradas = dataInicio
    ? saidas.filter((saida) => new Date(saida.created_at) >= dataInicio)
    : saidas;

  // Recalcula os lucros com os dados filtrados
  const lucroBruto = calcularLucroBruto(saidasFiltradas);
  const lucroLiquido = calcularLucroLiquido(entradasFiltradas, saidasFiltradas);

  // Atualiza os valores no HTML com animação
  animateMoneyCounter(document.getElementById('lucro-bruto'), lucroBruto);
  animateMoneyCounter(document.getElementById('lucro-liquido'), lucroLiquido);
}

// Adiciona o evento ao seletor de período
document.getElementById('periodo').addEventListener('change', (event) => {
  const periodo = event.target.value;
  calcularLucroPorPeriodo(periodo);
});

// Chamada inicial para calcular com o período "total"
window.onload = async () => {
  await loadDashboardData();
  calcularLucroPorPeriodo('total'); // Exibe lucro total ao carregar a página
  carregarProdutosBaixoEstoque();
  calcularValorEstoque()
};

async function carregarProdutosBaixoEstoque() {
  try {
    const response = await fetch(`${BASE_URL}/getProdutos`);
    const produtos = await response.json();

    const produtosBaixoEstoque = produtos.filter(p =>
      (p.unidade_medida === 'KG' && p.quantidade <= 1) ||
      (p.unidade_medida === 'UN' && p.quantidade <= 5)
    );

    const lista = document.getElementById("lista-estoque-baixo");
    lista.innerHTML = ""; // Limpa a lista antes de adicionar novos itens

    if (produtosBaixoEstoque.length === 0) {
      lista.innerHTML = '<li class="list-group-item text-center text-success">Todos os produtos estão em estoque!</li>';
      return;
    }

    produtosBaixoEstoque.forEach(produto => {
      const item = document.createElement("li");
      item.className = `list-group-item d-flex justify-content-between align-items-center ${produto.quantidade === 0 ? 'list-group-item-danger' : 'list-group-item-warning'} fw-bold`;
      item.style.cursor = 'pointer';
      item.innerHTML = `
              <span>${produto.nome} (Qtd: ${produto.quantidade} ${produto.unidade_medida})</span>
              <span class="badge bg-${produto.quantidade === 0 ? 'danger' : 'warning'} rounded-pill p-2">
                  ${produto.quantidade === 0 ? 'Sem estoque' : 'Estoque baixo'}
              </span>
          `;
      
      // Adicionar evento de clique para direcionar para a página de estoque
      item.addEventListener('click', () => {
        window.location.href = `${BASE_URL}/estoque`;
      });
      
      lista.appendChild(item);
    });
  } catch (error) {
    console.error("Erro ao carregar produtos de estoque baixo:", error);
  }
}

// Iniciar carregamento quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
  loadDashboardData();
});

// Alterar a função calcularLucro para usar calcularLucroPorPeriodo
async function calcularLucro() {
  // Esta função agora irá simplesmente chamar calcularLucroPorPeriodo
  // com o período atualmente selecionado
  const periodo = document.getElementById('periodo').value;
  calcularLucroPorPeriodo(periodo);
}