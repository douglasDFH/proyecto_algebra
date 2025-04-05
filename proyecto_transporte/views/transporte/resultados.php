<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Resultados de la Optimización</h4>
            </div>
            <div class="card-body">
                <?php if (empty($resultados)): ?>
                <div class="alert alert-warning">
                    No se encontraron resultados para esta optimización.
                </div>
                <?php else: ?>
                <div class="alert alert-success">
                    <h5>¡Optimización Exitosa!</h5>
                    <p>
                        Se ha determinado la distribución óptima de productos entre las ciudades para minimizar
                        los costos de transporte usando programación lineal.
                    </p>
                </div>

                <div class="mb-4">
                    <h5>Distribución Óptima:</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Ruta</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th class="text-end">Distancia (km)</th>
                                    <th class="text-end">Costo/km ($)</th>
                                    <th class="text-end">Productos</th>
                                    <th class="text-end">Costo Total ($)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $resultado): ?>
                                <tr <?php echo $resultado['cantidad_productos'] > 0 ? 'class="table-primary"' : ''; ?>>
                                    <td><?php echo $resultado['ruta_id']; ?></td>
                                    <td><?php echo $resultado['origen']; ?></td>
                                    <td><?php echo $resultado['destino']; ?></td>
                                    <td class="text-end"><?php echo number_format($resultado['distancia']); ?></td>
                                    <td class="text-end"><?php echo number_format($resultado['costo_km'], 2); ?></td>
                                    <td class="text-end"><?php echo number_format($resultado['cantidad_productos']); ?></td>
                                    <td class="text-end"><?php echo number_format($resultado['costo_total'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-dark">
                                <tr>
                                    <th colspan="5" class="text-end">Total:</th>
                                    <th class="text-end"><?php echo number_format(array_sum(array_column($resultados, 'cantidad_productos'))); ?></th>
                                    <th class="text-end"><?php echo number_format($costo_total, 2); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Explicación del Cálculo</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            El sistema ha resuelto el problema de optimización mediante programación lineal, siguiendo los pasos:
                        </p>
                        <ol>
                            <li>Se definieron las variables de decisión: cantidad de productos a transportar por cada ruta</li>
                            <li>Se estableció la función objetivo: minimizar el costo total de transporte</li>
                            <li>Se identificaron las restricciones: transportar un total de <?php echo number_format($resultados[0]['cantidad_productos']); ?> productos</li>
                            <li>Se calculó el costo unitario para cada ruta multiplicando la distancia por el costo por kilómetro</li>
                            <li>Se ordenaron las rutas de menor a mayor costo</li>
                            <li>Se asignaron todos los productos a la ruta con menor costo unitario</li>
                        </ol>
                        <p>
                            Esta distribución garantiza el transporte de todos los productos minimizando el costo total.
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-primary h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Interpretación</h5>
                            </div>
                            <div class="card-body">
                                <p>La solución indica que para minimizar el costo total de transporte:</p>
                                <ul>
                                    <?php 
                                    $rutaOptima = null;
                                    foreach ($resultados as $resultado): 
                                        if ($resultado['cantidad_productos'] > 0) {
                                            $rutaOptima = $resultado;
                                    ?>
                                    <li>
                                        <strong><?php echo number_format($resultado['cantidad_productos']); ?> productos</strong>
                                        deben enviarse desde <strong><?php echo $resultado['origen']; ?></strong>
                                        hasta <strong><?php echo $resultado['destino']; ?></strong>
                                    </li>
                                    <?php 
                                        }
                                    endforeach; 
                                    
                                    if ($rutaOptima):
                                    ?>
                                    <li>
                                        Esta es la ruta más económica con un costo de 
                                        <strong>$<?php echo number_format($rutaOptima['costo_km'] * $rutaOptima['distancia'], 2); ?></strong> 
                                        por producto.
                                    </li>
                                    <?php endif; ?>
                                </ul>
                                <p>
                                    Con esta distribución, el costo total de transporte es de
                                    <strong>$<?php echo number_format($costo_total, 2); ?></strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Beneficios</h5>
                            </div>
                            <div class="card-body">
                                <p>Esta solución optimizada ofrece los siguientes beneficios:</p>
                                <ul>
                                    <li>Minimización del costo total de transporte mediante programación lineal</li>
                                    <li>Simplificación logística al utilizar una sola ruta</li>
                                    <li>Reducción de la complejidad operativa</li>
                                    <li>Máximo ahorro en costos para la empresa</li>
                                </ul>
                                <p>
                                    Al implementar esta distribución, se asegura el uso óptimo de los recursos
                                    de transporte disponibles, aplicando principios matemáticos rigurosos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php?controller=transporte" class="btn btn-outline-secondary">Volver a Transporte</a>
                    <a href="index.php?controller=transporte&action=optimizar" class="btn btn-primary">Nueva Optimización</a>
                </div>
            </div>
        </div>
    </div>
</div>