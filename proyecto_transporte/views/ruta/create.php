<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Nueva Ruta</h4>
            </div>
            <div class="card-body">
                <form action="index.php?controller=ruta&action=store" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="origen_id" class="form-label">Ciudad de Origen</label>
                            <select class="form-select" id="origen_id" name="origen_id" required>
                                <option value="">Seleccione una ciudad</option>
                                <?php while ($ciudad = $ciudades->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $ciudad['id']; ?>"><?php echo $ciudad['nombre']; ?></option>
                                <?php endwhile; ?>
                                <?php $ciudades->execute(); // Reiniciar el cursor para el siguiente bucle ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="destino_id" class="form-label">Ciudad de Destino</label>
                            <select class="form-select" id="destino_id" name="destino_id" required>
                                <option value="">Seleccione una ciudad</option>
                                <?php while ($ciudad = $ciudades->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $ciudad['id']; ?>"><?php echo $ciudad['nombre']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="distancia" class="form-label">Distancia (km)</label>
                            <input type="number" class="form-control" id="distancia" name="distancia" step="1" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="costo_km" class="form-label">Costo por Kilómetro ($)</label>
                            <input type="number" class="form-control" id="costo_km" name="costo_km" step="0.01" min="0.01" required>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <p><i class="fas fa-info-circle"></i> <strong>Nota:</strong> El origen y el destino deben ser ciudades diferentes.</p>
                        <p>El costo total por producto será calculado automáticamente multiplicando la distancia por el costo por kilómetro.</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php?controller=ruta" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Ruta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Validación del formulario con JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(event) {
        const origen = document.getElementById('origen_id').value;
        const destino = document.getElementById('destino_id').value;
        
        if (origen === destino && origen !== '') {
            event.preventDefault();
            alert('Error: El origen y destino deben ser diferentes.');
        }
    });
    
    // Calcular costo total en tiempo real
    const distanciaInput = document.getElementById('distancia');
    const costoKmInput = document.getElementById('costo_km');
    
    function actualizarCostoTotal() {
        const distancia = parseFloat(distanciaInput.value) || 0;
        const costoKm = parseFloat(costoKmInput.value) || 0;
        const costoTotal = distancia * costoKm;
        
        // Si quieres mostrar el costo total en la interfaz, puedes añadir un elemento con id "costo_total" y actualizar su contenido aquí
    }
    
    distanciaInput.addEventListener('input', actualizarCostoTotal);
    costoKmInput.addEventListener('input', actualizarCostoTotal);
});
</script>