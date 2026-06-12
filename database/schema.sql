DROP DATABASE sec_ete_db;
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
    PRIMARY KEY (id_actividad)
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
    PRIMARY KEY (id_actividad_por_alumno)
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
-- El profesor no asigna el puntaje esperado para esa pregunta, eso lo hacemos nosotros.
CREATE TABLE pregunta (
    id_pregunta INT NOT NULL AUTO_INCREMENT,
    id_formulario INT NOT NULL, 
    id_tipo_pregunta INT NOT NULL,
    pregunta TEXT NOT NULL,
    puntaje_rendimiento INTEGER NOT NULL, 
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


-- ========================================================================== --
--                       IV. POBLAMOS LA BASE DE DATOS                        --
-- ========================================================================== --

-- Inserción de un administrador --

INSERT INTO administrador (id_administrador, nombre_administrador, primer_apellido_administrador, segundo_apellido_administrador, correo_administrador, contra_administrador)
VALUES 
(123456789, 'Angela Eugenia', 'Villanueva', 'Vilchis', 'angela.villanueva@unam.mx', 'hola123456');

-- Insercion de profesores --
INSERT INTO profesor (id_profesor, nombre_profesor, primer_apellido_profesor, segundo_apellido_profesor, correo_profesor, contra_profesor)
VALUES 
(322157000, 'Luana Sofia', 'Alvarez', 'Molina', 'luana.alvarez@ciencias.unam.mx', 'luanita777'),
(987654321, 'Luis Adrián', 'González', 'Falcon', 'luis.falcon@ingenieria.unam.mx', 'luillilol');

-- Insercion de grupos --
INSERT INTO grupo (id_profesor, nombre_grupo)
VALUES 
(322157000, '61B'),
(987654321, '61D');

-- Insercion de alumnos --
INSERT INTO alumno (id_alumno, id_grupo, nombre_alumno, primer_apellido_alumno, segundo_apellido_alumno, correo_alumno, contra_alumno)
VALUES
(000000001, 1, 'Sofía', 'Hernández', 'Pérez', '000000001@alumno.enp.unam.mx', '01Contrasenia'),
(000000002, 1, 'Diego', 'Martínez', 'Torres', '000000002@alumno.enp.unam.mx', '02Contrasenia'),
(000000003, 1, 'Jimena', 'Esparza', 'Ruiz', '000000003@alumno.enp.unam.mx', '03Contrasenia'),
(000000004, 2, 'Mateo', 'Ramírez', 'Vargas', '000000004@alumno.enp.unam.mx', '04Contrasenia'),
(000000005, 2, 'Valeria', 'Flores', 'Castro', '000000005@alumno.enp.unam.mx', '05Contrasenia');

-- Inserción de actividades --
INSERT INTO actividad (titulo, descripcion, modulo, fecha, hora, id_grupo)
VALUES 

('Hola Mundo y Variables', 'Crea un programa que solicite el nombre del usuario por consola y despliegue un saludo personalizado junto con el cálculo de su edad en días.', 1, '2026-06-12', '23:59', 1),
('Estructuras de Control', 'Desarrolla un script que implemente un menú interactivo (utilizando ciclos y condicionales) para simular un cajero automático básico.', 1, '2026-06-19', '23:59', 1),
('Mi primera Función', 'Escribe una función que reciba una lista de números y devuelva un diccionario/objeto con el valor máximo, mínimo y el promedio.', 2, '2026-06-26', '23:59', 1),

('Modelado de Clases', 'Crea el diagrama y código de una clase "Vehiculo" y dos subclases ("Coche" y "Motocicleta") aplicando el concepto de herencia.', 1, '2026-06-14', '23:59', 2),
('Gestor de Archivos CSV', 'Desarrolla un programa capaz de leer un archivo de texto .csv con calificaciones de alumnos, calcular los promedios y exportar los resultados a un nuevo archivo.', 2, '2026-06-21', '23:59', 2),
('Conexión a Base de Datos', 'Implementar un CRUD básico (Create, Read, Update, Delete) en consola utilizando persistencia de datos local o SQLite.', 3, '2026-06-28', '23:59', 2);


-- Inserción de actividades por alumno --
INSERT INTO actividad_por_alumno (entregado, id_actividad, id_alumno)
VALUES 
(TRUE, 1, 000000001),  
(FALSE, 1, 000000002), 
(TRUE, 1, 000000003),
-- Alumnos del Grupo 2 (Mateo 3004, Valeria 3005) asignados a la Actividad 4
(TRUE, 4, 000000004),  
(FALSE, 4, 000000005);


-- Inserción de materiales --
INSERT INTO material (id_grupo, titulo, descripcion, fecha, hora, modulo, url)
VALUES 

(1, 'Guía de Sintaxis Básica', 'Documento de referencia rápida con la sintaxis de variables, tipos de datos y operadores.', '2026-06-12', '08:00', 1, 'https://code-docs.edu/guides/sintaxis_basica.pdf'),
(1, 'Cheat Sheet: Ciclos y Condicionales', 'Infografía interactiva que explica visualmente el flujo de los ciclos For y While.', '2026-06-15', '09:30', 1, 'https://code-docs.edu/cheatsheets/control_flow.png'),
(1, 'Introducción a Algoritmos', 'Enlace a un video interactivo que explica cómo desglosar un problema lógico antes de escribir código.', '2026-06-22', '10:00', 2, 'https://youtube.com/watch?v=pensamiento_logico_dev'),

(2, 'Pilares de la POO', 'Artículo técnico detallado sobre Abstracción, Encapsulamiento, Herencia y Polimorfismo.', '2026-06-12', '08:15', 1, 'https://dev-blog.edu/poo/cuatro_pilares_explicados'),
(2, 'Manejo de Excepciones y Errores', 'Apunte digital sobre cómo utilizar bloques try/except (try/catch) para evitar que el software truene.', '2026-06-18', '11:00', 2, 'https://code-docs.edu/advanced/exception_handling.pdf'),
(2, 'Repositorio de Plantillas SQL', 'Acceso al repositorio institucional de GitHub con scripts base para conectar tu código a bases de datos.', '2026-06-25', '16:00', 3, 'https://github.com/escuela-dev/db-connection-templates');