<?php
use Controllers\CategoriaController; 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #121212 !important;
            color: white;
        }

        /* Estilos personalizados para el header */
        header {
            background-color: #000000 !important;
        }

        .navbar {
            padding: 0.8rem;
        }

        .navbar-brand {
            color: #B52BD8 !important;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 50px;
            margin-right: 10px;
        }

        .navbar-brand:hover {
            color: #452BD8 !important;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            color: #B52BD8 !important;
        }

        .navbar-toggler-icon {
            background-color: white;
        }

        .navbar-text {
            color: #B52BD8;
        }

        .text-danger {
            color: #B52BD8 !important;
        }

        /* Estilos para las categorías en fila */
        .navbar-categorias {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .navbar-categorias .nav-item {
            margin-right: 15px;
        }

        .navbar-categorias .nav-link {
            color: white;
            font-weight: bold;
        }

        .navbar-categorias .nav-link:hover {
            color: #B52BD8;
        }

        .navbar-light .navbar-nav .nav-link.active {
            color: #B52BD8 !important;
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="<?= BASE_URL ?>">
                    <img src="<?= BASE_URL ?>public/imgs/logo.png" alt="Logo Car Shop"> Car Shop
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav"></div>
                    <ul class="navbar-nav me-auto">
                        <?php if (!isset($_SESSION['login']) || $_SESSION['login'] == 'failed'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>Usuario/login">Identificarse</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>Usuario/registro">Registrarse</a>
                            </li>
                        <?php else: ?>
                            <?php if ($_SESSION['login']->rol === "admin"): ?>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Pedido/mostrarPedidos/">Gestionar Pedidos</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Producto/gestionarProductos/">Gestionar Productos</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Producto/crearProducto/">Añadir Producto</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Categoria/mostrarCategorias/">Gestionar Categorías</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Categoria/crearCategoria/">Añadir Categoría</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Usuario/registro/">Registrar Usuario</a></li>
                            <?php else: ?>
                                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>Pedido/mostrarPedidos/">Mis Pedidos</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= BASE_URL ?>Carrito/mostrarCarrito/">
                                        <i class="fas fa-shopping-cart"></i> <!-- FontAwesome icon -->
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item"><a class="nav-link text-danger" href="<?= BASE_URL ?>Usuario/logout/">Cerrar Sesión</a></li>
                        <?php endif; ?>
                    </ul>

                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] != 'failed'): ?>
                        <!-- Enlace para ir a modificar datos de usuario -->
                        <span class="ms-5 navbar-text text-light">
                            <a href="<?= BASE_URL ?>Usuario/modificarDatos?id=<?= $_SESSION['login']->id ?>" class="nav-link">
                                <?= $_SESSION['login']->nombre ?> <?= $_SESSION['login']->apellidos ?>
                            </a>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <?php $categorias = CategoriaController::getCategorias(); ?>

    <nav class="navbar navbar-expand-lg"></nav>
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarCategorias">
                <ul class="navbar-nav me-auto navbar-categorias">
                    <?php foreach ($categorias as $categoria): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>Categoria/mostrarProductosCategoria/?id=<?= $categoria['id'] ?>"><?= $categoria['nombre'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS (necesario para los dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
