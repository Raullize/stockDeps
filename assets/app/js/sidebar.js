document.addEventListener('DOMContentLoaded', function() {
    // Elementos
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.toggle-btn');
    const mobileToggle = document.querySelector('.mobile-toggle');
    const menuLinks = document.querySelectorAll('.menu-link');
    
    // Toggle sidebar no desktop
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Previne comportamento padrão
            sidebar.classList.toggle('collapsed');
            
            // Salvar estado no localStorage
            const isSidebarCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isSidebarCollapsed);
        });
    }
    
    // Toggle sidebar no mobile
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Previne propagação do evento
            sidebar.classList.toggle('show');
            
            // Adicionar/remover classe do botão para mostrar estado
            if (sidebar.classList.contains('show')) {
                mobileToggle.classList.add('active');
                mobileToggle.innerHTML = '<i class="fas fa-times"></i>';
                document.body.style.overflow = 'hidden'; // Previne rolagem quando menu aberto
            } else {
                mobileToggle.classList.remove('active');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
                document.body.style.overflow = ''; // Restaura rolagem
            }
        });
    }
    
    // Fechar sidebar no mobile quando clicar em um link
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                sidebar.classList.remove('show');
                if (mobileToggle) {
                    mobileToggle.classList.remove('active');
                    mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
                }
                document.body.style.overflow = ''; // Restaura rolagem
            }
        });
    });
    
    // Fechar sidebar no mobile quando clicar fora
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && sidebar.classList.contains('show')) {
            // Verificar se o clique foi fora da sidebar e do botão toggle
            if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                sidebar.classList.remove('show');
                if (mobileToggle) {
                    mobileToggle.classList.remove('active');
                    mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
                }
                document.body.style.overflow = ''; // Restaura rolagem
            }
        }
    });
    
    // Verificar o tamanho da tela ao redimensionar
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992 && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            if (mobileToggle) {
                mobileToggle.classList.remove('active');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
            document.body.style.overflow = '';
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
    
    // Restaurar estado da sidebar do localStorage (apenas em desktop)
    function restoreSidebarState() {
        if (window.innerWidth >= 992) {
            const isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isSidebarCollapsed) {
                sidebar.classList.add('collapsed');
            }
        }
    }
    
    // Inicializar
    setActiveLink();
    restoreSidebarState();
    
    // Atualizar link ativo quando a página muda
    window.addEventListener('popstate', setActiveLink);

    // Adicionar evento de transição para evitar problemas de layout
    sidebar.addEventListener('transitionend', function(e) {
        if (e.propertyName === 'width' || e.propertyName === 'transform') {
            document.body.style.overflow = '';
        }
    });

    // Prevenir que a transição da sidebar afete o layout durante a navegação
    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const isSidebarCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isSidebarCollapsed);
        });
    });
    
    // Inicializar corretamente o ícone do botão móvel
    if (mobileToggle) {
        if (sidebar.classList.contains('show')) {
            mobileToggle.innerHTML = '<i class="fas fa-times"></i>';
        } else {
            mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
        }
    }
}); 