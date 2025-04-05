<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Gestión de Ciudades</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <a href="index.php?controller=ciudad&action=create" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Nueva Ciudad
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Fecha de Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 0;
                            while ($row = $ciudades->fetch(PDO::FETCH_ASSOC)) {
                                $count++;
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['nombre']; ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <a href="index.php?controller=ciudad&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
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
                                                        <p>¿Está seguro de que desea eliminar la ciudad <strong><?php echo $row['nombre']; ?></strong>?</p>
                                                        <p class="text-danger">Esta acción no se puede deshacer. Si la ciudad está siendo utilizada en rutas, no podrá ser eliminada.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <a href="index.php?controller=ciudad&action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            
                            if ($count == 0) {
                                echo '<tr><td colspan="4" class="text-center">No hay ciudades registradas</td></tr>';
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