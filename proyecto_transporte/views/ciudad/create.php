<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Nueva Ciudad</h4>
            </div>
            <div class="card-body">
                <form action="index.php?controller=ciudad&action=store" method="post">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Ciudad</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                        <div class="form-text">Ingrese el nombre completo de la ciudad.</div>
                    </div>
                    
                    <div class="alert alert-info">
                        <p><i class="fas fa-info-circle"></i> <strong>Nota:</strong> Las ciudades se utilizarán como origen y destino en las rutas.</p>
                        <p>Asegúrese de ingresar el nombre correcto de la ciudad.</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php?controller=ciudad" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Ciudad</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>