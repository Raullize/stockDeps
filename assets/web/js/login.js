const BASE_URL = '/stockDeps';

// Função para aplicar efeito de flutuação aleatória aos elementos
function applyRandomFloatingEffect() {
    const elements = document.querySelectorAll('.floating-element');
    
    elements.forEach(element => {
        // Adiciona um pequeno movimento aleatório inicial para diferenciar os elementos
        const randomX = Math.random() * 10 - 5;
        const randomY = Math.random() * 10 - 5;
        const randomRotate = Math.random() * 5 - 2.5;
        
        element.style.transform = `translate(${randomX}px, ${randomY}px) rotate(${randomRotate}deg)`;
    });
}

// Aplicar efeito de flutuação quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    applyRandomFloatingEffect();
    
    // Adicionar o efeito de brilho no botão
    const loginButton = document.querySelector('.btn-login');
    if (loginButton) {
        loginButton.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            this.style.background = `radial-gradient(circle at ${x}px ${y}px, var(--primary-hover) 0%, var(--primary-color) 50%)`;
        });
        
        loginButton.addEventListener('mouseleave', function() {
            this.style.background = 'var(--primary-color)';
        });
    }
});

// Funcionalidade de mostrar/ocultar senha
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

togglePassword.addEventListener('click', function() {
    // Alternar o tipo de input entre 'password' e 'text'
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Alternar o ícone entre 'eye' e 'eye-slash'
    this.querySelector('i').classList.toggle('fa-eye');
    this.querySelector('i').classList.toggle('fa-eye-slash');
});

// Exibir mensagem no container de mensagem
function showMessage(message, type) {
    const messageContainer = document.getElementById('message-container');
    messageContainer.textContent = message;
    messageContainer.className = 'message-container';
    messageContainer.classList.add(type);
    messageContainer.style.display = 'block';
    
    // Adicionar classe para animar entrada da mensagem
    messageContainer.classList.add('animate-in');
    
    // Esconder a mensagem após 5 segundos
    setTimeout(() => {
        messageContainer.classList.remove('animate-in');
        messageContainer.classList.add('animate-out');
        
        setTimeout(() => {
            messageContainer.style.display = 'none';
            messageContainer.classList.remove('animate-out');
        }, 300);
    }, 5000);
}

// Valida login
const form_login = $("#form-login");
form_login.on("submit", function (e) {
    e.preventDefault();

    const serializedData = form_login.serialize();
    
    // Efeito no botão durante o envio
    const loginButton = document.querySelector('.btn-login');
    const btnText = loginButton.querySelector('.btn-text');
    const btnIcon = loginButton.querySelector('.btn-icon');
    
    // Desabilitar botão e mostrar spinner
    loginButton.disabled = true;
    btnText.innerHTML = 'Entrando';
    btnIcon.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
    loginButton.classList.add('loading');

    $.ajax({
        type: "POST",
        url: `${BASE_URL}/login`,
        data: serializedData,
        dataType: "json",
        success: function (response) {
            if (response.type === 'error') {
                showMessage(response.message, 'error');
                exibirMensagemTemporariaErro(response.message);
            }
            else if (response.type === 'warning') {
                showMessage(response.message, 'warning');
                exibirMensagemTemporariaAviso(response.message);
            }
            else if (response.type === 'success') {
                showMessage('Login realizado com sucesso! Redirecionando...', 'success');
                
                // Adiciona um efeito de sucesso ao botão
                loginButton.classList.remove('loading');
                loginButton.classList.add('success');
                btnText.innerHTML = 'Sucesso';
                btnIcon.innerHTML = '<i class="fas fa-check"></i>';
                
                setTimeout(() => {
                    if (response.user === 'Admin') {
                        window.location.href = `${BASE_URL}/adm`;
                    } else {
                        window.location.href = `${BASE_URL}/app`;
                    }
                }, 1000);
                return;
            }
            
            // Reativar botão de login
            loginButton.disabled = false;
            loginButton.classList.remove('loading');
            btnText.innerHTML = 'Entrar';
            btnIcon.innerHTML = '<i class="fas fa-arrow-right"></i>';
        },
        error: function (xhr, status, error) {
            console.error("Erro no AJAX:", error);
            showMessage("Erro ao processar a solicitação.", 'error');
            exibirMensagemTemporariaErro("Erro ao processar a solicitação.");
            
            // Reativar botão de login
            loginButton.disabled = false;
            loginButton.classList.remove('loading');
            btnText.innerHTML = 'Entrar';
            btnIcon.innerHTML = '<i class="fas fa-arrow-right"></i>';
        }
    });
});

// Adicionar efeito de animação nos inputs
const inputs = document.querySelectorAll('.form-control');

inputs.forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        if (this.value === '') {
            this.parentElement.classList.remove('focused');
        }
    });
});


