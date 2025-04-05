<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Optimización de Transporte</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Optimización de Transporte</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarTransporteDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Transporte
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarTransporteDropdown">
                            <li><a class="dropdown-item" href="index.php?controller=transporte">Panel de Transporte</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=transporte&action=optimizar">Nueva Optimización</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=transporte&action=historia">Historial</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarConfigDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Configuración
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarConfigDropdown">
                            <li><a class="dropdown-item" href="index.php?controller=ciudad">Gestionar Ciudades</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=ruta">Gestionar Rutas</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        <!-- Mensajes de alerta -->
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- El contenido específico de cada vista será incluido aquí -->
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            Sistema de Optimización de Transporte - <?php echo date('Y'); ?>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/main.js"></script>
</body>
</html>