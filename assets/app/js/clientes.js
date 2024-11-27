let clientes = [];
let produtos = [];
let saidas = [];
let categorias = [];

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
    clientes = await response.json();
    preencherTabelaClientes(clientes);
}

async function fetchEntradas() {
    const response = await fetch('/stock-deps/getEntradas');
    const entradas = await response.json();
}

async function fetchSaidas() {
    const response = await fetch('/stock-deps/getSaidas');
    saidas = await response.json(); // Preenche a variável global saídas
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

function preencherTabelaClientes(clientes) {
    const tabela = document.querySelector("#tabelaClientes tbody"); // Seleciona o <tbody> da tabela
    tabela.innerHTML = ""; // Limpa o conteúdo atual para evitar duplicações

    clientes.forEach(cliente => {
        const linha = document.createElement("tr"); // Cria uma nova linha

        // Preenche as colunas da linha
        linha.innerHTML = `
            <td>${cliente.id}</td>
            <td>${cliente.nome}</td>
            <td>${cliente.cpf}</td>
            <td>${cliente.celular}</td>
            <td>
                <div class="btn-group w-100 ">
                    <button class="btn  text-light btn-primary" onclick="abrirModalEditarCliente(${cliente.id})">Editar</button>
                    <button class="btn  btn-danger" onclick="excluirCliente(${cliente.id})">Excluir</button>
                    <button class="btn  btn-success" onclick="abrirModalHistorico(${cliente.id})">Histórico</button>
                </div>
            </td>
        `;

        tabela.appendChild(linha); // Adiciona a linha à tabela
    });
}

document.getElementById("buscarCliente").addEventListener("input", function () {
    const termo = this.value.toLowerCase();
    const linhas = document.querySelectorAll("#tabelaClientes tbody tr");

    linhas.forEach(linha => {
        const nome = linha.cells[1].textContent.toLowerCase();
        linha.style.display = nome.includes(termo) ? "" : "none";
    });
});

function abrirModalEditarCliente(id) {
    console.log(clientes)
    const cliente = clientes.find(c => c.id === id);
    if (!cliente) {
        alert("Cliente não encontrado");
        return;
    }
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
            const categoria = categorias.find(c => c.id === saida.idCategoria);

            htmlHistorico += `
                <p><strong>Produto:</strong> ${produto ? produto.nome : 'Desconhecido'} <br>
                <strong>Categoria:</strong> ${categoria ? categoria.nome : 'Desconhecida'} <br>
                <strong>Quantidade:</strong> ${saida.quantidade} <br>
                <strong>Data:</strong> ${new Date(saida.created_at).toLocaleDateString()}</p>
            `;
        });
    } else {
        htmlHistorico = '<p>Nenhuma saída registrada para este cliente.</p>';
    }

    document.getElementById("historicoCliente").innerHTML = htmlHistorico;

    modalHistorico.show();
}

async function excluirCliente(id) {
    const confirmar = confirm("Tem certeza que deseja excluir este cliente?");
    if (confirmar) {
        const response = await fetch(`/stock-deps/deleteCliente/${id}`, {
            method: 'DELETE',
        });

        if (response.ok) {
            alert("Cliente excluído com sucesso!");
            fetchClientes(); 
        } else {
            alert("Erro ao excluir o cliente.");
        }
    }
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
