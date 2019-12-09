-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 09/12/2019 às 17h59min
-- Versão do Servidor: 5.5.20
-- Versão do PHP: 5.4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `projeto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE IF NOT EXISTS `cidade` (
  `id_cidade` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cidade` varchar(100) NOT NULL,
  `cod_estado` int(11) NOT NULL,
  PRIMARY KEY (`id_cidade`),
  KEY `cod_estado` (`cod_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`id_cidade`, `nome_cidade`, `cod_estado`) VALUES
(1, 'Araraquara', 2),
(2, 'Matão', 2),
(4, 'Sao Carlos', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nome_estado` varchar(100) NOT NULL,
  `uf` varchar(100) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `estado`
--

INSERT INTO `estado` (`id_estado`, `nome_estado`, `uf`) VALUES
(2, 'Sao Paulo', 'SP'),
(3, 'Rio De Janeiro', 'RJ'),
(4, 'Minas Gerais', 'MG'),
(5, 'Parana', 'PR'),
(8, 'Amazonas', 'AM'),
(9, 'Ceará', 'CE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogador`
--

CREATE TABLE IF NOT EXISTS `jogador` (
  `id_jogador` int(11) NOT NULL AUTO_INCREMENT,
  `nome_jogador` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `cod_cidade` int(11) NOT NULL,
  `cod_time` int(11) NOT NULL,
  `posicao` varchar(40) NOT NULL,
  `sexo` char(1) NOT NULL,
  PRIMARY KEY (`id_jogador`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `jogador`
--

INSERT INTO `jogador` (`id_jogador`, `nome_jogador`, `data_nascimento`, `email`, `cod_cidade`, `cod_time`, `posicao`, `sexo`) VALUES
(3, 'Gui69', '2019-11-16', 'lord@gmail.com', 1, 1, 'Zagueiro', 'M');

-- --------------------------------------------------------

--
-- Estrutura da tabela `time`
--

CREATE TABLE IF NOT EXISTS `time` (
  `id_time` int(11) NOT NULL AUTO_INCREMENT,
  `nome_time` varchar(100) NOT NULL,
  `cod_cidade` int(11) NOT NULL,
  PRIMARY KEY (`id_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `time`
--

INSERT INTO `time` (`id_time`, `nome_time`, `cod_cidade`) VALUES
(1, 'Ferrovia', 2);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `cidade`
--
ALTER TABLE `cidade`
  ADD CONSTRAINT `cidade_ibfk_1` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
