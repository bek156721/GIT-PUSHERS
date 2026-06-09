# Convenciones del Proyecto - Git Pushers

Este documento es nuestra guía obligatoria para colaborar de forma armoniosa, mantener un código limpio y evitar conflictos. Todos los integrantes nos comprometemos a respetar estos acuerdos. 

---

## Nuestro Equipo: Expectativas y Acuerdos 

Para trabajar en un ambiente sano y eficiente, respondimos a este cuestionario y nos comprometemos a respetar las respuestas de cada uno::

### Lo que NO soportamos del trabajar en equipo:
* **Rebeca:** Falta de comunicacion, que la distribucion del trabajo no sea equitativa y falta de flexibilidad. 
* **Viridiana:** Una mala organizacion, falta de participacion de los integrantes y una mala comunicacion. 
* **Dante:** La falta de comunicacion, la mala distribucion del trabajo y la falta de apoyo entre integrantes. 
* **Diego Lopez:** Mala comunicacion y falta de iniciativa. 
* **Diego Serrano:** Falta de comunicacion y problemas de organizacion. 

### Lo que necesito para poder contribuir:
* **Rebeca:** Paciencia, comunicacion, respeto, solidaridad, consultar cambios antes de hacerlos para llegar a un acuerdo como equipo, tomar "breaks" en caso de que sea necesario y musica. 
* **Viridiana:** Respeto, comunicacion, espacios para compartir y proponer ideas y paciencia. 
* **Dante:** Comunicacion, mucha paciencia y apoyo. 
* **Diego Lopez:** Respeto, comunicacion, iniciativa y paciencia. 
* **Diego Serrano:** Comunicacion, apoyo y respeto. 

### Las ventajas de trabajar en equipo:
* **Rebeca:** Constante retroalimentacion y diferentes puntos de vista para la resolucion de problemas. 
* **Viridiana:** Complementar las habilidades que cada integrante tiene con la de los otros, más creatividad al poder intercambiar ideas. 
* **Dante:** Mayor eficiencia y apoyo entre todos. 
* **Diego Lopez:** Diferentes formas de ver el mismo problema. 
* **Diego Serrano:** Mayor eficiencia de trabajo, apoyo al solucionar problemas y facilidad en multiples areas. 

---

## Mapa del Proyecto: ¿Qué va en cada carpeta? 

Para mantener el orden y que nadie se pierda, respetaremos estrictamente el propósito de cada directorio. Así es como se distribuye el proyecto:

| Carpeta / Archivo | ¿Qué contiene? | ¿Quién lo usa / Modifica? |
| :--- | :--- | :--- |
| **`database/`** | El archivo `schema.sql`. Estructura de las tablas y datos iniciales de MariaDB.  | **Todo el equipo** al montar el proyecto localmente.  |
| **`docs/`** | Planteamiento del proyecto, documentación, requerimientos o diagramas.  | **Todo el equipo** para consultar o actualizar reglas.  |
| **`dynamics/`** | La lógica de PHP. Aquí también va el archivo `conexion.php` para conectarse a la base de datos. | **Todos** al  momento de realizar sus avances.  |
| **`statics/css/`** | Hojas de estilo `.css`. Aquí pondremos tanto los estilos globales como los específicos de cada página. | **Todo el equipo**. *Nota: Si creas un CSS para tu página, ponle un nombre claro (ej: `inicioSesion.css`).*  |
| **`statics/fonts/`** | Fuentes tipográficas descargadas que usemos para los textos del sitio.  | Se agregan al inicio si el diseño lo requiere.  |
| **`statics/media/`** | Subcarpetas `audio/` e `img/`. Aquí van todas las imágenes, iconos, logos y audios del proyecto.  | **Todo el equipo** para subir los recursos que necesiten sus páginas.  |
| **`templates/`** | Partes HTML/PHP que se repiten en todo el sitio: `header.php`, `footer.php`, etc...  | Lo modifica quien se encargue de generarlo, una vez generado no se mueve a menos de que haya un consenso para cambiarlo.  |
**`uploads/`**  | **Exclusivamente para las fotos y archivos que suban los usuarios.**  | **Nadie la toca a mano.** PHP se encarga de guardar los archivos aquí mediante código.  |
| **Raíz del proyecto** `(./)` | Aquí unicamente va `index.php` que es nuestra página de aterrizaje del proyecto, así como el README.md y los directorios del proyecto.  | Nadie mueve cosas aquí.  |

---

## Reglas de Sintaxis y Nomenclatura 

* **Idiomas y Caracteres:** Todo el codigo y archivos se escriben en español, pero **SIN caracteres especiales, NI acentos, NI la letra "ñ"** (Ej: usar `anio` o `contrasenia`). 
* **Todo en Minusculas:** No se usaran mayusculas en nombres de variables, clases, ids o archivos. 

### Nomenclatura: 
En este equipo adoptamos `kebab-case` (palabras-separadas-por-guiones) como el estandar absoluto. Se aplicara obligatoriamente en:
* Nombres de archivos, ID's y Clases de CSS: `kebab-case` (palabras-separadas-por-guiones) -> Ej: `formulario-inicio-sesion.php`, `#contenedor-principal`, `.tarjeta-perfil`.
* Variables y funciones: `camelCase` (primeraPalabraIniciaEnMinusculaYLasDemasInicianEnMayuscula) -> Ej: `$idUsuario`, `function obtenerDatos()`.
* Tablas DB: `snake_case` (todas_las_palabras_en_minusculas_separadas_por_guiones_bajos) -> Ej: `alumno`, `tipo_pregunta`.

---

## Convenciones de Codigo

### HTML (Maquetacion Limpia)
* **Uso de `<div>` restringido:** Intentaremos **no utilizar** etiquetas `<div>` innecesarias para mantener el HTML semantico. En caso de ser estrictamente necesario usar un `<div>`, se debe agregar un comentario explicando su utilidad. 

### CSS (Estilos Ordenados)
* **Uso de Banderas:** Al trabajar en los archivos CSS, es obligatorio usar banderas (comentarios grandes) para delimitar que se esta diseñando en cada espacio del archivo (Ej: `/* === NAVBAR === */`, `/* === FOOTER === */`). 
* **Apertura de Llaves:** Al utilizar llaves, **NUNCA se abren en la misma linea**. La llave de apertura debe ir en una linea nueva. 
Ejemplo:
    ```css
    .imagen-r
    {
        width: 170px;
    }
    ```

### Lógica (Variables y Funciones)
* **Comentarios en la misma linea:** Cada vez que se declare una variable o una funcion, se debe describir su proposito de forma breve mediante un comentario **en esa misma linea**. Ejemplo:
    ```php
    $id-usuario = 0; // Almacena el identificador unico del usuario logueado
    ```

---

## Manejo de Git y Flujo de Trabajo

Para evitar conflictos y mantener el repositorio impecable, seguiremos las convenciones vistas en clase de manera estricta:

### Nomenclatura de Ramas
Las ramas se crearan usando `kebab-case` y los prefijos estandard:
* `main`: Solo versiones finales y estables para entrega. 
* `develop`: Rama de integracion del equipo. 
* `feature/[nombre-caracteristica]`: Para nuevas paginas (Ej: `feature/pagina-aterrizaje`). 
* `fix/[nombre]`: Para arreglar errores y/o refactorizar. 
* `docs/[nombre]`: Para cambios o archivos de documentacion (Ej: `docs/convenciones` ). 
* `db/[nombre]`: Para cambios en los scripts SQL (Ej: `db/schema-inicial`). 

### Mensajes de Commit
Usaremos el formato descriptivo con prefijos claros: 
* `feat:` Para cosas nuevas o paginas completas.
* `fix:` Para corregir errores en el código.
* `docs:` Para documentacion o cambios en este archivo.
* `style:` Para puro diseño visual en CSS.
* `chore:` Para agregar/cambiar configuraciones del proyecto.


*Ejemplo de commit:* `feat: Agrega archivo 'index.php' para la página de aterrizaje.`

---

## Reglas de Convivencia y Calidad
1. **Consultar antes de cambiar:** Siguiendo las peticiones de los miembros del equipo, **DEBES consultar con el equipo antes de hacer cambios en archivos compartidos** (como templates de diseño o configuraciones de bases de datos) para llegar a un acuerdo comun. 
2. **Apoyo e Iniciativa:** Si notas que un compañero se trabó o no sabe como resolver un problema, ofrece tu apoyo. La iniciativa y la solidaridad son pilares de este equipo:)
3. **NO subir código que no funcione:** Antes de hacer `push`, asegurate de que tu pagina PHP cargue de forma local y no rompa el diseño general. 
4. **Documentación de código:**  Es necesario documentar todo el código, aunque sean cosas simples, pero describir en un comentario qué estamos haciendo y por qué.
