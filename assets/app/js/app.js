

async function fetchProdutos() {
    const response = await fetch('/stock-deps/getProdutos');
    const produtos = await response.json();
    preencherTabelaProdutos(produtos);
}

async function fetchCategorias() {
    const response = await fetch('/stock-deps/getCategorias');
    const categorias = await response.json();
    preencherCategorias(categorias);
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

function loadAllData() {
    fetchProdutos();
    fetchCategorias();
    fetchClientes();
    fetchEntradas();
    fetchSaidas();
}

window.onload = loadAllData;
