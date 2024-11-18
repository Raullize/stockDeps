async function fetchProdutos() {
  const response = await fetch('/stock-deps/getProdutos');
  produtos = await response.json();
}

async function fetchCategorias() {
  const response = await fetch('/stock-deps/getCategorias');
  categorias = await response.json();
}

async function fetchClientes() {
  const response = await fetch('/stock-deps/getClientes');
  const clientes = await response.json();
}

async function fetchEntradas() {
  const response = await fetch('/stock-deps/getEntradas');
  const entradas = await response.json();
}

async function fetchSaidas() {
  const response = await fetch('/stock-deps/getSaidas');
  const saidas = await response.json();
}

async function loadDashboardData() {
  try {
      // Carrega os dados dos endpoints
      const [produtosRes, categoriasRes, clientesRes, entradasRes, saidasRes] = await Promise.all([
          fetch("/stock-deps/getProdutos"),
          fetch("/stock-deps/getCategorias"),
          fetch("/stock-deps/getClientes"),
          fetch("/stock-deps/getEntradas"),
          fetch("/stock-deps/getSaidas"),
      ]);

      // Converte cada resposta para JSON
      const [produtos, categorias, clientes, entradas, saidas] = await Promise.all([
          produtosRes.json(),
          categoriasRes.json(),
          clientesRes.json(),
          entradasRes.json(),
          saidasRes.json(),
      ]);

      // Manipula os dados e trata undefined
      const totalProdutos = produtos?.length || 0;
      const totalCategorias = categorias?.length || 0;
      const totalClientes = clientes?.length || 0;
      const totalEntradas = entradas?.reduce((total, item) => total + item.valor, 0) || 0;
      const totalSaidas = saidas?.reduce((total, item) => total + item.valor, 0) || 0;

      // Atualiza o dashboard com os valores obtidos
      document.getElementById("totalProdutos").textContent = totalProdutos;
      document.getElementById("totalCategorias").textContent = totalCategorias;
      document.getElementById("totalClientes").textContent = totalClientes;
      document.getElementById("totalEntradas").textContent = `R$ ${totalEntradas.toFixed(2)}`;
      document.getElementById("totalSaidas").textContent = `R$ ${totalSaidas.toFixed(2)}`;
  } catch (error) {
      console.error("Erro ao carregar os dados do dashboard:", error);
  }
}

function atualizarLucro() {
  const periodo = document.getElementById("lucroPeriodo").value;

  let lucro = 0;
  
  if (periodo === "dia") {
      lucro = 200;  
  } else if (periodo === "semana") {
      lucro = 1500;  
  } else if (periodo === "mes") {
      lucro = 6000;  
  }
  
  document.getElementById("lucroPeriodoValor").textContent = `R$ ${lucro.toFixed(2)}`;
}

// Chama a função para carregar os dados quando a página carrega
document.addEventListener("DOMContentLoaded", loadDashboardData);

