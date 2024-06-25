-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2024 a las 04:44:08
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_online1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `token_password` varchar(40) DEFAULT NULL,
  `password_request` tinyint(4) NOT NULL DEFAULT 0,
  `activo` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `password`, `nombre`, `email`, `token_password`, `password_request`, `activo`, `fecha_alta`) VALUES
(1, 'admin', '$2y$10$FLQ7O/spRZJkKG1qx3tyqOFaPcNCxDfycFSz/5cwobC0u5ZatuVwy', 'Administrador', 'stevenruizxx@gmail.com', NULL, 0, 1, '2024-06-12 23:58:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristicas`
--

CREATE TABLE `caracteristicas` (
  `id` int(11) NOT NULL,
  `caracteristicas` varchar(30) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `caracteristicas`
--

INSERT INTO `caracteristicas` (`id`, `caracteristicas`, `activo`) VALUES
(1, 'Color', 1),
(2, 'Almacenamiento', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `activo`) VALUES
(1, 'IPhones', 1),
(2, 'Air Pods', 1),
(3, 'MacBook', 1),
(4, 'Ipad', 1),
(5, 'Penes', 0),
(6, 'm', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(80) NOT NULL,
  `apellidos` varchar(80) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `estatus` tinyint(100) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombres`, `apellidos`, `email`, `telefono`, `dni`, `estatus`, `fecha_alta`, `fecha_modifica`, `fecha_baja`) VALUES
(1, 'Owen', 'Granados', 'stevenruizxx@gmail.com', '3142077039', '123', 1, '2024-06-11 16:49:39', NULL, NULL),
(4, 'Helger', 'Santiago', 'helgerjo123@gmail.com', '8654234567', '10369652', 1, '2024-06-19 09:15:27', NULL, NULL),
(5, 'Juan Pablo', 'Caño', 'jpcf44430@gmail.com', '321656', '554651', 1, '2024-06-21 07:34:27', NULL, NULL),
(6, 'Nelson', 'Granados', 'granadosdilam1@gmail.com', '3214535', '1234', 1, '2024-06-24 20:10:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `id_transaccion`, `fecha`, `status`, `email`, `id_cliente`, `total`) VALUES
(1, '82M62108FS8791932', '2024-06-19 04:18:08', 'COMPLETED', 'helgerjo123@gmail.com', 4, 1600),
(2, '2WM75027YL659252F', '2024-06-19 10:59:24', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 2000),
(3, '3GF11921WF585092C', '2024-06-21 02:32:34', 'COMPLETED', 'helgerjo123@gmail.com', 4, 284),
(4, '7G3041025V048915M', '2024-06-21 03:15:38', 'COMPLETED', 'jpcf44430@gmail.com', 5, 1136),
(5, '3FF609485E227070M', '2024-06-23 07:58:25', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 2084),
(6, '95T05667WJ946041U', '2024-06-23 09:35:18', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 1300),
(7, '43G40525M6401690T', '2024-06-23 09:45:52', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 1420),
(8, '83X77548AE958614T', '2024-06-23 09:48:02', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 1600),
(9, '63V94287UN7293712', '2024-06-23 09:48:43', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 800),
(10, '2YV19878190245640', '2024-06-25 02:33:24', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 1300),
(11, '93B870120H2735529', '2024-06-25 02:36:27', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 800),
(12, '08P479035A000801G', '2024-06-25 03:01:14', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 240),
(13, '1V5609877D687520M', '2024-06-25 03:02:14', 'COMPLETED', 'stevenruizxx@gmail.com', 1, 240);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `valor` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `valor`) VALUES
(1, 'tienda_nombre', 'ARKATECH'),
(2, 'correo_email', 'stevenruizxx@gmail.com'),
(3, 'correo_smtp', 'smtp.gmail.com'),
(4, 'correo_password', '+y7yOhPV17Qa2/3YOqjHNw==:IsWu8JK/25BcKUd3y8ZqSf5hO78kooL8cJwua1D9IkU='),
(5, 'correo_puerto', '465');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `c_almacenamiento`
--

CREATE TABLE `c_almacenamiento` (
  `id` smallint(6) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `c_almacenamiento`
--

INSERT INTO `c_almacenamiento` (`id`, `nombre`) VALUES
(1, '64GB'),
(2, '128GB'),
(3, '256GB'),
(4, '512GB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `c_colores`
--

CREATE TABLE `c_colores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `c_colores`
--

INSERT INTO `c_colores` (`id`, `nombre`) VALUES
(1, 'Blanco'),
(2, 'Negro'),
(3, 'Azul'),
(4, 'Rojo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `id_compra`, `id_producto`, `nombre`, `precio`, `cantidad`) VALUES
(1, 1, 2, 'IPhone 12', 400.00, 4),
(2, 2, 22, 'MacBook Air 13 Chip M1 - 256 GB - Gris Espacial', 1000.00, 2),
(3, 3, 1, 'iPhone 11 128 GB 4GB RAM | Pantalla 6.1 Pulgadas |', 284.05, 1),
(4, 4, 1, 'iPhone 11 128 GB 4GB RAM | Pantalla 6.1 Pulgadas |', 284.05, 4),
(5, 5, 1, 'iPhone 11 128 GB 4GB RAM | Pantalla 6.1 Pulgadas |', 284.05, 1),
(6, 5, 3, 'IPhone 13', 600.00, 3),
(7, 6, 23, 'MacBook Air 15 Chip M2 - 256GB - Gris Espacial', 1300.00, 1),
(8, 7, 20, 'Airpods', 120.00, 1),
(9, 7, 23, 'MacBook Air 15 Chip M2 - 256GB - Gris Espacial', 1300.00, 1),
(10, 8, 4, 'IPhone 14', 800.00, 2),
(11, 9, 4, 'IPhone 14', 800.00, 1),
(12, 10, 23, 'MacBook Air 15 Chip M2 - 256GB - Gris Espacial', 1300.00, 1),
(13, 11, 4, 'IPhone 14', 800.00, 1),
(14, 12, 20, 'Airpods', 120.00, 2),
(15, 13, 20, 'Airpods', 120.00, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` tinyint(3) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `id_categoria` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `descuento`, `stock`, `id_categoria`, `activo`) VALUES
(1, 'iPhone 11 128 GB 4GB RAM | Pantalla 6.1 Pulgadas |', '<p>&nbsp;</p><p>El <strong>iPhone 11</strong> es un dispositivo potente y asequible de Apple. Cuenta con un sistema de <strong>doble cámara</strong> de 12 MP con modo Noche, grabación de video 4K y cámara frontal de 12 MP.</p><p>Está impulsado por el chip A13 Bionic y ofrece una excelente duración de batería. Su resistencia al agua y al polvo con certificación <strong>IP68</strong> lo hace duradero.</p><p>Disponible en seis vibrantes colores, el iPhone 11 combina un diseño atractivo con un rendimiento sólido a un precio accesible.</p><p>&nbsp;</p><p>&nbsp;</p>', 299.00, 5, 0, 1, 1),
(2, 'IPhone 12', '<p>&nbsp;</p><p>El <strong>iPhone 12</strong> marca un hito en el diseño de Apple, con un elegante cuerpo de aluminio con bordes planos y una impresionante pantalla Super Retina XDR de 6.1 pulgadas.</p><p>Su sistema de <strong>cámaras duales</strong> de 12 MP ofrece un modo Noche mejorado, grabación de video Dolby Vision a 4K y una cámara frontal de 12 MP con modo Retrato y grabación 4K.</p><p>Impulsado por el potente chip A14 Bionic, el iPhone 12 brinda un rendimiento excepcional y compatibilidad con redes 5G. Además, cuenta con una resistencia al agua y polvo <strong>IP68</strong> y tecnología de carga inalámbrica.</p><p>Con opciones de almacenamiento de hasta 256 GB y cinco atractivos colores, el iPhone 12 combina diseño, potencia y funcionalidad en un paquete compacto.</p><p>&nbsp;</p><p>&nbsp;</p>', 400.00, 0, 0, 1, 1),
(3, 'IPhone 13', '<p>&nbsp;</p><p>El <strong>iPhone 13</strong> eleva el listón con su impresionante pantalla Super Retina XDR de 6.1 pulgadas y un brillo pico de hasta 1200 nits, brindando una experiencia visual deslumbrante.</p><p>Su sistema de <strong>doble cámara</strong> cuenta con una cámara principal de 12 MP con un sensor mayor y estabilización óptica de imagen por sensor, además de una cámara ultra gran angular de 12 MP. La cámara frontal TrueDepth de 12 MP ofrece un modo Retrato mejorado y grabación de video 4K.</p><p>Impulsado por el potente chip A15 Bionic, el iPhone 13 brinda un rendimiento sin precedentes y una duración de batería mejorada. Cuenta con resistencia al agua y al polvo <strong>IP68</strong>, compatibilidad con redes 5G y opciones de almacenamiento de hasta 512 GB.</p><p>Con un elegante diseño de vidrio reforzado y cinco atractivos colores, el iPhone 13 combina potencia, funcionalidad y estilo en un paquete compacto.</p><p>&nbsp;</p>', 600.00, 0, 6, 1, 1),
(4, 'IPhone 14', '<p>El <strong>iPhone 14</strong> es el último lanzamiento de Apple en su línea de teléfonos inteligentes. Cuenta con un diseño elegante y moderno, con un cuerpo de aluminio aeroespacial y una pantalla Super Retina XDR de borde a borde.</p><ul><li>Alimentado por el potente chip <strong>A16 Bionic</strong>, este dispositivo ofrece un rendimiento excepcional y una eficiencia energética incomparable.</li><li>Su cámara principal de <strong>48MP</strong> con estabilización óptica de imagen captura fotos y videos de calidad profesional, mientras que la cámara frontal de <strong>12MP</strong> te permite tomar selfies impresionantes.</li><li>El <strong>iPhone 14</strong> también cuenta con <strong>resistencia al agua IP68</strong>, lo que lo hace resistente a salpicaduras, polvo y sumergible hasta 6 metros de profundidad.</li><li>Su batería de larga duración y la compatibilidad con <strong>carga rápida</strong> te permiten mantenerte conectado durante todo el día.</li></ul>', 800.00, 0, 6, 1, 1),
(5, 'IPhone 15', '<p>El nuevo <strong>iPhone 15</strong> es la última innovación de Apple, diseñado para brindar una experiencia incomparable. Con su impresionante pantalla Super Retina XDR de 6.7 pulgadas, disfrutarás de colores vivos y detalles nítidos como nunca antes.</p><p>La cámara del iPhone 15 es una verdadera obra maestra, con un sistema de <strong>triple lente</strong> que incluye:</p><ul><li>Cámara principal de <strong>48 MP</strong> con estabilización óptica de imagen</li><li>Cámara ultra gran angular de <strong>12 MP</strong></li><li>Cámara teleobjetivo de <strong>12 MP</strong> con zoom óptico 3x</li></ul><p>Además, cuenta con un potente modo <i>Noche</i> y capacidades de grabación de video <strong>4K a 60 fps</strong>.</p><p>&nbsp;</p><p>Bajo el capó, el iPhone 15 está impulsado por el nuevo chip A17 Bionic, que ofrece un rendimiento sin precedentes y una eficiencia energética excepcional. Con una batería de <strong>4.800 mAh</strong> y carga inalámbrica rápida, nunca te quedarás sin energía.</p><p>El diseño del iPhone 15 es elegante y resistente, con un marco de cerámica y una carcasa de vidrio reforzado. Además, cuenta con una certificación <strong>IP68</strong> para resistencia al agua y al polvo.</p>', 1200.00, 0, 5, 1, 1),
(15, 'Iphone 15 pro max', '<p>El <strong>iPhone 15 Pro Max</strong> es la máxima expresión de innovación y potencia de Apple. Con una impresionante pantalla Super Retina XDR de 6.8 pulgadas, disfrutarás de una experiencia visual sin precedentes, con colores vibrantes, negros profundos y un brillo impresionante.</p><p>La cámara del iPhone 15 Pro Max es una verdadera obra maestra, con un sistema de <strong>cuádruple lente</strong> que incluye:</p><ul><li>Cámara principal de <strong>48 MP</strong> con estabilización óptica de imagen mejorada</li><li>Cámara ultra gran angular de <strong>12 MP</strong> con estabilización de sensor</li><li>Cámara teleobjetivo de <strong>12 MP</strong> con zoom óptico 3x</li><li>Cámara periscopio de <strong>12 MP</strong> con zoom óptico 10x</li></ul><p>Además, cuenta con un modo <i>Noche Profunda</i> revolucionario y capacidades de grabación de video <strong>8K a 30 fps</strong>.</p><p>&nbsp;</p><p>Impulsado por el potente chip A17 Bionic, el iPhone 15 Pro Max ofrece un rendimiento sin precedentes y una eficiencia energética excepcional. Con una batería de <strong>5.000 mAh</strong> y carga inalámbrica rápida, nunca te quedarás sin energía.</p><p>El diseño del iPhone 15 Pro Max es elegante y robusto, con un marco de titanio y una carcasa de vidrio cerámico reforzado. Cuenta con una certificación <strong>IP68</strong> para resistencia al agua y al polvo, además de una pantalla reforzada con cerámica blindada.</p><p>Con el nuevo <strong>Dynamic Island</strong>, el notch se ha transformado en una experiencia interactiva y multitarea, brindando una forma innovadora de interactuar con tu iPhone.</p>', 1200.00, 0, 14, 1, 1),
(19, 'w', '<p>w</p>', 1.00, 1, 1, 1, 0),
(20, 'Airpods', '<h3>Características principales</h3><ul><li>Chip H1 para auriculares</li><li>Dos micrófonos con tecnología beamforming</li><li>Dos sensores ópticosAcelerómetro con detección de movimiento</li><li>Acelerómetro con detección de&nbsp;voz</li></ul><h3>Controles</h3><ul><li>Toca dos veces para reproducir audio, cambiar de&nbsp;canción o contestar una llamada</li><li>Di «Oye Siri» para escuchar una canción, hacer una&nbsp;llamada, obtener indicaciones y mucho&nbsp;más</li></ul><h4><strong>AirPods</strong></h4><ul><li>Hasta 5 horas de reproducción de audio con una sola carga*</li><li>Hasta 3 horas de conversación con una sola carga*</li><li>Más de 24 horas de reproducción de audio*</li><li>Hasta 18 horas de conversación*</li><li>15 minutos en el estuche te dan hasta 3 horas de reproducción de audio6 o hasta 2 horas de conversación*</li></ul><h3>&nbsp;</h3>', 120.00, 0, 0, 2, 1),
(21, 'AirPods Pro (2da Generación)', '<h3><strong>Características Principales</strong></h3><ul><li><strong>Cancelación Activa de Ruido:</strong> Sumérgete en tu música o podcast favorito con una cancelación de ruido líder en la industria, que adapta el sonido a la forma de tu oído y al ambiente que te rodea.</li><li><strong>Modo Ambiente:</strong> Escucha el mundo exterior con solo un toque, permitiéndote estar consciente de tu entorno cuando lo necesites.</li><li><strong>Diseño Personalizado:</strong> Con almohadillas de silicona en tres tamaños diferentes, garantizan un ajuste cómodo y seguro para todos.</li><li><strong>Calidad de Sonido Superior:</strong> Equipados con el Adaptive EQ, que ajusta automáticamente la música según la forma de tu oído, ofreciendo una experiencia auditiva rica y envolvente.</li><li><strong>Resistencia al Agua y al Sudor:</strong> Ya sea durante un entrenamiento intenso o atrapado en la lluvia, los AirPods Pro están diseñados para mantenerse al ritmo de tu estilo de vida activo.</li><li><strong>Conectividad Eficiente:</strong> Con el chip Apple H1, disfruta de una conexión inalámbrica más estable, un sonido de alta calidad y la comodidad de \"Oye Siri\" activado por voz.</li><li><strong>Estuche de Carga Inalámbrica:</strong> Con varias cargas adicionales para más de 24 horas de uso total, y con la opción de carga rápida, nunca te quedarás sin música.</li><li><strong>Compatibilidad Amplia:</strong> Se conectan sin esfuerzo a todos tus dispositivos Apple, y el audio se cambia de manera fluida entre dispositivos.</li></ul><p>Los AirPods Pro de Segunda Generación son más que unos simples auriculares; son un testimonio del compromiso de Apple con la innovación y el diseño. Prepárate para escuchar el futuro.</p>', 250.00, 0, 0, 2, 1),
(22, 'MacBook Air 13 Chip M1 - 256 GB - Gris Espacial', '<p><strong>Pantalla Retina</strong></p><ul><li>Pantalla de 13.3 pulgadas (diagonal) retroiluminada por LED con tecnología IPS</li><li>Resolución nativa de 2560 x 1600 a 227 pixeles por pulgada compatible con millones de colores</li></ul><p><strong>Resoluciones ajustadas compatibles</strong>:</p><ul><li>1680 x 1050</li><li>1440 x 900</li><li>1024 x 640</li></ul><p><strong>Brillo de 400 nits</strong></p><p><strong>Amplia gama de colores (P3)</strong></p><p><strong>Tecnología True&nbsp;Tone</strong></p>', 1000.00, 0, 0, 3, 1),
(23, 'MacBook Air 15 Chip M2 - 256GB - Gris Espacial', '<p><strong>Pantalla Liquid Retina</strong></p><ul><li>Pantalla de 15,3 pulgadas (diagonal) retroiluminada por LED con tecnología IPS</li><li>Resolución nativa de 2.880 por 1.864 a 224 píxeles por pulgada compatible con 1.000 millones de colores</li></ul><p><strong>Brillo de 500 nits</strong></p><p><strong>Gama cromática amplia (P3)</strong></p><p><strong>Tecnología True&nbsp;Tone</strong></p>', 1300.00, 0, 2, 3, 1),
(24, 'Penes', '<p>Negros</p>', 0.00, 0, 1, 4, 0),
(25, 'm', '<p>m</p>', 0.00, 0, 0, 6, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_variantes`
--

CREATE TABLE `productos_variantes` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_almacenamiento` smallint(11) DEFAULT NULL,
  `id_color` int(11) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(40) DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `activacion`, `token`, `token_password`, `password_request`, `id_cliente`) VALUES
(1, 'Owen', '$2y$10$Y3DuUpJIqDKbG8UkLjmlWeTpO3cHsCxi/SJz1pPZdUHRA7BWJDULy', 1, '31204da877f4708bcd4818faa0a9497f', '', 0, 1),
(4, 'Helger', '$2y$10$VGoa2UdGhK0MqOTAqV6aV.WkjZz/ucZD/icacCAFibBF/TYXyJN9W', 1, '8843d729faae1c37b80194f78aa048a6', NULL, 0, 4),
(5, 'juan', '$2y$10$ji9PbvyTlQ3Ch4iLb551kufiLj7zuaZlL1A34Gi0HtF9sz47hA2NS', 1, 'fda9f70d2d3630490a57dfddd6001bc8', NULL, 0, 5),
(6, 'nelson', '$2y$10$l65kO4MAMoyFsMEnvyb5re8zPFa5eR7ffUWG45cJuPM8vvf6ntLUi', 1, 'adddb1ad284d4c0727b5cd02ec04893c', NULL, 0, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_transaccion` (`id_transaccion`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_transaccion_2` (`id_transaccion`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `c_almacenamiento`
--
ALTER TABLE `c_almacenamiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `c_colores`
--
ALTER TABLE `c_colores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `productos_variantes`
--
ALTER TABLE `productos_variantes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_color` (`id_color`),
  ADD KEY `id_almacenamiento` (`id_almacenamiento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuario` (`usuario`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `c_almacenamiento`
--
ALTER TABLE `c_almacenamiento`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `c_colores`
--
ALTER TABLE `c_colores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `productos_variantes`
--
ALTER TABLE `productos_variantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `productos_variantes`
--
ALTER TABLE `productos_variantes`
  ADD CONSTRAINT `productos_variantes_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `productos_variantes_ibfk_2` FOREIGN KEY (`id_color`) REFERENCES `c_colores` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_variantes_ibfk_3` FOREIGN KEY (`id_almacenamiento`) REFERENCES `c_almacenamiento` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
