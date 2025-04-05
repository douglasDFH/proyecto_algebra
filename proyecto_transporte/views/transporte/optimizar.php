<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Nueva Optimización de Transporte</h4>
            </div>
            <div class="card-body">
                <form action="index.php?controller=transporte&action=procesarOptimizacion" method="post">
                    <div class="mb-4">
                        <h5>Rutas Disponibles:</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Distancia (km)</th>
                                        <th>Costo por km ($)</th>
                                        <th>Costo Total por Producto ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // Calcular y ordenar las rutas por costo
                                    $rutasOrdenadas = $rutas;
                                    foreach ($rutasOrdenadas as &$ruta) {
                                        $ruta['costo_total'] = $ruta['distancia'] * $ruta['costo_km'];
                                    }
                                    usort($rutasOrdenadas, function($a, $b) {
                                        return $a['costo_total'] - $b['costo_total'];
                                    });
                                    
                                    foreach ($rutasOrdenadas as $index => $ruta): 
                                        $esRutaMasEconomica = ($index === 0);
                                    ?>
                                    <tr <?php echo $esRutaMasEconomica ? 'class="table-success"' : ''; ?>>
                                        <td><?php echo $ruta['origen_nombre']; ?></td>
                                        <td><?php echo $ruta['destino_nombre']; ?></td>
                                        <td class="text-end"><?php echo number_format($ruta['distancia']); ?></td>
                                        <td class="text-end"><?php echo number_format($ruta['costo_km'], 2); ?></td>
                                        <td class="text-end">
                                            <?php echo number_format($ruta['distancia'] * $ruta['costo_km'], 2); ?>
                                            <?php if ($esRutaMasEconomica): ?>
                                                <span class="badge bg-success">Más económica</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="total_productos" class="form-label">Total de Productos a Transportar</label>
                        <input type="number" class="form-control form-control-lg" id="total_productos" name="total_productos" min="1" required>
                        <div class="form-text">Ingrese la cantidad total de productos que necesita transportar.</div>
                    </div>

                    <div class="alert alert-info">
                        <p><strong>Nota sobre la Optimización:</strong> El sistema utilizará programación lineal para determinar la distribución óptima.</p>
                        <p>En problemas sin restricciones adicionales, todos los productos se asignarán a la ruta con menor costo por producto (resaltada en verde).</p>
                        <p>Las distancias y costos por kilómetro están preestablecidos según el ejercicio propuesto.</p>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Calcular Distribución Óptima</button>
                        <a href="index.php?controller=transporte" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>