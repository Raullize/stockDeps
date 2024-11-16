function preencherTabelaProdutos(produtos) {
    console.log(produtos);
    const corpoTabela = document.getElementById("corpoTabela");
    corpoTabela.innerHTML = '';  // Limpa a tabela antes de adicionar novos dados

    produtos.forEach(produto => {
        // Cria uma nova linha (tr) para a tabela
        const tr = document.createElement('tr');

        // Adiciona as células (td) para cada coluna da tabela
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
        // Converte o preço para número e formata com 2 casas decimais
        tdPreco.textContent = parseFloat(produto.preco).toFixed(2); 
        tr.appendChild(tdPreco);

        // Cria a célula para as Ações com colspan="2"
        const tdAcoes = document.createElement('td');
        tdAcoes.setAttribute('colspan', '2');

        // Cria os botões de ações
        const btnGroup = document.createElement('div');
        btnGroup.classList.add('btn-group', 'w-100');

        // Botão Editar
        const btnEditar = document.createElement('button');
        btnEditar.classList.add('btn', 'btn-primary');
        btnEditar.textContent = 'Editar';
        btnEditar.onclick = function () {
            // Preenche os campos de edição
            document.getElementById('nomeProduto').value = produto.nome;
            document.getElementById('descricaoProduto').value = produto.descricao;
            document.getElementById('precoProduto').value = parseFloat(produto.preco).toFixed(2);
            new bootstrap.Modal(document.getElementById('modalEditar')).show();
        };
        btnGroup.appendChild(btnEditar);

        // Botão Excluir
        const btnExcluir = document.createElement('button');
        btnExcluir.classList.add('btn', 'btn-danger');
        btnExcluir.textContent = 'Excluir';
        btnExcluir.onclick = function () {
            // Preenche os dados do produto a ser excluído (se necessário)
            new bootstrap.Modal(document.getElementById('modalExcluir')).show();
        };
        btnGroup.appendChild(btnExcluir);

        // Botão Adicionar Entrada
        const btnEntrada = document.createElement('button');
        btnEntrada.classList.add('btn', 'btn-success');
        btnEntrada.textContent = 'Adicionar Entrada';
        btnEntrada.onclick = function () {
            // Preenche os dados da entrada
            new bootstrap.Modal(document.getElementById('modalEntrada')).show();
        };
        btnGroup.appendChild(btnEntrada);

        // Botão Adicionar Saída
        const btnSaida = document.createElement('button');
        btnSaida.classList.add('btn', 'btn-warning');
        btnSaida.textContent = 'Adicionar Saída';
        btnSaida.onclick = function () {
            // Preenche os dados da saída
            new bootstrap.Modal(document.getElementById('modalSaida')).show();
        };
        btnGroup.appendChild(btnSaida);

        // Adiciona os botões à célula de ações
        tdAcoes.appendChild(btnGroup);

        // Adiciona a célula de ações à linha
        tr.appendChild(tdAcoes);

        // Adiciona a linha à tabela
        corpoTabela.appendChild(tr);
    });
}


function preencherCategorias(categorias) {
    const selectElement = document.getElementById('categoria');
    const selectElementModalAdicionarProdutos = document.getElementById('categoriaProduto');
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
        selectElementModalAdicionarProdutos.appendChild(option);
    });
}

function abrirModalAdicionarProduto() {
    const modalAdicionarProduto = new bootstrap.Modal(document.getElementById('modalAdicionarProduto'));
    modalAdicionarProduto.show();
}