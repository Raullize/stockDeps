document.addEventListener('DOMContentLoaded', function() {
    // Elementos
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.toggle-btn');
    const mobileToggle = document.querySelector('.mobile-toggle');
    const menuLinks = document.querySelectorAll('.menu-link');
    const tableResponsives = document.querySelectorAll('.table-responsive');
    
    // Toggle sidebar no desktop (apenas para telas maiores)
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Previne comportamento padrão
            if (window.innerWidth >= 992) { // Apenas execute em telas grandes
                sidebar.classList.toggle('collapsed');
                
                // Salvar estado no localStorage
                const isSidebarCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isSidebarCollapsed);
            }
        });
    }
    
    // Toggle sidebar no mobile
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            
            // Se a sidebar estiver aberta, certifique-se que as tabelas fiquem abaixo
            if (sidebar.classList.contains('show') && window.innerWidth < 992) {
                adjustTableZIndex(true);
            } else {
                adjustTableZIndex(false);
            }
        });
    }
    
    // Função para ajustar o z-index das tabelas em dispositivos móveis
    function adjustTableZIndex(sidebarOpen) {
        if (window.innerWidth < 992) {
            tableResponsives.forEach(table => {
                if (sidebarOpen) {
                    table.style.position = 'relative';
                    table.style.zIndex = '1';
                } else {
                    table.style.position = 'relative';
                    table.style.zIndex = '10';
                }
            });
        }
    }
    
    // Fechar sidebar no mobile quando clicar em um link
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                sidebar.classList.remove('show');
                adjustTableZIndex(false);
            }
        });
    });
    
    // Fechar sidebar no mobile quando clicar fora
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992) {
            // Verificar se o clique foi fora da sidebar e do botão toggle
            if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                sidebar.classList.remove('show');
                adjustTableZIndex(false);
            }
        }
    });
    
    // Marcar o link ativo com base na URL atual
    function setActiveLink() {
        const currentPath = window.location.pathname;
        
        menuLinks.forEach(link => {
            const linkPath = link.getAttribute('href');
            link.classList.remove('active');
            
            if (currentPath === linkPath || 
                (linkPath !== '/' && currentPath.includes(linkPath))) {
                link.classList.add('active');
            }
        });
    }
    
    // Restaurar estado da sidebar do localStorage
    function restoreSidebarState() {
        // Aplicar o estado collapsed apenas em telas grandes
        if (window.innerWidth >= 992) {
            const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isSidebarCollapsed) {
                sidebar.classList.add('collapsed');
            } else {
                sidebar.classList.remove('collapsed');
            }
        }
    }
    
    // Inicializar
    setActiveLink();
    restoreSidebarState();
    adjustTableZIndex(sidebar.classList.contains('show'));
    
    // Atualizar link ativo quando a página muda
    window.addEventListener('popstate', setActiveLink);

    // Verificar e ajustar sidebar ao redimensionar a janela
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            // Em telas grandes, restaurar o estado do localStorage
            restoreSidebarState();
            sidebar.classList.remove('show'); // Remover classe show em telas grandes
            
            // Resetar os estilos de z-index nas tabelas
            tableResponsives.forEach(table => {
                table.style.position = '';
                table.style.zIndex = '';
            });
        } else {
            // Em telas pequenas, garantir que a sidebar tenha largura completa
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
            }
            
            // Ajustar z-index das tabelas
            adjustTableZIndex(sidebar.classList.contains('show'));
        }
    });

    // Adicionar evento de transição para evitar problemas de layout
    sidebar.addEventListener('transitionend', function(e) {
        if (e.propertyName === 'width') {
            document.body.style.overflow = '';
        }
    });

    // Prevenir que a transição da sidebar afete o layout durante a navegação
    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (window.innerWidth >= 992) {
                const isSidebarCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isSidebarCollapsed);
            }
        });
    });
}); 