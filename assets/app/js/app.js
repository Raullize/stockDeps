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

const preencherTabelaProdutos = produtos => {
    const corpoTabela = document.getElementById("corpoTabela");
    corpoTabela.innerHTML = '';

    produtos.forEach(produto => {
        const tr = document.createElement('tr');

        // Desestruturação para mapear as propriedades
        const { id, nome, descricao, preco } = produto;
        const dados = [id, nome, descricao, preco, 100, "Disponível"];

        // Criação de células de dados de forma compacta
        tr.append(...dados.map(dado => {
            const td = document.createElement('td');
            td.textContent = dado;
            return td;
        }));

        // Botões de ação em um único passo
        tr.appendChild(createButtonGroup(produto));
        corpoTabela.appendChild(tr);
    });
};

const createButtonGroup = produto => {
    const actions = [
        { text: 'Editar', class: 'btn-primary', action: () => openModal('Editar', produto) },
        { text: 'Excluir', class: 'btn-danger', action: () => openModal('Excluir', produto) },
        { text: 'Adicionar Entrada', class: 'btn-success', action: openModalEntrada },
        { text: 'Adicionar Saída', class: 'btn-warning', action: openModalSaida }
    ];

    const btnGroup = document.createElement('div');
    btnGroup.classList.add('btn-group', 'w-100');
    actions.forEach(({ text, class: btnClass, action }) => {
        const btn = document.createElement('button');
        btn.classList.add('btn', btnClass);
        btn.textContent = text;
        btn.onclick = action;
        btnGroup.appendChild(btn);
    });

    const tdAcoes = document.createElement('td');
    tdAcoes.colSpan = 2;
    tdAcoes.appendChild(btnGroup);
    return tdAcoes;
};

const openModal = (tipo, produto) => {
    const modalId = tipo === 'Editar' ? 'modalEditar' : 'modalExcluir';
    if (tipo === 'Editar') {
        document.getElementById('nomeProduto').value = produto.nome;
        document.getElementById('descricaoProduto').value = produto.descricao;
        document.getElementById('precoProduto').value = parseFloat(produto.preco).toFixed(2);
    }
    new bootstrap.Modal(document.getElementById(modalId)).show();
};

const openModalEntrada = () => new bootstrap.Modal(document.getElementById('modalEntrada')).show();
const openModalSaida = () => new bootstrap.Modal(document.getElementById('modalSaida')).show();


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

function preencherCategorias(categorias, callbackMostrarProdutos) {
    const selectElement = document.getElementById('categoria');
    const selectElementModal = document.getElementById('categoriaProdutoAdicionar');

    // Adiciona a opção "Todas" no select principal
    const optionAll = document.createElement('option');
    optionAll.value = 'todas'; // Valor para identificar a exibição de todos os produtos
    optionAll.textContent = 'Todas';
    selectElement.appendChild(optionAll);

    // Adiciona o placeholder "Selecione a categoria" no modal select
    const placeholderModal = document.createElement('option');
    placeholderModal.value = ''; // Valor vazio para validação
    placeholderModal.textContent = 'Selecione a categoria';
    placeholderModal.disabled = true;
    placeholderModal.selected = true;
    selectElementModal.appendChild(placeholderModal);

    // Preenche as opções de categorias no select principal
    categorias.forEach(categoria => {
        const option = document.createElement('option');
        option.value = categoria.id;
        option.textContent = categoria.nome;
        selectElement.appendChild(option);
    });

    // Preenche as opções de categorias no modal select
    categorias.forEach(categoria => {
        const option = document.createElement('option');
        option.value = categoria.id;
        option.textContent = categoria.nome;
        selectElementModal.appendChild(option);
    });

    // Adiciona um evento para filtrar produtos
    selectElement.addEventListener('change', function () {
        const selectedValue = this.value;

        if (selectedValue === 'todas') {
            callbackMostrarProdutos(); // Exibe todos os produtos
        } else {
            callbackMostrarProdutos(selectedValue); // Exibe produtos da categoria selecionada
        }
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




window.onload = loadAllData;
