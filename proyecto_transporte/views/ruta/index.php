<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Gestión de Rutas</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a href="index.php?controller=ruta&action=create" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Nueva Ruta
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th class="text-end">Distancia (km)</th>
                                <th class="text-end">Costo/km ($)</th>
                                <th class="text-end">Costo Total ($)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            while ($row = $rutas->fetch(PDO::FETCH_ASSOC)) {
                                $count++;
                                $costoTotal = $row['distancia'] * $row['costo_km'];
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['origen_nombre']; ?></td>
                                    <td><?php echo $row['destino_nombre']; ?></td>
                                    <td class="text-end"><?php echo number_format($row['distancia']); ?></td>
                                    <td class="text-end"><?php echo number_format($row['costo_km'], 2); ?></td>
                                    <td class="text-end"><?php echo number_format($costoTotal, 2); ?></td>
                                    <td>
                                        <a href="index.php?controller=ruta&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                        
                                        <!-- Modal de confirmación para eliminar -->
                                        <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Confirmar Eliminación</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Está seguro de que desea eliminar la ruta de <strong><?php echo $row['origen_nombre']; ?></strong> a <strong><?php echo $row['destino_nombre']; ?></strong>?</p>
                                                        <p class="text-danger">Esta acción no se puede deshacer. Si la ruta está siendo utilizada en alguna optimización, no podrá ser eliminada.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <a href="index.php?controller=ruta&action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            
                            if ($count == 0) {
                                echo '<tr><td colspan="7" class="text-center">No hay rutas registradas</td></tr>';
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