<form action="<?= BASE_URL ?>Categoria/actualizarCategoria?id=<?= $categoria['id'] ?>" method="POST" class="p-4 mx-auto" style="max-width: 600px;">
    <h2 class="text-center text-light mb-4">Actualizar Categoría</h2>

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
    
    <div class="mb-3">
        <label for="nombre" class="form-label text-light">Nombre de la categoría:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $categoria['nombre'] ?? '' ?>" required>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
</form>
