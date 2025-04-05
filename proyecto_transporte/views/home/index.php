<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Bienvenido al Sistema de Optimización de Transporte</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">Minimiza tus costos de transporte entre ciudades</h5>
                <p class="card-text">
                    Este sistema está diseñado para ayudarte a determinar la distribución óptima de productos entre las ciudades de La Paz, Cochabamba y Tarija, minimizando los costos totales de transporte.
                </p>
                
                <div class="alert alert-info">
                    <h5>Sobre la optimización:</h5>
                    <p>Basado en el problema presentado en el ejemplo 2, nuestro sistema utiliza álgebra lineal y matrices inversas para determinar la distribución óptima de productos entre ciudades. Consideramos las siguientes rutas:</p>
                    <ul>
                        <li>La Paz → Cochabamba: 610 km</li>
                        <li>La Paz → Tarija: 1050 km</li>
                        <li>Cochabamba → Tarija: 700 km</li>
                    </ul>
                    <p>Con un costo de $25 por kilómetro por producto.</p>
                </div>
                
                <div class="text-center mt-4">
                    <a href="index.php?controller=transporte&action=optimizar" class="btn btn-primary btn-lg">Iniciar Nueva Optimización</a>
                    <a href="index.php?controller=transporte&action=historia" class="btn btn-secondary btn-lg ms-2">Ver Historial</a>
                </div>
            </div>
        </div>
    </div>
</div>
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                © <?php echo date('Y'); ?> Sistema de Optimización de Transporte
            </div>
        </footer>
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>