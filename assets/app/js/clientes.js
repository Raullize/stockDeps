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
    buscarCliente(clientes);
    ordenarTabelaClientes('nome', 'setaNomeCliente');
    mostrarPaginaClientes(paginaAtualClientes); // Exibir corretamente a primeira página de clientes
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
    tabela.innerHTML = ""; // Limpa a tabela

    clientesPaginados.forEach(cliente => {
        const linha = document.createElement("tr");
        linha.innerHTML = `
            <td>${cliente.nome}</td>
            <td>${cliente.cpf}</td>
            <td>${cliente.celular}</td>
            <td>
                <div class="btn-group w-100">
                    <button class="btn btn-primary text-light" onclick="abrirModalEditarCliente(${cliente.id})">Editar</button>
                    <button class="btn btn-danger" onclick="openModalExcluir(${cliente.id})">Excluir</button>
                    <button class="btn btn-success" onclick="abrirModalHistorico(${cliente.id})">Histórico</button>
                </div>
            </td>
        `;
        tabela.appendChild(linha);
    });
}

function mostrarPaginaClientes(pagina, listaClientes = clientes) {
    paginaAtualClientes = pagina; // Atualizar a página atual
    const inicio = (pagina - 1) * itensPorPaginaClientes;  // Cálculo do início da página
    const fim = inicio + itensPorPaginaClientes;           // Cálculo do fim da página
    const clientesPaginados = listaClientes.slice(inicio, fim); // Pegando apenas os clientes da página atual
    preencherTabelaClientes(clientesPaginados);           // Preenchendo a tabela com os clientes paginados
    atualizarPaginacaoClientes(listaClientes);            // Atualizando a paginação
}


function atualizarPaginacaoClientes(listaClientes = clientes) {
    const totalPaginas = Math.ceil(listaClientes.length / itensPorPaginaClientes);
    const pagination = document.getElementById('paginationClientes');
    pagination.innerHTML = '';

    const maxLeft = Math.max(paginaAtualClientes - Math.floor(maxBotoesPaginacaoClientes / 2), 1);
    const maxRight = Math.min(maxLeft + maxBotoesPaginacaoClientes - 1, totalPaginas);

    // Botão "Anterior"
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

    // Botão "Próximo"
    if (paginaAtualClientes < totalPaginas) {
        const nextLi = document.createElement('li');
        nextLi.classList.add('page-item');
        nextLi.innerHTML = `<a class="page-link" href="#">Próximo</a>`;
        nextLi.onclick = () => mostrarPaginaClientes(paginaAtualClientes + 1);
        pagination.appendChild(nextLi);
    }
}

function buscarCliente(clientes) {
    const inputBuscarCliente = document.getElementById('buscarCliente');

    inputBuscarCliente.addEventListener('input', function () {
        const termoBusca = inputBuscarCliente.value.toLowerCase();

        // Filtra os clientes com base no termo de busca
        const clientesFiltrados = clientes.filter(cliente =>
            cliente.nome.toLowerCase().includes(termoBusca) ||
            cliente.cpf.toLowerCase().includes(termoBusca)
        );

        // Atualiza a exibição com a lista filtrada
        mostrarPaginaClientes(1, clientesFiltrados); // Mostra a página 1 dos clientes filtrados
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

// Função para ordenar a tabela de clientes
function ordenarTabelaClientes(coluna, idSeta) {
    if (ordemAtualClientes.coluna === coluna) {
        ordemAtualClientes.crescente = !ordemAtualClientes.crescente;
    } else {
        ordemAtualClientes.coluna = coluna;
        ordemAtualClientes.crescente = true;
    }

    // Atualizar setas
    document.querySelectorAll(".seta").forEach(seta => (seta.textContent = "⬍"));
    const setaAtual = document.getElementById(idSeta);
    setaAtual.textContent = ordemAtualClientes.crescente ? "⬆" : "⬇";

    // Ordenar os clientes
    const clientesOrdenados = [...clientes].sort((a, b) => {
        let valorA = a[coluna];
        let valorB = b[coluna];

        // Se for uma string, converter para minúscula para comparar corretamente
        if (typeof valorA === "string") {
            valorA = valorA.toLowerCase();
            valorB = valorB.toLowerCase();
        }

        // Comparar de acordo com a ordem crescente ou decrescente
        if (ordemAtualClientes.crescente) {
            return valorA > valorB ? 1 : valorA < valorB ? -1 : 0;
        } else {
            return valorA < valorB ? 1 : valorA > valorB ? -1 : 0;
        }
    });

    mostrarPaginaClientes(1, clientesOrdenados);
}


document.getElementById("ordenarNomeCliente").addEventListener("click", () => ordenarTabelaClientes("nome", "setaNomeCliente"));
