<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Historial de Optimizaciones</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a href="index.php?controller=transporte&action=optimizar" class="btn btn-primary">Nueva Optimización</a>
                </div>
                
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
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php?controller=transporte" class="btn btn-outline-secondary">Volver a Transporte</a>
                </div>
            </div>
        </div>
    </div>
</div>