let fornecedores = [];

async function fetchFornecedores() {
    const response = await fetch('/stock-deps/getFornecedores');
    fornecedores = await response.json();
    preencherTabelaFornecedores(fornecedores);
    console.log(fornecedores)
}

function preencherTabelaFornecedores(fornecedores) {
    const tabela = document.querySelector("#tabelaFornecedores tbody");
    tabela.innerHTML = "";
    fornecedores.forEach(fornecedor => {
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

document.getElementById("buscarFornecedor").addEventListener("input", function () {
    const termo = this.value.toLowerCase();
    const linhas = document.querySelectorAll("#tabelaFornecedores tbody tr");

    linhas.forEach(linha => {
        const nome = linha.cells[1].textContent.toLowerCase();
        linha.style.display = nome.includes(termo) ? "" : "none";
    });
});


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
    window.location.href = `/stock-deps/historicoFornecedor/${id}`;
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

    const response = await fetch('/stock-deps/atualizarFornecedor', {
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
