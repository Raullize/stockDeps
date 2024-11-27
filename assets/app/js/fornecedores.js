let fornecedores = [];

async function fetchFornecedores() {
    const response = await fetch('/stock-deps/getFornecedores');
    fornecedores = await response.json();
    preencherTabelaFornecedores(fornecedores);
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
            <td>${fornecedor.municipio}</td>
            <td>${fornecedor.bairro}</td>
            <td>${fornecedor.uf}</td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-info" onclick="editarFornecedor(${fornecedor.id})">Editar</button>
                    <button class="btn btn-success" onclick="verHistoricoFornecedor(${fornecedor.id})">Histórico</button>
                    <button class="btn btn-danger" onclick="excluirFornecedor(${fornecedor.id})">Excluir</button>
                </div>
            </td>
        `;
        tabela.appendChild(linha);
    });
}

function editarFornecedor(id) {
    const fornecedor = fornecedores.find(f => f.id === id);
    if (fornecedor) {
        document.getElementById("editarFornecedorId").value = fornecedor.id;
        document.getElementById("editarFornecedorNome").value = fornecedor.nome;
        document.getElementById("editarFornecedorCnpj").value = fornecedor.cnpj;
        document.getElementById("editarFornecedorEmail").value = fornecedor.email;
        document.getElementById("editarFornecedorTelefone").value = fornecedor.telefone;
        document.getElementById("editarFornecedorCidade").value = fornecedor.cidade;
        document.getElementById("editarFornecedorBairro").value = fornecedor.bairro;
        document.getElementById("editarFornecedorUf").value = fornecedor.uf;

        abrirModal();
    }
}

function verHistoricoFornecedor(id) {
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
