async function fetchProdutos() {
    const response = await fetch('/stock-deps/getProdutos');
    produtos = await response.json();
    preencherTabelaProdutos(produtos);
    buscarProduto(produtos);
}

async function fetchCategorias() {
    const response = await fetch('/stock-deps/getCategorias');
    categorias = await response.json();
    preencherCategorias(categorias);
}

async function fetchClientes() {
    const response = await fetch('/stock-deps/getClientes');
    const clientes = await response.json();
}

async function fetchEntradas() {
    const response = await fetch('/stock-deps/getEntradas');
    const entradas = await response.json();
    buscarEntrada(entradas)
    console.log(entradas)
}

async function fetchSaidas() {
    const response = await fetch('/stock-deps/getSaidas');
    const saidas = await response.json();
    buscarSaida(saidas);
    console.log(saidas)
}

function loadAllData() {
    fetchProdutos();
    fetchCategorias();
    fetchClientes();
    fetchEntradas();
    fetchSaidas();
}

function preencherTabelaProdutos(produtos) {
    console.log(produtos)
    const corpoTabela = document.getElementById("corpoTabela");
    corpoTabela.innerHTML = '';

    produtos.forEach(produto => {
        const tr = document.createElement('tr');
        const tdId = document.createElement('td');
        tdId.textContent = produto.id;
        tr.appendChild(tdId);

        const tdNome = document.createElement('td');
        tdNome.textContent = produto.nome;
        tr.appendChild(tdNome);

        const tdDescricao = document.createElement('td');
        tdDescricao.textContent = produto.descricao;
        tr.appendChild(tdDescricao);

        const tdPreco = document.createElement('td');
        tdPreco.textContent = parseFloat(produto.preco).toFixed(2);
        tr.appendChild(tdPreco);

        const tdQuantidade = document.createElement('td');
        tdQuantidade.textContent = "100";
        tr.appendChild(tdQuantidade);

        const tdStatus = document.createElement('td');
        tdStatus.textContent = "Disponível";
        tr.appendChild(tdStatus);

        const tdAcoes = document.createElement('td');
        tdAcoes.setAttribute('colspan', '2');

        const btnGroup = document.createElement('div');
        btnGroup.classList.add('btn-group', 'w-100');

        const btnEditar = document.createElement('button');
        btnEditar.classList.add('btn', 'btn-primary');
        btnEditar.textContent = 'Editar';
        btnEditar.onclick = function () {
            document.getElementById('nomeProduto').value = produto.nome;
            document.getElementById('descricaoProduto').value = produto.descricao;
            document.getElementById('precoProduto').value = parseFloat(produto.preco).toFixed(2);
            new bootstrap.Modal(document.getElementById('modalEditar')).show();
        };
        btnGroup.appendChild(btnEditar);

        const btnExcluir = document.createElement('button');
        btnExcluir.classList.add('btn', 'btn-danger');
        btnExcluir.textContent = 'Excluir';
        btnExcluir.onclick = function () {
            new bootstrap.Modal(document.getElementById('modalExcluir')).show();
        };
        btnGroup.appendChild(btnExcluir);

        const btnEntrada = document.createElement('button');
        btnEntrada.classList.add('btn', 'btn-success');
        btnEntrada.textContent = 'Adicionar Entrada';
        btnEntrada.onclick = function () {
            new bootstrap.Modal(document.getElementById('modalEntrada')).show();
        };
        btnGroup.appendChild(btnEntrada);

        const btnSaida = document.createElement('button');
        btnSaida.classList.add('btn', 'btn-warning');
        btnSaida.textContent = 'Adicionar Saída';
        btnSaida.onclick = function () {
            new bootstrap.Modal(document.getElementById('modalSaida')).show();
        };
        btnGroup.appendChild(btnSaida);

        tdAcoes.appendChild(btnGroup);
        tr.appendChild(tdAcoes);
        corpoTabela.appendChild(tr);
    });
}

function preencherTabelaEntradas(entradas) {
    const corpoTabelaEntradas = document.getElementById("corpoTabelaEntradas");
    corpoTabelaEntradas.innerHTML = '';

    entradas.forEach(entrada => {
        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.textContent = entrada.id;
        tr.appendChild(tdId);

        const tdIdProduto = document.createElement('td');
        tdIdProduto.textContent = entrada.idProdutos;
        tr.appendChild(tdIdProduto);

        const tdQuantidade = document.createElement('td');
        tdQuantidade.textContent = entrada.quantidade;
        tr.appendChild(tdQuantidade);

        const tdCriadoEm = document.createElement('td');
        tdCriadoEm.textContent = entrada.created_at;
        tr.appendChild(tdCriadoEm);

        const tdAcoes = document.createElement('td');
        const btnGroup = document.createElement('div');
        btnGroup.classList.add('btn-group');

        const btnEditar = document.createElement('button');
        btnEditar.classList.add('btn', 'btn-primary');
        btnEditar.textContent = 'Editar';
        btnEditar.onclick = function () {
            abrirModalEditarEntrada(entrada);
        };
        btnGroup.appendChild(btnEditar);

        const btnExcluir = document.createElement('button');
        btnExcluir.classList.add('btn', 'btn-danger');
        btnExcluir.textContent = 'Excluir';
        btnExcluir.onclick = function () {
            alert(`Excluir entrada ID: ${entrada.id}`);
        };
        btnGroup.appendChild(btnExcluir);

        tdAcoes.appendChild(btnGroup);
        tr.appendChild(tdAcoes);

        corpoTabelaEntradas.appendChild(tr);
    });
}

function preencherTabelaSaidas(saidas) {
    const corpoTabelaSaidas = document.getElementById("corpoTabelaSaidas");
    corpoTabelaSaidas.innerHTML = '';

    saidas.forEach(saida => {
        const tr = document.createElement('tr');

        const tdId = document.createElement('td');
        tdId.textContent = saida.id;
        tr.appendChild(tdId);

        const tdIdProduto = document.createElement('td');
        tdIdProduto.textContent = saida.idProdutos;
        tr.appendChild(tdIdProduto);

        const tdQuantidade = document.createElement('td');
        tdQuantidade.textContent = saida.quantidade;
        tr.appendChild(tdQuantidade);

        const tdCriadoEm = document.createElement('td');
        tdCriadoEm.textContent = saida.created_at;
        tr.appendChild(tdCriadoEm);

        const tdAcoes = document.createElement('td');
        const btnGroup = document.createElement('div');
        btnGroup.classList.add('btn-group');

        const btnEditar = document.createElement('button');
        btnEditar.classList.add('btn', 'btn-primary');
        btnEditar.textContent = 'Editar';
        btnEditar.onclick = function () {
            abrirModalEditarSaida(saida);
        };
        btnGroup.appendChild(btnEditar);

        const btnExcluir = document.createElement('button');
        btnExcluir.classList.add('btn', 'btn-danger');
        btnExcluir.textContent = 'Excluir';
        btnExcluir.onclick = function () {
            alert(`Excluir saída ID: ${saida.id}`);
        };
        btnGroup.appendChild(btnExcluir);

        tdAcoes.appendChild(btnGroup);
        tr.appendChild(tdAcoes);

        corpoTabelaSaidas.appendChild(tr);
    });
}

function buscarProduto(produtos) {
    const inputBuscarProduto = document.getElementById('buscarProduto');

    inputBuscarProduto.addEventListener('input', function () {
        const termoBusca = inputBuscarProduto.value.toLowerCase();

        const produtosFiltrados = produtos.filter(produto =>
            produto.nome.toLowerCase().includes(termoBusca) ||
            produto.descricao.toLowerCase().includes(termoBusca)
        );

        preencherTabelaProdutos(produtosFiltrados);
    });
}

function buscarEntrada(entradas) {
    const inputBuscarEntradas = document.getElementById('buscarEntradas');

    inputBuscarEntradas.addEventListener('input', function () {
        const termoBusca = inputBuscarEntradas.value.toLowerCase();

        const entradasFiltradas = entradas.filter(entrada =>
            entrada.id.toString().includes(termoBusca) ||
            entrada.idProdutos.toString().includes(termoBusca)
        );

        preencherTabelaEntradas(entradasFiltradas);
    });
}

function buscarSaida(saidas) {
    const inputBuscarSaidas = document.getElementById('buscarSaidas');

    inputBuscarSaidas.addEventListener('input', function () {
        const termoBusca = inputBuscarSaidas.value.toLowerCase();

        const saidasFiltradas = saidas.filter(saida =>
            saida.id.toString().includes(termoBusca) ||
            saida.idProdutos.toString().includes(termoBusca)
        );

        preencherTabelaSaidas(saidasFiltradas);
    });
}

function alterarTabelaPorCategoriaSelecionada(produtos) {
    const categoriaSelecionada = document.getElementById("categoria").value;
    const categoriaSelecionadaNumero = Number(categoriaSelecionada);
    let produtosFiltrados = [];

    if (categoriaSelecionada) {
        if (!isNaN(categoriaSelecionadaNumero)) {
            produtosFiltrados = produtos.filter(produto => Number(produto.idCategoria) == categoriaSelecionadaNumero);
        } else {
            produtosFiltrados = produtos;
        }
    } else {
        produtosFiltrados = produtos;
    }

    preencherTabelaProdutos(produtosFiltrados);
}

function preencherCategorias(categorias) {
    const selectElement = document.getElementById('categoria');
    const selectElementModal = document.getElementById('categoriaProdutoAdicionar');

    categorias.forEach(categoria => {
        const option = document.createElement('option');
        option.value = categoria.id;
        option.textContent = categoria.nome;
        selectElement.appendChild(option);
    });

    categorias.forEach(categoria => {
        const option = document.createElement('option');
        option.value = categoria.id;
        option.textContent = categoria.nome;
        selectElementModal.appendChild(option);
    });
}

function abrirModalAdicionarProduto() {
    const modalAdicionarProduto = new bootstrap.Modal(document.getElementById('modalAdicionarProduto'));
    modalAdicionarProduto.show();
}

function abrirModalEditarEntrada(entrada) {
    const modalEditarEntrada = new bootstrap.Modal(document.getElementById('modalEditarEntrada'));
    document.getElementById('idProdutoEntrada').value = entrada.idProdutos;
    document.getElementById('quantidadeEntrada').value = entrada.quantidade;
    modalEditarEntrada.show();

    document.getElementById('formEditarEntrada').onsubmit = function (e) {
        e.preventDefault();
        const idProduto = document.getElementById('idProdutoEntrada').value;
        const quantidade = document.getElementById('quantidadeEntrada').value;

        // Adicione aqui a lógica para salvar os dados editados
        alert(`Entrada Editada: Produto ID ${idProduto}, Quantidade ${quantidade}`);
        modalEditarEntrada.hide();
    };
}

function abrirModalEditarSaida(saida) {
    const modalEditarSaida = new bootstrap.Modal(document.getElementById('modalEditarSaida'));
    document.getElementById('idProdutoSaida').value = saida.idProdutos;
    document.getElementById('quantidadeSaida').value = saida.quantidade;
    modalEditarSaida.show();

    document.getElementById('formEditarSaida').onsubmit = function (e) {
        e.preventDefault();
        const idProduto = document.getElementById('idProdutoSaida').value;
        const quantidade = document.getElementById('quantidadeSaida').value;

        // Adicione aqui a lógica para salvar os dados editados
        alert(`Saída Editada: Produto ID ${idProduto}, Quantidade ${quantidade}`);
        modalEditarSaida.hide();
    };
}

document.getElementById("consultarEntradasBtn").addEventListener("click", async function () {
    const response = await fetch('/stock-deps/getEntradas');
    const entradas = await response.json();

    preencherTabelaEntradas(entradas);
    buscarEntrada(entradas);

    const modalEntradas = new bootstrap.Modal(document.getElementById('modalEntradas'));
    modalEntradas.show();
});

document.getElementById("consultarSaidasBtn").addEventListener("click", async function () {
    const response = await fetch('/stock-deps/getSaidas');
    const saidas = await response.json();

    preencherTabelaSaidas(saidas);

    const modalSaidas = new bootstrap.Modal(document.getElementById('modalSaidas'));
    modalSaidas.show();
});

document.getElementById("categoria").addEventListener("change", function () {
    alterarTabelaPorCategoriaSelecionada(produtos);
});

async function loadDashboardData() {
    const produtos = await fetchProdutos();
    const categorias = await fetchCategorias();
    const entradas = await fetchEntradas();
    const saidas = await fetchSaidas();

    // Atualizar valores nos cards
    document.getElementById('totalProdutos').textContent = produtos.length;
    document.getElementById('totalCategorias').textContent = categorias.length;
    document.getElementById('totalEntradas').textContent = entradas.length;
    document.getElementById('totalSaidas').textContent = saidas.length;

    // Preencher tabela de produtos recentes
    const produtosRecente = document.getElementById('produtosRecente');
    produtos.slice(-5).forEach(produto => {  // Exibe os últimos 5 produtos
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${produto.id}</td>
        <td>${produto.nome}</td>
        <td>${parseFloat(produto.preco).toFixed(2)}</td>
        <td>${categorias.find(c => c.id === produto.idCategoria).nome}</td>
      `;
        produtosRecente.appendChild(tr);
    });

    // Preencher tabela de entradas recentes
    const entradasRecentes = document.getElementById('entradasRecentes');
    entradas.slice(-5).forEach(entrada => {  // Exibe as últimas 5 entradas
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${entrada.id}</td>
        <td>${produtos.find(p => p.id === entrada.idProdutos).nome}</td>
        <td>${entrada.quantidade}</td>
        <td>${new Date(entrada.created_at).toLocaleDateString()}</td>
      `;
        entradasRecentes.appendChild(tr);
    });
}


window.onload = loadAllData;
