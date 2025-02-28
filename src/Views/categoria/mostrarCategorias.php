<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Categorías</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="text-light">
    <div class="container mt-5 mb-5">
        <h1 class="text-center mb-4">Listado de Categorías</h1>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success">
                <?= $mensaje ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errores)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errores as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <ul class="list-group">
            <?php if (!empty($categorias)): ?>
                <?php foreach ($categorias as $categoria): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $categoria['nombre'] ?>
                        <div>
                            <form action="<?= BASE_URL ?>Categoria/modificarCategoria" method="GET" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Modificar</button>
                            </form>
                            <form action="<?= BASE_URL ?>Categoria/eliminarCategoria" method="POST" style="display: inline;">
                                <input type="hidden" name="categoria_id" value="<?= $categoria['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="list-group-item">No hay categorías disponibles.</li>
            <?php endif; ?>
        </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>