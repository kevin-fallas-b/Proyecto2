-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2020 at 10:33 PM
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
-- Table structure for table `tbl_categoria`
--

CREATE TABLE `tbl_categoria` (
  `id` int(11) NOT NULL,
  `id_oferta` int(11) NOT NULL,
  `nombre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `ubicacion` varchar(200) NOT NULL COMMENT 'work from home, oficina en x lugar',
  `salario` int(11) NOT NULL COMMENT 'bruto, en colones',
  `horario` int(11) NOT NULL,
  `duracion` int(11) NOT NULL COMMENT 'duracion del contrato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `cedula` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `telefono` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `tbl_oferta`
--
ALTER TABLE `tbl_oferta`
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
  ADD PRIMARY KEY (`cedula`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_experiencia`
--
ALTER TABLE `tbl_experiencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_oferta`
--
ALTER TABLE `tbl_oferta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_requisito`
--
ALTER TABLE `tbl_requisito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_titulo`
--
ALTER TABLE `tbl_titulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
