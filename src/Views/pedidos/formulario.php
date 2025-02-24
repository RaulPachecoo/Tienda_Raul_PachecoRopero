<div class="container mt-5">
    <h1 class="text-light text-center">Finalizar Pedido</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mb-5 text-light shadow p-4" style="background-color: black;">
                <form action="<?= BASE_URL ?>Pedido/crearPedido" method="POST">
                    <div class="mb-3">
                        <label for="provincia" class="form-label">Provincia</label>
                        <input type="text" name="provincia" id="provincia" class="form-control bg-secondary text-light border-light" required>
                    </div>
                    <div class="mb-3">
                        <label for="localidad" class="form-label">Localidad</label>
                        <input type="text" name="localidad" id="localidad" class="form-control bg-secondary text-light border-light" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control bg-secondary text-light border-light" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Realizar Pedido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
