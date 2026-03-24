<?php

// Desactivar avisos del servidor para una visualización limpia
error_reporting(0);
ini_set('display_errors', 0);

// Ponemos UTF-8 para que se vean bien las tildes y la eñe
header('Content-Type: text/html; charset=UTF-8');

// Cargamos el XML con SimpleXML. Si falla, mostramos error y paramos
$xml = simplexml_load_file('menu.xml') or die("Error: No se pudo cargar el archivo XML");

/**
 * Función que convierte cada característica en un icono de Font Awesome
 * @param string $caracteristica - El texto que viene del XML (ej: "picante")
 * @return string - El código HTML del icono correspondiente
 */
function getIcono($caracteristica) {
    // Asociamos cada texto con su icono de Font Awesome
    // El title="" es para que al pasar el ratón salga el nombre de la característica
    $iconos = [
        'picante' => '<i class="fas fa-pepper-hot" title="Picante"></i>',
        'vegano' => '<i class="fas fa-leaf" title="Vegano"></i>',
        'vegetariano' => '<i class="fas fa-seedling" title="Vegetariano"></i>',
        'sin-gluten' => '<i class="fas fa-wheat-slash" title="Sin gluten"></i>',
        'carne' => '<i class="fas fa-drumstick-bite" title="Carne"></i>',
        'pescado' => '<i class="fas fa-fish" title="Pescado"></i>',
        'lacteos' => '<i class="fas fa-cheese" title="Lácteos"></i>',
        'destacado' => '<i class="fas fa-star" title="Plato destacado"></i>'
    ];
    
    // Si la característica existe en el array, devolvemos su icono
    // Si no existe, devolvemos un icono genérico de utensilios
    return isset($iconos[$caracteristica]) ? $iconos[$caracteristica] : '<i class="fas fa-utensils"></i>';
}

// Creamos un array vacío para organizar los platos por categoría
$platosPorTipo = [];

// Recorremos todos los platos que hay en el XML
foreach ($xml->plato as $plato) {
    // Sacamos el atributo "tipo" de cada plato (entrantes, carnes, etc)
    $tipo = (string)$plato['tipo'];
    
    // Si este tipo de plato no existe todavía en el array, lo creamos como array vacío
    if (!isset($platosPorTipo[$tipo])) {
        $platosPorTipo[$tipo] = [];
    }
    
    // Añadimos este plato a su categoría correspondiente
    $platosPorTipo[$tipo][] = $plato;
}

// Traducimos los nombres de las categorías para que se vean más bonitos en la web
$nombresCategorias = [
    'entrantes' => '🍽️ Tapas & Entrantes',
    'ensaladas' => '🥗 Ensaladas',
    'huevos' => '🍳 Huevos con...',
    'bocadillos' => '🥪 Bocadillos & Hamburguesas',
    'arroces' => '🍚 Arroces (mínimo 2 personas)',
    'carnes' => '🥩 Carnes',
    'pescados' => '🐟 Pescados',
    'postres' => '🍰 Postres'
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- Viewport necesario para que sea responsive en móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camarero! Una de mero!! - Carta del Restaurante</title>
    
    <!-- Bootstrap 5 CSS -->
    <!-- Usamos Bootstrap para tener un grid responsive sin tener que escribir mucho CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts para tipografías elegantes -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- AOS Library: animaciones al hacer scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Nuestra hoja de estilos personalizada -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- ==================== HEADER ==================== -->
    <!-- Cabecera con imagen de fondo y botón para ir a la carta -->
    <header class="hero-section">
        <div class="hero-overlay"></div> <!-- Capa oscura sobre la imagen para que el texto destaque -->
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <h1 class="display-3 fw-bold" data-aos="fade-down">Camarero! Una de mero!!</h1>
                    <p class="lead" data-aos="fade-up" data-aos-delay="200">Carta de temporada | Cocina tradicional con toques modernos</p>
                    <div class="mt-4" data-aos="fade-up" data-aos-delay="400">
                        <a href="#carta" class="btn btn-outline-light btn-lg rounded-pill px-5">
                            <i class="fas fa-scroll me-2"></i>Ver la carta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ==================== CONTENEDOR PRINCIPAL DE LA CARTA ==================== -->
    <main id="carta" class="container py-5">
        
        <?php 
        // Recorremos cada categoría de platos que hemos organizado antes
        foreach ($platosPorTipo as $tipo => $platos): 
            // Si la categoría tiene traducción, la usamos. Si no, ponemos el nombre original con primera mayúscula
            $titulo = $nombresCategorias[$tipo] ?? ucfirst($tipo);
        ?>
            <!-- Cada categoría es una sección con animación al hacer scroll -->
            <section class="categoria mb-5" data-aos="fade-up">
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="categoria-titulo">
                            <span class="titulo-decorado"><?php echo $titulo; ?></span>
                        </h2>
                    </div>
                </div>
                
                <!-- Grid de Bootstrap: en móvil 1 columna, tablet 2, escritorio 3 -->
                <div class="row g-4">
                    <?php foreach ($platos as $plato): ?>
                        <!-- Cada plato es una columna que se adapta al tamaño de pantalla -->
                        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                            <div class="card plato-card h-100 border-0 shadow-sm">
                                
                                <!-- ========== IMAGEN DEL PLATO ========== -->
                                <?php if (!empty($plato->imagen) && file_exists($plato->imagen)): ?>
                                    <!-- Si la imagen existe, la mostramos -->
                                    <div class="card-img-top-wrapper">
                                        <img src="<?php echo $plato->imagen; ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo $plato->nombre; ?>"
                                             onerror="this.src='img/placeholder.jpg'"> <!-- Si falla, muestra placeholder -->
                                        
                                        <!-- Badge de destacado: si el plato tiene la característica "destacado", mostramos una estrella -->
                                        <?php 
                                        $esDestacado = false;
                                        foreach ($plato->caracteristicas->item as $item) {
                                            if ((string)$item == 'destacado') $esDestacado = true;
                                        }
                                        if ($esDestacado): ?>
                                            <span class="badge-destacado">
                                                <i class="fas fa-star"></i> Recomendado
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <!-- Si no hay imagen, mostramos un placeholder con icono -->
                                    <div class="card-img-top-wrapper bg-light">
                                        <div class="placeholder-img d-flex align-items-center justify-content-center">
                                            <i class="fas fa-utensils fa-3x text-secondary"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- ========== CUERPO DE LA TARJETA ========== -->
                                <div class="card-body">
                                    <!-- Cabecera: nombre y precio -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h3 class="card-title h5 mb-0"><?php echo $plato->nombre; ?></h3>
                                        <span class="precio-badge"><?php echo $plato->precio; ?>€</span>
                                    </div>
                                    
                                    <!-- Descripción del plato -->
                                    <p class="card-text descripcion text-muted small">
                                        <?php echo $plato->descripcion; ?>
                                    </p>
                                    
                                    <!-- Calorías con icono de fuego -->
                                    <div class="calorias mb-2">
                                        <i class="fas fa-fire text-danger me-1"></i>
                                        <span class="small"><?php echo $plato->calorias; ?> kcal</span>
                                    </div>
                                    
                                    <!-- Características: recorremos todos los <item> y los convertimos en iconos -->
                                    <div class="caracteristicas mt-3">
                                        <?php foreach ($plato->caracteristicas->item as $item): ?>
                                            <?php echo getIcono((string)$item); ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
        
    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <div class="row">
                <div class="col-12">
                    <p class="mb-2">
                        <i class="fas fa-utensils text-warning me-2"></i>
                        Todos los precios IVA incluido
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-clock text-warning me-2"></i>
                        Horario: Lunes a Domingo | 12:00 - 16:00 / 20:00 - 23:30
                    </p>
                    <p class="mb-0 small text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Consulta nuestras opciones sin gluten y para alergias
                    </p>
                    <hr class="my-3 bg-secondary">
                    <p class="small text-muted mb-0">
                        <i class="fas fa-map-marker-alt me-1"></i> Calle de la Buena Mesa, 12 · Madrid
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                        <i class="fas fa-phone me-1"></i> +34 912 345 678
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts: Bootstrap JS y AOS para animaciones -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inicializamos las animaciones AOS
        AOS.init({
            duration: 800,      // Duración de la animación en ms
            once: true,        // La animación ocurre solo una vez
            offset: 100        // Distancia desde el fondo para activar la animación
        });
    </script>
</body>
</html>