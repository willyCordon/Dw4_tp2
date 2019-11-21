DROP DATABASE IF EXISTS DW4_SOBRE_FUTBOL;
CREATE DATABASE DW4_SOBRE_FUTBOL;
USE DW4_SOBRE_FUTBOL;

CREATE TABLE equipos(
    id_equipo TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(25),
    puntos INT(4),
    apodo VARCHAR(25),
    entrenador VARCHAR(50),
    imagen VARCHAR(50)
)ENGINE='innoDB';

CREATE TABLE usuarios(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(55) UNIQUE NOT NULL,
    clave VARCHAR(255) NOT NULL,
    nombre VARCHAR(55),
    apellido VARCHAR(100),
    fecha_alta DATETIME,
    avatar VARCHAR(100),
    fecha_nacimiento DATE,
    equipo TINYINT(1) UNSIGNED,
    
    FOREIGN KEY(equipo) REFERENCES equipos(id_equipo) ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE='innoDB';

CREATE TABLE publicaciones(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    texto text,
    privacidad ENUM('Sólo yo', 'Todos'),
    dia DATE,
    hora TIME,
    usuario INT UNSIGNED,
    imagen VARCHAR(100),
    
    FOREIGN KEY(usuario) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE='innoDB';

CREATE TABLE comentarios(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dia DATE,
    hora TIME,
    publicacion INT UNSIGNED,
    usuario INT UNSIGNED,
    texto VARCHAR(300),
    
    FOREIGN KEY(usuario) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(publicacion) REFERENCES publicaciones(id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE='innoDB';


/* INSERT */

INSERT INTO equipos (nombre, entrenador, apodo, puntos, imagen)
VALUES	
('Aldosivi',           'ÁNGEL GUILLERMO HOYOS'  ,'tiburon'         ,08,    'aldosivi.png'),
('Argentinos',         'DIEGO DABOVE'           ,'bicho'           ,25,    'argentinos.png'),
('Arsenal',            'SERGIO RONDINA'         ,'del viaducto'    ,17,    'arsenal.png'),
('Atlético Tucumán',   'RICARDO ZIELINSKI'      ,'decano'          ,22,    'tucuman.jpg'),
('Banfield',           'JULIO FALCIONI'         ,'taladro'         ,13,    'banfield.png'),
('Boca Juniors',       'GUSTAVO ALFARO'         ,'xeneize'         ,25,    'boca.png'),
('Central Córdoba',    'GUSTAVO COLEONI'        ,'ferroviario'     ,16,    'centralC.png'),
('Colón',              'PABLO LAVALLÉN'         ,'sabalero'        ,13,    'colon.png'),
('Defensa y Justicia', 'MARIANO SOSO'           ,'halcón'          ,14,    'defensa.png'),
('Estudiantes',        'GABRIEL MILITO'         ,'pincha'          ,22,    'estudiantes.png'),
('Gimnasia y Esgrima', 'DIEGO MARADONA'         ,'lobo'            ,10,    'gimnasia.png'),
('Godoy Cruz',         'PABLO VOJVODA'          ,'tomba'           ,06,    'godoyCruz.png'),
('Huracán',            'NÉSTOR APUZZO'          ,'globo'           ,14,    'huracan.png'),
('Independiente',      'FERNANDO BERÓN'         ,'rojo'            ,20,    'independiente.png'),
('Lanús',              'LUIS ZUBELDÍA'          ,'granate'         ,25,    'lanus.png'),
('Newells Old Boys',   'FRANK DARÍO KUDELKA'    ,'leproso'         ,21,    'newlls.png'),
('Patronato',          'MARIO SCIACQUA'         ,'patrón'          ,13,    'patronato.png'),
('Racing',             'EDUARDO COUDET'         ,'academico'       ,24,    'racing.png'),
('River Plate',  'MARCELO GALLARDO'       ,'millonario'      ,24,    'river.png'),
('Rosario Central',    'DIEGO COCCA'            ,'canalla'         ,19,    'rosario.png'),
('San Lorenzo',        'DIEGO MONARRIZ'         ,'santo'           ,19,    'sanlorenzo.png'),
('Talleres',           'ALEXANDER MEDINA'       ,'matador'         ,19,    'talleres.png'),
('Unión de Santa Fe',  'LEONARDO MADELÓN'       ,'tatengue'        ,16,    'union.png'),
('Vélez Sarsfield',    'GABRIEL HEINZE'         ,'fortinero'       ,22,    'velez.png');



/****Claves: 1234*****/

INSERT INTO usuarios(nombre, apellido, email, clave, fecha_alta, avatar, equipo, fecha_nacimiento)
VALUES
('Willy', 'Cordon', 'cordonwilly24@gmail.com', '$2y$10$2cxR4r.B86y7nnfhaRGKKuiIsnsNKLs/yUQ6RQS8/pEfMTh2WLhM2', now(), 'willy.jpg', 6, '1992-12-22'),
('Alejandro', 'Di Donato', 'alejandro.didonato@davinci.edu.ar', '$2y$10$2cxR4r.B86y7nnfhaRGKKuiIsnsNKLs/yUQ6RQS8/pEfMTh2WLhM2', now(), 'ale.jpg', 19, '1992-07-25'),
('Pablo', 'Rodriguez', 'pab.rodri@gmail.com', '$2y$10$2cxR4r.B86y7nnfhaRGKKuiIsnsNKLs/yUQ6RQS8/pEfMTh2WLhM2', now(), 'perfil-pablo.jpg', 8, '1978-02-21'),
('Roberto', 'Gutierrez', 'beto.g@gmail.com', '$2y$10$2cxR4r.B86y7nnfhaRGKKuiIsnsNKLs/yUQ6RQS8/pEfMTh2WLhM2', now(), 'perfil-roberto.jpg', 19, '1986-05-26'),
('Mariana', 'Pérez', 'perezmarian@gmail.com', '$2y$10$2cxR4r.B86y7nnfhaRGKKuiIsnsNKLs/yUQ6RQS8/pEfMTh2WLhM2', now(), 'perfil-mariana.jpg', 6, '1996-11-13');

INSERT INTO publicaciones (texto, privacidad, dia, hora, usuario, imagen)
VALUES
('Qué pasó el 9-12-18?', 'Todos', '2019-12-01', '12:21:30', 1, null),
('Te fuiste a la B', 'Todos', '2019-12-01', '13:10:31', 1, null),
('Aeea, yo soy Sabalero, aeea, Sabalero, Sabalero!', 'Todos', '2019-12-01', '14:22:32', 3, null),
('Vamos Boquita.', 'Todos', '2019-12-01', '15:50:10', 1, null),
('Alguien tiene entradas para la final de la Libertadores?', 'Todos', '2019-12-01', '15:55:50', 2, null),
('Gracias Gallardo.', 'Todos', '2019-12-01', '21:24:30', 4, null),
('El mejor de todos los tiempos.', 'Todos', '2019-12-01', '23:25:30', 5, 'riquelme.jpg');

INSERT INTO comentarios(texto, publicacion, usuario, dia, hora)
VALUES
('Los eliminamos 5 veces en 5 años, amargo.', 2, 2, '2019-12-01', '14:24:50'),
('Vamosss', 4, 5, '2019-12-03', '13:26:30');