// Funciones JavaScript para el sistema de optimización de transporte

document.addEventListener('DOMContentLoaded', function() {
    
    // Configura el cierre automático de las alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // Validación del formulario de optimización
    const optimizacionForm = document.querySelector('form[action*="procesarOptimizacion"]');
    if (optimizacionForm) {
        optimizacionForm.addEventListener('submit', function(event) {
            const totalProductos = document.getElementById('total_productos');
            
            if (totalProductos.value <= 0) {
                event.preventDefault();
                alert('La cantidad de productos debe ser mayor a cero.');
                totalProductos.focus();
                return false;
            }
            
            // Mostrar un mensaje de espera mientras se realiza el cálculo
            const submitBtn = optimizacionForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Calculando...';
        });
    }
    
    // Animar las tarjetas de resultado
    const resultCards = document.querySelectorAll('.card-body .card');
    if (resultCards.length > 0) {
        resultCards.forEach(function(card, index) {
            setTimeout(function() {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(function() {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 200);
        });
    }
    
    // Resaltar filas de tabla al pasar el mouse
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(function(row) {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f0f8ff';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
    
    // Función para formatear números con separador de miles
    window.formatNumber = function(number) {
        return new Intl.NumberFormat('es-BO').format(number);
    };
});