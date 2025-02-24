<div class="container mt-5">
    <h1 class="text-light text-center">Modificar Datos de Usuario</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mb-5 text-light shadow p-4" style="background-color: black;">

                <!-- Mostrar errores, si los hay -->
                <?php if (isset($errores) && count($errores) > 0): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Formulario para modificar los datos -->
                <form method="POST" action="<?php echo BASE_URL . 'Usuario/modificarDatos?id=' . $usuarioId; ?>">

                    <!-- Campo nombre -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control bg-secondary text-light border-light" id="nombre" name="data[nombre]" value="<?php echo htmlspecialchars($usuario->getNombre()); ?>" required>
                    </div>

                    <!-- Campo apellidos -->
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control bg-secondary text-light border-light" id="apellidos" name="data[apellidos]" value="<?php echo htmlspecialchars($usuario->getApellidos()); ?>" required>
                    </div>

                    <!-- Campo email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-secondary text-light border-light" id="email" name="data[email]" value="<?php echo htmlspecialchars($usuario->getEmail()); ?>" required>
                    </div>

                    <!-- Campo de contraseña (opcional) -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña (opcional)</label>
                        <input type="password" class="form-control bg-secondary text-light border-light" id="password" name="data[password]" placeholder="Dejar en blanco si no desea cambiarla">
                    </div>

                    <!-- Campo rol, solo visible para administradores -->
                    <?php if ($_SESSION['login']->rol === 'admin'): ?>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select bg-secondary text-light border-light" id="rol" name="data[rol]" required>
                            <option value="user" <?php echo $usuario->getRol() === 'user' ? 'selected' : ''; ?>>Usuario</option>
                            <option value="admin" <?php echo $usuario->getRol() === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                    <?php endif; ?>

                    <!-- Botón de enviar -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
