<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-dark text-light">
    <div class="container mt-5 mb-5">
        <h1 class="text-center mb-4">Modificar Producto</h1>

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

        <?php if (!empty($producto)): ?>
            <form action="<?= BASE_URL ?>Producto/actualizarProducto?id=<?= $producto['id'] ?>" method="POST" enctype="multipart/form-data" class="bg-dark p-4">

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="<?= $producto['nombre'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required><?= $producto['descripcion'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría:</label>
                    <select id="categoria" name="categoria" class="form-select">
                        <?php
                        $categories = \Models\Categoria::getAll();
                        foreach ($categories as $category):
                        ?>
                            <option value="<?= $category['id'] ?>" <?= $producto['categoria_id'] == $category['id'] ? 'selected' : '' ?>>
                                <?= $category['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label">Precio (€):</label>
                    <input type="number" id="precio" name="precio" class="form-control" value="<?= $producto['precio'] ?>" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" id="stock" name="stock" class="form-control" value="<?= $producto['stock'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="oferta" class="form-label">Oferta (%):</label>
                    <input type="number" id="oferta" name="oferta" class="form-control" value="<?= $producto['oferta'] ?>" min="0" max="100">
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control"
                        value="<?= !empty($producto['fecha']) ? date('Y-m-d', strtotime($producto['fecha'])) : date('Y-m-d') ?>">
                </div>

                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" class="form-control">
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="<?= BASE_URL ?>public/imgs/<?= $producto['imagen'] ?>" alt="Imagen actual" class="mt-2 img-fluid rounded" style="max-width: 200px;">
                    <?php endif; ?>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Modificar Producto</button>
                    <a href="<?= BASE_URL ?>Producto/gestionarProductos" class="btn btn-secondary">Volver</a>
                </div>

            </form>
        <?php else: ?>
            <p class="text-center text-warning">El producto no fue encontrado.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>