document.addEventListener('DOMContentLoaded', function() {
    // Carregar dados dos cards
    carregarEstatisticas();
    
    // Gráficos
    inicializarGraficoLucro();
    inicializarGraficoCategorias();
    
    // Tabela de produtos mais vendidos
    carregarProdutosMaisVendidos();
    
    // Evento para atualizar o gráfico de lucro quando o período mudar
    document.getElementById('periodo').addEventListener('change', function() {
        atualizarGraficoLucro(this.value);
    });
});

// Função para carregar estatísticas dos cards
function carregarEstatisticas() {
    // Simulação de dados (substituir por chamada AJAX real)
    setTimeout(() => {
        document.getElementById('total-produtos').textContent = '152';
        document.getElementById('produtos-estoque').textContent = '127';
        document.getElementById('estoque-baixo').textContent = '18';
        document.getElementById('produtos-sem-estoque').textContent = '7';
        document.getElementById('total-clientes').textContent = '48';
        document.getElementById('total-fornecedores').textContent = '12';
        document.getElementById('total-entradas').textContent = '245';
        document.getElementById('total-saidas').textContent = '186';
        
        // Adicionar animação de contagem
        animarContadores();
    }, 300);
}

// Função para animar contadores
function animarContadores() {
    const contadores = document.querySelectorAll('.statistic-value');
    
    contadores.forEach(contador => {
        const valorFinal = parseInt(contador.textContent);
        let valorAtual = 0;
        const duracao = 1500; // milissegundos
        const incremento = Math.ceil(valorFinal / (duracao / 16)); // 60 FPS
        
        const animacao = setInterval(() => {
            valorAtual += incremento;
            if (valorAtual >= valorFinal) {
                contador.textContent = valorFinal;
                clearInterval(animacao);
            } else {
                contador.textContent = valorAtual;
            }
        }, 16);
    });
}

// Função para inicializar o gráfico de lucro
function inicializarGraficoLucro() {
    const ctx = document.getElementById('lucroChart').getContext('2d');
    
    // Configuração do gradiente
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(67, 97, 238, 0.3)');
    gradient.addColorStop(1, 'rgba(67, 97, 238, 0.0)');
    
    // Criação do gráfico
    window.lucroChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul'],
            datasets: [{
                label: 'Lucro (R$)',
                data: [5800, 7200, 6500, 8100, 7600, 9200, 10500],
                borderColor: '#4361ee',
                backgroundColor: gradient,
                tension: 0.4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#4361ee',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#ffffff',
                    titleColor: '#333333',
                    bodyColor: '#666666',
                    borderColor: '#e0e0e0',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Lucro: R$ ' + context.parsed.y.toLocaleString('pt-BR');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [2, 2]
                    },
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            }
        }
    });
}

// Função para atualizar o gráfico de lucro com base no período selecionado
function atualizarGraficoLucro(periodo) {
    let labels = [];
    let dados = [];
    
    // Simulação de dados para diferentes períodos
    if (periodo === '7') {
        labels = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
        dados = [1200, 950, 1400, 1800, 1600, 2100, 1900];
    } else if (periodo === '30') {
        labels = ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'];
        dados = [5800, 6700, 7200, 8500];
    } else if (periodo === '90') {
        labels = ['Janeiro', 'Fevereiro', 'Março'];
        dados = [18500, 17800, 22300];
    } else if (periodo === '365') {
        labels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        dados = [23500, 19800, 21300, 18900, 20100, 22700, 24500, 26800, 28100, 25600, 29800, 32400];
    }
    
    // Atualizar o gráfico
    window.lucroChart.data.labels = labels;
    window.lucroChart.data.datasets[0].data = dados;
    window.lucroChart.update();
}

// Função para inicializar o gráfico de categorias (pizza)
function inicializarGraficoCategorias() {
    const ctx = document.getElementById('categoriasChart').getContext('2d');
    
    // Dados simulados
    const data = {
        labels: ['Eletrônicos', 'Vestuário', 'Alimentos', 'Papelaria', 'Outros'],
        datasets: [{
            data: [35, 25, 20, 15, 5],
            backgroundColor: [
                '#4361ee',
                '#3a0ca3',
                '#f72585',
                '#4cc9f0',
                '#7209b7'
            ],
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    };
    
    new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#ffffff',
                    titleColor: '#333333',
                    bodyColor: '#666666',
                    borderColor: '#e0e0e0',
                    borderWidth: 1,
                    padding: 10,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
}

// Função para carregar a tabela de produtos mais vendidos
function carregarProdutosMaisVendidos() {
    // Simulação de dados (substituir por chamada AJAX real)
    const produtos = [
        { id: 1, nome: 'Smartphone XYZ', categoria: 'Eletrônicos', preco: 1299.90, vendas: 42, faturamento: 54595.80, status: 'Em estoque' },
        { id: 2, nome: 'Notebook Ultra', categoria: 'Eletrônicos', preco: 3499.90, vendas: 28, faturamento: 97997.20, status: 'Em estoque' },
        { id: 3, nome: 'Tênis Runner', categoria: 'Vestuário', preco: 299.90, vendas: 65, faturamento: 19493.50, status: 'Estoque baixo' },
        { id: 4, nome: 'Headphone Pro', categoria: 'Eletrônicos', preco: 599.90, vendas: 37, faturamento: 22196.30, status: 'Em estoque' },
        { id: 5, nome: 'Caderno Universitário', categoria: 'Papelaria', preco: 24.90, vendas: 120, faturamento: 2988.00, status: 'Sem estoque' }
    ];
    
    const tabela = document.getElementById('tabela-produtos');
    let html = '';
    
    produtos.forEach(produto => {
        let statusClass = '';
        let statusIcon = '';
        
        if (produto.status === 'Em estoque') {
            statusClass = 'text-success';
            statusIcon = 'fas fa-check-circle';
        } else if (produto.status === 'Estoque baixo') {
            statusClass = 'text-warning';
            statusIcon = 'fas fa-exclamation-circle';
        } else {
            statusClass = 'text-danger';
            statusIcon = 'fas fa-times-circle';
        }
        
        html += `
            <tr>
                <th scope="row">${produto.id}</th>
                <td>${produto.nome}</td>
                <td>${produto.categoria}</td>
                <td>R$ ${produto.preco.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                <td>${produto.vendas}</td>
                <td>R$ ${produto.faturamento.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                <td><span class="${statusClass}"><i class="${statusIcon} me-1"></i>${produto.status}</span></td>
            </tr>
        `;
    });
    
    tabela.innerHTML = html;
} 