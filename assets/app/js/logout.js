// Obter o botão de logout
const logoutButton = document.querySelector('.logout-link');
const baseUrl = '/stockDeps';

if (logoutButton) {
    logoutButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Alterar o ícone para um spinner durante o processo
        const logoutIcon = this.querySelector('.logout-icon i');
        const originalIcon = logoutIcon.className;
        logoutIcon.className = 'fas fa-spinner fa-spin';
        
        // Desabilitar o botão para evitar múltiplos cliques
        this.style.pointerEvents = 'none';
        
        // Fazer a requisição para o endpoint de logout
        fetch(`${baseUrl}/app/logout`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.type === 'success') {
                // Exibir mensagem de sucesso (opcional)
                console.log("Logout realizado com sucesso, redirecionando...");
                
                // Redirecionar para a página de login
                setTimeout(() => {
                    window.location.href = baseUrl;
                }, 500);
            }
        })
        .catch(error => {
            // Em caso de erro, restaurar o botão
            console.error('Erro ao fazer logout:', error);
            this.style.pointerEvents = 'auto';
            logoutIcon.className = originalIcon;
        });
    });
} 