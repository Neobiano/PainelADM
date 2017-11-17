-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 17-Nov-2017 às 19:22
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aulas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Fidelização'),
(2, 'IDPos'),
(3, 'Fatura - Parcelamento'),
(4, 'Fatura - Envio por Email'),
(5, 'Alteração Cadastral'),
(6, 'Alteração de Limite');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prioridades`
--

CREATE TABLE `prioridades` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `prioridades`
--

INSERT INTO `prioridades` (`id`, `nome`) VALUES
(1, 'Urgente'),
(2, 'Alta'),
(3, 'Normal'),
(4, 'Baixa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `projetos`
--

INSERT INTO `projetos` (`id`, `nome`, `descricao`) VALUES
(8, 'Gestão TI', 0x47657374c3a36f20646520544920646120756e696461646573),
(9, 'Gestão URAS', 0x47657374c3a36f2064612055524120646120756e6964616465),
(10, 'Novo Projeto', 0x566169206d6575206669),
(11, 'Meu novo projeto', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status` (`id`, `nome`) VALUES
(1, 'Aberto'),
(2, 'Fechado'),
(4, 'Aguardando GEATE5'),
(5, 'Aguardando GEATE01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL,
  `assunto` varchar(100) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `id_prioridade` int(11) NOT NULL,
  `data_cacad` date NOT NULL,
  `id_projeto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipos`
--

INSERT INTO `tipos` (`id`, `nome`) VALUES
(1, 'Bug'),
(2, 'Funcionalidade'),
(3, 'Suporte');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `administrador` varchar(1) NOT NULL,
  `datacad` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `login`, `senha`, `ativo`, `administrador`, `datacad`) VALUES
(4, 'Fabiano Lisboa', 'fabiano.lisboas@caixa.gov.br', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'S', 'S', '2028-10-17 00:00:00'),
(2, 'joao da silva sauro', 'joaodasilva@gmail.com', 'joaos', '86ff44f9903ce0944623c9e56ab09352', 's', 's', '2028-10-17 00:00:00'),
(102, 'Leandro Caetano', 'leandro@caetano.com', 'caetano', '594e650d073a0fa5577c7a12de74b57d', 'S', 'S', '2016-11-17 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prioridades`
--
ALTER TABLE `prioridades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `prioridades`
--
ALTER TABLE `prioridades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
