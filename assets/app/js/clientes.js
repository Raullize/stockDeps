const BASE_URL = '/stockDeps/app';

const itensPorPaginaClientes = 8;   // Quantidade de clientes por página
const maxBotoesPaginacaoClientes = 5;
let paginaAtualClientes = 1;        // Sempre começar na página 1

let clientes = [];
let clientesFiltrados = []; // Variável global para armazenar clientes filtrados
let produtos = [];
let saidas = [];
let categorias = [];

let ordemAtualClientes = {
    coluna: 'nome',  // Ordenação padrão por nome
    crescente: true
};

async function fetchProdutos() {
    const response = await fetch(`${BASE_URL}/getProdutos`);
    produtos = await response.json();
}

async function fetchCategorias() {
    const response = await fetch(`${BASE_URL}/getCategorias`);
    categorias = await response.json();
}

async function fetchClientes() {
    try {
        console.log("Iniciando fetchClientes");
    const response = await fetch(`${BASE_URL}/getClientes`);
        
        if (!response.ok) {
            throw new Error(`Erro ao buscar clientes: ${response.status} ${response.statusText}`);
        }
        
    clientes = await response.json();
        console.log("Clientes recebidos:", clientes);
        
        if (!Array.isArray(clientes)) {
            console.error("Dados recebidos não são um array:", clientes);
            clientes = [];
        }
        
    clientesFiltrados = [...clientes];
        console.log("clientesFiltrados inicializado:", clientesFiltrados);
        
    aplicarOrdenacaoClientes();
    mostrarPaginaClientes(paginaAtualClientes);
        buscarCliente();
        
        console.log("fetchClientes concluído com sucesso");
    } catch (error) {
        console.error("Erro ao carregar clientes:", error);
        alert("Ocorreu um erro ao carregar os clientes. Verifique o console para mais detalhes.");
    }
}

async function fetchEntradas() {
    const response = await fetch(`${BASE_URL}/getEntradas`);
    const entradas = await response.json();
}

async function fetchSaidas() {
    console.log("Iniciando fetchSaidas");
    try {
    const response = await fetch(`${BASE_URL}/getSaidas`);
        
        if (!response.ok) {
            throw new Error(`Erro ao buscar saídas: ${response.status} ${response.statusText}`);
        }
        
        saidas = await response.json();
        
        console.log("Saídas recebidas:", saidas);
        
        // Verificar o formato das datas nas saídas
        if (Array.isArray(saidas) && saidas.length > 0) {
            console.log("Exemplo de saída:", saidas[0]);
            console.log("Formato da data em saídas:", typeof saidas[0].data, saidas[0].data);
            
            // Tentar converter a primeira data para verificar compatibilidade
            const dataTeste = new Date(saidas[0].data);
            console.log("Conversão de teste da data:", dataTeste, "É válida?", !isNaN(dataTeste.getTime()));
        } else {
            console.log("Nenhuma saída disponível para análise");
        }
    } catch (error) {
        console.error("Erro ao carregar saídas:", error);
        saidas = [];
    }
}

async function loadAllData() {
    console.log("Iniciando carregamento de dados");
    try {
        await fetchProdutos();
        console.log("Produtos carregados");
        
        await fetchCategorias();
        console.log("Categorias carregadas");
        
        await fetchClientes();
        console.log("Clientes carregados");
        
        await fetchEntradas();
        console.log("Entradas carregadas");
        
        await fetchSaidas();
        console.log("Saídas carregadas");
        
        console.log("Todos os dados foram carregados com sucesso");
    } catch (error) {
        console.error("Erro ao carregar dados:", error);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM carregado, iniciando aplicação");
    
    // Verificar se os elementos HTML necessários existem
    const tabelaClientes = document.querySelector("#tabelaClientes tbody");
    if (!tabelaClientes) {
        console.error("ERRO CRÍTICO: Tabela de clientes não encontrada no DOM!");
        alert("Erro ao inicializar a página de clientes. A tabela não foi encontrada.");
        return;
    } else {
        console.log("Tabela de clientes encontrada no DOM");
    }
    
    const paginacaoClientes = document.getElementById("paginationClientes");
    if (!paginacaoClientes) {
        console.error("ERRO: Elemento de paginação não encontrado no DOM!");
    } else {
        console.log("Elemento de paginação encontrado no DOM");
    }
    
    // Adicionar eventos de ordenação
    const ordenarNome = document.getElementById("ordenarNomeCliente");
    if (ordenarNome) {
        ordenarNome.addEventListener("click", () => ordenarTabelaClientes("nome", "setaNomeCliente"));
    }
    
    const ordenarCpf = document.getElementById("ordenarCpfCliente");
    if (ordenarCpf) {
        ordenarCpf.addEventListener("click", () => ordenarTabelaClientes("cpf", "setaCpfCliente"));
    }
    
    const ordenarTelefone = document.getElementById("ordenarTelefoneCliente");
    if (ordenarTelefone) {
        ordenarTelefone.addEventListener("click", () => ordenarTabelaClientes("celular", "setaTelefoneCliente"));
    }
    
    // Iniciar carregamento de dados
    loadAllData();
});

function preencherTabelaClientes(clientesPaginados) {
    console.log("Preenchendo tabela de clientes", clientesPaginados);
    
    const tabela = document.querySelector("#tabelaClientes tbody");
    if (!tabela) {
        console.error("Elemento da tabela não encontrado!");
        return;
    }
    
    // Limpar a tabela
    tabela.innerHTML = "";

    // Verificar se há dados para exibir
    if (!clientesPaginados || clientesPaginados.length === 0) {
        console.log("Nenhum cliente para exibir na tabela");
        tabela.innerHTML = `<tr><td colspan="4" class="text-center">Nenhum cliente encontrado</td></tr>`;
        return;
    }

    // Preencher com os dados dos clientes
    clientesPaginados.forEach((cliente, index) => {
        console.log(`Adicionando cliente ${index+1}:`, cliente.nome);
        
        const linha = document.createElement("tr");
        linha.innerHTML = `
            <td>${cliente.nome || 'N/A'}</td>
            <td>${cliente.cpf || 'N/A'}</td>
            <td>${cliente.celular || 'N/A'}</td>
            <td class="text-center">
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-primary action-btn" onclick="abrirModalEditarCliente(${cliente.id})" title="Editar cliente">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger action-btn" onclick="openModalExcluir(${cliente.id})" title="Excluir cliente">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <button class="btn btn-success action-btn btn-historico-cliente" data-id="${cliente.id}" title="Histórico de compras">
                        <i class="fas fa-history"></i>
                    </button>
                </div>
            </td>
        `;
        tabela.appendChild(linha);
    });
    
    console.log(`Total de ${clientesPaginados.length} clientes adicionados à tabela`);
    
    // Adicionar eventos aos botões de histórico após criá-los
    document.querySelectorAll('.btn-historico-cliente').forEach(botao => {
        botao.addEventListener('click', function() {
            const id = Number(this.getAttribute('data-id'));
            abrirModalHistorico(id);
        });
    });
}

function mostrarPaginaClientes(pagina) {
    console.log(`Exibindo página ${pagina} de clientes`);
    paginaAtualClientes = pagina;

    // Verificar se há dados para exibir
    if (!clientesFiltrados || clientesFiltrados.length === 0) {
        console.log("Nenhum cliente para exibir");
        const tabela = document.querySelector("#tabelaClientes tbody");
        tabela.innerHTML = `<tr><td colspan="4" class="text-center">Nenhum cliente encontrado</td></tr>`;
        document.getElementById('paginationClientes').innerHTML = '';
        return;
    }

    const inicio = (pagina - 1) * itensPorPaginaClientes;
    const fim = inicio + itensPorPaginaClientes;
    const clientesPaginados = clientesFiltrados.slice(inicio, fim);
    
    console.log(`Exibindo ${clientesPaginados.length} clientes (do índice ${inicio} ao ${fim-1})`);

    if (clientesPaginados.length === 0 && paginaAtualClientes > 1) {
        // Retroceder uma página se a atual ficar vazia após a exclusão
        console.log("Página vazia, retrocedendo...");
        mostrarPaginaClientes(paginaAtualClientes - 1);
        return;
    }

    preencherTabelaClientes(clientesPaginados);
    atualizarPaginacaoClientes();
}

function atualizarPaginacaoClientes() {
    const totalPaginas = Math.ceil(clientesFiltrados.length / itensPorPaginaClientes);
    const pagination = document.getElementById('paginationClientes');
    pagination.innerHTML = '';

    const maxLeft = Math.max(paginaAtualClientes - Math.floor(maxBotoesPaginacaoClientes / 2), 1);
    const maxRight = Math.min(maxLeft + maxBotoesPaginacaoClientes - 1, totalPaginas);

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

    if (paginaAtualClientes < totalPaginas) {
        const nextLi = document.createElement('li');
        nextLi.classList.add('page-item');
        nextLi.innerHTML = `<a class="page-link" href="#">Próximo</a>`;
        nextLi.onclick = () => mostrarPaginaClientes(paginaAtualClientes + 1);
        pagination.appendChild(nextLi);
    }
}

function buscarCliente() {
    console.log("Configurando busca de clientes");
    const inputBuscarCliente = document.getElementById("buscarCliente");
    
    if (!inputBuscarCliente) {
        console.error("Campo de busca de clientes não encontrado!");
        return;
    }

    inputBuscarCliente.addEventListener("input", function () {
        const termoBusca = inputBuscarCliente.value.toLowerCase();
        console.log(`Buscando clientes com termo: "${termoBusca}"`);

        try {
            // Verificar se a variável clientes está inicializada
            if (!Array.isArray(clientes)) {
                console.error("A variável clientes não é um array válido para busca");
                return;
            }

        // Atualiza clientesFiltrados com base no termo de busca
            clientesFiltrados = clientes.filter(cliente => {
                if (!cliente) return false;
                
                const nome = (cliente.nome || "").toLowerCase();
                const cpf = (cliente.cpf || "").toLowerCase();
                
                return nome.includes(termoBusca) || cpf.includes(termoBusca);
            });
            
            console.log(`Encontrados ${clientesFiltrados.length} clientes correspondentes à busca`);

        // Reseta a paginação para a primeira página e exibe os resultados
        paginaAtualClientes = 1;
        mostrarPaginaClientes(paginaAtualClientes);
        } catch (error) {
            console.error("Erro ao buscar clientes:", error);
        }
    });
    
    console.log("Busca de clientes configurada");
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
    console.log("Abrindo modal histórico do cliente ID:", id);
    
    try {
        // Garantir que o id seja um número
        id = Number(id);
        
    const modalHistorico = new bootstrap.Modal(document.getElementById("modalHistoricoCliente"));

        // Armazenar ID do cliente selecionado
        document.getElementById("clienteIdHistorico").value = id;
        
        // Limpar filtros
        document.getElementById("filtroDataHistoricoCliente").value = "";
        document.getElementById("buscarHistoricoCliente").value = "";
        
        // Carregar dados do histórico
        carregarHistoricoCliente(id);
        
        // Mostrar modal
        modalHistorico.show();
        
        // Adicionar eventos para os filtros
        const btnFiltrar = document.getElementById("filtrarHistoricoClienteBtn");
        const btnLimpar = document.getElementById("limparFiltroHistoricoClienteBtn");
        const inputBuscar = document.getElementById("buscarHistoricoCliente");
        
        // Remover eventos antigos antes de adicionar novos
        btnFiltrar.removeEventListener("click", filtrarHistoricoCliente);
        btnLimpar.removeEventListener("click", limparFiltrosHistoricoCliente);
        inputBuscar.removeEventListener("keyup", filtrarHistoricoCliente);
        
        // Adicionar eventos novos
        btnFiltrar.addEventListener("click", filtrarHistoricoCliente);
        btnLimpar.addEventListener("click", limparFiltrosHistoricoCliente);
        inputBuscar.addEventListener("keyup", filtrarHistoricoCliente);
        
        console.log("Modal aberto com sucesso");
    } catch (error) {
        console.error("Erro ao abrir modal de histórico:", error);
        alert("Houve um erro ao abrir o histórico. Por favor, tente novamente.");
    }
}

// Variáveis para controle da paginação e dados do histórico
let historicoClienteDados = [];
let historicoClienteFiltrado = [];
let paginaAtualHistoricoCliente = 1;
const itensPorPaginaHistoricoCliente = 5;

function carregarHistoricoCliente(clienteId) {
    console.log("Carregando histórico do cliente ID:", clienteId);
    
    // Verificar se temos dados de saídas
    if (!Array.isArray(saidas) || saidas.length === 0) {
        console.warn("Não há saídas disponíveis para carregar o histórico");
        historicoClienteDados = [];
        historicoClienteFiltrado = [];
        atualizarTabelaHistoricoCliente();
        return;
    }
    
    try {
        // Ordenar saídas por data (mais recentes primeiro)
        // Usar uma cópia para evitar modificar o array original
        const saidasOrdenadas = [...saidas].sort((a, b) => {
            const dataA = new Date(a.data || 0);
            const dataB = new Date(b.data || 0);
            
            // Verificar se as datas são válidas
            if (isNaN(dataA.getTime()) && isNaN(dataB.getTime())) return 0;
            if (isNaN(dataA.getTime())) return 1;  // b vem primeiro
            if (isNaN(dataB.getTime())) return -1; // a vem primeiro
            
            return dataB - dataA;
        });
        
        console.log("Saídas ordenadas por data (primeiras 3):", saidasOrdenadas.slice(0, 3));
        
        // Filtrar saídas do cliente
        const saidasCliente = saidasOrdenadas.filter(saida => saida.idClientes === clienteId);
        console.log(`Encontradas ${saidasCliente.length} saídas para o cliente ID ${clienteId}`);
        
        // Transformar dados para exibição
        historicoClienteDados = saidasCliente.map(saida => {
            const produto = produtos.find(p => p.id === saida.idProdutos);
            
            // Calcular o preço total com segurança
            const preco = typeof saida.preco === 'number' ? saida.preco : 0;
            const quantidade = typeof saida.quantidade === 'number' ? saida.quantidade : 0;
            const total = preco * quantidade;
            
            // Formatar a data original para exibição
            const dataFormatada = formatarData(saida.data);
            
            return {
                produtoNome: produto ? produto.nome : 'Produto não encontrado',
                quantidade: saida.quantidade,
                preco: formatarMoeda(preco),
                total: formatarMoeda(total),
                data: dataFormatada,
                dataOriginal: saida.data // Para usar nos filtros
            };
        });
        
        console.log("Dados de histórico preparados:", historicoClienteDados);
        
        // Aplicar filtros iniciais (sem filtro)
        historicoClienteFiltrado = [...historicoClienteDados];
        
        // Atualizar exibição
        atualizarTabelaHistoricoCliente();
    } catch (error) {
        console.error("Erro ao carregar histórico do cliente:", error);
        historicoClienteDados = [];
        historicoClienteFiltrado = [];
        atualizarTabelaHistoricoCliente();
    }
}

function atualizarTabelaHistoricoCliente() {
    const tbody = document.getElementById("corpoTabelaHistoricoCliente");
    const mensagemVazia = document.getElementById("mensagemNenhumHistoricoCliente");
    
    // Verificar se existem dados
    if (historicoClienteFiltrado.length === 0) {
        tbody.innerHTML = "";
        mensagemVazia.style.display = "block";
        document.getElementById("paginacaoHistoricoCliente").innerHTML = "";
        return;
    }
    
    // Esconder mensagem de vazio
    mensagemVazia.style.display = "none";
    
    // Calcular paginação
    const inicio = (paginaAtualHistoricoCliente - 1) * itensPorPaginaHistoricoCliente;
    const fim = inicio + itensPorPaginaHistoricoCliente;
    const dadosPaginados = historicoClienteFiltrado.slice(inicio, fim);
    
    // Gerar HTML das linhas
    let html = "";
    dadosPaginados.forEach(item => {
        html += `
            <tr>
                <td>${item.produtoNome}</td>
                <td>${item.quantidade}</td>
                <td>${item.preco}</td>
                <td>${item.total}</td>
                <td>${item.data}</td>
            </tr>
            `;
        });
    
    // Atualizar tabela
    tbody.innerHTML = html;
    
    // Atualizar paginação
    atualizarPaginacaoHistoricoCliente();
}

function atualizarPaginacaoHistoricoCliente() {
    const paginacao = document.getElementById("paginacaoHistoricoCliente");
    
    // Calcular páginas
    const totalPaginas = Math.ceil(historicoClienteFiltrado.length / itensPorPaginaHistoricoCliente);
    
    // Não exibir paginação se tiver apenas uma página
    if (totalPaginas <= 1) {
        paginacao.innerHTML = "";
        return;
    }
    
    // Gerar botões de paginação
    let html = "";
    
    // Botão anterior
    html += `
        <li class="page-item ${paginaAtualHistoricoCliente === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-pagina="${paginaAtualHistoricoCliente - 1}">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
    `;
    
    // Páginas
    for (let i = 1; i <= totalPaginas; i++) {
        html += `
            <li class="page-item ${paginaAtualHistoricoCliente === i ? 'active' : ''}">
                <a class="page-link" href="#" data-pagina="${i}">${i}</a>
            </li>
        `;
    }
    
    // Botão próximo
    html += `
        <li class="page-item ${paginaAtualHistoricoCliente === totalPaginas ? 'disabled' : ''}">
            <a class="page-link" href="#" data-pagina="${paginaAtualHistoricoCliente + 1}">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    `;
    
    // Atualizar HTML
    paginacao.innerHTML = html;
    
    // Adicionar eventos aos botões
    document.querySelectorAll("#paginacaoHistoricoCliente .page-link").forEach(botao => {
        botao.addEventListener("click", (e) => {
            e.preventDefault();
            const pagina = parseInt(e.currentTarget.getAttribute("data-pagina"));
            if (!isNaN(pagina)) {
                paginaAtualHistoricoCliente = pagina;
                atualizarTabelaHistoricoCliente();
            }
        });
    });
}

function filtrarHistoricoCliente() {
    console.log("Aplicando filtros ao histórico do cliente");
    const filtroData = document.getElementById("filtroDataHistoricoCliente").value;
    const filtroProduto = document.getElementById("buscarHistoricoCliente").value.toLowerCase();
    
    console.log(`Filtros aplicados - Data: "${filtroData}", Produto: "${filtroProduto}"`);
    
    try {
        // Verificar se temos dados para filtrar
        if (!Array.isArray(historicoClienteDados)) {
            console.warn("Dados de histórico não disponíveis para filtragem");
            historicoClienteFiltrado = [];
            atualizarTabelaHistoricoCliente();
            return;
        }
        
        // Aplicar filtros
        historicoClienteFiltrado = historicoClienteDados.filter(item => {
            let passaFiltroData = true;
            let passaFiltroProduto = true;
            
            // Filtrar por data
            if (filtroData) {
                try {
                    // Converter data do filtro para objeto Date
                    const dataFiltro = new Date(filtroData);
                    
                    if (!isNaN(dataFiltro.getTime())) {
                        // Normalizar para comparar apenas a data (sem hora)
                        const dataFiltroStr = dataFiltro.toISOString().split('T')[0];
                        
                        // Tentar converter a data do item para comparar
                        let dataSaidaStr = "";
                        
                        if (item.dataOriginal) {
                            const dataSaida = new Date(item.dataOriginal);
                            if (!isNaN(dataSaida.getTime())) {
                                dataSaidaStr = dataSaida.toISOString().split('T')[0];
                            }
                        }
                        
                        passaFiltroData = dataSaidaStr === dataFiltroStr;
                        console.log(`Comparando datas - Filtro: ${dataFiltroStr}, Item: ${dataSaidaStr}, Passa: ${passaFiltroData}`);
    } else {
                        console.warn("Data do filtro inválida:", filtroData);
                    }
                } catch (error) {
                    console.error("Erro ao filtrar por data:", error);
                    passaFiltroData = false;
                }
            }
            
            // Filtrar por produto
            if (filtroProduto) {
                const nomeProduto = (item.produtoNome || "").toLowerCase();
                passaFiltroProduto = nomeProduto.includes(filtroProduto);
            }
            
            // Deve passar em ambos os filtros
            return passaFiltroData && passaFiltroProduto;
        });
        
        console.log(`Filtro resultou em ${historicoClienteFiltrado.length} itens`);
        
        // Resetar para primeira página e atualizar tabela
        paginaAtualHistoricoCliente = 1;
        atualizarTabelaHistoricoCliente();
    } catch (error) {
        console.error("Erro ao aplicar filtros:", error);
        alert("Ocorreu um erro ao aplicar os filtros. Consulte o console para mais detalhes.");
    }
}

function limparFiltrosHistoricoCliente() {
    // Limpar campos de filtro
    document.getElementById("filtroDataHistoricoCliente").value = "";
    document.getElementById("buscarHistoricoCliente").value = "";
    
    // Resetar dados filtrados
    historicoClienteFiltrado = [...historicoClienteDados];
    
    // Atualizar tabela
    paginaAtualHistoricoCliente = 1;
    atualizarTabelaHistoricoCliente();
}

// Função auxiliar para formatar moeda
function formatarMoeda(valor) {
    return `R$ ${valor.toFixed(2).replace('.', ',')}`;
}

// Função auxiliar para formatar data
function formatarData(dataString) {
    // Se não houver data, retornar mensagem amigável
    if (!dataString) {
        return "Data não disponível";
    }
    
    try {
        // Verificar se é um timestamp em milissegundos (número)
        if (!isNaN(dataString) && typeof dataString === 'number') {
            const data = new Date(dataString);
            return data.toLocaleDateString('pt-BR');
        }
        
        // Verificar se é uma string
        if (typeof dataString === 'string') {
            // Verificar se é formato MySQL (YYYY-MM-DD HH:MM:SS)
            if (dataString.match(/^\d{4}-\d{2}-\d{2}(?: \d{2}:\d{2}:\d{2})?$/)) {
                const data = new Date(dataString.replace(' ', 'T'));
                return data.toLocaleDateString('pt-BR');
            }
            
            // Verificar se é formato ISO (YYYY-MM-DDTHH:MM:SSZ)
            if (dataString.includes('T')) {
                const data = new Date(dataString);
                return data.toLocaleDateString('pt-BR');
            }
            
            // Verificar se é formato brasileiro (DD/MM/YYYY)
            if (dataString.includes('/')) {
                const partes = dataString.split('/');
                if (partes.length === 3) {
                    // No formato DD/MM/YYYY, precisamos converter para MM/DD/YYYY
                    const data = new Date(`${partes[1]}/${partes[0]}/${partes[2]}`);
                    if (!isNaN(data.getTime())) {
                        return data.toLocaleDateString('pt-BR');
                    }
                }
            }
            
            // Verificar se é formato com traços (DD-MM-YYYY)
            if (dataString.match(/^\d{2}-\d{2}-\d{4}$/)) {
                const partes = dataString.split('-');
                const data = new Date(`${partes[1]}/${partes[0]}/${partes[2]}`);
                if (!isNaN(data.getTime())) {
                    return data.toLocaleDateString('pt-BR');
                }
            }
            
            // Tentar formato americano simples (YYYY/MM/DD)
            if (dataString.match(/^\d{4}\/\d{2}\/\d{2}$/)) {
                const data = new Date(dataString);
                if (!isNaN(data.getTime())) {
                    return data.toLocaleDateString('pt-BR');
                }
            }
            
            // Último recurso: tentar converter diretamente
            const data = new Date(dataString);
            if (!isNaN(data.getTime())) {
                return data.toLocaleDateString('pt-BR');
            }
        }
        
        // Se chegou aqui, nenhum formato funcionou
        console.warn("Formato de data não reconhecido:", dataString);
        return "Data não reconhecida";
        
    } catch (error) {
        console.error("Erro ao processar data:", error, dataString);
        return "Erro na data";
    }
}

function aplicarOrdenacaoClientes() {
    console.log("Aplicando ordenação nos clientes");
    
    if (!clientesFiltrados || !Array.isArray(clientesFiltrados)) {
        console.error("clientesFiltrados não é um array válido para ordenação");
        return;
    }
    
    clientesFiltrados.sort((a, b) => {
        if (!a || !b || !ordemAtualClientes.coluna) {
            return 0;
        }
        
        let valorA = a[ordemAtualClientes.coluna];
        let valorB = b[ordemAtualClientes.coluna];
        
        // Tratar valores undefined ou null
        valorA = valorA || '';
        valorB = valorB || '';

        if (typeof valorA === 'string') {
            valorA = valorA.toLowerCase();
            valorB = valorB.toLowerCase();
        }

        if (ordemAtualClientes.crescente) {
            return valorA > valorB ? 1 : valorA < valorB ? -1 : 0;
        } else {
            return valorA < valorB ? 1 : valorA > valorB ? -1 : 0;
        }
    });
    
    console.log("Ordenação aplicada:", ordemAtualClientes);
}

function ordenarTabelaClientes(coluna, idSeta) {
    console.log(`Ordenando por ${coluna}`);
    
    if (ordemAtualClientes.coluna === coluna) {
        ordemAtualClientes.crescente = !ordemAtualClientes.crescente;
    } else {
        ordemAtualClientes.coluna = coluna;
        ordemAtualClientes.crescente = true;
    }

    // Atualizar ícones de ordenação
    document.querySelectorAll(".seta").forEach(seta => (seta.textContent = "⬍"));
    const setaAtual = document.getElementById(idSeta);
    if (setaAtual) {
    setaAtual.textContent = ordemAtualClientes.crescente ? "⬆" : "⬇";
    }

    aplicarOrdenacaoClientes();
    mostrarPaginaClientes(1);
}

function openModalExcluir(clienteId) {
    // Insere o ID do cliente no campo oculto do modal
    const inputClienteId = document.getElementById('idClienteExcluir');
    inputClienteId.value = clienteId;

    // Mostra o modal
    new bootstrap.Modal(document.getElementById('modalExcluir')).show();
}