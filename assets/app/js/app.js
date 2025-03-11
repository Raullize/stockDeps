const BASE_URL = '/stockDeps/app';
const itensPorPagina = 8;
const maxBotoesPaginacao = 5; // Limite de botões de página exibidos

// Função de debounce para otimizar buscas
function debounce(func, wait = 300) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

let produtos = [];
let produtosOriginais = [];
let clientes = [];
let fornecedores = [];
let entradas = [];
let saidas = [];
let categorias = [];

let paginaAtual = 1;
let paginaAtualEntradas = 1;
let paginaAtualSaidas = 1;

let entradasFiltradas = [];
let saidasFiltradas = [];
let produtosFiltrados = [];

let produtosOrdenados = [];

async function fetchProdutos() {
  const response = await fetch(`${BASE_URL}/getProdutos`);
  produtosOriginais = await response.json(); // Salva os produtos originais
  produtosFiltrados = [...produtosOriginais]; // Inicializa os filtrados com todos os produtos
  produtosOrdenados = [...produtosFiltrados]; // Inicializa os ordenados com os produtos filtrados
  buscarProduto(); // Inicializa o evento de busca 
  mostrarPagina(paginaAtual); // Mostra a primeira página
}
async function fetchCategorias() {
  const response = await fetch(`${BASE_URL}/getCategorias`);
  categorias = await response.json();
  preencherCategorias(categorias, () => alterarTabelaPorCategoriaSelecionada());
  renderizarTabela(categorias);
}
async function fetchClientes() {
  const response = await fetch(`${BASE_URL}/getClientes`);
  clientes = await response.json();
  preencherClientes(clientes);

}
async function fetchFornecedores() {
  const response = await fetch(`${BASE_URL}/getFornecedores`);
  fornecedores = await response.json();
  preencherFornecedores(fornecedores);
}
async function fetchEntradas() {
  const response = await fetch(`${BASE_URL}/getEntradas`);
  entradas = await response.json();
  entradasFiltradas = [...entradas]; // Inicializa as filtradas
  mostrarPaginaEntradas(paginaAtualEntradas);
  buscarEntrada();
  filtrarEntradasPorData();
}
async function fetchSaidas() {
  const response = await fetch(`${BASE_URL}/getSaidas`);
  saidas = await response.json();
  saidasFiltradas = [...saidas];
  mostrarPaginaSaidas(paginaAtualSaidas);
  buscarSaida();
  filtrarSaidasPorData();
}

function loadAllData() {
  fetchProdutos();
  fetchCategorias();
  fetchClientes();
  fetchFornecedores();
  fetchEntradas();
  fetchSaidas();
}

function formatarData(dataISO) {
  const data = new Date(dataISO);
  return data.toLocaleDateString("pt-BR", {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
  });
}

function renderizarTabela() {
  const tbody = document.getElementById("corpoTabelaCategorias");
  tbody.innerHTML = "";

  categorias.forEach((categoria) => {
    const tr = document.createElement("tr");

    tr.innerHTML = `
            <td>${categoria.nome}</td>
            <td>${categoria.descricao}</td>
            <td class="text-center">
                <button class="btn btn-primary btn-sm action-btn" onclick="editarCategoria(${categoria.id})" title="Editar">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm action-btn" onclick="excluirCategoria(${categoria.id})" title="Excluir">
                  <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        `;

    tbody.appendChild(tr);
  });
}


function buscarProduto() {
  const inputBuscarProduto = document.getElementById("buscarProduto");
  if (!inputBuscarProduto) return;
  
  // Remover event listener anterior para evitar duplicações
  const buscarProdutoHandler = debounce(function(e) {
    console.time('busca-produto');
    const termoBusca = e.target.value.toLowerCase();

    produtosFiltrados = produtosOriginais.filter(
      (produto) =>
        (produto.nome?.toLowerCase() || '').includes(termoBusca) ||
        (produto.codigo_produto?.toLowerCase() || '').includes(termoBusca)
    );

    // Reiniciar a ordenação com os produtos filtrados
    produtosOrdenados = [...produtosFiltrados];
    paginaAtual = 1; // Reinicia na primeira página
    mostrarPagina(paginaAtual); // Atualiza a tabela
    console.timeEnd('busca-produto');
  }, 300);
  
  // Remover event listeners antigos e adicionar o novo
  inputBuscarProduto.removeEventListener("input", buscarProdutoHandler);
  inputBuscarProduto.addEventListener("input", buscarProdutoHandler);
}

function removerAcentos(str) {
  if (!str) return '';
  return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

function buscarEntrada() {
  const inputBuscarEntrada = document.getElementById("buscarEntrada");
  if (!inputBuscarEntrada) return;
  
  const buscarEntradaHandler = debounce(function(e) {
    const termoBusca = removerAcentos(e.target.value.toLowerCase());
    
    // Usar um mapa para acesso mais rápido aos produtos e fornecedores
    const produtosMap = new Map();
    const fornecedoresMap = new Map();
    
    // Preencher mapas para busca rápida
    produtosOriginais.forEach(p => produtosMap.set(p.id, p));
    fornecedores.forEach(f => fornecedoresMap.set(f.id, f));

    entradasFiltradas = entradas.filter((entrada) => {
      const produto = produtosMap.get(entrada.idProdutos);
      const fornecedor = fornecedoresMap.get(entrada.idFornecedor);
      
      return (
        removerAcentos((produto?.nome || '').toLowerCase()).includes(termoBusca) ||
        removerAcentos((fornecedor?.nome || '').toLowerCase()).includes(termoBusca)
      );
    });

    paginaAtualEntradas = 1;
    mostrarPaginaEntradas(paginaAtualEntradas); // Atualiza a tabela com os resultados filtrados
  }, 300);
  
  // Remover event listeners antigos e adicionar o novo
  inputBuscarEntrada.removeEventListener("input", buscarEntradaHandler);
  inputBuscarEntrada.addEventListener("input", buscarEntradaHandler);
}

function buscarSaida() {
  const inputBuscarSaida = document.getElementById("buscarSaida");
  if (!inputBuscarSaida) return;
  
  const buscarSaidaHandler = debounce(function(e) {
    const termoBusca = removerAcentos(e.target.value.toLowerCase());
    
    // Usar um mapa para acesso mais rápido aos produtos e clientes
    const produtosMap = new Map();
    const clientesMap = new Map();
    
    // Preencher mapas para busca rápida
    produtosOriginais.forEach(p => produtosMap.set(p.id, p));
    if (Array.isArray(clientes)) {
      clientes.forEach(c => clientesMap.set(c.id, c));
    }

    saidasFiltradas = saidas.filter((saida) => {
      const produto = produtosMap.get(saida.idProdutos);
      const cliente = clientesMap.get(saida.idClientes);
      const nomeCliente = cliente?.nome || "Cliente não encontrado";

      return (
        removerAcentos((produto?.nome || '').toLowerCase()).includes(termoBusca) ||
        removerAcentos(nomeCliente.toLowerCase()).includes(termoBusca)
      );
    });

    paginaAtualSaidas = 1;
    mostrarPaginaSaidas(paginaAtualSaidas); // Atualiza a tabela com os resultados filtrados
  }, 300);
  
  // Remover event listeners antigos e adicionar o novo
  inputBuscarSaida.removeEventListener("input", buscarSaidaHandler);
  inputBuscarSaida.addEventListener("input", buscarSaidaHandler);
}



function mostrarPaginaEntradas(pagina) {
  const inicio = (pagina - 1) * itensPorPagina;
  const fim = inicio + itensPorPagina;
  
  // Ordenar as entradas da mais recente para a mais antiga
  // Usar uma cópia para não modificar o array original diretamente
  const entradasOrdenadas = [...entradasFiltradas].sort(
    (a, b) => new Date(b.created_at) - new Date(a.created_at)
  );
  
  // Paginar os resultados
  const entradasPagina = entradasOrdenadas.slice(inicio, fim);
  
  // Selecionar a tabela e limpar seu conteúdo
  const tabela = document.querySelector("#tabelaEntradas tbody");
  if (!tabela) return;
  
  // Criar mapas para acesso rápido
  const produtosMap = new Map();
  const fornecedoresMap = new Map();
  
  produtosOriginais.forEach(p => produtosMap.set(p.id, p));
  fornecedores.forEach(f => fornecedoresMap.set(f.id, f));
  
  // Criar fragment para otimizar inserções no DOM
  const fragment = document.createDocumentFragment();
  
  // Exibir mensagem caso não haja entradas
  if (entradasPagina.length === 0) {
    const tr = document.createElement('tr');
    tr.innerHTML = `<tr><td colspan="6" class="text-center">Nenhuma entrada encontrada.</td></tr>`;
    fragment.appendChild(tr);
  } else {
    // Preencher a tabela com as entradas paginadas
    entradasPagina.forEach((entrada) => {
      const produto = produtosMap.get(entrada.idProdutos);
      const fornecedor = fornecedoresMap.get(entrada.idFornecedor);
      
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${fornecedor?.nome || "Fornecedor não encontrado"}</td>
        <td>${produto?.nome || "Produto não encontrado"}</td>
        <td>${entrada.quantidade}</td>
        <td>${entrada.preco.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })}</td>
        <td>${formatarData(entrada.created_at)}</td>
        <td class="text-center">
          <button class="btn btn-primary btn-sm action-btn" onclick="editarEntrada(${entrada.id})" title="Editar">
            <i class="fas fa-edit"></i>
          </button>
          <button class="btn btn-danger btn-sm action-btn" data-bs-toggle="modal" data-bs-target="#modalExcluirEntrada" onclick="excluirEntrada(${entrada.id})" title="Excluir">
            <i class="fas fa-trash-alt"></i>
          </button>
        </td>
      `;
      fragment.appendChild(tr);
    });
  }
  
  // Limpar a tabela e adicionar o fragment
  tabela.innerHTML = '';
  tabela.appendChild(fragment);
  
  // Configurar a paginação
  configurarPaginacao(
    entradasFiltradas.length, 
    mostrarPaginaEntradas, 
    "#paginacaoEntradas", 
    pagina
  );
  
  // Atualizar página atual
  paginaAtualEntradas = pagina;
}

function mostrarPaginaSaidas(pagina) {
  const inicio = (pagina - 1) * itensPorPagina;
  const fim = inicio + itensPorPagina;

  // Ordenar as saídas da mais recente para a mais antiga
  const saidasOrdenadas = [...saidasFiltradas].sort(
    (a, b) => new Date(b.created_at) - new Date(a.created_at)
  );

  // Paginar os resultados
  const saidasPagina = saidasOrdenadas.slice(inicio, fim);

  // Selecionar a tabela e limpar seu conteúdo
  const tabela = document.querySelector("#tabelaSaidas tbody");
  if (!tabela) return;
  
  // Criar mapas para acesso rápido
  const produtosMap = new Map();
  const clientesMap = new Map();
  
  produtosOriginais.forEach(p => produtosMap.set(p.id, p));
  if (Array.isArray(clientes)) {
    clientes.forEach(c => clientesMap.set(c.id, c));
  }
  
  // Criar fragment para otimizar inserções no DOM
  const fragment = document.createDocumentFragment();

  // Exibir mensagem caso não haja saídas
  if (saidasPagina.length === 0) {
    const tr = document.createElement('tr');
    tr.innerHTML = `<td colspan="6" class="text-center">Nenhuma saída encontrada.</td>`;
    fragment.appendChild(tr);
  } else {
    // Preencher a tabela com as saídas paginadas
    saidasPagina.forEach((saida) => {
      const produto = produtosMap.get(saida.idProdutos);
      const cliente = clientesMap.get(saida.idClientes);
      const nomeCliente = cliente?.nome || "Cliente não encontrado";

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${nomeCliente}</td>
        <td>${produto?.nome || "Produto não encontrado"}</td>
        <td>${saida.quantidade}</td>
        <td>${saida.preco.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })}</td>
        <td>${formatarData(saida.created_at)}</td>
        <td class="text-center">
          <button class="btn btn-primary btn-sm action-btn" onclick="editarSaida(${saida.id})" title="Editar">
            <i class="fas fa-edit"></i>
          </button>
          <button class="btn btn-danger btn-sm action-btn" data-bs-toggle="modal" data-bs-target="#modalExcluirSaida" onclick="excluirSaida(${saida.id})" title="Excluir">
            <i class="fas fa-trash-alt"></i>
          </button>
        </td>
      `;
      fragment.appendChild(tr);
    });
  }
  
  // Limpar a tabela e adicionar o fragment
  tabela.innerHTML = '';
  tabela.appendChild(fragment);

  // Configurar a paginação
  configurarPaginacao(
    saidasFiltradas.length, 
    mostrarPaginaSaidas, 
    "#paginacaoSaidas", 
    pagina
  );
  
  // Atualizar página atual
  paginaAtualSaidas = pagina;
}



function filtrarEntradasPorData() {
  const dataFiltro = document.querySelector("#filtroDataEntrada").value; // Pega a data do filtro
  if (!dataFiltro) return; // Não faz nada se o campo de data estiver vazio



  // Filtra as entradas com a data selecionada
  entradasFiltradas = entradas.filter((entrada) => {
    // Extrai a parte da data de created_at (formato YYYY-MM-DD)
    const dataEntrada = entrada.created_at.split(" ")[0]; // Pega a data sem a hora (ex: 2024-12-22)


    // Compara as datas no formato YYYY-MM-DD
    return dataEntrada === dataFiltro;
  });

  // Verifica se há entradas filtradas, caso contrário exibe uma mensagem
  if (entradasFiltradas.length === 0) {
    mostrarMensagemNenhumaEntrada();
  } else {
    // Exibe a primeira página das entradas filtradas
    mostrarPaginaEntradas(1);
  }
}

function mostrarMensagemNenhumaEntrada() {
  // Seleciona a tabela de entradas e limpa seu conteúdo
  const tabela = document.querySelector("#tabelaEntradas tbody");
  tabela.innerHTML = `<tr><td colspan="6" class="text-center">Nenhuma entrada encontrada para a data selecionada.</td></tr>`;
}

function filtrarSaidasPorData() {
  const dataFiltro = document.querySelector("#filtroDataSaida").value; // Pega a data do filtro
  if (!dataFiltro) return; // Não faz nada se o campo de data estiver vazio


  // Filtra as saídas com a data selecionada
  saidasFiltradas = saidas.filter((saida) => {
    // Extrai a parte da data de created_at (formato YYYY-MM-DD)
    const dataSaida = saida.created_at.split(" ")[0]; // Pega a data sem a hora (ex: 2024-12-22)


    // Compara as datas no formato YYYY-MM-DD
    return dataSaida === dataFiltro;
  });

  // Verifica se há saídas filtradas, caso contrário exibe uma mensagem
  if (saidasFiltradas.length === 0) {
    mostrarMensagemNenhumaSaida();
  } else {
    // Exibe a primeira página das saídas filtradas
    mostrarPaginaSaidas(1);
  }
}

function mostrarMensagemNenhumaSaida() {
  // Seleciona a tabela de saídas e limpa seu conteúdo
  const tabela = document.querySelector("#tabelaSaidas tbody");
  tabela.innerHTML = `<tr><td colspan="6" class="text-center">Nenhuma saída encontrada para a data selecionada.</td></tr>`;
}

function configurarPaginacao(
  totalItens,
  callback,
  seletorPaginacao,
  paginaAtual
) {
  const totalPaginas = Math.ceil(totalItens / itensPorPagina);
  const container = document.querySelector(seletorPaginacao);
  if (!container) return;
  
  // Criar um fragment para otimizar as inserções no DOM
  const fragment = document.createDocumentFragment();
  
  // Se não houver itens ou apenas uma página, não mostrar paginação
  if (totalPaginas <= 1) {
    container.innerHTML = '';
    return;
  }
  
  // Calcular o intervalo de botões a exibir
  let startPage = Math.max(1, paginaAtual - Math.floor(maxBotoesPaginacao / 2));
  let endPage = Math.min(totalPaginas, startPage + maxBotoesPaginacao - 1);
  
  // Ajustar startPage se não tivermos suficientes no final
  if (endPage - startPage + 1 < maxBotoesPaginacao) {
    startPage = Math.max(1, endPage - maxBotoesPaginacao + 1);
  }

  // Botão "Anterior"
  const btnAnterior = document.createElement('li');
  btnAnterior.className = `page-item ${paginaAtual === 1 ? 'disabled' : ''}`;
  btnAnterior.innerHTML = `<a class="page-link" href="#">Anterior</a>`;
  
  if (paginaAtual > 1) {
    const link = btnAnterior.querySelector('a');
    link.addEventListener('click', function(e) {
      e.preventDefault();
      callback(paginaAtual - 1);
    });
  }
  
  fragment.appendChild(btnAnterior);

  // Botões de número de página
  for (let i = startPage; i <= endPage; i++) {
    const btnPagina = document.createElement('li');
    btnPagina.className = `page-item ${i === paginaAtual ? 'active' : ''}`;
    btnPagina.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    
    const link = btnPagina.querySelector('a');
    link.addEventListener('click', function(e) {
      e.preventDefault();
      callback(i);
    });
    
    fragment.appendChild(btnPagina);
  }

  // Botão "Próximo"
  const btnProximo = document.createElement('li');
  btnProximo.className = `page-item ${paginaAtual === totalPaginas ? 'disabled' : ''}`;
  btnProximo.innerHTML = `<a class="page-link" href="#">Próximo</a>`;
  
  if (paginaAtual < totalPaginas) {
    const link = btnProximo.querySelector('a');
    link.addEventListener('click', function(e) {
      e.preventDefault();
      callback(paginaAtual + 1);
    });
  }
  
  fragment.appendChild(btnProximo);

  // Limpar o container e adicionar o fragment
  container.innerHTML = '';
  container.appendChild(fragment);
}

function editarEntrada(id) {
  const entrada = entradasFiltradas.find((e) => e.id === id); // Encontrar a entrada

  if (entrada) {
    // Obter o nome do produto com base no id do produto
    const produto = produtosOriginais.find((p) => p.id === entrada.idProdutos);
    const nomeProduto = produto ? produto.nome : "Produto não encontrado";

    // Preencher os campos do modal
    document.getElementById("idEntradaEditar").value = id;
    document.getElementById("entradaProduto").value = nomeProduto;
    document.getElementById("entradaQuantidade").value = entrada.quantidade;
    document.getElementById("entradaPreco").value = entrada.preco;

    // Abrir o modal
    const modalEditarEntrada = new bootstrap.Modal(
      document.getElementById("modalEditarEntrada"),
      {
        backdrop: "static", // Não fecha o modal de consulta ao abrir o de editar
        keyboard: false, // Impede o fechamento do modal com a tecla ESC
      }
    );
    modalEditarEntrada.show();
  } else {
    console.error("Entrada não encontrada.");
  }
}

function excluirEntrada(entradaId) {
  // Insere o ID da entrada no campo oculto do modal
  const inputEntradaId = document.getElementById("idEntradaExcluir");
  if (inputEntradaId) {
    inputEntradaId.value = entradaId;
  }

  // Fecha quaisquer modais abertos
  const modaisAbertos = document.querySelectorAll(".modal.show");
  modaisAbertos.forEach((modal) => {
    const bootstrapModal = bootstrap.Modal.getInstance(modal);
    if (bootstrapModal) bootstrapModal.hide();
  });

  // Remove backdrop existente, se houver
  document
    .querySelectorAll(".modal-backdrop")
    .forEach((backdrop) => backdrop.remove());

  // Exibe o modal de exclusão usando Bootstrap
  const modalExcluirEntrada = new bootstrap.Modal(
    document.getElementById("modalExcluirEntrada")
  );
  modalExcluirEntrada.show();
}

function editarSaida(id) {
  const saida = saidas.find((s) => s.id === id); // Encontre a saída pelo ID
  const produto = produtosOriginais.find((p) => p.id === saida.idProdutos); // Encontre o produto correspondente à saída

  if (saida) {
    // Preencher os campos no modal
    document.getElementById("idEditarSaida").value = saida.id;
    document.getElementById("saidaProduto").value = produto.nome; // Nome do produto (não editável)
    document.getElementById("saidaQuantidade").value = saida.quantidade; // Quantidade
    document.getElementById("saidaPreco").value = saida.preco; // Preço

    // Abrir o modal de edição sem fechar o modal anterior
    const modalEditarSaida = new bootstrap.Modal(
      document.getElementById("modalEditarSaida"),
      {
        backdrop: "static", // Não fecha o modal de consulta ao abrir o de editar
        keyboard: false, // Impede o fechamento do modal com a tecla ESC
      }
    );
    modalEditarSaida.show();
  } else {
    console.error("Saída não encontrada.");
  }
}

function excluirSaida(saidaId) {
  // Fecha manualmente qualquer modal aberto
  const modaisAbertos = document.querySelectorAll(".modal.show");
  modaisAbertos.forEach((modal) => {
    const bootstrapModal = bootstrap.Modal.getInstance(modal);
    if (bootstrapModal) bootstrapModal.hide();
  });

  // Remove backdrop existente, se houver
  document
    .querySelectorAll(".modal-backdrop")
    .forEach((backdrop) => backdrop.remove());

  // Configura o modal de exclusão
  const inputSaidaId = document.getElementById("idSaidaExcluir");
  if (inputSaidaId) {
    inputSaidaId.value = saidaId;
  }

  // Exibe o modal de exclusão
  const modalExcluir = new bootstrap.Modal(
    document.getElementById("modalExcluirSaida")
  );
  modalExcluir.show();
}

document.addEventListener("DOMContentLoaded", () => {
  const consultarEntradasBtn = document.getElementById("consultarEntradasBtn");
  const consultarSaidasBtn = document.getElementById("consultarSaidasBtn");
  const entradasModalElement = document.getElementById("entradasModal");
  const saidasModalElement = document.getElementById("saidasModal");

  if (
    !consultarEntradasBtn ||
    !consultarSaidasBtn ||
    !entradasModalElement ||
    !saidasModalElement
  ) {
    console.error("Botões ou modais não encontrados no DOM.");
    return;
  }

  // Inicializar os modais
  const entradasModal = new bootstrap.Modal(entradasModalElement);
  const saidasModal = new bootstrap.Modal(saidasModalElement);

  consultarEntradasBtn.addEventListener("click", () => {
    entradasModal.show();
    fetchEntradas();
  });

  consultarSaidasBtn.addEventListener("click", () => {
    saidasModal.show();
    fetchSaidas();
  });
});

function preencherTabelaProdutos(produtosPaginados) {
  const corpoTabela = document.getElementById("corpoTabela");
  corpoTabela.innerHTML = ""; // Limpa a tabela

  if (!produtosPaginados || produtosPaginados.length === 0) {
    return; // Se não há produtos, apenas limpa a tabela
  }

  produtosPaginados.forEach((produto) => {
    const tr = document.createElement("tr");
    const {
      codigo_produto,
      nome,
      descricao,
      preco,
      quantidade,
      unidade_medida,
    } = produto;

    const precoFormatado = preco.toLocaleString("pt-BR", {
      style: "currency",
      currency: "BRL",
    });

    // Truncar descrição se for muito longa
    const descricaoTruncada = descricao.length > 50 
      ? `${descricao.substring(0, 50)}...` 
      : descricao;

    // Determinar status com base na quantidade
    let statusHTML = '';
    if (quantidade === 0) {
      statusHTML = '<span class="status-badge esgotado">Esgotado</span>';
    } else if ((unidade_medida === 'KG' && quantidade <= 1) || (unidade_medida === 'UN' && quantidade <= 5)) {
      statusHTML = '<span class="status-badge pouco">Estoque Baixo</span>';
    } else {
      statusHTML = '<span class="status-badge disponivel">Disponível</span>';
    }

    // Criar células da tabela
    const tdCodigo = document.createElement("td");
    tdCodigo.textContent = codigo_produto;
    tr.appendChild(tdCodigo);

    const tdNome = document.createElement("td");
    tdNome.textContent = nome;
    tr.appendChild(tdNome);

    const tdDescricao = document.createElement("td");
    tdDescricao.textContent = descricaoTruncada;
    
    // Adicionar tooltip para descrições truncadas
    if (descricao.length > 50) {
      tdDescricao.title = descricao;
      tdDescricao.classList.add('text-truncate', 'max-width-description');
    }
    tr.appendChild(tdDescricao);

    const tdPreco = document.createElement("td");
    tdPreco.textContent = precoFormatado;
    tr.appendChild(tdPreco);

    const tdQuantidade = document.createElement("td");
    tdQuantidade.textContent = quantidade;
    tr.appendChild(tdQuantidade);

    const tdUnidade = document.createElement("td");
    tdUnidade.textContent = unidade_medida;
    tr.appendChild(tdUnidade);

    const tdStatus = document.createElement("td");
    tdStatus.innerHTML = statusHTML;
    tr.appendChild(tdStatus);

    tr.appendChild(createButtonGroup(produto)); // Adiciona os botões de ação
    corpoTabela.appendChild(tr);
  });
}

function mostrarPagina(pagina) {
  const inicio = (pagina - 1) * itensPorPagina;
  const fim = inicio + itensPorPagina;
  
  // Paginar os resultados
  const produtosPagina = produtosOrdenados.slice(inicio, fim);
  
  // Selecionar a tabela e limpar seu conteúdo
  const tabela = document.getElementById("corpoTabela");
  if (!tabela) return;
  
  // Criar um fragment para otimizar as inserções no DOM
  const fragment = document.createDocumentFragment();
  
  // Exibir mensagem caso não haja produtos
  if (produtosPagina.length === 0) {
    const tr = document.createElement('tr');
    tr.innerHTML = `<td colspan="8" class="text-center">Nenhum produto encontrado.</td>`;
    fragment.appendChild(tr);
  } else {
    // Criar mapa de categorias para acesso mais rápido
    const categoriasMap = new Map();
    categorias.forEach(c => categoriasMap.set(c.id, c));
    
    // Preencher a tabela com os produtos paginados
    produtosPagina.forEach((produto) => {
      const categoria = categoriasMap.get(produto.idCategorias);
      const status = produto.quantidade > 0 ? "Disponível" : "Indisponível";
      
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${produto.codigo_produto || ''}</td>
        <td>${produto.nome || ''}</td>
        <td>${produto.descricao || ''}</td>
        <td>${produto.preco ? produto.preco.toLocaleString("pt-BR", { style: "currency", currency: "BRL" }) : 'R$ 0,00'}</td>
        <td>${produto.quantidade || 0}</td>
        <td>${produto.unidade_medida || ''}</td>
        <td>${status}</td>
        <td class="text-center">
          <button class="btn btn-primary btn-sm action-btn" data-bs-toggle="modal" data-bs-target="#modalEditar" onclick="prepararEdicaoProduto(${produto.id})" title="Editar">
            <i class="fas fa-edit"></i>
          </button>
          <button class="btn btn-danger btn-sm action-btn" data-bs-toggle="modal" data-bs-target="#modalExcluir" onclick="prepararExclusao(${produto.id})" title="Excluir">
            <i class="fas fa-trash-alt"></i>
          </button>
          <button class="btn btn-success btn-sm action-btn" data-bs-toggle="modal" data-bs-target="#modalEntrada" onclick="prepararEntrada(${produto.id})" title="Adicionar Entrada">
            <i class="fas fa-arrow-circle-down"></i>
          </button>
          <button class="btn btn-warning btn-sm action-btn" data-bs-toggle="modal" data-bs-target="#modalSaida" onclick="prepararSaida(${produto.id})" title="Adicionar Saída">
            <i class="fas fa-arrow-circle-up"></i>
          </button>
        </td>
      `;
      
      fragment.appendChild(tr);
    });
  }
  
  // Limpar a tabela e adicionar o fragmento
  tabela.innerHTML = '';
  tabela.appendChild(fragment);
  
  // Atualizar a paginação
  atualizarPaginacao(produtosOrdenados.length, pagina);
  
  // Atualizar página atual
  paginaAtual = pagina;
}

function atualizarPaginacao(totalProdutos, paginaAtual) {
  const totalPaginas = Math.ceil(totalProdutos / itensPorPagina);
  const pagination = document.getElementById("pagination");
  pagination.innerHTML = ""; // Limpa o container de paginação

  const paginaInicial = Math.max(
    1,
    paginaAtual - Math.floor(maxBotoesPaginacao / 2)
  );
  const paginaFinal = Math.min(
    totalPaginas,
    paginaInicial + maxBotoesPaginacao - 1
  );

  // Botão "Anterior"
  if (paginaAtual > 1) {
    const liPrev = document.createElement("li");
    liPrev.classList.add("page-item");
    const aPrev = document.createElement("a");
    aPrev.classList.add("page-link");
    aPrev.textContent = "Anterior";
    aPrev.onclick = () => mostrarPagina(paginaAtual - 1, produtos);
    liPrev.appendChild(aPrev);
    pagination.appendChild(liPrev);
  }

  // Botões das páginas
  for (let i = paginaInicial; i <= paginaFinal; i++) {
    const li = document.createElement("li");
    li.classList.add("page-item");
    if (i === paginaAtual) {
      li.classList.add("active"); // Adiciona a classe ativa na página atual
    }

    const a = document.createElement("a");
    a.classList.add("page-link");
    a.textContent = i;
    a.onclick = () => {
      mostrarPagina(i, produtos); // Navega para a página correspondente
    };
    li.appendChild(a);
    pagination.appendChild(li);
  }

  // Botão "Próximo"
  if (paginaAtual < totalPaginas) {
    const liNext = document.createElement("li");
    liNext.classList.add("page-item");
    const aNext = document.createElement("a");
    aNext.classList.add("page-link");
    aNext.textContent = "Próximo";
    aNext.onclick = () => mostrarPagina(paginaAtual + 1, produtos);
    liNext.appendChild(aNext);
    pagination.appendChild(liNext);
  }
}


function alterarTabelaPorCategoriaSelecionada() {
  const categoriaSelecionada = document.getElementById("categoria").value;
  const categoriaSelecionadaNumero = Number(categoriaSelecionada);

  if (categoriaSelecionada && !isNaN(categoriaSelecionadaNumero)) {
    produtosFiltrados = produtosOriginais.filter(
      (produto) => Number(produto.idCategoria) === categoriaSelecionadaNumero
    );
  } else {
    produtosFiltrados = [...produtosOriginais]; // Reseta para todos os produtos
  }

  // Reiniciar a ordenação com os produtos filtrados
  produtosOrdenados = [...produtosFiltrados];
  paginaAtual = 1; // Reinicia na primeira página
  mostrarPagina(paginaAtual); // Mostra a tabela atualizada
}

function ordenarProdutos(produtos) {
  // Lógica de ordenação (dependendo da necessidade)
  return produtos; // Retorna os produtos ordenados
}

function preencherCategorias(categorias, onChangeCallback) {
  // Encontre todos os selects de categoria na página
  const selectsCategorias = [
    document.getElementById("categoria"),                  // Filtro principal
    document.getElementById("categoriaProdutoAdicionar"),  // Modal adicionar
    document.getElementById("categoriaProdutoEditar")      // Modal editar
  ];

  // Iterar sobre todos os selects encontrados e preencher cada um
  selectsCategorias.forEach(select => {
    if (select) {
      // Limpar as opções existentes
      select.innerHTML = "";

      // Adicionar a opção vazia para filtro (apenas no filtro principal)
      if (select.id === "categoria") {
        const optionVazia = document.createElement("option");
        optionVazia.value = "";
        optionVazia.textContent = "Todas as categorias";
        select.appendChild(optionVazia);
      }

      // Adicionar as categorias
      if (Array.isArray(categorias)) {
        categorias.forEach(categoria => {
          const option = document.createElement("option");
          option.value = categoria.id;
          option.textContent = categoria.nome;
          select.appendChild(option);
        });
      }

      // Adicionar o evento de change, se fornecido
      if (onChangeCallback && typeof onChangeCallback === 'function') {
        select.addEventListener("change", onChangeCallback);
      }
    }
  });

  console.log("Categorias carregadas:", categorias);
}

function preencherFornecedores(fornecedores) {
  const input = document.getElementById("fornecedor");
  const lista = document.getElementById("fornecedor-lista");

  input.addEventListener("input", () => {
    const query = input.value.toLowerCase().trim();
    lista.innerHTML = "";

    if (query === "") {
      lista.style.display = "none";
      return;
    }

    const fornecedoresFiltrados = fornecedores.filter((fornecedor) =>
      fornecedor.nome.toLowerCase().includes(query)
    );

    if (fornecedoresFiltrados.length > 0) {
      lista.style.display = "block";
      fornecedoresFiltrados.forEach((fornecedor) => {
        const item = document.createElement("div");
        item.classList.add("list-group-item", "list-group-item-action");
        item.textContent = fornecedor.nome;
        item.addEventListener("click", () => {
          input.value = fornecedor.nome;
          lista.style.display = "none";
        });
        lista.appendChild(item);
      });
    } else {
      lista.style.display = "none";
    }
  });

  input.addEventListener("blur", () => {
    setTimeout(() => {
      lista.style.display = "none";
    }, 200);
  });

  input.addEventListener("focus", () => {
    if (input.value.trim() !== "") {
      lista.style.display = "block";
    }
  });
}

function preencherClientes(clientes) {
  const input = document.getElementById("cliente");
  const lista = document.getElementById("clientes-lista");

  input.addEventListener("input", () => {
    const query = input.value.toLowerCase();
    lista.innerHTML = "";

    if (query === "") {
      lista.style.display = "none";
      return;
    }

    const clientesFiltrados = clientes.filter((cliente) =>
      cliente.nome.toLowerCase().includes(query)
    );

    if (clientesFiltrados.length > 0) {
      lista.style.display = "block";
      clientesFiltrados.forEach((cliente) => {
        const item = document.createElement("div");
        item.classList.add("list-group-item", "list-group-item-action");
        item.textContent = cliente.nome;
        item.addEventListener("click", () => {
          input.value = cliente.nome;
          lista.style.display = "none";
        });
        lista.appendChild(item);
      });
    } else {
      lista.style.display = "none";
    }
  });

  input.addEventListener("blur", () => {
    setTimeout(() => {
      lista.style.display = "none";
    }, 200);
  });

  input.addEventListener("focus", () => {
    if (input.value.trim() !== "") {
      lista.style.display = "block";
    }
  });
}

function abrirModalAdicionarProduto() {
  const modalAdicionarProduto = new bootstrap.Modal(
    document.getElementById("modalAdicionarProduto")
  );
  modalAdicionarProduto.show();
}

function abrirModalEditarEntrada(entrada) {
  const modalEditarEntrada = new bootstrap.Modal(
    document.getElementById("modalEditarEntrada")
  );
  document.getElementById("idProdutoEntrada").value = entrada.idProdutos;
  document.getElementById("quantidadeEntrada").value = entrada.quantidade;
  modalEditarEntrada.show();

  document.getElementById("formEditarEntrada").onsubmit = function (e) {
    e.preventDefault();
    const idProduto = document.getElementById("idProdutoEntrada").value;
    const quantidade = document.getElementById("quantidadeEntrada").value;

    alert(`Entrada Editada: Produto ID ${idProduto}, Quantidade ${quantidade}`);
    modalEditarEntrada.hide();
  };
}

function abrirModalEditarSaida(saida) {
  const modalEditarSaida = new bootstrap.Modal(
    document.getElementById("modalEditarSaida")
  );
  document.getElementById("idProdutoSaida").value = saida.idProdutos;
  document.getElementById("quantidadeSaida").value = saida.quantidade;
  modalEditarSaida.show();

  document.getElementById("formEditarSaida").onsubmit = function (e) {
    e.preventDefault();
    const idProduto = document.getElementById("idProdutoSaida").value;
    const quantidade = document.getElementById("quantidadeSaida").value;

    alert(`Saída Editada: Produto ID ${idProduto}, Quantidade ${quantidade}`);
    modalEditarSaida.hide();
  };
}

document.getElementById("categoria").addEventListener("change", function () {
  alterarTabelaPorCategoriaSelecionada(produtos);
});

document
  .getElementById("clienteNaoCadastrado")
  .addEventListener("change", function () {
    const clienteInput = document.getElementById("cliente");

    if (this.checked) {
      // Cliente não cadastrado selecionado
      clienteInput.readOnly = true;
      clienteInput.value = "Cliente não cadastrado";
      clienteInput.placeholder = "Cliente não cadastrado";
      clienteInput.classList.add("text-muted");
    } else {
      // Cliente cadastrado selecionado
      clienteInput.readOnly = false;
      clienteInput.value = "";
      clienteInput.placeholder = "Digite o nome do cliente";
      clienteInput.classList.remove("text-muted");
    }
  });

function createButtonGroup(produto) {
  const actions = [
    {
      text: "Editar",
      icon: "fas fa-edit",
      class: "btn-primary",
      action: () => openModal("Editar", produto, produto.id, categorias),
    },
    {
      text: "Excluir",
      icon: "fas fa-trash-alt",
      class: "btn-danger",
      action: () => openModal("Excluir", produto.id),
    },
    {
      text: "Adicionar Entrada",
      icon: "fas fa-arrow-circle-down",
      class: "btn-success",
      action: () => openModalEntrada(produto.id),
    },
    {
      text: "Adicionar Saída",
      icon: "fas fa-arrow-circle-up",
      class: "btn-warning",
      action: () => openModalSaida(produto.id, produto.preco),
    },
  ];

  const tdActions = document.createElement("td");
  tdActions.classList.add("text-center");
  
  actions.forEach(({ icon, text, class: btnClass, action }) => {
    const btn = document.createElement("button");
    btn.setAttribute("type", "button");
    btn.classList.add("btn", btnClass, "btn-sm", "action-btn");
    btn.innerHTML = `<i class="${icon}"></i>`;
    btn.title = text;
    btn.addEventListener("click", action);
    tdActions.appendChild(btn);
  });

  return tdActions;
}

function openModal(tipo, produto) {
  const modalId = tipo === "Editar" ? "modalEditar" : "modalExcluir";

  if (tipo === "Editar") {
    document.getElementById("idProdutoUpdate").value = produto.id;
    document.getElementById("codigoProdutoEditar").value =
      produto.codigo_produto;
    document.getElementById("nomeProduto").value = produto.nome;
    document.getElementById("descricaoProduto").value = produto.descricao;
    document.getElementById("fotoProduto").value = ""; // Limpa o campo (opcional)
    document.getElementById("previewImagem").src = produto.imagem; // Define o src da imagem
    document.getElementById("previewImagem").style.display = "block"; // Mostra a imagem
    // Configurar unidade de medida
    const unidadeSelect = document.getElementById("unidadeProdutoEditar");
    const unidadeMedida = produto.unidade_medida;

    // Resetar a seleção para garantir que a opção padrão seja mostrada se necessário
    unidadeSelect.querySelector('option[disabled]').selected = true;
    
    // Verificar se a unidade é válida (KG ou UN) e selecioná-la
    if (unidadeMedida === 'KG' || unidadeMedida === 'UN') {
      // Selecionar a unidade do produto
      unidadeSelect.value = unidadeMedida;
    } else if (unidadeMedida) {
      // Se for uma unidade antiga diferente de KG ou UN, 
      // adicionar temporariamente uma opção para este produto específico
      const optionExiste = Array.from(unidadeSelect.options).some(
        (option) => option.value === unidadeMedida
      );
      
      if (!optionExiste) {
        const novaOption = document.createElement("option");
        novaOption.value = unidadeMedida;
        novaOption.textContent = unidadeMedida + ' (unidade legada)';
        novaOption.className = 'legacy-unit';
        unidadeSelect.appendChild(novaOption);
        unidadeSelect.value = unidadeMedida;
      }
    }

    const precoProduto = document.getElementById("precoProduto");

    // Garante que `produto.preco` seja um número válido antes de formatar
    let preco = produto.preco ? parseFloat(produto.preco) : 0;

    // Define o valor formatado no campo de entrada
    precoProduto.value = preco.toLocaleString("pt-BR", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });


    // Configurar categorias no select
    const categoria = categorias.find(
      (categoria) => categoria.id === produto.idCategoria
    );
    const categoriaSelect = document.getElementById("categoriaProdutoEditar");
    categoriaSelect.innerHTML = ""; // Limpar opções anteriores

    // Adicionar uma opção padrão "Selecione uma categoria"
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Selecione uma categoria";
    categoriaSelect.appendChild(defaultOption);

    // Preencher as opções com as categorias disponíveis
    categorias.forEach((categoria) => {
      const option = document.createElement("option");
      option.value = categoria.id;
      option.textContent = categoria.nome;
      categoriaSelect.appendChild(option);
    });

    // Selecionar a categoria correspondente ao produto
    if (categoria) {
      categoriaSelect.value = categoria.id;
    }
  }

  if (tipo === "Excluir") {
    document.getElementById("idProdutoExcluir").value = produto;
  }

  // Exibir o modal correspondente
  new bootstrap.Modal(document.getElementById(modalId)).show();
}

function openModalEntrada(id) {
  const inputProdutoId = document.getElementById("produtoId");

  inputProdutoId.value = id;
  new bootstrap.Modal(document.getElementById("modalEntrada")).show();
}

function openModalSaida(id, preco) {
  const inputProdutoId = document.getElementById("produtoId2");
  const inputPrecoSaida = document.getElementById("precoSaida");

  inputProdutoId.value = id;

  // Verifica se o preço é maior que 0, senão define como 0 formatado
  if (!preco || preco <= 0) {
    inputPrecoSaida.value = "R$ 0,00";
  } else {
    // Formata o valor do preço como moeda (BRL) antes de exibir
    inputPrecoSaida.value = preco.toLocaleString("pt-BR", {
      style: "currency",
      currency: "BRL",
    });
  }

  // Exibe o modal
  new bootstrap.Modal(document.getElementById("modalSaida")).show();
}

let ordemAtual = {
  coluna: null,
  crescente: true,
};

function ordenarTabela(coluna, idSeta) {
  if (ordemAtual.coluna === coluna) {
    ordemAtual.crescente = !ordemAtual.crescente;
  } else {
    ordemAtual.coluna = coluna;
    ordemAtual.crescente = true;
  }

  // Atualizar setas
  document
    .querySelectorAll(".seta")
    .forEach((seta) => (seta.textContent = "⬍"));
  const setaAtual = document.getElementById(idSeta);
  setaAtual.textContent = ordemAtual.crescente ? "⬆" : "⬇";

  // Ordenar produtos filtrados
  produtosOrdenados = [...produtosFiltrados].sort((a, b) => {
    let valorA = a[coluna];
    let valorB = b[coluna];

    // Se for uma string, converter para minúscula para comparar corretamente
    if (typeof valorA === "string") {
      valorA = valorA.toLowerCase();
      valorB = valorB.toLowerCase();
    }

    // Converter para número se for numérico
    if (!isNaN(valorA) && !isNaN(valorB)) {
      valorA = Number(valorA);
      valorB = Number(valorB);
    }

    // Comparar de acordo com a ordem crescente ou decrescente
    if (ordemAtual.crescente) {
      return valorA > valorB ? 1 : valorA < valorB ? -1 : 0;
    } else {
      return valorA < valorB ? 1 : valorA > valorB ? -1 : 0;
    }
  });

  mostrarPagina(1); // Atualiza a tabela começando na primeira página
}

document
  .getElementById("ordenarCodigo")
  .addEventListener("click", () =>
    ordenarTabela("codigo_produto", "setaCodigo")
  );
document
  .getElementById("ordenarNome")
  .addEventListener("click", () => ordenarTabela("nome", "setaNome"));
document
  .getElementById("ordenarPreco")
  .addEventListener("click", () => ordenarTabela("preco", "setaPreco"));
document
  .getElementById("ordenarQuantidade")
  .addEventListener("click", () =>
    ordenarTabela("quantidade", "setaQuantidade")
  );

// Funções de exportação para Excel
async function exportarClientesExcel() {
  try {
    const response = await fetch(`${BASE_URL}/excel-r-c`);
    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'relatorio-clientes.xlsx';
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
  } catch (error) {
    console.error('Erro ao exportar clientes:', error);
    alert('Erro ao gerar relatório Excel de clientes');
  }
}

async function exportarFornecedoresExcel() {
  try {
    const response = await fetch(`${BASE_URL}/excel-r-f`);
    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'relatorio-fornecedores.xlsx';
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
  } catch (error) {
    console.error('Erro ao exportar fornecedores:', error);
    alert('Erro ao gerar relatório Excel de fornecedores');
  }
}

async function exportarProdutosExcel() {
  try {
    const response = await fetch(`${BASE_URL}/excel-r-p`);
    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'relatorio-produtos.xlsx';
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
  } catch (error) {
    console.error('Erro ao exportar produtos:', error);
    alert('Erro ao gerar relatório Excel de produtos');
  }
}

// Adiciona event listeners para os botões de Excel
document.addEventListener('DOMContentLoaded', function() {
  const excelClientesBtn = document.querySelector('a[href*="excel-r-c"]');
  const excelFornecedoresBtn = document.querySelector('a[href*="excel-r-f"]');
  const excelProdutosBtn = document.querySelector('a[href*="excel-r-p"]');

  if (excelClientesBtn) {
    excelClientesBtn.addEventListener('click', function(e) {
      e.preventDefault();
      exportarClientesExcel();
    });
  }

  if (excelFornecedoresBtn) {
    excelFornecedoresBtn.addEventListener('click', function(e) {
      e.preventDefault();
      exportarFornecedoresExcel();
    });
  }

  if (excelProdutosBtn) {
    excelProdutosBtn.addEventListener('click', function(e) {
      e.preventDefault();
      exportarProdutosExcel();
    });
  }
});

// Função de exportação para Excel
async function exportarRelatorioExcel(tipo) {
  try {
    const response = await fetch(`${BASE_URL}/excel-r-${tipo}`);
    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `relatorio-${tipo}.xlsx`;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
    document.body.removeChild(a);
  } catch (error) {
    console.error(`Erro ao exportar ${tipo}:`, error);
    alert(`Erro ao gerar relatório Excel de ${tipo}`);
  }
}

document
  .getElementById("categoria-cadastro")
  .addEventListener("submit", async function (event) {
    event.preventDefault();

    const nome = document.getElementById("nomeCategoriaAdicionar").value;
    const descricao = document.getElementById(
      "descricaoCategoriaAdicionar"
    ).value;

    const novaCategoria = {
      nome: nome,
      descricao: descricao,
    };

    try {
      const response = await fetch(`${BASE_URL}/addCategoria`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(novaCategoria),
      });

      if (response.ok) {
        const categoriaAdicionada = await response.json();
        categorias.push(categoriaAdicionada); // Adiciona a nova categoria à lista
        renderizarTabela();

        // Limpa e fecha o modal
        document.getElementById("nomeCategoriaAdicionar").value = "";
        document.getElementById("descricaoCategoriaAdicionar").value = "";
        const modal = bootstrap.Modal.getInstance(
          document.getElementById("modalAdicionarCategoria")
        );
        modal.hide();
      } else {
        console.error("Erro ao adicionar categoria");
      }
    } catch (error) {
      console.error("Erro ao adicionar categoria:", error);
    }
  });

function editarCategoria(id) {
  const categoria = categorias.find((cat) => cat.id === id);

  document.getElementById("idCategoriaEditar").value = categoria.id;
  document.getElementById("nomeCategoriaEditar").value = categoria.nome;
  document.getElementById("descricaoCategoriaEditar").value =
    categoria.descricao;

  const modalEditar = new bootstrap.Modal(
    document.getElementById("modalEditarCategoria")
  );
  modalEditar.show();
}

function excluirCategoria(id) {
  // Insere o ID da categoria no campo oculto do modal
  const inputCategoriaId = document.getElementById("idCategoriaExcluir");
  inputCategoriaId.value = id;

  // Mostra o modal de exclusão
  new bootstrap.Modal(document.getElementById("modalExcluirCategoria")).show();
}

// Adicionando as funções prepararEntrada e prepararSaida que são chamadas pelos botões
function prepararEntrada(id) {
  openModalEntrada(id);
}

function prepararSaida(id) {
  // Encontrar o produto pelo ID para obter o preço
  const produto = produtosOriginais.find(p => p.id == id);
  const preco = produto ? produto.preco : 0;
  
  openModalSaida(id, preco);
}

// Função para preparar a edição de um produto
function prepararEdicaoProduto(id) {
  // Encontrar o produto pelo ID
  const produto = produtosOriginais.find(p => p.id == id);
  
  // Se encontrou o produto, abrir o modal para edição
  if (produto) {
    openModal("Editar", produto);
  } else {
    console.error("Produto não encontrado:", id);
  }
}

// Função para preparar a exclusão de um produto
function prepararExclusao(id) {
  // Definir o ID do produto a ser excluído no campo oculto
  const inputIdProdutoExcluir = document.getElementById("idProdutoExcluir");
  if (inputIdProdutoExcluir) {
    inputIdProdutoExcluir.value = id;
  }
  
  // Abrir o modal de exclusão
  const modalExcluir = new bootstrap.Modal(document.getElementById("modalExcluir"));
  modalExcluir.show();
}

window.onload = loadAllData;

// Validação do formulário de adicionar produto
document.addEventListener('DOMContentLoaded', function() {
  const formAdicionarProduto = document.getElementById('produto-cadastro');
  if (formAdicionarProduto) {
    formAdicionarProduto.addEventListener('submit', function(event) {
      const unidadeSelect = document.getElementById('unidadeProdutoAdicionar');
      
      if (!unidadeSelect.value) {
        event.preventDefault();
        alert('Por favor, selecione uma unidade de medida.');
        unidadeSelect.focus();
      }
    });
  }
});
