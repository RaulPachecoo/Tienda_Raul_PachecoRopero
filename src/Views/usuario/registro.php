<?php
require_once __DIR__ . '/../../Utils/Utils.php';
use Utils\Utils;
require_once __DIR__ . '/../../../config/config.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - Car Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
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

        .btn-register {
            background: linear-gradient(to right, #452BD8, #B52BD8);
            color: black;
            font-weight: bold;
            border-radius: 50px;
            padding: 10px;
            width: 100%;
        }

        .login-link a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <img src="<?= BASE_URL ?>public/imgs/logo.png" alt="Logo Car Shop" width="150">

        <h3 class="mt-3">Regístrate en Car Shop</h3>

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
            <div class="alert alert-success">Registro completado correctamente</div>
        <?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
            <div class="alert alert-danger">No se ha podido registrar</div>
        <?php endif; ?>
        <?php Utils::deleteSession('register'); ?>

        <?php if (isset($errores)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errores as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>Usuario/registro" method="POST">
            <div class="text-start mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="data[nombre]" id="nombre" class="form-control" required>
            </div>

            <div class="text-start mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" name="data[apellidos]" id="apellidos" class="form-control" required>
            </div>

            <div class="text-start mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="data[email]" id="email" class="form-control" required>
            </div>

            <div class="text-start mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="data[password]" id="password" class="form-control" required>
            </div>

            <div class="text-start mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select name="data[rol]" id="rol" class="form-control" required>
                    <option value="user">Usuario</option>
                    <?php if ($_SESSION['login']->rol == 'admin'): ?>
                        <option value="admin">Administrador</option>
                    <?php else: ?>
                        <input type="hidden" name="data[rol]" value="user">
                    <?php endif; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-register">Registrarse</button>
        </form>

        <p class="mt-3 login-link">
            ¿Ya tienes cuenta? <a href="<?= BASE_URL ?>Usuario/login">Inicia sesión</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
