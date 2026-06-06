# Planteamiento del proyecto del equipo GIT-PUSHERS (Curso Web 2026 - ENP 6 - UNAM)

#### 1. INFORMACIÓN INICIAL
- **Autor:**  Git Pushers (Equipo 7)
- **Título del proyecto:** 
- **Fecha de inicio:**  27 de Mayo de 2026

#### 2. RESUMEN DEL PROYECTO, METAS Y OBJETIVOS
- **Resumen:** 
    Esta plataforma será una herramienta extra para profesores, ayudará a  dar una atención más personalizada a sus alumnos para mejorar su desempeño académico, esperando así la reducción de la deserción de estudiantes de primer año -escalable a alumnos del segundo año- dentro de la ETE de computación en el  plantel 6 “Antonio Caso” -escalable a todos los planteles de la ENP-. 
 
- **Metas:**
  - Realizar una plataforma intuitiva, cómoda y llamativa para estudiantes.
  - Reducir la deserción de estudiante de primer año de la ETE en computación dentro del plantel 6 “Antonio Caso” 
  - Dotar al profesorado y a los estudiantes de información y recursos para realizar estrategias grupales para mejorar el desempeño dentro de las clases    

- **Objetivos:**
  - Se busca darle a los estudiantes una atención personalizada dependiendo de la situación en la que se encuentre. 
  - Ayudar a profesores a detectar a alumnos que necesiten ayuda, así como que tipo de ayuda y que material se podría compartir con ellos
  - El alumnado podrá tener un seguimiento más personalizado 

#### 3. PÚBLICO OBJETIVO (UX): 
Estudiantes del primer año del Estudio Técnico Especializado de Computación entre 15 y 18 años 
Docentes del Estudio Técnico Especializado de Computación

#### 4. PROPÓSITO Y ALCANCE
- **En alcance (Entregables):**
  - Acceso profesores y alumnos (extendible a administradores)
  - Perfiles de usuario con los datos que otorga la Escuela Nacional Preparatoria (Correo 	Institucional, número de cuenta).
  - Cuestionarios para poder obtener un perfil individual completo de cada estudiante 
  - Materiales  de utilidad para los estudiantes a través de links (videos, lecturas, tutoriales y ejercicios)
  - Seguimiento continuo del estado académico del estudiante (actividades realizadas y perfil individual de cada estudiante)
  - Consulta del perfil individual de cada estudiante (únicamente disponible para el docente encargado de dicho grupo y el estudiante en cuestión), así como el despliegue de estadísticas a nivel grupal 
  - En caso de que los alumnos presenten dificultades para seguir adelante en el estudio técnico distintas de que no les guste o que ya no puedan asistir por situaciones externas no completadas en los cuestionarios; se tendrá una sección que desplegará una guía para poder comunicarse con el docente respecto a estas dificultades (pedirá que se envié un mensaje del alumno al profesor especificando las razones por las cuales estaría en peligro de desertar)
  - En caso de que algún alumno se de baja de la ETE, se le mostrará las estadísticas de qué perfiles son los que que cuentan con mayor deserción 
  - Solo existirá un profesor por grupo 
  - El alumno solo podrá estar inscrito a un solo grupo 
	
  
- **Fuera de alcance:**
  - Interacción entre usuarios de manera sincrónica 
  - No se permitirán asesorías ni clases virtuales 
  - No se podrán realizar comentarios anónimos
  - No se asegurará la permanencia de los estudiantes con falta de interés ni disposición 
  - La plataforma no podrá traducirse de forma automática
#### 5. ESPECIFICACIONES FUNCIONALES
- Por usuarios 
		
    - **Estudiante**: tendrá acceso a material educativo, cuestionarios para crear perfiles individuales, así como los resultados de dichos cuestionarios y seguimiento en actividades hechas en clase

    - **Profesores**: podrán añadir, modificar y consultar información acerca de sus alumnos (únicamente de sus alumnos). Podrán compartir material con sus alumnos.    
#### 6. REQUISITOS NO FUNCIONALES
  - Accesibilidad: la plataforma debe ser navegable mediante teclado, mouse y pantallas (celulares y tabletas). 
  - Deberá tener un diseño responsivo.

- Mostrar mensajes de error de manera clara.

#### 7. A FUTURO…

- **Administrativo**: tendrán acceso completo a todas las funciones del sistema, podrán añadir información de los usuarios, consultar y serán los únicos que podrán eliminar a los alumnos
- Que la plataforma tenga lector de pantalla 
- Que se pueda cambiar el tamaño de letra para la mejor lectura de la información
- Los usuarios podrán proporcionar información de sugerencias mediante correo electrónico o un formulario de comentarios 
- Permitir la traducción de forma automática 

#### 8. ARQUITECTURA DE LA INFORMACIÓN Y UX
- Se usarán colores para distinguir fácilmente los enlaces ya visitados
- La(s) página(s) tendrán un color de fondo claro y la letra oscura, con lo cual se aumenta el contraste, obteniendo mayor legibilidad
- Tendrá un encabezado donde serán visibles los logos de las instituciones involucradas, así como el título del proyecto 
- Barra de navegación lateral fija (Sticky Navbar)

#### 9. ESPECIFICACIONES TÉCNICAS

- **Frontend:** Se usará HTML como lenguaje de maquetado y CSS como lenguaje de estilado
- **Backend:** SQL como lenguaje de peticiones y Php como lenguaje de programación
- **Base de Datos:** MariaDB para relacionar tipo de usuario (alumnos y profesores), seguimiento de actividades, respuestas de cuestionarios, datos de los alumnos (número de cuenta y perfiles completo)   




