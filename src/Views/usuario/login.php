<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión - Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../../../public/css/style.css"> -->
    <style>
        body {
            background-color: #121212;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #181818;
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .form-control {
            background-color: #121212;
            color: white;
            border: 1px solid #333;
        }

        .form-control:focus {
            background-color: #121212;
            color: white;
            border-color: #B52BD8;
            box-shadow: none;
        }

        .btn-login {
            background: linear-gradient(to right, #452BD8, #B52BD8);
            color: black;
            font-weight: bold;
            border-radius: 50px;
            padding: 10px;
            width: 100%;
        }

        .register-link a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <img src="<?= BASE_URL ?>public/imgs/logo.png" alt="Logo Car Shop" width="150">

        <h3 class="mt-3">Inicia sesión en Car Shop</h3>

        <form method="POST" action="<?= BASE_URL ?>Usuario/login">
            <div class="text-start mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="data[email]" class="form-control" placeholder="Tu email" required>
            </div>

            <div class="text-start mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" id="password" name="data[password]" class="form-control" placeholder="Tu contraseña" required>
            </div>

            <button type="submit" class="btn btn-login">Iniciar sesión</button>
        </form>

        <p class="mt-3 register-link">
            ¿No tienes cuenta? <a href="<?= BASE_URL ?>Usuario/registro">Regístrate</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>