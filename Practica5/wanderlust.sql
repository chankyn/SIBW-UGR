-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-05-2019 a las 12:00:26
-- Versión del servidor: 5.7.25-0ubuntu0.18.04.2
-- Versión de PHP: 7.2.15-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wanderlust`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `valoracion` int(11) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_evento`, `ip`, `autor`, `email`, `fecha`, `valoracion`, `comentario`) VALUES
(2, 1, '', 'Martina Cano', 'martina@prueba.com', '2019-04-14 21:28:42', 1, 'La calidad de la comida muy mala. No repetiría.'),
(3, 1, '', 'pepeFiestas', 'pepeFiestas@pruebas.com', '2019-04-14 21:33:12', 4, 'Bonita ciudad. Calidad.*Mensaje editado por el moderador'),
(4, 1, '', 'prueba2', 'prueba2@gemilio.com', '2019-04-14 22:00:43', 3, 'Prueba 2 de php'),
(5, 1, '', 'pepeLuis', 'pepelu@gmail.com', '2019-04-18 08:38:59', 4, 'Fantástico pueblo! Una fortaleza envidiable.'),
(6, 1, '', 'pepeLuis', 'pepelu@gmail.com', '2019-04-18 08:39:29', 3, 'Fantástico pueblo! Una fortaleza envidiable.'),
(7, 1, '', 'pepeLuis', 'pepelu@gmail.com', '2019-04-18 08:39:55', 3, 'Fantástico pueblo! Una fortaleza envidiable.'),
(8, 1, '', 'pepe', 'pepelu@gmail.com', '2019-04-18 08:41:16', 4, 'Otra vez se va a repetir?'),
(10, 1, '', 'pruebap', 'prueba2@gemilio.com', '2019-04-18 08:44:13', 5, 'Segunda ****** de redirección.'),
(11, 1, '10.0.2.2', 'migue', 'migue@prueba.com', '2019-04-18 09:14:29', 4, 'Alojamiento barato. Recomiendo el casco antiguo de la ciudad.'),
(14, 1, '10.0.2.2', 'asdasdsa', 'miguehonojosa@outlook.es', '2019-04-18 19:14:16', 3, 'asdasdsa'),
(15, 1, '10.0.2.2', 'asdasdsa', 'chanketeasecas@gmail.com', '2019-04-18 19:14:48', 5, 'sdasdasd12312'),
(16, 1, '10.0.2.2', 'pepe', 'asdasda@prueba.com', '2019-04-18 22:19:47', 2, 'Este mensaje esta siendo editado.*Mensaje editado por el moderador'),
(19, 1, '10.0.2.2', 'MariaDeLaO', 'marialaportuguesa@pepephone.com', '2019-04-20 07:55:44', 3, 'Estuve el pasado fin de semana por alli y me parecio un lugar muy bonito*Mensaje editado por el moderador'),
(20, 2, '10.0.2.2', 'pepeLuis', 'pepe@gemilio.com', '2019-04-21 11:24:40', 3, 'Me encanta este lugar!'),
(21, 2, '10.0.2.2', 'Luisa', 'luisa@erasmus.com', '2019-04-21 11:25:27', 5, 'Nice place! *****');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id_etiqueta` int(11) NOT NULL,
  `etiqueta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas_eventos`
--

CREATE TABLE `etiquetas_eventos` (
  `id_etiqueta` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `etiqueta` varchar(255) NOT NULL,
  `contenido` varchar(255) DEFAULT '"editar"',
  `ruta_imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `etiquetas_eventos`
--

INSERT INTO `etiquetas_eventos` (`id_etiqueta`, `id_evento`, `etiqueta`, `contenido`, `ruta_imagen`) VALUES
(12, 11, 'Imagen', NULL, 'imagenes/Evento1_turismo1.jpg'),
(13, 5, 'Parrafo', NULL, NULL),
(14, 5, 'Imagen', NULL, 'imagenes/Evento2.jpg'),
(16, 10, 'Parrafo', '    Este es un texto de prueba.', NULL),
(18, 10, 'Imagen', NULL, 'imagenes/Evento1_turismo1.jpg'),
(19, 10, 'Parrafo', '   Hola', NULL),
(29, 1, 'Parrafo', 'editar 1', NULL),
(30, 1, 'Parrafo', '\"editar\"', NULL),
(31, 1, 'Texto', '\"editar\"', NULL),
(32, 1, 'Texto', '\"editar\"', NULL),
(33, 1, 'Imagen', '\"editar\"', 'imagenes/ev1_1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `fecha` date DEFAULT NULL,
  `descripcion` text,
  `descripcion_avanzada` text,
  `ruta_imagen` varchar(255) DEFAULT NULL,
  `ruta_imagen_secundaria` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ultima_modificacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `fecha`, `descripcion`, `descripcion_avanzada`, `ruta_imagen`, `ruta_imagen_secundaria`, `fecha_creacion`, `ultima_modificacion`) VALUES
(1, 'Álcala la Real', '2019-05-01', 'Alcalá la Real es un municipio y ciudad de España, en la provincia de Jaén, comunidad autónoma de Andalucía. Es cabecera de la comarca de la Sierra Sur y se ubica en el extremo suroeste de la provincia, limitando con las provincias de Granada y Córdoba.Alcalá la Real se ubica en una zona estratégica que comunica el valle del Guadalquivir (a través del río Guadajoz) con las áreas de vega granadinas, a través de los ríos Frailes y Velillos. Su posición estratégica, no solo sobre el territorio, sino en la misma ubicación de la ciudad (sobre el cerro de La Mota), le confiere una importancia fundamental en cuanto a las vías de comunicación a lo largo de la historia, lo cual viene a confirmar su importancia cuando esta área se convierte en zona de frontera durante la Edad Media con el Reino de Granada.', 'En este municipio podemos destacar el conjunto monumental de la Fortaleza de la Mota, dentro del conjunto monumental de la Fortaleza de la Mota existen varios espacios tematizados donde se explica el concepto de frontera, los modos de vida de sus habitantes, la funcionalidad de los distintos espacios y la articulación de la Fortaleza con el territorio circundante. Horarios: Del 15 de octubre al 31 de marzo. L-D de 10.00 a 17.30hrs. Sábados hasta las 18.00hrs. Del 1 de abril al 14 de octubre. L-D de 10.30 a 19.30 hrs. Cerrado: 25 diciembre, 1 y 6 de Enero. Horario especial: 24, 31 de diciembre y 5 de enero de 10.00 a 14.00 hrs.', 'imagenes/ev1_1.jpg', 'imagenes/Evento2.jpg', '2019-04-01 18:01:12', '2019-05-16 15:48:57'),
(2, 'Ronda', '2019-04-01', 'Ronda es un municipio español perteneciente a la comunidad autónoma de Andalucía, situada en el noroeste de la provincia de Málaga, a unos 100 kilómetros de la ciudad de Málaga. Es la cabeza del partido judicial homónimo y la capital de la comarca de la Serranía de Ronda.\r\nLa ciudad se asienta sobre una meseta cortada por un profundo tajo excavado por el río Guadalevín, al que asoman los edificios de su centro histórico, lo que confiere a la ciudad una panorámica pintoresca que, unida a la variedad de monumentos que posee, a su entorno natural y a su cercanía a los grandes centros del turismo de masas de la Costa del Sol, ha convertido a Ronda en un centro turístico notable. La cornisa del tajo y el puente que lo salva son la imagen por antonomasia de la ciudad.', 'Lo más sorprendente de Ronda es el Puente Nuevo, que se erige sobre un imponente tajo de más de 100 metros. ¿Te gustaría saber cuándo se construyó? Pues nada menos que en 1793, con lo que te puedes hacer una idea de lo poco que ha cambiado Ronda en estos casi tres siglos. Ronda también es conocida como el lugar de nacimiento de las modernas corridas de toros. El coliseo taurino de la localidad sólo se usa una vez al año, durante su Feria Goyesca, pero alberga también un museo en el que puedes aprender acerca de la historia de esta (controvertida) tradición.', 'imagenes/Evento2.jpg', 'imagenes/Evento2_turismo1.jpg', '2019-04-19 19:01:02', '2019-04-23 06:52:26'),
(3, 'Calas de Conil', NULL, NULL, '', 'imagenes/Evento3.jpg', NULL, NULL, '2019-04-19 19:42:47'),
(4, 'Cazorla', NULL, NULL, '', 'imagenes/Evento4.jpg', NULL, NULL, '2019-04-19 19:42:47'),
(6, 'Asturias', NULL, NULL, '', 'imagenes/Evento6.jpg', NULL, NULL, '2019-04-19 19:42:47'),
(7, 'Portugal', NULL, NULL, '', 'imagenes/Evento7.jpg', NULL, NULL, '2019-04-19 19:42:47'),
(8, 'Francia', NULL, NULL, '', 'imagenes/Evento8.jpg', NULL, NULL, '2019-04-19 19:42:47'),
(9, 'Huelva', NULL, NULL, '', 'imagenes/Evento9.jpg', NULL, NULL, '2019-04-19 19:42:47'),
(10, 'Evento Prueba 1.0', '2019-05-15', '', '', '', '', '2019-05-16 15:02:28', '2019-05-23 08:43:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_eventos`
--

CREATE TABLE `imagenes_eventos` (
  `id_evento` int(11) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `imagenes_eventos`
--

INSERT INTO `imagenes_eventos` (`id_evento`, `ruta_imagen`) VALUES
(0, 'imagenes/carrusel/ev1_1.jpg'),
(1, 'imagenes/carrusel/ev1_1.jpg'),
(1, 'imagenes/carrusel/ev1_2.jpg'),
(1, 'imagenes/carrusel/ev1_3.jpg'),
(1, 'imagenes/carrusel/ev1_4.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_principal`
--

CREATE TABLE `menu_principal` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `id_padre` int(10) NOT NULL,
  `enlace` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu_principal`
--

INSERT INTO `menu_principal` (`id`, `nombre`, `id_padre`, `enlace`) VALUES
(1, 'Portada', 0, 'index.php'),
(2, 'Sobre nosotros', 0, '#nosotros'),
(3, 'Código', 0, '#code'),
(4, 'Javascript', 3, '#'),
(5, 'Resumen', 2, '#r'),
(6, 'Contacto', 2, '#Contacto'),
(7, 'Css', 3, '#css'),
(8, 'Jquery', 3, '#js'),
(9, 'PHP', 3, '#php');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabras_prohibidas`
--

CREATE TABLE `palabras_prohibidas` (
  `palabra` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `palabras_prohibidas`
--

INSERT INTO `palabras_prohibidas` (`palabra`) VALUES
('negro'),
('morado'),
('pepe'),
('payaso'),
('prueba'),
('calcetin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegios`
--

CREATE TABLE `privilegios` (
  `id_privilegio` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `moderacion` tinyint(1) NOT NULL,
  `gestion_sitio` tinyint(1) NOT NULL,
  `gestion_permisos` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `privilegios`
--

INSERT INTO `privilegios` (`id_privilegio`, `nombre`, `moderacion`, `gestion_sitio`, `gestion_permisos`) VALUES
(1, 'registrado', 1, 1, 1),
(2, 'moderador', 0, 1, 1),
(3, 'gestor_sitio', 0, 0, 1),
(4, 'superusuario', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_privilegio` int(11) NOT NULL DEFAULT '1',
  `nombre` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `primer_apellido` varchar(255) DEFAULT NULL,
  `segundo_apellido` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_privilegio`, `nombre`, `password`, `primer_apellido`, `segundo_apellido`, `direccion`, `email`) VALUES
(1, 2, 'Paco', '1234', NULL, NULL, NULL, 'pacopruebas@gmail.com'),
(2, 1, '1234', '1234', NULL, NULL, NULL, '1234@gmail.com'),
(11, 1, 'user', 'password', NULL, NULL, NULL, 'mail@gmail.com'),
(12, 1, 'pepe', '1234', NULL, NULL, NULL, 'pepe@gmail.com'),
(13, 1, 'migue', '1234', 'Hinojosa', 'Castro', 'Alcalá la Real', 'migue@prueba.com'),
(14, 3, 'abc', '123', NULL, NULL, NULL, 'abc@correo.es'),
(15, 3, 'gestor', '1234', 'prueba', NULL, NULL, 'gestor@gmail.com'),
(16, 4, 'super', '1234', 'prueba', 'prueba2', NULL, ''),
(17, 2, 'pepito', '1234', NULL, NULL, NULL, 'pepito@gmail.com'),
(18, 2, 'moderador', '1234', NULL, NULL, NULL, 'moderador@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos_eventos`
--

CREATE TABLE `videos_eventos` (
  `id_evento` int(11) NOT NULL,
  `ruta_video` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `videos_eventos`
--

INSERT INTO `videos_eventos` (`id_evento`, `ruta_video`) VALUES
(1, 'videos/video1.mp4');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`);

--
-- Indices de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id_etiqueta`);

--
-- Indices de la tabla `etiquetas_eventos`
--
ALTER TABLE `etiquetas_eventos`
  ADD PRIMARY KEY (`id_etiqueta`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu_principal`
--
ALTER TABLE `menu_principal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  ADD PRIMARY KEY (`id_privilegio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  MODIFY `id_etiqueta` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `etiquetas_eventos`
--
ALTER TABLE `etiquetas_eventos`
  MODIFY `id_etiqueta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `menu_principal`
--
ALTER TABLE `menu_principal`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  MODIFY `id_privilegio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
