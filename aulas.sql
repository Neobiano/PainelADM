-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 23-Nov-2017 às 16:42
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
-- Estrutura da tabela `periodos_entrega`
--

CREATE TABLE `periodos_entrega` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `inter_ini` int(11) DEFAULT NULL,
  `inter_fim` int(11) DEFAULT NULL,
  `cor` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `nome` varchar(50) NOT NULL,
  `fechado` varchar(1) NOT NULL,
  `cor` varchar(10) NOT NULL,
  `padrao_abertura` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status` (`id`, `nome`, `fechado`, `cor`, `padrao_abertura`) VALUES
(1, 'Aberto', 'N', '#66c72d', 'S'),
(2, 'Fechado', 'N', '#41dcc2', NULL),
(4, 'Aguardando GEATE5', 'N', '#c25858', NULL),
(5, 'Aguardando GEATE01', 'N', '#473bc2', NULL),
(7, 'Esperando na Janela', 'N', '#798a31', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id` int(11) NOT NULL,
  `assunto` varchar(100) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `id_prioridade` int(11) DEFAULT NULL,
  `data_cacad` date DEFAULT NULL,
  `id_projeto` int(11) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `id_atribuido` int(11) DEFAULT NULL,
  `id_criador` int(11) DEFAULT NULL,
  `descricao` longtext NOT NULL,
  `data_prev_fim` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tarefas`
--

INSERT INTO `tarefas` (`id`, `assunto`, `id_tipo`, `id_status`, `id_prioridade`, `data_cacad`, `id_projeto`, `id_categoria`, `data_inicio`, `data_fim`, `id_atribuido`, `id_criador`, `descricao`, `data_prev_fim`) VALUES
(1, 'Primeira tarefa', 3, 5, 1, '2017-11-23', 9, 3, '2017-11-20', '2017-11-23', 4, 4, '<p>&Agrave; Caixa,</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol>\r\n	<li>1. Solicitamos verificar o retorno abaixo, pois ao realizar redu&ccedil;&atilde;o de limite o sistema apres<u><strong>enta a cr&iacute;tica &ldquo;MPA0002 - CAMPO OBRIGATORIO&rdquo;</strong></u></li>\r\n	<li>2. Qual orienta&ccedil;&atilde;o devemos informar ao cliente, visto que foi feito v&aacute;rios testes e n&atilde;o &eacute; poss&iacute;vel reduzir.</li>\r\n</ol>\r\n\r\n<p>Att,</p>\r\n\r\n<p><strong>Luana Ferreira Rocha</strong></p>\r\n\r\n<p>Analista &ndash;&nbsp;BPO</p>\r\n\r\n<p><a href="mailto:lfrocha@indracompany.com" style="color:#0563c1; text-decoration:underline">lfrocha@indracompany.com</a></p>\r\n\r\n<p><u><a href="https://webmail.indra.es/owa/redir.aspx?C=opUz3Vnlz0yUS4EweMfdwtYuFaA5ZdJIa0fyBQQvyK2gznjuvvSVWAoCiCimVLaXMqrj7fsXCFA.&amp;URL=http%3a%2f%2fwww.indracompany.com%2f" style="color:#0563c1; text-decoration:underline" target="_blank">www.indracompany.com</a></u></p>\r\n', NULL),
(2, 'CAMPOS INVERTIDOS NA FUNCIONALIDADE VALOR ANUIDADE - FRONT END INDRA', 1, 1, 4, '2017-11-23', 8, 5, '2017-11-21', NULL, 4, 4, '<div>\r\n<p>&Aacute;</p>\r\n\r\n<p>INDRA</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>1. Encaminhamos tela do Mind4Card, da funcionalidade Valor Anuidade, na qual consta valores invertidos nas colunas &ldquo;VALOR TOTAL&rdquo; e &ldquo;VALOR PARCELA&rdquo;, conforme evidencia abaixo</p>\r\n\r\n<p>2. A consulta em quest&atilde;o se deu para o cliente CPF 269.878.888-76 (Luciana A. Fumoto) cart&atilde;o 5411.</p>\r\n\r\n<p>3 Solicitamos verificar o retorno dos campos relacionados aos servi&ccedil;os, realizando as corre&ccedil;&otilde;es caso necess&aacute;rio.</p>\r\n\r\n<p>4 Abaixo segue servi&ccedil;o e campos a serem utilizados nas referidas colunas.</p>\r\n\r\n<p>4.1 Servi&ccedil;o: TICL129 (SAT)<br />\r\n&bull; Valor Total &gt; Campo: IMPCUOTOT<br />\r\n&bull; Valor Parcela &gt; Campo: IMPCUOPER</p>\r\n\r\n<p>5 Aguardamos retorno e nos colocamos a disposi&ccedil;&atilde;o para demais esclarecimentos.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>LEANDRO ARRUDA LEAL<br />\r\nCoordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n</div>\r\n', '2017-11-30'),
(3, 'Avaya Recorder - Falha na Gravação de Tela (19/09/2017 - ID: 1117941505822410) (RM #120)', 1, 7, 2, '2017-11-23', 8, 5, '2017-11-23', NULL, 4, 4, '<p>&Agrave;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>INDRA</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Prezados</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Segue evid&ecirc;ncia de atendimento sem grava&ccedil;&atilde;o de tela no aplicativo <em>Avaya Recorder</em>:</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Data: 19/09/2017, ID: <strong>1117941505822410</strong></p>\r\n\r\n<p><img src="file:///C:/Users/c124607/AppData/Local/Temp/msohtmlclip1/01/clip_image001.jpg" style="height:432px; width:768px" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Solicitamos verificar a falha sist&ecirc;mica, considerando que todos os atendimento precisar realizar grava&ccedil;&atilde;o de tela e voz.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Aguardamos retorno at&eacute; dia 21/09 e nos colocamos &agrave; disposi&ccedil;&atilde;o para os esclarecimentos necess&aacute;rios.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Atenciosamente</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>LEANDRO CAETANO DE FARIA</strong></p>\r\n\r\n<p><strong>Auxiliar Operacional</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>LEANDRO ARRUDA LEAL</p>\r\n\r\n<p>Coordenador de Centralizadora</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS</p>\r\n\r\n<p>Gerente de Centralizadora</p>\r\n\r\n<p>Atendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n', '2017-11-30');

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
-- Indexes for table `periodos_entrega`
--
ALTER TABLE `periodos_entrega`
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
-- AUTO_INCREMENT for table `periodos_entrega`
--
ALTER TABLE `periodos_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
