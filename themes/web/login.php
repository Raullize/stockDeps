<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StockDeps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f7f8fa;
        }

        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            width: 100%;
            max-width: 20rem;
            height: 22rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-container:hover {
            box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.15);
        }

        .form-control {
            height: 2.3rem; /* Ajusta a altura dos inputs */
            font-size: 0.875rem; /* Ajusta o tamanho da fonte nos inputs */
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-floating>label {
            font-size: 0.875rem; /* Ajusta o tamanho da fonte no label */
            transition: all 0.2s ease;
        }

        .form-floating>input:focus~label {
            color: #007bff;
            transform: translateY(-150%);
        }

        .btn-custom {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .btn-custom:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: #007bff;
            margin-bottom: 1.5rem;
            text-align: center;
            letter-spacing: 0.05rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-text">StockDeps</div>
        <form id="form-login" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Usuário">
                <label for="username">Usuário</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
                <label for="password">Senha</label>
            </div>
            <button type="submit" class="btn btn-custom w-100 mt-2">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script src="<?= url('assets/web/js/login.js') ?>" async></script>
<script src="<?= url('assets/app/js/funcoesAuxiliares.js') ?>"></script>