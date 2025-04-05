<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Gestión de Transporte</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Nueva Optimización</h5>
                                <p class="card-text">Calcular la distribución óptima de productos entre ciudades</p>
                                <a href="index.php?controller=transporte&action=optimizar" class="btn btn-primary">Iniciar Optimización</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">Historial de Optimizaciones</h5>
                                <p class="card-text">Ver todas las optimizaciones realizadas anteriormente</p>
                                <a href="index.php?controller=transporte&action=historia" class="btn btn-secondary">Ver Historial</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h5 class="mt-4 mb-3">Últimas Optimizaciones</h5>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Total de Productos</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            while ($row = $optimizaciones->fetch(PDO::FETCH_ASSOC)) {
                                $count++;
                                if ($count > 5) break; // Mostrar solo las últimas 5 optimizaciones
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo number_format($row['total_productos']); ?> unidades</td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['fecha_calculo'])); ?></td>
                                    <td>
                                        <a href="index.php?controller=transporte&action=resultados&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Ver Detalles</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            
                            if ($count == 0) {
                                echo '<tr><td colspan="4" class="text-center">No hay optimizaciones registradas</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($count > 0) { ?>
                    <div class="text-end">
                        <a href="index.php?controller=transporte&action=historia" class="btn btn-outline-primary">Ver todas las optimizaciones</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>