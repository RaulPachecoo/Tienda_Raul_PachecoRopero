<h1 class="text-light text-center mb-4">Listado de Pedidos</h1>

<?php if (!empty($pedidos)): ?>
    <div class="container mt-5">
        <div class="row">
            <?php foreach ($pedidos as $pedido): ?>
                <div class="col-12 mb-4"> <!-- Aquí cambiamos a col-12 para una tarjeta por fila -->
                    <div class="card bg-dark text-light border-light shadow">
                        <div class="card-body">
                            <h5 class="card-title">Pedido ID: <?= $pedido['id'] ?></h5>
                            <p><strong>Provincia:</strong> <?= $pedido['provincia'] ?></p>
                            <p><strong>Localidad:</strong> <?= $pedido['localidad'] ?></p>
                            <p><strong>Dirección:</strong> <?= $pedido['direccion'] ?></p>
                            <p><strong>Coste:</strong> <?= $pedido['coste'] ?>€</p>
                            <p><strong>Estado:</strong> <?= $pedido['estado'] ?></p>
                            <p><strong>Fecha:</strong> <?= $pedido['fecha'] ?></p>
                            <p><strong>Hora:</strong> <?= $pedido['hora'] ?></p>

                            <?php if ($pedido['estado'] != 'Enviado'): ?>
                                <?php if ($_SESSION['login']->rol === "admin"): ?>
                                    <a href="<?= BASE_URL ?>Pedido/completarPedido?id=<?= $pedido['id'] ?>" class="btn btn-success mt-2">Marcar como Enviado</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="mt-2 text-success">Este pedido ya ha sido enviado.</p>
                            <?php endif; ?>
                            <?php if (isset($pedido['error'])): ?>
                                <p class="mt-2 text-danger"><?= $pedido['error'] ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="container text-center mt-5">
        <h2 class="text-light">No hay pedidos disponibles.</h2>
    </div>
<?php endif; ?>
