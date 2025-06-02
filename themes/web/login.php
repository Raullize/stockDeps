<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= url('assets/web/css/globals.css') ?>">
    <link rel="stylesheet" href="<?= url('assets/web/css/login.css') ?>">
    <!-- Ícone do site -->
    <link rel="icon" href="<?= url('assets/web/images/logos/logo-without-background.png') ?>" type="image/png" />
    <title>Login - StockDeps</title>
</head>

<body>
    <div class="login-container">
        <!-- Lado da animação -->
        <div class="animation-side">
            <div class="animation-content">
                <div class="brand-container">
                    <h1 class="brand-name">StockDeps</h1>
                </div>
                
                <div class="tagline">
                    <h2>Controle de Estoque Inteligente</h2>
                    <p>Gerencie seus recursos com eficiência e precisão</p>
                </div>
                
                <!-- Elementos animados -->
                <div class="animation-elements">
                    <div class="floating-element box-1"><i class="fas fa-box"></i></div>
                    <div class="floating-element box-2"><i class="fas fa-chart-line"></i></div>
                    <div class="floating-element box-3"><i class="fas fa-tags"></i></div>
                    <div class="floating-element box-4"><i class="fas fa-truck-loading"></i></div>
                    <div class="floating-circle circle-1"></div>
                    <div class="floating-circle circle-2"></div>
                    <div class="floating-circle circle-3"></div>
                </div>
            </div>
        </div>
        
        <!-- Lado do formulário -->
        <div class="form-side">
            <div class="form-container">
                <div class="form-header">
                    <h2>Bem-vindo de volta!</h2>
                    <p>Entre com suas credenciais para acessar o sistema</p>
                </div>
                
                <form id="form-login" method="POST">
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="username" placeholder="Usuário" name="username" required>
                        <label for="username">Usuário</label>
                    </div>
                    
                    <div class="form-floating mb-4 password-field">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                        <label for="password">Senha</label>
                        <span class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <span class="btn-text">Entrar</span>
                        <span class="btn-icon"><i class="fas fa-arrow-right"></i></span>
                    </button>
                </form>
                
                <div id="message-container" class="message-container"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= url('assets/web/js/login.js') ?>" async></script>
    <script src="<?= url('assets/app/js/funcoesAuxiliares.js') ?>"></script>
</body>

</html>