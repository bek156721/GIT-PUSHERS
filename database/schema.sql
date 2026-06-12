CREATE DATABASE IF NOT EXISTS sec_ete_db;
USE sec_ete_db;

-- ========================================================================== --
--                       I. USUARIOS Y ENTIDADES BÁSICAS                      --                           --
-- ========================================================================== --

-- 1. PROFESOR: Es independiente y almacena datos de los docentes.
CREATE TABLE profesor 
( 
    id_profesor INT NOT NULL, 
    nombre_profesor VARCHAR(50) NOT NULL,
    primer_apellido_profesor VARCHAR(50) NOT NULL,  
    segundo_apellido_profesor VARCHAR(50), 
    correo_profesor VARCHAR(50), 
    contra_profesor VARCHAR(255), 
    PRIMARY KEY (id_profesor) 
);

-- 2. ADMINISTRADOR: Es independiente y representa a los usuarios con control total sobre la plataforma.
CREATE TABLE administrador 
( 
    id_administrador INT NOT NULL, 
    nombre_administrador VARCHAR(50) NOT NULL,
    primer_apellido_administrador VARCHAR(50) NOT NULL,  
    segundo_apellido_administrador VARCHAR(50), 
    correo_administrador VARCHAR(50), 
    contra_administrador VARCHAR(255), 
    PRIMARY KEY (id_administrador) 
);

-- 3. GRUPO: Depende directamente de profesor asignado.
CREATE TABLE grupo (
    id_grupo INT NOT NULL AUTO_INCREMENT,
    id_profesor INT NOT NULL, 
    nombre_grupo VARCHAR(3),
    PRIMARY KEY (id_grupo), 
    FOREIGN KEY (id_profesor) REFERENCES profesor(id_profesor)
);

-- 4. ALUMNO: Depende del grupo al que pertenezca (cada alumno debe estar inscrito a un grupo).
CREATE TABLE alumno 
( 
    id_alumno INT NOT NULL, 
    id_grupo INT NOT NULL,
    nombre_alumno VARCHAR(50) NOT NULL,
    primer_apellido_alumno VARCHAR(50) NOT NULL,  
    segundo_apellido_alumno VARCHAR(50), 
    correo_alumno VARCHAR(50), 
    contra_alumno VARCHAR(255),
    PRIMARY KEY (id_alumno),
    FOREIGN KEY (id_grupo) REFERENCES grupo(id_grupo)
);

-- 5. ASISTENCIA: Servirá para el registro de veces que los alumnos ingresan al sitio.
CREATE TABLE asistencia(
    id_asistencia INT NOT NULL AUTO_INCREMENT,
    id_alumno INT NOT NULL,
    fecha VARCHAR(10),
    hora VARCHAR(5),
    PRIMARY KEY (id_asistencia),
    FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno)
);


-- ========================================================================== --
--                      II. CONTENIDOS Y SEGUIMIENTO                          --
-- ========================================================================== --

-- 6. ACTIVIDAD: Representa una actividad que crea el profesor por cada grupo.

CREATE TABLE actividad (
    id_actividad INT NOT NULL AUTO_INCREMENT,    
    titulo VARCHAR(50),
    descripcion TEXT NOT NULL,
    modulo INT NOT NULL CHECK (modulo BETWEEN 1 AND 5),
    fecha VARCHAR(10),
    hora VARCHAR(5),
    id_grupo INT NOT NULL,
    FOREIGN KEY (id_grupo) REFERENCES grupo(id_grupo),
    PRIMARY KEY (id_actividad),
);

-- 7. ACTIVIDAD POR ALUMNO: Representa la actividad de cada alumno individualmente, es decir,
--                          es una copia de la actividad asignada al alumno que pertenece al grupo
--                          pero incluye el booleano para determinar si ya la entregó o no.

CREATE TABLE actividad_por_alumno (
    id_actividad_por_alumno INT NOT NULL AUTO_INCREMENT,    
    entregado BOOL,
    id_actividad INTEGER NOT NULL,
    id_alumno INTEGER NOT NULL,
    FOREIGN KEY(id_actividad) REFERENCES actividad(id_actividad),
    FOREIGN KEY(id_alumno) REFERENCES alumno(id_alumno),
    PRIMARY KEY (id_actividad),
);


-- 8. MATERIAL: Para recursos de apoyo (links, PDFs, etc.) compartidos a todo un 
--              grupo.
CREATE TABLE material (
    id_material INT NOT NULL AUTO_INCREMENT,
    id_grupo INT NOT NULL, 
    titulo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha VARCHAR(10),
    hora VARCHAR(5),
    modulo INT NOT NULL CHECK (modulo BETWEEN 1 AND 5),
    url TEXT,
    PRIMARY KEY (id_material),
    FOREIGN KEY (id_grupo) REFERENCES grupo(id_grupo)
);

-- 9. FORMULARIO: Representa un examen, encuesta o cuestionario de algún modulo para 
--                un grupo.
CREATE TABLE formulario (
    id_formulario INT NOT NULL AUTO_INCREMENT,
    id_grupo INT NULL, 
    titulo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha VARCHAR(10),
    hora VARCHAR(5),
    modulo INT NOT NULL CHECK (modulo BETWEEN 1 AND 5),
    rendimiento_esperado INT NOT NULL,
    PRIMARY KEY (id_formulario),
    FOREIGN KEY (id_grupo) REFERENCES grupo(id_grupo)
);

-- 10. ACTIVIDAD POR ALUMNO: Representa el formulario de cada alumno individualmente, es decir,
--                          es una copia del formulario asignada al alumno que pertenece al grupo
--                          pero incluye el booleano para determinar si ya la entregó o no.

CREATE TABLE formulario_por_alumno(
    id_formulario_por_alumno INTEGER NOT NULL AUTO_INCREMENT,
    entregado BOOL,
    calificacion DECIMAL NULL,
    rendimiento_alumno DECIMAL NOT NULL, -- lo calculamos nosotros en base al puntaje que obtenga el alumno
    id_formulario INTEGER NOT NULL,
    id_alumno INTEGER NOT NULL,
    FOREIGN KEY(id_formulario) REFERENCES formulario(id_formulario),
    FOREIGN KEY(id_alumno) REFERENCES alumno(id_alumno),
    PRIMARY KEY(id_formulario_por_alumno)
);

-- ========================================================================== --
--                       III. ESTRUCTURA INTERNA FORMULARIOS                  --
-- ========================================================================== --

-- 11. TIPO DE PREGUNTA: Enumeración que representará los tipos de pregunta que se
--                      podrán hacer en los formularios (Ej: Abierta, Radio,
--                      Checkbox, etc...). Esta tabla ya estará poblada.
CREATE TABLE tipo_pregunta(
    id_tipo_pregunta INT NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_tipo_pregunta)
);

-- 12. PREGUNTA: Reactivos que componen un formulario, cada uno tiene un tipo_pregunta.
CREATE TABLE pregunta (
    id_pregunta INT NOT NULL AUTO_INCREMENT,
    id_formulario INT NOT NULL, 
    id_tipo_pregunta INT NOT NULL,
    pregunta TEXT NOT NULL,
    puntaje_rendimiento INTEGER NOT NULL, --El profesor no asigna esto
    PRIMARY KEY (id_pregunta), 
    FOREIGN KEY (id_formulario) REFERENCES formulario(id_formulario),
    FOREIGN KEY (id_tipo_pregunta) REFERENCES tipo_pregunta(id_tipo_pregunta)
);

-- 13. OPCIÓN PREGUNTA: Las posibles respuestas para una pregunta de opción múltiple.
--                      El campo correcta se usará para las estadísticas.
CREATE TABLE opcion_pregunta(
    id_opcion_pregunta INT NOT NULL AUTO_INCREMENT,
    id_pregunta INT NOT NULL,
    opcion TEXT NOT NULL,
    correcta BOOLEAN,
    puntaje_opcion DECIMAL NOT NULL,
    PRIMARY KEY (id_opcion_pregunta),
    FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta)
);


-- 14. RESPUESTA ALUMNO: Bitácora donde se guarda lo que respondió cada alumno en cada pregunta.
-- Nota: id_opcion_pregunta acepta NULL para cuando la pregunta sea de tipo abierta.
CREATE TABLE respuesta_alumno(
    id_respuesta_alumno INT NOT NULL AUTO_INCREMENT,
    id_alumno INT NOT NULL,
    id_pregunta INT NOT NULL,
    id_opcion_pregunta INT NULL, 
    texto_respuesta TEXT,
    calificacion_por_pregunta DECIMAL NULL,
    PRIMARY KEY (id_respuesta_alumno),
    FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno),
    FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta),
    FOREIGN KEY (id_opcion_pregunta) REFERENCES opcion_pregunta(id_opcion_pregunta)
);
