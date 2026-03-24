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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Camarero! Una de mero!! - Carta del Restaurante</title>
    
    <!-- Bootstrap 5 CSS - Grid responsive sin necesidad de escribir CSS complejo -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts para tipografías elegantes y profesionales -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 - Biblioteca completa de iconos vectoriales -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Nuestra hoja de estilos personalizada (sin animaciones) -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- ==================== HEADER / SECCIÓN HERO ==================== -->
    <!-- Cabecera con imagen de fondo y botón de anclaje para navegar a la carta -->
    <header class="hero-section">
        <!-- Capa oscura sobre la imagen de fondo para mejorar el contraste del texto -->
        <div class="hero-overlay"></div>
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <!-- Título principal con el nombre de la página web-->
                    <h1 class="display-3 fw-bold">Camarero! Una de mero!!</h1>
                    <!-- Subtítulo con la descripción de la carta -->
                    <p class="lead">Carta de temporada | Cocina tradicional con toques modernos</p>
                    <div class="mt-4">
                        <!-- Botón que enlaza directamente a la sección de la carta -->
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
        // Recorremos cada categoría de platos que hemos organizado previamente en el array $platosPorTipo
        foreach ($platosPorTipo as $tipo => $platos): 
            // Si la categoría tiene una traducción definida en el array $nombresCategorias, la usamos.
            // Si no existe traducción, usamos mayúscula en el nombre original (ucfirst) para mostrarlo bonito.
            $titulo = $nombresCategorias[$tipo] ?? ucfirst($tipo);
        ?>
            <!-- Cada categoría es una sección independiente dentro de la carta -->
            <section class="categoria mb-5">
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="categoria-titulo">
                            <span class="titulo-decorado"><?php echo $titulo; ?></span>
                        </h2>
                    </div>
                </div>
                
                <!-- Grid de Bootstrap: responsive por defecto -->
                <!-- En móvil: 1 columna | En tablet: 2 columnas | En escritorio: 3 columnas -->
                <div class="row g-4">
                    <?php foreach ($platos as $plato): ?>
                        <!-- Cada plato se muestra dentro de una columna que se adapta al ancho de pantalla -->
                        <div class="col-lg-4 col-md-6">
                            <div class="card plato-card h-100 border-0 shadow-sm">
                                
                                <!-- ========== BLOQUE DE IMAGEN DEL PLATO ========== -->
                                <?php if (!empty($plato->imagen) && file_exists($plato->imagen)): ?>
                                    <!-- Caso 1: Existe una imagen válida en la ruta especificada en el XML -->
                                    <div class="card-img-top-wrapper">
                                        <img src="<?php echo $plato->imagen; ?>" 
                                             class="card-img-top" 
                                             alt="<?php echo $plato->nombre; ?>"
                                             onerror="this.src='img/placeholder.jpg'"> <!-- Fallback si la imagen no carga -->
                                        
                                        <!-- Badge de "Recomendado" para platos destacados -->
                                        <?php 
                                        $esDestacado = false;
                                        // Recorremos las características del plato para ver si tiene la etiqueta "destacado"
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
                                    <!-- Caso 2: No hay imagen definida o la ruta no existe. Mostramos un placeholder visualmente agradable -->
                                    <div class="card-img-top-wrapper bg-light">
                                        <div class="placeholder-img d-flex align-items-center justify-content-center">
                                            <i class="fas fa-utensils fa-3x text-secondary"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- ========== CUERPO DE LA TARJETA CON LA INFORMACIÓN DEL PLATO ========== -->
                                <div class="card-body">
                                    <!-- Cabecera: alineamos el nombre del plato a la izquierda y el precio a la derecha -->
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h3 class="card-title h5 mb-0"><?php echo $plato->nombre; ?></h3>
                                        <span class="precio-badge"><?php echo $plato->precio; ?>€</span>
                                    </div>
                                    
                                    <!-- Descripción detallada del plato -->
                                    <p class="card-text descripcion text-muted small">
                                        <?php echo $plato->descripcion; ?>
                                    </p>
                                    
                                    <!-- Información calórica con icono de fuego para dar contexto visual -->
                                    <div class="calorias mb-2">
                                        <i class="fas fa-fire text-danger me-1"></i>
                                        <span class="small"><?php echo $plato->calorias; ?> kcal</span>
                                    </div>
                                    
                                    <!-- Características especiales del plato (picante, vegano, sin gluten, etc.) -->
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

    <!-- ==================== FOOTER / PIE DE PÁGINA ==================== -->
    <!-- Contiene información de contacto, horarios y notas de servicio -->
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

    <!-- Scripts necesarios para el correcto funcionamiento de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>