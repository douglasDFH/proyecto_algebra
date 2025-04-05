<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Editar Ciudad</h4>
            </div>
            <div class="card-body">
                <form action="index.php?controller=ciudad&action=update" method="post">
                    <input type="hidden" name="id" value="<?php echo $ciudad['id']; ?>">
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Ciudad</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $ciudad['nombre']; ?>" required>
                        <div class="form-text">Edite el nombre de la ciudad.</div>
                    </div>
                    
                    <div class="alert alert-warning">
                        <p><i class="fas fa-exclamation-triangle"></i> <strong>Advertencia:</strong> Cambiar el nombre de una ciudad afectará a todas las rutas asociadas.</p>
                        <p>Asegúrese de que este cambio es correcto antes de guardar.</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php?controller=ciudad" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Ciudad</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>