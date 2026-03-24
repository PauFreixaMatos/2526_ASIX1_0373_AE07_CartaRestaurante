
# 🍽️ AE07 — Camarero\! Una de mero\!\!

**Módulo:** 0373 — Lenguajes de marcas y sistemas de gestión de información  
**Profesor:** Alberto de Santos Ontoria  
**Alumno:** Pau Freixa Matos

Este proyecto consiste en una página web dinámica que muestra la carta completa de un restaurante. La principal característica es que la información de los platos no está escrita directamente en el HTML, sino que se gestiona de forma externa mediante un archivo **XML**, el cual es procesado y mostrado en pantalla utilizando **PHP**.

### 🌿 Estructura del proyecto

Para que el proyecto esté ordenado y el servidor encuentre bien las rutas, he organizado los ficheros así:

  * **index.php** → Es el archivo principal. Tiene el código PHP que lee el XML y genera el diseño con ayuda de Bootstrap.
  * **menu.xml** → Es nuestra "base de datos" con los **27 platos** divididos en entrantes, platos fuertes y postres.
  * **css/estilos.css** → Hoja de estilos para que la carta se vea bien en móviles y no se descuadre.
  * **img/** → Carpeta donde guardo el logo y las imágenes de los platos.

### 🛠️ Especificaciones técnicas cumplidas

  * **XML estructurado:** He creado el XML desde cero con la etiqueta `<menu>`. Cada plato tiene su atributo `tipo` y etiquetas hijas para el nombre, precio, descripción, calorías y las características anidadas.
  * **PHP y SimpleXML:** He usado PHP para cargar el archivo y hacer un bucle que recorra todos los platos automáticamente.
  * **Iconos de Font Awesome:** He vinculado la librería de iconos para que se vea un dibujo diferente según si el plato es picante, vegano o tiene gluten.
  * **Diseño Adaptativo:** He usado CSS Grid y Media Queries para que la carta sea responsive y se pueda leer bien desde un teléfono.

### 🔗 Visita la web aquí

[**Haz clic aquí para ver mi carta online**](https://cartarestaurante.free.nf/?i=1).

-----

**Comentario y observación final:** 
Como me salían avisos de “Warning” de PHP en la parte superior de la página, entré en la configuración del hosting y desactivé la visualización de errores para que la web se vea más limpia. Por otro lado, pasé el XML por un validador para comprobar que todas las etiquetas están bien cerradas.
