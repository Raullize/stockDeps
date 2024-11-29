const BASE_URL = '/stockDeps';

async function fetchProdutos() {
  const response = await fetch(`${BASE_URL}/getProdutos`);
  produtos = await response.json();
}

async function fetchCategorias() {
  const response = await fetch(`${BASE_URL}/getCategorias`);
  categorias = await response.json();
}

async function fetchClientes() {
  const response = await fetch(`${BASE_URL}/getClientes`);
  const clientes = await response.json();
}

async function fetchEntradas() {
  const response = await fetch(`${BASE_URL}/getEntradas`);
  const entradas = await response.json();
}

async function fetchSaidas() {
  const response = await fetch(`${BASE_URL}/getSaidas`);
  const saidas = await response.json();
}

// Dados iniciais
const lucroPorPeriodo = {
  diario: [300, 400, 350],
  semanal: [1200, 1350, 1500],
  mensal: [5000, 7000, 6000],
  anual: [70000, 85000, 95000],
};

const atualizarDashboard = (periodo) => {
  const lucro = lucroPorPeriodo[periodo].reduce((acc, val) => acc + val, 0);
  document.getElementById('lucro-total').innerText = `R$ ${lucro.toLocaleString('pt-BR')}`;
  document.getElementById('periodo-lucro').innerText = periodo.charAt(0).toUpperCase() + periodo.slice(1);
};

// Filtro de período
document.getElementById('filtro-periodo').addEventListener('change', (e) => {
  const periodo = e.target.value;
  atualizarDashboard(periodo);
});

// Gráfico de Lucro
const ctxLucro = document.getElementById('chart-lucro').getContext('2d');
new Chart(ctxLucro, {
  type: 'line',
  data: {
    labels: ['Janeiro', 'Fevereiro', 'Março'],
    datasets: [{
      label: 'Lucro (R$)',
      data: lucroPorPeriodo.mensal,
      borderColor: '#007bff',
      backgroundColor: 'rgba(0, 123, 255, 0.2)',
    }]
  },
});

// Gráfico de Categorias
const ctxCategorias = document.getElementById('chart-categorias').getContext('2d');
new Chart(ctxCategorias, {
  type: 'doughnut',
  data: {
    labels: ['Farinhas', 'Castanhas', 'Sementes'],
    datasets: [{
      label: 'Produtos',
      data: [40, 30, 20],
      backgroundColor: ['#007bff', '#28a745', '#ffc107']
    }]
  }
});