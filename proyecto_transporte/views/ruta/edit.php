<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Editar Ruta</h4>
            </div>
            <div class="card-body">
                <form action="index.php?controller=ruta&action=update" method="post">
                    <input type="hidden" name="id" value="<?php echo $ruta['id']; ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="origen_id" class="form-label">Ciudad de Origen</label>
                            <select class="form-select" id="origen_id" name="origen_id" required>
                                <option value="">Seleccione una ciudad</option>
                                <?php while ($ciudad = $ciudades->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $ciudad['id']; ?>" <?php echo ($ciudad['id'] == $ruta['origen_id']) ? 'selected' : ''; ?>>
                                        <?php echo $ciudad['nombre']; ?>
                                    </option>
                                <?php endwhile; ?>
                                <?php $ciudades->execute(); // Reiniciar el cursor para el siguiente bucle ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="destino_id" class="form-label">Ciudad de Destino</label>
                            <select class="form-select" id="destino_id" name="destino_id" required>
                                <option value="">Seleccione una ciudad</option>
                                <?php while ($ciudad = $ciudades->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $ciudad['id']; ?>" <?php echo ($ciudad['id'] == $ruta['destino_id']) ? 'selected' : ''; ?>>
                                        <?php echo $ciudad['nombre']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="distancia" class="form-label">Distancia (km)</label>
                            <input type="number" class="form-control" id="distancia" name="distancia" step="1" min="1" value="<?php echo $ruta['distancia']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="costo_km" class="form-label">Costo por Kilómetro ($)</label>
                            <input type="number" class="form-control" id="costo_km" name="costo_km" step="0.01" min="0.01" value="<?php echo $ruta['costo_km']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Costo Total por Producto</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" id="costo_total" value="<?php echo number_format($ruta['distancia'] * $ruta['costo_km'], 2); ?>" readonly>
                        </div>
                        <div class="form-text">Este valor se calcula automáticamente al multiplicar la distancia por el costo por kilómetro.</div>
                    </div>
                    
                    <div class="alert alert-info">
                        <p><i class="fas fa-info-circle"></i> <strong>Nota:</strong> El origen y el destino deben ser ciudades diferentes.</p>
                        <p>Los cambios en esta ruta afectarán a futuros cálculos de optimización, pero no a los ya realizados.</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php?controller=ruta" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Ruta</button>
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
    const distanciaInput = document.getElementById('distancia');
    const costoKmInput = document.getElementById('costo_km');
    const costoTotalInput = document.getElementById('costo_total');
    
    form.addEventListener('submit', function(event) {
        const origen = document.getElementById('origen_id').value;
        const destino = document.getElementById('destino_id').value;
        
        if (origen === destino && origen !== '') {
            event.preventDefault();
            alert('Error: El origen y destino deben ser diferentes.');
        }
    });
    
    // Actualizar el costo total cuando cambian los valores
    function actualizarCostoTotal() {
        const distancia = parseFloat(distanciaInput.value) || 0;
        const costoKm = parseFloat(costoKmInput.value) || 0;
        const costoTotal = distancia * costoKm;
        
        costoTotalInput.value = costoTotal.toFixed(2);
    }
    
    distanciaInput.addEventListener('input', actualizarCostoTotal);
    costoKmInput.addEventListener('input', actualizarCostoTotal);
});
</script>