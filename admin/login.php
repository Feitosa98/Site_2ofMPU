<?php
require_once __DIR__ . '/../system/security.php';
startSecureSession();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - Cartório 2º Ofício</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="../images/logo.png">
    <style>
        body {
            background: #07274D; /* Deep navy blue background */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        .login-card {
            background: #0D3E72; /* Card blue */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid rgba(242, 183, 5, 0.2);
            color: #e0efff;
        }

        .login-logo {
            max-width: 120px;
            margin-bottom: 25px;
            filter: drop-shadow(0 0 10px rgba(242, 183, 5, 0.3));
        }

        h2 {
            color: #F2B705; /* Solimões Gold */
            font-family: 'Playfair Display', serif;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #F2B705;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            background: #0A3566;
            border: 1px solid rgba(242, 183, 5, 0.3);
            border-radius: 8px;
            box-sizing: border-box;
            color: white;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #F2B705;
            box-shadow: 0 0 10px rgba(242, 183, 5, 0.2);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #F2B705;
            color: #07274D;
            border: none;
            border-radius: 8px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #ffffff;
            color: #0C4B8E;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(242, 183, 5, 0.3);
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: none;
        }

        .alert-error {
            background: #721c24;
            color: white;
            border: 1px solid #f5c6cb;
        }

        .text-muted {
            color: rgba(224, 239, 255, 0.6) !important;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <img src="../images/logo.png" alt="Cartório Logo" class="login-logo">
        <h2 class="mb-4">Portal do Colaborador</h2>

        <div id="loginAlert" class="alert alert-error"></div>

        <form id="loginForm">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') ?>">
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" placeholder="seu.email@cartorio.com" required>
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" placeholder="Sua senha" required>
            </div>
            <button type="submit" class="btn-login">Entrar no Sistema</button>
        </form>

        <p class="mt-3 text-muted" style="font-size: 0.8rem;">
            Esqueceu a senha? Contate o Administrador.
        </p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const alertBox = document.getElementById('loginAlert');
            const btn = this.querySelector('button');

            btn.disabled = true;
            btn.innerText = 'Entrando...';
            alertBox.style.display = 'none';

            fetch('../system/api/login.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso) {
                        window.location.href = data.redirect;
                    } else {
                        alertBox.textContent = data.erro || 'Erro ao fazer login';
                        alertBox.style.display = 'block';
                        btn.disabled = false;
                        btn.innerText = 'Entrar no Sistema';
                    }
                })
                .catch(err => {
                    console.error(err);
                    alertBox.textContent = 'Erro de conexão com o servidor';
                    alertBox.style.display = 'block';
                    btn.disabled = false;
                    btn.innerText = 'Entrar no Sistema';
                });
        });
    </script>
</body>

</html>
