-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2020 at 06:03 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_proyecto2`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_aplicacion`
--

CREATE TABLE `tbl_aplicacion` (
  `id` int(11) NOT NULL,
  `idOferta` int(11) NOT NULL,
  `cedula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categoria`
--

CREATE TABLE `tbl_categoria` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL COMMENT 'cedula juridica de la empresa duena de la categoria',
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_categoria`
--

INSERT INTO `tbl_categoria` (`id`, `cedula`, `nombre`) VALUES
(1, 123, 'Alimentos'),
(2, 123, 'Supermercados'),
(3, 123, 'Manejo'),
(4, 123, 'Panaderia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_experiencia`
--

CREATE TABLE `tbl_experiencia` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `empresa` varchar(50) NOT NULL,
  `puesto` varchar(50) NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `desc_responsa` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_experiencia`
--

INSERT INTO `tbl_experiencia` (`id`, `cedula`, `empresa`, `puesto`, `fecha_ini`, `fecha_fin`, `desc_responsa`) VALUES
(1, 604370412, 'Grupo BM', 'Empacador', '2013-10-01', NULL, 'ayudar a empacar comida'),
(2, 604370412, 'CooproSanVito R.L.', 'Asistente de informatica', '2015-09-01', '2015-11-01', 'crear redes de computadores de manera inalambrica'),
(8, 604370412, 'prueba', 'prueba', '2020-06-09', '2020-06-16', 'dadasda');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_meritos`
--

CREATE TABLE `tbl_meritos` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL COMMENT 'usuario dueno del merito',
  `descripcion` varchar(250) NOT NULL COMMENT 'el merito'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_meritos`
--

INSERT INTO `tbl_meritos` (`id`, `cedula`, `descripcion`) VALUES
(3, 604370412, 'Haber participado en un grupo artistico de la universidad nacional en el transucurso de 3 años, llevando acabo distintas presentaciones en diferentes regiones del pais. Dejando el nombre de la universidad en alto');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_oferta`
--

CREATE TABLE `tbl_oferta` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `numero_vacantes` int(11) NOT NULL,
  `fecha` date NOT NULL COMMENT 'fecha de publicacion del anuncio',
  `ubicacion` varchar(50) NOT NULL COMMENT 'work from home, oficina en x lugar',
  `salario` int(11) NOT NULL COMMENT 'bruto, en colones',
  `horario` varchar(50) NOT NULL,
  `duracion` varchar(50) NOT NULL COMMENT 'duracion del contrato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_oferta`
--

INSERT INTO `tbl_oferta` (`id`, `cedula`, `descripcion`, `numero_vacantes`, `fecha`, `ubicacion`, `salario`, `horario`, `duracion`) VALUES
(1, 123, 'Acomodador de gondolas', 2, '2020-06-10', 'Pista las lagunas', 75000, 'Lunes a viernes 8am-5pm', '3 meses'),
(2, 123, 'Repartidor de pan', 1, '2020-06-08', 'Pista las lagunas', 150000, 'lunes a viernes 5am - 12pm', 'indefinido');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_oftertascategoria`
--

CREATE TABLE `tbl_oftertascategoria` (
  `id` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `idOferta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_oftertascategoria`
--

INSERT INTO `tbl_oftertascategoria` (`id`, `idCategoria`, `idOferta`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(4, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_requisito`
--

CREATE TABLE `tbl_requisito` (
  `id` int(11) NOT NULL,
  `id_oferta` int(11) NOT NULL,
  `tipo` varchar(1) NOT NULL COMMENT 'minimo, opcional',
  `Descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_requisito`
--

INSERT INTO `tbl_requisito` (`id`, `id_oferta`, `tipo`, `Descripcion`) VALUES
(1, 1, 'o', 'Disponibilidad de tiempo'),
(2, 1, 'm', 'Carnet de manipulacion de alimentos'),
(3, 2, 'm', 'Licencia b2 al dia'),
(4, 2, 'o', 'Capacidad para cargar y descargar camion');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_titulo`
--

CREATE TABLE `tbl_titulo` (
  `id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL COMMENT 'Cedula persona duena del titulo',
  `especialidad` varchar(50) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `institucion` varchar(50) NOT NULL,
  `ano` int(11) NOT NULL COMMENT 'anno en que gano el titulo',
  `mes` int(11) NOT NULL COMMENT 'mes que gano el titulo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_titulo`
--

INSERT INTO `tbl_titulo` (`id`, `cedula`, `especialidad`, `titulo`, `institucion`, `ano`, `mes`) VALUES
(13, 604370412, 'Informatica', 'Tecnico medio en informatica en soporte', 'CTP Umberto Melloni Campanini', 2015, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `user` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `foto` varchar(50) NOT NULL DEFAULT 'unknown.png',
  `tipo` varchar(1) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`cedula`, `nombre`, `apellido`, `user`, `password`, `direccion`, `foto`, `tipo`, `telefono`, `correo`) VALUES
(123, 'AutoServicio Mako', '', 'Mako', '$2y$10$LDZ9mN2fo7KfiYSbOoM4b.n4p4idKDLYTdDtgLicszqrYBMuANGbK', 'Pista las lagunas, Perez Zeledon', '12084151.png', '2', 85844178, 'mako@autoserviciomako.com'),
(9010132, 'Angelica', 'Godinez Alvarado', 'angelica', '$2y$10$Sc5mSnorS7upO6q1rYREKuHHBrnvF55NHWwizwMp4.EgvdKfXmx2K', 'Pista las lagunas', 'unknown.png', '1', 955626232, 'angelica@gmail.com'),
(604370412, 'Kevin Jose', 'Fallas Bonilla', 'kevin', '$2y$10$7CIFgOI3kk2Kl2iw91MGI.uCkEhAXo7nAgB1USI6LQf84fU6PNrda', 'Villia Ligia, Perez Zeledon', '604370412.jpg', '1', 85844178, 'kevin.fallas.b@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_aplicacion`
--
ALTER TABLE `tbl_aplicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_experiencia`
--
ALTER TABLE `tbl_experiencia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_meritos`
--
ALTER TABLE `tbl_meritos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_oferta`
--
ALTER TABLE `tbl_oferta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_oftertascategoria`
--
ALTER TABLE `tbl_oftertascategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_requisito`
--
ALTER TABLE `tbl_requisito`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_titulo`
--
ALTER TABLE `tbl_titulo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `user` (`user`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_aplicacion`
--
ALTER TABLE `tbl_aplicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_experiencia`
--
ALTER TABLE `tbl_experiencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_meritos`
--
ALTER TABLE `tbl_meritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_oferta`
--
ALTER TABLE `tbl_oferta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_oftertascategoria`
--
ALTER TABLE `tbl_oftertascategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_requisito`
--
ALTER TABLE `tbl_requisito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_titulo`
--
ALTER TABLE `tbl_titulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
