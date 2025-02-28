<?php
use Controllers\CategoriaController;

$categorias = CategoriaController::getCategorias();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos por Categoría</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #000; /* Fondo negro */
            color: #fff; /* Texto blanco */
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <h1 class="text-light text-center mb-5">Productos por Categoría</h1>

        <nav class="navbar navbar-expand-lg">
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

        <div class="row">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-dark text-light border-light shadow d-flex flex-column h-100" style="height: 100%;"> <!-- Altura uniforme -->
                            <img src="<?= BASE_URL ?>public/imgs/<?= $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>" style="max-height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column flex-grow-1" style="flex: 1 1 auto;"> <!-- Fixed height for card body -->
                                <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                                <p class="card-text flex-grow-1"><?= $producto['descripcion'] ?></p> <!-- Descripción flexible -->
                                <h6 class="text-warning"><?= $producto['precio'] ?>€</h6>
                                <div class="mt-auto"> <!-- Mantiene el botón en la parte inferior -->
                                    <form method="POST" action="<?= BASE_URL ?>Carrito/anadirCarrito">
                                        <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                        <input type="hidden" name="precio" value="<?= $producto['precio'] ?>">
                                        <input type="hidden" name="nombre" value="<?= $producto['nombre'] ?>">
                                        <div class="d-flex align-items-center mb-2">
                                            <input type="number" name="cantidad" class="form-control me-2" value="1" min="1" max="<?= $producto['stock'] ?>" style="width: 70px;">
                                            <button type="submit" class="btn btn-primary" <?php echo !isset($_SESSION['login']) ? 'disabled' : ''; ?>>Añadir al carrito</button>
                                        </div>
                                    </form>
                                    <?php if (!isset($_SESSION['login'])): ?>
                                        <p class="text-warning mt-2">Inicia sesión para poder comprar.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center"><?= isset($mensaje) ? $mensaje : 'No hay productos disponibles en esta categoría.' ?></p>
            <?php endif; ?>
        </div>

        <?php if ($pagerfanta->haveToPaginate()): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($pagerfanta->hasPreviousPage()): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $pagerfanta->getPreviousPage() ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php foreach (range(1, $pagerfanta->getNbPages()) as $page): ?>
                        <li class="page-item <?= $page == $pagerfanta->getCurrentPage() ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a>
                        </li>
                    <?php endforeach; ?>

                    <?php if ($pagerfanta->hasNextPage()): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $pagerfanta->getNextPage() ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (para interactividad) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
