<h2 class="text-center text-light mb-4">Crear Nueva Categoría</h2>

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

<form action="<?= BASE_URL ?>Categoria/crearCategoria/" method="post" class="p-4 mx-auto" style="max-width: 600px;">
    <div class="mb-3">
        <label for="categoria" class="form-label text-light">Nombre de la categoría:</label>
        <input type="text" id="categoria" name="categoria" class="form-control" required>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-success">Crear Categoría</button>
    </div>
</form>
