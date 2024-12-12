const BASE_URL = '/stockDeps';

const itensPorPaginaFornecedores = 7;
const maxBotoesPaginacaoFornecedores = 5;
let paginaAtualFornecedores = 1;
let fornecedores = [];
let entradas = [];


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
}
async function fetchSaidas() {
    const response = await fetch(`${BASE_URL}/getSaidas`);
    saidas = await response.json(); // Preenche a variável global saídas
}
async function fetchFornecedores() {
    const response = await fetch(`${BASE_URL}/getFornecedores`);
    fornecedores = await response.json();
    mostrarPaginaFornecedores(paginaAtualFornecedores);
    buscarFornecedor(fornecedores); // Inicializa a busca com a lista de fornecedores
}

async function fetchEntradas() {
    const response = await fetch(`${BASE_URL}/getEntradas`);
    entradas = await response.json(); // Preenche a variável global saídas
}

function preencherTabelaFornecedores(fornecedoresPaginados) {
    const tabela = document.querySelector("#tabelaFornecedores tbody");
    tabela.innerHTML = "";
    fornecedoresPaginados.forEach(fornecedor => {
        const linha = document.createElement("tr");
        linha.innerHTML = `
            <td>${fornecedor.id}</td>
            <td>${fornecedor.nome}</td>
            <td>${fornecedor.cnpj}</td>
            <td>${fornecedor.email}</td>
            <td>${fornecedor.telefone}</td>
            <td>${fornecedor.endereco}</td>
            <td>${fornecedor.municipio}</td>
            <td>${fornecedor.cep}</td>
            <td>${fornecedor.uf}</td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-primary" onclick="editarFornecedor(${fornecedor.id})" data-bs-toggle="modal" data-bs-target="#modalEditarFornecedor" id="editarFornecedorBtn">Editar</button>
                    <button class="btn btn-danger" onclick="openModalExcluir(${fornecedor.id})">Excluir</button>
                    <button class="btn btn-success" onclick="abrirModalHistorico(${fornecedor.id})">Histórico</button>
                </div>
            </td>
        `;
        tabela.appendChild(linha);
    });
}

// Função para exibir a página de fornecedores atual
function mostrarPaginaFornecedores(pagina, listaFornecedores = fornecedores) {
    paginaAtualFornecedores = pagina;
    const inicio = (pagina - 1) * itensPorPaginaFornecedores;
    const fim = inicio + itensPorPaginaFornecedores;
    const fornecedoresPaginados = listaFornecedores.slice(inicio, fim);
    preencherTabelaFornecedores(fornecedoresPaginados);
    atualizarPaginacaoFornecedores(listaFornecedores);
}

// Função para atualizar os botões de paginação
function atualizarPaginacaoFornecedores(listaFornecedores = fornecedores) {
    const totalPaginas = Math.ceil(listaFornecedores.length / itensPorPaginaFornecedores);
    const pagination = document.getElementById('paginationFornecedores');
    pagination.innerHTML = '';

    const maxLeft = Math.max(paginaAtualFornecedores - Math.floor(maxBotoesPaginacaoFornecedores / 2), 1);
    const maxRight = Math.min(maxLeft + maxBotoesPaginacaoFornecedores - 1, totalPaginas);

    // Botão "Anterior"
    if (paginaAtualFornecedores > 1) {
        const prevLi = document.createElement('li');
        prevLi.classList.add('page-item');
        prevLi.innerHTML = `<a class="page-link" href="#">Anterior</a>`;
        prevLi.onclick = () => mostrarPaginaFornecedores(paginaAtualFornecedores - 1);
        pagination.appendChild(prevLi);
    }

    for (let i = maxLeft; i <= maxRight; i++) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        if (i === paginaAtualFornecedores) {
            li.classList.add('active');
        }

        const a = document.createElement('a');
        a.classList.add('page-link');
        a.textContent = i;
        a.onclick = () => mostrarPaginaFornecedores(i);
        li.appendChild(a);
        pagination.appendChild(li);
    }

    // Botão "Próximo"
    if (paginaAtualFornecedores < totalPaginas) {
        const nextLi = document.createElement('li');
        nextLi.classList.add('page-item');
        nextLi.innerHTML = `<a class="page-link" href="#">Próximo</a>`;
        nextLi.onclick = () => mostrarPaginaFornecedores(paginaAtualFornecedores + 1);
        pagination.appendChild(nextLi);
    }
}

// Função para buscar fornecedores com base no nome
function buscarFornecedor(fornecedores) {
    const inputBuscarFornecedor = document.getElementById('buscarFornecedor');

    inputBuscarFornecedor.addEventListener('input', function () {
        const termoBusca = inputBuscarFornecedor.value.toLowerCase();

        // Filtra os fornecedores com base no termo de busca
        const fornecedoresFiltrados = fornecedores.filter(fornecedor =>
            fornecedor.nome.toLowerCase().includes(termoBusca) ||
            fornecedor.cnpj.toLowerCase().includes(termoBusca)
        );

        // Mostra a primeira página da lista filtrada
        mostrarPaginaFornecedores(1, fornecedoresFiltrados);
    });
}


function editarFornecedor(id) {
    if (!fornecedores || fornecedores.length === 0) {
        console.error("O array de fornecedores está vazio ou não foi carregado.");
        return;
    }
    const fornecedor = fornecedores.find(fornecedor => fornecedor.id === id);
    if (fornecedor) {
        document.getElementById("editarFornecedorId").value = fornecedor.id;
        document.getElementById("editarFornecedorNome").value = fornecedor.nome;
        document.getElementById("editarFornecedorCnpj").value = fornecedor.cnpj;
        document.getElementById("editarFornecedorEmail").value = fornecedor.email;
        document.getElementById("editarFornecedorTelefone").value = fornecedor.telefone;
        document.getElementById("editarFornecedorEndereco").value = fornecedor.endereco;
        document.getElementById("editarFornecedorMunicipio").value = fornecedor.municipio || "";
        document.getElementById("editarFornecedorCep").value = fornecedor.cep || "";
        document.getElementById("editarUfFornecedor").value = fornecedor.uf || "";

        abrirModal()
    } else {
        console.error("Fornecedor não encontrado.");
    }
}

function verHistoricoFornecedor(id, fornecedores) {
    window.location.href = `${BASE_URL}/historicoFornecedor/${id}`;
}

function abrirModal() {
    const modal = document.getElementById("modalEditarFornecedor");
    modal.style.display = "block";
}

function fecharModal() {
    const modal = document.getElementById("modalEditarFornecedor");
    modal.style.display = "none";
}

document.getElementById("formEditarFornecedor").addEventListener("submit", async (event) => {
    event.preventDefault();

    const id = document.getElementById("editarFornecedorId").value;
    const nome = document.getElementById("editarFornecedorNome").value;
    const cnpj = document.getElementById("editarFornecedorCnpj").value;
    const email = document.getElementById("editarFornecedorEmail").value;
    const telefone = document.getElementById("editarFornecedorTelefone").value;
    const cidade = document.getElementById("editarFornecedorCidade").value;
    const bairro = document.getElementById("editarFornecedorBairro").value;
    const uf = document.getElementById("editarFornecedorUf").value;

    const fornecedorAtualizado = { id, nome, cnpj, email, telefone, cidade, bairro, uf };

    const response = await fetch(`${BASE_URL}/atualizarFornecedor`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(fornecedorAtualizado)
    });

    if (response.ok) {
        alert('Fornecedor atualizado com sucesso!');
        fecharModal();
        fetchFornecedores();
    } else {
        alert('Erro ao atualizar fornecedor.');
    }
});

function openModalExcluir(){
    new bootstrap.Modal(document.getElementById('modalExcluir')).show();
}
function abrirModalHistorico(id) {
    const modalHistorico = new bootstrap.Modal(document.getElementById("modalHistoricoFornecedor"));

    document.getElementById("historicoFornecedor").textContent = `Carregando histórico do fornecedor ID ${id}...`;

    const entradasFornecedor = entradas.filter(entrada => entrada.idFornecedor === id);

    let htmlHistorico = '';
    if (entradasFornecedor.length > 0) {
        entradasFornecedor.forEach(entrada => {
            const produto = produtos.find(p => p.id === entrada.idProdutos);
            const categoria = produto ? categorias.find(c => c.id === produto.idCategoria) : null;

            htmlHistorico += `
                <p><strong>Produto:</strong> ${produto ? produto.nome : 'Desconhecido'} <br>
                <strong>Categoria:</strong> ${categoria ? categoria.nome : 'Desconhecida'} <br>
                <strong>Quantidade:</strong> ${entrada.quantidade} <br>
                <strong>Preço:</strong> ${entrada.preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })} <br>
                <strong>Data:</strong> ${new Date(entrada.created_at).toLocaleDateString()}</p>
            `;
        });
    } else {
        htmlHistorico = '<p>Nenhuma entrada registrada para este fornecedor.</p>';
    }

    document.getElementById("historicoFornecedor").innerHTML = htmlHistorico;

    modalHistorico.show();
}

function loadAllData() {
    fetchProdutos();
    fetchCategorias();
    fetchClientes();
    fetchFornecedores();
    fetchEntradas();
    fetchSaidas();
}

document.addEventListener("DOMContentLoaded", () => {
    loadAllData();
});


let ordemAtualFornecedores = {
    coluna: null,
    crescente: true
};

// Função para ordenar a tabela de fornecedores
function ordenarTabelaFornecedores(coluna, idSeta) {
    if (ordemAtualFornecedores.coluna === coluna) {
        ordemAtualFornecedores.crescente = !ordemAtualFornecedores.crescente;
    } else {
        ordemAtualFornecedores.coluna = coluna;
        ordemAtualFornecedores.crescente = true;
    }

    // Atualizar setas
    document.querySelectorAll(".seta").forEach(seta => (seta.textContent = "⬍"));
    const setaAtual = document.getElementById(idSeta);
    setaAtual.textContent = ordemAtualFornecedores.crescente ? "⬆" : "⬇";

    // Ordenar os fornecedores
    const fornecedoresOrdenados = [...fornecedores].sort((a, b) => {
        let valorA = a[coluna];
        let valorB = b[coluna];

        // Se for uma string, converter para minúscula para comparar corretamente
        if (typeof valorA === "string") {
            valorA = valorA.toLowerCase();
            valorB = valorB.toLowerCase();
        }

        // Comparar de acordo com a ordem crescente ou decrescente
        if (ordemAtualFornecedores.crescente) {
            return valorA > valorB ? 1 : valorA < valorB ? -1 : 0;
        } else {
            return valorA < valorB ? 1 : valorA > valorB ? -1 : 0;
        }
    });

    mostrarPaginaFornecedores(1, fornecedoresOrdenados); // Atualiza a tabela com os dados ordenados
}

// Adicionando eventos de clique para ordenar as colunas de fornecedores
document.getElementById("ordenarIdFornecedor").addEventListener("click", () => ordenarTabelaFornecedores("id", "setaIdFornecedor"));
document.getElementById("ordenarNomeFornecedor").addEventListener("click", () => ordenarTabelaFornecedores("nome", "setaNomeFornecedor"));
document.getElementById("ordenarCnpjFornecedor").addEventListener("click", () => ordenarTabelaFornecedores("cnpj", "setaCnpjFornecedor"));
document.getElementById("ordenarEmailFornecedor").addEventListener("click", () => ordenarTabelaFornecedores("email", "setaEmailFornecedor"));
document.getElementById("ordenarTelefoneFornecedor").addEventListener("click", () => ordenarTabelaFornecedores("telefone", "setaTelefoneFornecedor"));
document.getElementById("ordenarEnderecoFornecedor").addEventListener("click", () => ordenarTabelaFornecedores("endereco", "setaEnderecoFornecedor"));
document.getElementById("ordenarMunicipioFornecedor").addEventListener("click", () => ordenarTabelaFornecedores("municipio", "setaMunicipioFornecedor"));
document.getElementById("ordenarCepFornecedor").addEventListener("click", () => ordenarTabelaFornecedores("cep", "setaCepFornecedor"));
document.getElementById("ordenarUfFornecedor").addEventListener("click", () => ordenarTabelaFornecedores("uf", "setaUfFornecedor"));

function formatarCNPJ(event) {
    let cnpj = event.target.value;

    // Remove qualquer caractere que não seja número
    cnpj = cnpj.replace(/\D/g, '');

    // Formata o CNPJ no padrão XX.XXX.XXX/XXXX-XX
    if (cnpj.length <= 14) {
        cnpj = cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
    }

    // Atualiza o valor do campo com o CNPJ formatado
    event.target.value = cnpj;
}
