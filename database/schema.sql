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
    imagen_profesor TEXT,
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
    imagen_administrador TEXT,
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
    imagen_alumno TEXT,
    PRIMARY KEY (id_alumno),
    FOREIGN KEY (id_grupo) REFERENCES grupo(id_grupo)
);


-- ========================================================================== --
--                      II. CONTENIDOS Y SEGUIMIENTO                          --
-- ========================================================================== --

-- 5. ACTIVIDAD: Para las actividades que deje el profesor a cada grupo 
--               e implicitamente a cada alumno, el profesor poddrá marcar como
--               entregada cada actividad para las estadísticas.
CREATE TABLE actividad (
    id_actividad INT NOT NULL AUTO_INCREMENT,    
    id_alumno INT NOT NULL,
    titulo VARCHAR(50),
    descripcion TEXT NOT NULL,
    modulo INT NOT NULL CHECK (modulo BETWEEN 1 AND 5),
    fecha VARCHAR(8),
    hora VARCHAR(5),
    entregado BOOLEAN,
    PRIMARY KEY (id_actividad),
    FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno)
);

-- 6. MATERIAL: Para recursos de apoyo (links, PDFs, etc.) compartidos a todo un 
--              grupo.
CREATE TABLE material (
    id_material INT NOT NULL AUTO_INCREMENT,
    id_grupo INT NOT NULL, 
    titulo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha VARCHAR(8),
    hora VARCHAR(5),
    modulo INT NOT NULL CHECK (modulo BETWEEN 1 AND 5),
    url TEXT,
    PRIMARY KEY (id_material),
    FOREIGN KEY (id_grupo) REFERENCES grupo(id_grupo)
);

-- 7. FORMULARIO: Representa un examen, encuesta o cuestionario de algún modulo para 
--                un grupo.
CREATE TABLE formulario (
    id_formulario INT NOT NULL AUTO_INCREMENT,
    id_grupo INT NOT NULL, 
    titulo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha VARCHAR(8),
    hora VARCHAR(5),
    modulo INT NOT NULL CHECK (modulo BETWEEN 1 AND 5),
    PRIMARY KEY (id_formulario),
    FOREIGN KEY (id_grupo) REFERENCES grupo(id_grupo)
);


-- ========================================================================== --
--                       III. ESTRUCTURA INTERNA FORMULARIOS                  --
-- ========================================================================== --

-- 8. TIPO DE PREGUNTA: Enumeración que representará los tipos de pregunta que se
--                      podrán hacer en los formularios (Ej: Abierta, Radio,
--                      Checkbox, etc...). Esta tabla ya estará poblada.
CREATE TABLE tipo_pregunta(
    id_tipo_pregunta INT NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_tipo_pregunta)
);

-- 9. PREGUNTA: Reactivos que componen un formulario, cada uno tiene un tipo_pregunta.
CREATE TABLE pregunta (
    id_pregunta INT NOT NULL AUTO_INCREMENT,
    id_formulario INT NOT NULL, 
    id_tipo_pregunta INT NOT NULL,
    pregunta TEXT NOT NULL,
    PRIMARY KEY (id_pregunta), 
    FOREIGN KEY (id_formulario) REFERENCES formulario(id_formulario),
    FOREIGN KEY (id_tipo_pregunta) REFERENCES tipo_pregunta(id_tipo_pregunta)
);

-- 10. OPCIÓN PREGUNTA: Las posibles respuestas para una pregunta de opción múltiple.
--                      El campo correcta se usará para las estadísticas.
CREATE TABLE opcion_pregunta(
    id_opcion_pregunta INT NOT NULL AUTO_INCREMENT,
    id_pregunta INT NOT NULL,
    opcion TEXT NOT NULL,
    correcta BOOLEAN,
    PRIMARY KEY (id_opcion_pregunta),
    FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta)
);

-- 11. RESPUESTA ALUMNO: Bitácora donde se guarda lo que respondió cada alumno en cada pregunta.
-- Nota: id_opcion_pregunta acepta NULL para cuando la pregunta sea de tipo abierta.
CREATE TABLE respuesta_alumno(
    id_respuesta_alumno INT NOT NULL AUTO_INCREMENT,
    id_alumno INT NOT NULL,
    id_pregunta INT NOT NULL,
    id_opcion_pregunta INT NULL, 
    texto_respuesta TEXT,
    PRIMARY KEY (id_respuesta_alumno),
    FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno),
    FOREIGN KEY (id_pregunta) REFERENCES pregunta(id_pregunta),
    FOREIGN KEY (id_opcion_pregunta) REFERENCES opcion_pregunta(id_opcion_pregunta)
);
