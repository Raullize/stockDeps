const BASE_URL = '/stockDeps';

const itensPorPaginaFornecedores = 7;
const maxBotoesPaginacaoFornecedores = 5;
let paginaAtualFornecedores = 1;
let fornecedores = [];

async function fetchFornecedores() {
    const response = await fetch(`${BASE_URL}/getFornecedores`);
    fornecedores = await response.json();
    mostrarPaginaFornecedores(paginaAtualFornecedores);
    buscarFornecedor(fornecedores); // Inicializa a busca com a lista de fornecedores
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
                    <button class="btn btn-danger" onclick="excluirFornecedor(${fornecedor.id})">Excluir</button>
                    <button class="btn btn-success" onclick="verHistoricoFornecedor(${fornecedor.id})">Histórico</button>
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

document.addEventListener("DOMContentLoaded", fetchFornecedores);
