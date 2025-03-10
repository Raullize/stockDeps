const BASE_URL = '/stockDeps/app';

const itensPorPaginaClientes = 8;   // Quantidade de clientes por página
const maxBotoesPaginacaoClientes = 5;
let paginaAtualClientes = 1;        // Sempre começar na página 1

let clientes = [];
let produtos = [];
let saidas = [];
let categorias = [];

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
    clientes = await response.json();
    clientesFiltrados = [...clientes];
    aplicarOrdenacaoClientes();
    mostrarPaginaClientes(paginaAtualClientes);
    buscarCliente()
}

async function fetchEntradas() {
    const response = await fetch(`${BASE_URL}/getEntradas`);
    const entradas = await response.json();
}

async function fetchSaidas() {
    const response = await fetch(`${BASE_URL}/getSaidas`);
    saidas = await response.json(); // Preenche a variável global saídas
    console.log(saidas)
}

function loadAllData() {
    fetchProdutos();
    fetchCategorias();
    fetchClientes();
    fetchEntradas();
    fetchSaidas();
}

document.addEventListener("DOMContentLoaded", () => {
    loadAllData();
});

function preencherTabelaClientes(clientesPaginados) {
    const tabela = document.querySelector("#tabelaClientes tbody");
    tabela.innerHTML = "";

    clientesPaginados.forEach(cliente => {
        const linha = document.createElement("tr");
        linha.innerHTML = `
            <td>${cliente.nome}</td>
            <td>${cliente.cpf}</td>
            <td>${cliente.celular}</td>
            <td class="text-center">
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-primary action-btn" onclick="abrirModalEditarCliente(${cliente.id})" title="Editar cliente">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger action-btn" onclick="openModalExcluir(${cliente.id})" title="Excluir cliente">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <button class="btn btn-success action-btn" onclick="abrirModalHistorico(${cliente.id})" title="Histórico de compras">
                        <i class="fas fa-history"></i>
                    </button>
                </div>
            </td>
        `;
        tabela.appendChild(linha);
    });
}

function mostrarPaginaClientes(pagina) {
    paginaAtualClientes = pagina;

    const inicio = (pagina - 1) * itensPorPaginaClientes;
    const fim = inicio + itensPorPaginaClientes;

    const clientesPaginados = clientesFiltrados.slice(inicio, fim);

    if (clientesPaginados.length === 0 && paginaAtualClientes > 1) {
        // Retroceder uma página se a atual ficar vazia após a exclusão
        mostrarPaginaClientes(paginaAtualClientes - 1);
        return;
    }

    preencherTabelaClientes(clientesPaginados);
    atualizarPaginacaoClientes();
}

function atualizarPaginacaoClientes() {
    const totalPaginas = Math.ceil(clientesFiltrados.length / itensPorPaginaClientes);
    const pagination = document.getElementById('paginationClientes');
    pagination.innerHTML = '';

    const maxLeft = Math.max(paginaAtualClientes - Math.floor(maxBotoesPaginacaoClientes / 2), 1);
    const maxRight = Math.min(maxLeft + maxBotoesPaginacaoClientes - 1, totalPaginas);

    if (paginaAtualClientes > 1) {
        const prevLi = document.createElement('li');
        prevLi.classList.add('page-item');
        prevLi.innerHTML = `<a class="page-link" href="#">Anterior</a>`;
        prevLi.onclick = () => mostrarPaginaClientes(paginaAtualClientes - 1);
        pagination.appendChild(prevLi);
    }

    for (let i = maxLeft; i <= maxRight; i++) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        if (i === paginaAtualClientes) {
            li.classList.add('active');
        }

        const a = document.createElement('a');
        a.classList.add('page-link');
        a.textContent = i;
        a.onclick = () => mostrarPaginaClientes(i);
        li.appendChild(a);
        pagination.appendChild(li);
    }

    if (paginaAtualClientes < totalPaginas) {
        const nextLi = document.createElement('li');
        nextLi.classList.add('page-item');
        nextLi.innerHTML = `<a class="page-link" href="#">Próximo</a>`;
        nextLi.onclick = () => mostrarPaginaClientes(paginaAtualClientes + 1);
        pagination.appendChild(nextLi);
    }
}

function buscarCliente() {
    const inputBuscarCliente = document.getElementById("buscarCliente");

    inputBuscarCliente.addEventListener("input", function () {
        const termoBusca = inputBuscarCliente.value.toLowerCase();

        // Atualiza clientesFiltrados com base no termo de busca
        clientesFiltrados = clientes.filter(cliente =>
            cliente.nome.toLowerCase().includes(termoBusca) ||
            cliente.cpf.toLowerCase().includes(termoBusca)
        );

        // Reseta a paginação para a primeira página e exibe os resultados
        paginaAtualClientes = 1;
        mostrarPaginaClientes(paginaAtualClientes);
    });
}

function abrirModalEditarCliente(id) {
    console.log(clientes)
    const cliente = clientes.find(c => c.id === id);
    if (!cliente) {
        alert("Cliente não encontrado");
        return;
    }

    document.getElementById("idClienteUpdate").value = id;
    document.getElementById("editarNomeCliente").value = cliente.nome;
    document.getElementById("editarCpfCliente").value = cliente.cpf;
    document.getElementById("editarTelefoneCliente").value = cliente.celular;

    const modalEditar = new bootstrap.Modal(document.getElementById("modalEditarCliente"));
    modalEditar.show();
}
function abrirModalHistorico(id) {
    const modalHistorico = new bootstrap.Modal(document.getElementById("modalHistoricoCliente"));

    document.getElementById("historicoCliente").textContent = `Carregando histórico do cliente ID ${id}...`;

    saidas.sort((a, b) => b.id - a.id);

    const saidasCliente = saidas.filter(saida => saida.idClientes === id);

    let htmlHistorico = '';
    if (saidasCliente.length > 0) {
        saidasCliente.forEach(saida => {
            const produto = produtos.find(p => p.id === saida.idProdutos);
            const categoria = produto ? categorias.find(c => c.id === produto.idCategoria) : null;

            htmlHistorico += `
                <p><strong>Produto:</strong> ${produto ? produto.nome : 'Desconhecido'} <br>
                <strong>Categoria:</strong> ${categoria ? categoria.nome : 'Desconhecida'} <br>
                <strong>Quantidade:</strong> ${saida.quantidade} <br>
                <strong>Preço:</strong> ${saida.preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })} <br>
                <strong>Data:</strong> ${new Date(saida.created_at).toLocaleDateString()}</p>
            `;
        });
    } else {
        htmlHistorico = '<p>Nenhuma saída registrada para este cliente.</p>';
    }

    document.getElementById("historicoCliente").innerHTML = htmlHistorico;

    modalHistorico.show();
}

function openModalExcluir(clienteId) {
    // Insere o ID do cliente no campo oculto do modal
    const inputClienteId = document.getElementById('idClienteExcluir');
    inputClienteId.value = clienteId;

    // Mostra o modal
    new bootstrap.Modal(document.getElementById('modalExcluir')).show();
}

function formatarCPF(event) {
    let cpf = event.target.value;

    // Remove qualquer caractere que não seja número
    cpf = cpf.replace(/\D/g, '');

    // Formata o CPF no padrão XXX.XXX.XXX-XX
    if (cpf.length <= 11) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    }

    // Atualiza o valor do campo com o CPF formatado
    event.target.value = cpf;
}

let ordemAtualClientes = {
    coluna: null,
    crescente: true
};

function ordenarTabelaClientes(coluna, idSeta) {
    if (ordemAtualClientes.coluna === coluna) {
        ordemAtualClientes.crescente = !ordemAtualClientes.crescente;
    } else {
        ordemAtualClientes.coluna = coluna;
        ordemAtualClientes.crescente = true;
    }

    document.querySelectorAll(".seta").forEach(seta => (seta.textContent = "⬍"));
    const setaAtual = document.getElementById(idSeta);
    setaAtual.textContent = ordemAtualClientes.crescente ? "⬆" : "⬇";

    aplicarOrdenacaoClientes();
    mostrarPaginaClientes(1);
}

function aplicarOrdenacaoClientes() {
    clientesFiltrados.sort((a, b) => {
        let valorA = a[ordemAtualClientes.coluna];
        let valorB = b[ordemAtualClientes.coluna];

        if (typeof valorA === 'string') {
            valorA = valorA.toLowerCase();
            valorB = valorB.toLowerCase();
        }

        return ordemAtualClientes.crescente
            ? (valorA > valorB ? 1 : valorA < valorB ? -1 : 0)
            : (valorA < valorB ? 1 : valorA > valorB ? -1 : 0);
    });
}


document.getElementById("ordenarNomeCliente").addEventListener("click", () => ordenarTabelaClientes("nome", "setaNomeCliente"));

function formatarTelefone(event) {
    const input = event.target;
    let valor = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
    if (valor.length > 11) valor = valor.slice(0, 11); // Limita a 11 caracteres

    const tamanhoAnterior = input.dataset.previousLength || 0;
    input.dataset.previousLength = valor.length;

    if (tamanhoAnterior > valor.length) {
        input.value = valor; // Não aplica máscara ao apagar
        return;
    }

    if (valor.length <= 10) {
        input.value = valor.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else {
        input.value = valor.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
    }
}

document.getElementById('telefoneCliente').addEventListener('input', formatarTelefone);

