-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 25-Nov-2017 às 18:55
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
(6, 'Alteração de Limite'),
(7, 'Cartão Adicional'),
(8, 'Variação Cambial'),
(9, 'Anuidade '),
(10, 'Autorizações'),
(11, 'Bloqueios - Cartão'),
(12, 'Bloqueios - Conta'),
(13, 'Carta de Quitação '),
(14, 'Cartão Solidário'),
(15, 'Endereço/Meios de Comunicação'),
(16, 'Erro WebServices '),
(17, 'Especificação'),
(18, 'Fatura - Código de Barras '),
(19, 'Fatura - Divergência de Valores'),
(20, 'ID POS'),
(21, 'Inconsistência Cadastral '),
(22, 'Limites de Créidito'),
(23, 'Log de Atendimentos '),
(24, 'Segurança'),
(25, 'Sugestões Caixa'),
(26, 'Sugestões Indra'),
(27, 'Suporte - Geral '),
(28, 'Suporte - Impacto de Alterações '),
(29, 'Upgrade/Downgrade '),
(30, 'WebService - Problema de Acesso'),
(31, 'APOIO - DESENVOLVIMENTO'),
(32, 'APOIO - Faturamento'),
(33, 'APOIO - Gestão'),
(34, 'Monitoramento de BD'),
(35, 'Adequação de Leiaute'),
(36, 'Deficiente Auditivo'),
(37, 'Desbloqueio'),
(38, 'Pesquisa de Satisfação'),
(39, 'Retenção'),
(40, 'Vocalização de Informações'),
(41, 'Vocalização de Saldo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `periodos_entrega`
--

CREATE TABLE `periodos_entrega` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `inter_ini` int(11) DEFAULT NULL,
  `inter_fim` int(11) DEFAULT NULL,
  `cor` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `periodos_entrega`
--

INSERT INTO `periodos_entrega` (`id`, `nome`, `inter_ini`, `inter_fim`, `cor`) VALUES
(1, 'Semana da Entrega', -7, -1, '#eee710'),
(2, '7 dias de Vencido', 1, 7, '#de4294'),
(3, 'Mais de 7 dias de Atraso', 8, 365, '#e94343'),
(4, 'Entrega pro poderoso', 366, 100000, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prioridades`
--

CREATE TABLE `prioridades` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `padrao_abertura` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `prioridades`
--

INSERT INTO `prioridades` (`id`, `nome`, `padrao_abertura`) VALUES
(1, 'Urgente', NULL),
(2, 'Alta', NULL),
(3, 'Normal', 'S'),
(4, 'Baixa', NULL);

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
  `cor` varchar(50) NOT NULL,
  `padrao_abertura` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status` (`id`, `nome`, `fechado`, `cor`, `padrao_abertura`) VALUES
(1, 'Novo', 'N', '#66c72d', 'S'),
(2, 'Fechado', 'S', '#4f857b', 'N'),
(4, 'Aguardando GEATE5', 'N', '#c25858', NULL),
(5, 'Aguardando GEATE01', 'N', '#473bc2', NULL),
(7, 'Esperando na Janela', 'N', '#798a31', NULL),
(8, 'Em Execução', 'N', '#37e1d6', 'N'),
(9, 'Aguardando Indra', 'N', '#ae35a8', 'N'),
(10, 'Rejeitado ', 'S', '#e3c4c4', 'N'),
(11, 'Aguardando - GECOP ', 'N', '', 'N'),
(12, 'Aguardando - CEDES ', 'N', '#3adca3', 'N'),
(13, 'Aguardando - INDRA ', 'N', '#ebe422', 'N'),
(14, 'Aguardando Homologação ', 'N', '', 'N'),
(15, 'Aguardando - GEFEN ', 'N', '', 'N'),
(16, 'Aguardando - CERATFO08 	', 'N', '', 'N'),
(17, 'Aguardando - CERATFO02 ', 'N', '', 'N'),
(18, 'Aguardando - CERATFO03', 'N', '', 'N'),
(19, 'Aguardando - CERATFO05 ', 'N', '', 'N'),
(20, 'Aguardando - GEASP16 	', 'N', '', 'N'),
(21, 'Aguardando - CECOP08 ', 'N', '', 'N');

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
(1, 'Primeira tarefa', 3, 5, 1, '2017-11-23', 9, 3, '2017-11-20', '2017-11-23', 102, 102, '<p>&Agrave; Caixa,</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol>\r\n	<li>1. Solicitamos verificar o retorno abaixo, pois ao realizar redu&ccedil;&atilde;o de limite o sistema apres<u><strong>enta a cr&iacute;tica &ldquo;MPA0002 - CAMPO OBRIGATORIO&rdquo;</strong></u></li>\r\n	<li>2. Qual orienta&ccedil;&atilde;o devemos informar ao cliente, visto que foi feito v&aacute;rios testes e n&atilde;o &eacute; poss&iacute;vel reduzir.</li>\r\n</ol>\r\n\r\n<p>Att,</p>\r\n\r\n<p><strong>Luana Ferreira Rocha</strong></p>\r\n\r\n<p>Analista &ndash;&nbsp;BPO</p>\r\n\r\n<p><a href="mailto:lfrocha@indracompany.com" style="color:#0563c1; text-decoration:underline">lfrocha@indracompany.com</a></p>\r\n\r\n<p><u><a href="https://webmail.indra.es/owa/redir.aspx?C=opUz3Vnlz0yUS4EweMfdwtYuFaA5ZdJIa0fyBQQvyK2gznjuvvSVWAoCiCimVLaXMqrj7fsXCFA.&amp;URL=http%3a%2f%2fwww.indracompany.com%2f" style="color:#0563c1; text-decoration:underline" target="_blank">www.indracompany.com</a></u></p>\r\n', '2017-11-15'),
(2, 'CAMPOS INVERTIDOS NA FUNCIONALIDADE VALOR ANUIDADE - FRONT END INDRA', 1, 1, 4, '2017-11-23', 8, 5, '2017-11-21', NULL, 4, 4, '<div>\r\n<p>&Aacute;</p>\r\n\r\n<p>INDRA</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>1. Encaminhamos tela do Mind4Card, da funcionalidade Valor Anuidade, na qual consta valores invertidos nas colunas &ldquo;VALOR TOTAL&rdquo; e &ldquo;VALOR PARCELA&rdquo;, conforme evidencia abaixo</p>\r\n\r\n<p>2. A consulta em quest&atilde;o se deu para o cliente CPF 269.878.888-76 (Luciana A. Fumoto) cart&atilde;o 5411.</p>\r\n\r\n<p>3 Solicitamos verificar o retorno dos campos relacionados aos servi&ccedil;os, realizando as corre&ccedil;&otilde;es caso necess&aacute;rio.</p>\r\n\r\n<p>4 Abaixo segue servi&ccedil;o e campos a serem utilizados nas referidas colunas.</p>\r\n\r\n<p>4.1 Servi&ccedil;o: TICL129 (SAT)<br />\r\n&bull; Valor Total &gt; Campo: IMPCUOTOT<br />\r\n&bull; Valor Parcela &gt; Campo: IMPCUOPER</p>\r\n\r\n<p>5 Aguardamos retorno e nos colocamos a disposi&ccedil;&atilde;o para demais esclarecimentos.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>LEANDRO ARRUDA LEAL<br />\r\nCoordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n</div>\r\n', '2017-11-30'),
(3, 'Avaya Recorder - Falha na Gravação de Tela (19/09/2017 - ID: 1117941505822410) (RM #120)', 1, 8, 2, '2017-11-23', 8, 5, '2017-11-23', NULL, 2, 2, '<p>&Agrave;</p>\r\n\r\n<p>INDRA</p>\r\n\r\n<p>Prezados</p>\r\n\r\n<p>1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Segue evid&ecirc;ncia de atendimento sem grava&ccedil;&atilde;o de tela no aplicativo <em>Avaya Recorder</em>:</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Data: 19/09/2017, ID: <strong>1117941505822410</strong></p>\r\n\r\n<p><img src="data:image/png;base64,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" /></p>\r\n\r\n<p>2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Solicitamos verificar a falha sist&ecirc;mica, considerando que todos os atendimento precisar realizar grava&ccedil;&atilde;o de tela e voz.</p>\r\n\r\n<p>3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Aguardamos retorno at&eacute; dia 21/09 e nos colocamos &agrave; disposi&ccedil;&atilde;o para os esclarecimentos necess&aacute;rios.</p>\r\n\r\n<p>Atenciosamente</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>LEANDRO CAETANO DE FARIA</strong></p>\r\n\r\n<p><strong>Auxiliar Operacional</strong></p>\r\n\r\n<p>LEANDRO ARRUDA LEAL</p>\r\n\r\n<p>Coordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS</p>\r\n\r\n<p>Gerente de Centralizadora</p>\r\n\r\n<p>Atendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n', '2017-11-01'),
(4, 'PF - Erro na inclusão de adicional', 1, 9, 3, '2017-11-25', 8, 7, '2017-05-17', NULL, 102, 102, '<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<p>De: CERATFO05 - Tecnologia Cart&otilde;es<br />\r\nEnviada em: quarta-feira, 2 de novembro de 2016 15:32<br />\r\nPara: GEATE09 - Cart&otilde;es<br />\r\nCc: CERATFO05 - Tecnologia Cart&otilde;es; CERATFO08 - Cart&otilde;es Atendimento; CERATFO02 - Qualidade Cart&otilde;es de Cr&eacute;dito; Thiago Oliveira Barros; Eduardo Araujo Mendonca; Givanildo da Silva; Jayme Gilberto Amatnecks Junior; Marcia Helena Marinho de Farias<br />\r\nAssunto: Erro na inclus&atilde;o de adicional</p>\r\n\r\n<p>&Agrave;<br />\r\nGEATE</p>\r\n\r\n<p>Senhor Gerente</p>\r\n\r\n<p>1. Informamos que em tentativa de inclus&atilde;o de adicional nesta central atrav&eacute;s do FRONTEND INDRA obtivemos o erro MPE0461 - LIMITE RECUSADO\nFIELD-&gt; LIMITE CREDITO TARJETA para o cliente CPF 57641650910 - Cart&atilde;o: 4128 e CPF adicional 07841631979, conforme evidencias abaixo.</p>\r\n\r\n<p>2. Informamos tamb&eacute;m que em caso semelhante (CPF 97085944820 - Cart&atilde;o:0716) foi poss&iacute;vel incluir o adicional na ferramenta corporativa SAT.<br />\r\n3. Em anexo segue envelope de retorno do erro.<br />\r\n4. Solicitamos a gentileza de seu apoio na an&aacute;lise da situa&ccedil;&atilde;o e as providencias, se necess&aacute;rias.<br />\r\n5. Agradecemos a aten&ccedil;&atilde;o e nos colocamos a disposi&ccedil;&atilde;o.</p>\r\n\r\n<p>Jayme Amatnecks<br />\r\nAuxiliar Operacional</p>\r\n\r\n<p>Leandro Arruda Leal<br />\r\nCoordenador de Centralizadora</p>\r\n\r\n<p>M&aacute;rcia Helena Marinho de Farias<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;o Fortaleza/CE</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '2017-05-31'),
(5, 'Erro variação cambial', 1, 12, 3, '2017-11-25', 8, 8, '2017-04-22', NULL, 4, 4, '<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<p>&Aacute; Caixa,</p>\r\n\r\n<p>Qualidade/ produ&ccedil;&atilde;o,</p>\r\n\r\n<p>At&eacute; o retorno definitivo, qual padroniza&ccedil;&atilde;o devemos utilizar quando apresentar o erro?</p>\r\n\r\n<p>Att,<br />\r\nLuana Gondim da Silva<br />\r\nMultiplicadora &ndash; BPO<br />\r\n<a class="email" href="mailto:lgondim@indracompany.com.br">lgondim@indracompany.com.br</a><br />\r\n<a class="external" href="http://www.indracompany.com/">www.indracompany.com</a></p>\r\n\r\n<p>De: <a class="email" href="mailto:ceratfo05@caixa.gov.br">ceratfo05@caixa.gov.br</a> [mailto:<a class="email" href="mailto:ceratfo05@caixa.gov.br">ceratfo05@caixa.gov.br</a>]<br />\r\nEnviada: quarta-feira, 3 de maio de 2017 20:28<br />\r\nPara: Araujo Rocha, Josemar &lt;<a class="email" href="mailto:jaraujor@indracompany.com">jaraujor@indracompany.com</a>&gt;; <a class="email" href="mailto:ti.for@indrabrasilbpo.com">ti.for@indrabrasilbpo.com</a>; Gondim Da Silva, Luana &lt;<a class="email" href="mailto:lgondim@indracompany.com">lgondim@indracompany.com</a>&gt;; Ferreira Rocha, Luana &lt;<a class="email" href="mailto:lfrocha@indracompany.com">lfrocha@indracompany.com</a>&gt;; De Lima Nobre, Iraciana &lt;<a class="email" href="mailto:ilima@indracompany.com">ilima@indracompany.com</a>&gt;; Silva Saldanha, Alexandre &lt;<a class="email" href="mailto:assaldanha@indracompany.com">assaldanha@indracompany.com</a>&gt;; Da Silva, Luiz Antonio &lt;<a class="email" href="mailto:luasilva@indracompany.com">luasilva@indracompany.com</a>&gt;; Evangelista Da Silva Santos, Silvia &lt;<a class="email" href="mailto:sevangelista@indracompany.com">sevangelista@indracompany.com</a>&gt;<br />\r\nCc: Thiago Oliveira Barros &lt;<a class="email" href="mailto:thiago.o.barros@caixa.gov.br">thiago.o.barros@caixa.gov.br</a>&gt;; Givanildo da Silva &lt;<a class="email" href="mailto:givanildo.silva@caixa.gov.br">givanildo.silva@caixa.gov.br</a>&gt;; <a class="email" href="mailto:ceratfo08@caixa.gov.br">ceratfo08@caixa.gov.br</a>; <a class="email" href="mailto:ceratfo05@caixa.gov.br">ceratfo05@caixa.gov.br</a>; <a class="email" href="mailto:ceratfo02@caixa.gov.br">ceratfo02@caixa.gov.br</a>; Marilandia Mota Holanda &lt;<a class="email" href="mailto:marilandia.holanda@caixa.gov.br">marilandia.holanda@caixa.gov.br</a>&gt;; Leandro Caetano de Faria &lt;<a class="email" href="mailto:leandro.c.faria@caixa.gov.br">leandro.c.faria@caixa.gov.br</a>&gt;; Fabiano Leal Lisboas &lt;<a class="email" href="mailto:fabiano.lisboas@caixa.gov.br">fabiano.lisboas@caixa.gov.br</a>&gt;; Marcia Helena Marinho de Farias &lt;<a class="email" href="mailto:marcia.farias@caixa.gov.br">marcia.farias@caixa.gov.br</a>&gt;<br />\r\nAssunto: ENC: Erro varia&ccedil;&atilde;o cambial</p>\r\n\r\n<p>&Aacute;</p>\r\n\r\n<p>INDRA</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>1 Estamos verificando com o gestor a possibilidade de tratamento dos casos atrav&eacute;s de abertura de ocorr&ecirc;ncia.</p>\r\n\r\n<p>2 Enviaremos orienta&ccedil;&atilde;o assim que recebermos retorno.</p>\r\n\r\n<p>3 A disposi&ccedil;&atilde;o.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>LEANDRO ARRUDA LEAL<br />\r\nCoordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n\r\n<p>De: Gondim Da Silva, Luana [mailto:<a class="email" href="mailto:lgondim@indracompany.com">lgondim@indracompany.com</a>]<br />\r\nEnviada em: quinta-feira, 27 de abril de 2017 17:03<br />\r\nPara: CERATFO08 - Cart&otilde;es Atendimento; CERATFO05 - Tecnologia Cart&otilde;es; CERATFO02 - Qualidade Cart&otilde;es de Cr&eacute;dito<br />\r\nCc: Silva Saldanha, Alexandre; Ferreira Rocha, Luana; Da Silva, Luiz Antonio; Soares Diniz, Kecia; Evangelista Da Silva Santos, Silvia<br />\r\nAssunto: Erro varia&ccedil;&atilde;o cambial</p>\r\n\r\n<p>&Aacute; Caixa,</p>\r\n\r\n<p>1. Informamos que ao realizar altera&ccedil;&atilde;o de varia&ccedil;&atilde;o cambial, o sistema est&aacute; apresentando erro</p>\r\n\r\n<p>2. Por favor analisar o erro , pois a a&ccedil;&atilde;o n&atilde;o &eacute; conclu&iacute;da com sucesso</p>\r\n\r\n<p>3.</p>\r\n\r\n<p>4. Segue em anexo envelope informando que o par&acirc;metro INDSEGU est&aacute; vazio.<br />\r\n5. Por oportuno, solicito uma padroniza&ccedil;&atilde;o at&eacute; a solu&ccedil;&atilde;o do problema</p>\r\n\r\n<p>Att,<br />\r\nLuana Gondim da Silva<br />\r\nMultiplicadora &ndash; BPO<br />\r\n<a class="email" href="mailto:lgondim@indracompany.com.br">lgondim@indracompany.com.br</a><br />\r\n<a class="external" href="http://www.indracompany.com/">www.indracompany.com</a></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '2017-06-03'),
(6, 'Divergência tb_eventos_dac x tb_fila_acumulado NS', 1, 13, 3, '2017-11-25', 8, 31, '2017-05-24', NULL, 102, 102, '<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<p>&Agrave;<br />\r\nIndra</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>1 Ap&oacute;s testes efetuados diretamente no banco de dados DB_ATF fazendo uso da nova tabela tb_eventos_dac_2 que cont&ecirc;m os dois novos campos CALL_DISP e DISPVDN, chegou-se as seguintes conclus&otilde;es:</p>\r\n\r\n<p>&bull; Utilizando os campos citados com os respectivos valores CALL_DISP = 2 (Chamadas atendidas) e CALL_DISP = 3 (Chamadas abandonadas) como crit&eacute;rio de filtro para as consultas executadas sobre a tabela tb_eventos_dac_2, constatou-se que os valores referentes ao TOTAL de chamadas ATENDIDAS, e ABANDONADAS condizem (ou com pequenas diferen&ccedil;as) com os valores listados na tabela tb_log_categorizacao. No entanto os demais valores que representa os intervalos de tempo (atendidas at&eacute; 10 segundos, atendidas at&eacute; 45 segundos, abandonadas ap&oacute;s 90 segundos etc..) necess&aacute;rios a confec&ccedil;&atilde;o de relat&oacute;rios gerenciais est&atilde;o divergentes.</p>\r\n\r\n<p>&bull; Abaixo segue a consulta efetuada e os consequentes resultados.</p>\r\n\r\n<p>Consulta em SQL - Utilizando a data de 03/03/2017 como crit&eacute;rio de pesquisa.<br />\r\nselect &#39;tb_eventos_dac_2&#39; as tabela, 74 as cod_fila,<br />\r\n(<br />\r\nselect count(<strong>) from tb_eventos_DAC_2 ted<br />\r\nwhere data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;<br />\r\nand cod_fila = 74 and dispvdn=92024 and ted.call_disp = 2<br />\r\n) atendidas,<br />\r\n(<br />\r\nselect count(</strong>) from tb_eventos_DAC_2 ted<br />\r\nwhere data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;<br />\r\nand tempo_espera &lt;= 10 and cod_fila = 74 and dispvdn=92024 and ted.call_disp = 2<br />\r\n) atendidas_0_e_10,</p>\r\n\r\n<pre>\r\n<code>(\r\n                           select count(*)  from tb_eventos_DAC_2 ted \r\n                           where data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;\r\n                           and  (tempo_espera &gt; 10) and (tempo_espera &lt;= 45) and cod_fila = 74 and dispvdn=92024 and ted.call_disp = 2\r\n                    )  atendidas_10_e_45,</code></pre>\r\n\r\n<pre>\r\n<code>(\r\n                           select count(*)  from tb_eventos_DAC_2 ted \r\n                           where data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;\r\n                           and  (tempo_espera &gt; 45) and (tempo_espera &lt;= 90) and cod_fila = 74 and dispvdn=92024 and ted.call_disp = 2\r\n                    )  atendidas_45_e_90,</code></pre>\r\n\r\n<pre>\r\n<code>(\r\n                           select count(*)  from tb_eventos_DAC_2 ted \r\n                           where data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;\r\n                           and  (tempo_espera &gt; 90)  and cod_fila = 74 and dispvdn=92024 and ted.call_disp = 2\r\n                    )  atendidas_depois_90,</code></pre>\r\n\r\n<pre>\r\n<code>(\r\n                           select count(*)  from tb_eventos_DAC_2 ted \r\n                           where data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;\r\n                           and cod_fila = 74 and dispvdn = 92024 and (ted.call_disp =3) \r\n                    ) abandonadas,</code></pre>\r\n\r\n<pre>\r\n<code>(\r\n                           select count(*)  from tb_eventos_DAC_2 ted \r\n                           where data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;\r\n                           and  tempo_espera &lt;= 10 and cod_fila = 74 and dispvdn = 92024 and ted.call_disp = 3\r\n                    ) abandonadas_0_e_10,</code></pre>\r\n\r\n<pre>\r\n<code>(\r\n                           select count(*)  from tb_eventos_DAC_2 ted \r\n                           where data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;\r\n                           and  tempo_espera &gt; 10 and tempo_espera &lt;= 45 and cod_fila = 74 and dispvdn=92024 and ted.call_disp = 3\r\n                    ) abandonadas_10_e_45,</code></pre>\r\n\r\n<pre>\r\n<code>(\r\n                           select count(*)  from tb_eventos_DAC_2 ted \r\n                           where data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;\r\n                           and  tempo_espera &gt; 45 and tempo_espera &lt;= 90 and cod_fila = 74 and dispvdn=92024 and ted.call_disp = 3\r\n                    ) abandonadas_45_e_90,</code></pre>\r\n\r\n<pre>\r\n<code>(\r\n                           select count(*)  from tb_eventos_DAC_2 ted \r\n                           where data_hora between &#39;03/03/2017 00:00:00&#39; and &#39;03/03/2017 23:59:59.999&#39;\r\n                           and tempo_espera &gt; 90 and  cod_fila = 74 and dispvdn=92024 and ted.call_disp = 3\r\n                    ) abandonadas_depois_90</code></pre>\r\n\r\n<pre>\r\n<code>select &#39;tb_fila_acumulado&#39; as tabela, cod_fila, \r\n                    sum(atendidas) atendidas,\r\n                    sum(atendidas_1) atendidas_0_e_10,\r\n                    sum(atendidas_2) atendidas_10_e_45,\r\n                    sum(atendidas_3) atendidas_45_e_90,\r\n                    (sum(atendidas) - (sum(atendidas_1) + sum(atendidas_2) + sum(atendidas_3))) atendidas_depois_90,</code></pre>\r\n\r\n<pre>\r\n<code>sum(abandonadas) abandonadas,\r\n                    sum(abandonadas_1) abandonadas_0_e_10,\r\n                    sum(abandonadas_2) abandonadas_10_e_45,\r\n                    sum(abandonadas_3) abandonadas_45_e_90,\r\n                    (sum(abandonadas) - (sum(abandonadas_1) + sum(abandonadas_2) + sum(abandonadas_3))) abandonadas_depois_90</code></pre>\r\n\r\n<pre>\r\n<code>from tb_fila_acumulado tfa\r\n                    where data = &#39;03/03/2017&#39; and tempo_atendimento &gt; 0\r\n                    and cod_fila = 74  \r\n                    group by cod_fila</code></pre>\r\n\r\n<p>Resultados<br />\r\ntabela cod_fila atendidas atendidas_0_e_10 atendidas_10_e_45 atendidas_45_e_90 atendidas_depois_90 abandonadas abandonadas_0_e_10 abandonadas_10_e_45 abandonadas_45_e_90 abandonadas_depois_90<br />\r\ntb_eventos_dac_2 74 9130 2112 518 889 5611 2538 49 440 517 1532<br />\r\ntb_fila_acumulado 74 9127 2170 569 902 5486 2538 167 371 505 1495</p>\r\n\r\n<p>2 Solicitamos portando que seja efetuada uma an&aacute;lise sobre o caso no intu&iacute;do de identificar as poss&iacute;veis inconsist&ecirc;ncias ou justificativas plaus&iacute;veis para as diferen&ccedil;as encontradas.</p>\r\n\r\n<p>3 Agradecemos a aten&ccedil;&atilde;o e nos colocamos a disposi&ccedil;&atilde;o.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>FABIANO LEAL LISBOAS<br />\r\nAssistente Pleno</p>\r\n\r\n<p>LEANDRO DE ARRUDA LEAL<br />\r\nCoordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FREITAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n\r\n<p>De: Thiago Oliveira Barros<br />\r\nEnviada em: ter&ccedil;a-feira, 4 de abril de 2017 13:57<br />\r\nPara: Fabiano Leal Lisboas &lt;<a class="email" href="mailto:fabiano.lisboas@caixa.gov.br">fabiano.lisboas@caixa.gov.br</a>&gt;<br />\r\nAssunto: ENC: Diverg&ecirc;ncia tb_eventos_dac x tb_fila_acumulado NS<br />\r\nPrioridade: Alta</p>\r\n\r\n<p>De: CERATFO08 - Cart&otilde;es Atendimento<br />\r\nEnviada em: sexta-feira, 17 de mar&ccedil;o de 2017 15:56<br />\r\nPara: Miranda Ferreira, Francisco Giuan; Araujo Rocha, Josemar; Silva Saldanha, Alexandre; De Lima Nobre, Iraciana; Da Silva, Luiz Antonio; Ferreira Rocha, Luana; Gondim Da Silva, Luana<br />\r\nCc: Fabiano Leal Lisboas; CERATFO08 - Cart&otilde;es Atendimento; CERATFO05 - Tecnologia Cart&otilde;es; CERATFO02 - Qualidade Cart&otilde;es de Cr&eacute;dito; Leandro Caetano de Faria; Jayme Gilberto Amatnecks Junior; Thiago Oliveira Barros; Eduardo Araujo Mendonca; Givanildo da Silva; Marcia Helena Marinho de Farias; Evandro Nascimento Almeida Junior<br />\r\nAssunto: ENC: Diverg&ecirc;ncia tb_eventos_dac x tb_fila_acumulado NS<br />\r\nPrioridade: Alta</p>\r\n\r\n<p>&Agrave;<br />\r\nINDRA TI</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>1 Conforme acordado segue o leiaute da nova tabela criada (tb_eventos_dac_2) no banco de dados &quot;DB_ATF&quot; a fim de armazenar temporariamente os registros de atendimentos que contenham os 2 (dois) novos campos solicitados, &agrave; saber CALL_DISP e DISPVDN.</p>\r\n\r\n<pre>\r\n<code>a. Leiaute\r\n              [tb_eventos_DAC_2](\r\n                           [callid] [varchar](30) NULL,\r\n                           [data_hora] [datetime] NOT NULL,\r\n                           [cod_fila] [bigint] NOT NULL,\r\n                           [tempo_espera] [int] NULL,\r\n                           [tempo_consulta_mudo] [int] NULL,\r\n                           [tempo_atend] [int] NULL,\r\n                           [id_operador] [varchar](20) NULL,\r\n                           [desc_operador] [varchar](100) NULL,\r\n                           [call_disp] [int] NULL,\r\n                           [dispvdn] [char](01) NULL\r\n                         )</code></pre>\r\n\r\n<p>2 Os registros gerados nesta tabela dever&atilde;o, a partir da data de execu&ccedil;&atilde;o do script, retroagir at&eacute; a data de 01/01/2017.</p>\r\n\r\n<p>3 As rotinas correntes respons&aacute;veis por inclu&iacute;rem os registros na tabela tb_eventos_DAC n&atilde;o dever&atilde;o ser alteradas at&eacute; segunda ordem, tendo em vista a criticidade dos dados utilizados nas rotinas de acompanhamento e gest&atilde;o da unidade.</p>\r\n\r\n<p>4 No intuito de preservar a integridade dos dados utilizados da tabela tb_eventos_DAC as permiss&otilde;es de update para a mesma s&oacute; ser&atilde;o habilitadas ap&oacute;s os devidos testes nos registros gerados (tb_eventos_DAC_2) efetuados pela equipe caixa</p>\r\n\r\n<p>5 Aguardamos posi&ccedil;&atilde;o sobre a data efetiva de inclus&atilde;o dos registros para a referida tabela e agradecemos a aten&ccedil;&atilde;o dispensada.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>THIAGO OLIVEIRA BARROS<br />\r\nAssistente Pleno</p>\r\n\r\n<p>MARILANDIA MOTA HOLANDA<br />\r\nCoordenadora de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n\r\n<p>De: CERATFO08 - Cart&otilde;es Atendimento<br />\r\nEnviada em: sexta-feira, 10 de mar&ccedil;o de 2017 14:26<br />\r\nPara: Araujo Rocha, Josemar; Silva Saldanha, Alexandre; De Lima Nobre, Iraciana; Da Silva, Luiz Antonio; Gondim Da Silva, Luana; Ferreira Rocha, Luana<br />\r\nCc: CERATFO05 - Tecnologia Cart&otilde;es; CERATFO02 - Qualidade Cart&otilde;es de Cr&eacute;dito; Evandro Nascimento Almeida Junior; Leandro Caetano de Faria; Fabiano Leal Lisboas; Givanildo da Silva; Eduardo Araujo Mendonca; Thiago Oliveira Barros; Jayme Gilberto Amatnecks Junior; CERATFO08 - Cart&otilde;es Atendimento<br />\r\nAssunto: ENC: Diverg&ecirc;ncia tb_eventos_dac x tb_fila_acumulado NS<br />\r\nPrioridade: Alta</p>\r\n\r\n<p>&Agrave;<br />\r\nINDRA</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>1. Reiteramos pedido de posicionamento sobre os crit&eacute;rios utilizados que resultam em diverg&ecirc;ncias conforme evidenciado na mensagem abaixo.<br />\r\n2. Aguardamos retorno.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>THIAGO OLIVEIRA BARROS<br />\r\nAssistente Pleno</p>\r\n\r\n<p>MARILANDIA MOTA HOLANDA<br />\r\nCoordenadora de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n\r\n<p>De: CERATFO08 - Cart&otilde;es Atendimento<br />\r\nEnviada em: ter&ccedil;a-feira, 21 de fevereiro de 2017 16:22<br />\r\nPara: Silva Saldanha, Alexandre; Araujo Rocha, Josemar; De Lima Nobre, Iraciana; Da Silva, Luiz Antonio; Ferreira Rocha, Luana; Gondim Da Silva, Luana<br />\r\nCc: CERATFO05 - Tecnologia Cart&otilde;es; CERATFO02 - Qualidade Cart&otilde;es de Cr&eacute;dito; Evandro Nascimento Almeida Junior; Leandro Caetano de Faria; Fabiano Leal Lisboas; Givanildo da Silva; Eduardo Araujo Mendonca; Thiago Oliveira Barros; Jayme Gilberto Amatnecks Junior; CERATFO08 - Cart&otilde;es Atendimento<br />\r\nAssunto: ENC: Diverg&ecirc;ncia tb_eventos_dac x tb_fila_acumulado NS<br />\r\nPrioridade: Alta</p>\r\n\r\n<p>&Agrave;<br />\r\nINDRA</p>\r\n\r\n<p>1. Solicitamos posicionamento a respeito da demanda abaixo sobre a diverg&ecirc;ncia entre as tabelas.<br />\r\n2. Segue evid&ecirc;ncia extra&iacute;da do banco de dados do dia 14/02 para aux&iacute;lio.</p>\r\n\r\n<p>FILA 74 - CXA_GERAL_INT ATENDIDAS &gt;=0s e &lt;=10s ATENDIDAS &gt;10s e &lt;=45s ATENDIDAS &gt;45s e &lt;=90s ATENDIDAS&gt;90s ABANDONADAS &gt;=0s e &lt;=10s ABANDONADAS &gt;10s e &lt;=45s ABANDONADAS &gt;45s e &lt;=90s ABANDONADAS &gt;90s<br />\r\ntb_eventos_DAC 447 165 150 16652 11140 2040 3482 7776<br />\r\ntb_fila_acumulado 476 167 135 16649 576 2050 3418 7300</p>\r\n\r\n<p>FILA 78 - CXA_GERAL_NAC<br />\r\ntb_eventos_DAC 304 113 173 13503 9503 1422 2371 3454<br />\r\ntb_fila_acumulado 344 84 249 13433 394 1418 2317 3145</p>\r\n\r\n<p>FILA 99 - CXA_GERAL<br />\r\ntb_eventos_DAC 99 29 61 4465 3074 308 655 986<br />\r\ntb_fila_acumulado 106 29 90 4437 71 318 651 892</p>\r\n\r\n<p>FILA 86 - CXA_GERAL_PJ<br />\r\ntb_eventos_DAC 3207 3459 93 11 5255 29 16 25<br />\r\ntb_fila_acumulado 5214 1480 75 6 17 5 2 0</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>THIAGO OLIVEIRA BARROS<br />\r\nAssistente Pleno</p>\r\n\r\n<p>MARILANDIA MOTA HOLANDA<br />\r\nCoordenadora de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n\r\n<p>De: Silva Saldanha, Alexandre [mailto:<a class="email" href="mailto:assaldanha@indracompany.com">assaldanha@indracompany.com</a>]<br />\r\nEnviada em: ter&ccedil;a-feira, 27 de dezembro de 2016 12:38<br />\r\nPara: CERATFO08 - Cart&otilde;es Atendimento; De Lima Nobre, Iraciana; Da Silva, Luiz Antonio; Gondim Da Silva, Luana; Ferreira Rocha, Luana<br />\r\nCc: CERATFO05 - Tecnologia Cart&otilde;es; CERATFO02 - Qualidade Cart&otilde;es de Cr&eacute;dito; Evandro Nascimento Almeida Junior; Leandro Caetano de Faria; Fabiano Leal Lisboas; Givanildo da Silva; Eduardo Araujo Mendonca; Thiago Oliveira Barros; Jayme Gilberto Amatnecks Junior<br />\r\nAssunto: RE: Diverg&ecirc;ncia tb_eventos_dac x tb_fila_acumulado NS</p>\r\n\r\n<p>A Caixa,</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>Estamos tratando as demandas, no entanto o foco est&aacute; na que nos foi solicitado maior urg&ecirc;ncia (tb_fila_acumulado (01/01/2016 - 16/05/2016).</p>\r\n\r\n<p>Daremos o retonor dos pontos referente a esta demanda assim que obtivermos dados t&eacute;cnicos.</p>\r\n\r\n<p>Desde j&aacute; agradecemos a compreens&atilde;o.</p>\r\n\r\n<p>Att,<br />\r\nAlexandre Silva Saldanha<br />\r\nL&iacute;der de Produ&ccedil;&atilde;o/Planejamento<br />\r\n(085) 3921-0128 | 98157-8826<br />\r\n<a class="email" href="mailto:assaldanha@indracompany.com">assaldanha@indracompany.com</a><br />\r\n<a class="external" href="http://www.indracompany.com/">www.indracompany.com</a></p>\r\n\r\n<p>De: <a class="email" href="mailto:ceratfo08@caixa.gov.br">ceratfo08@caixa.gov.br</a> [mailto:<a class="email" href="mailto:ceratfo08@caixa.gov.br">ceratfo08@caixa.gov.br</a>]<br />\r\nEnviada: ter&ccedil;a-feira, 27 de dezembro de 2016 12:08<br />\r\nPara: <a class="email" href="mailto:ceratfo08@caixa.gov.br">ceratfo08@caixa.gov.br</a>; Silva Saldanha, Alexandre &lt;<a class="email" href="mailto:assaldanha@indracompany.com">assaldanha@indracompany.com</a>&gt;; De Lima Nobre, Iraciana &lt;<a class="email" href="mailto:ilima@indracompany.com">ilima@indracompany.com</a>&gt;; Da Silva, Luiz Antonio &lt;<a class="email" href="mailto:luasilva@indracompany.com">luasilva@indracompany.com</a>&gt;; Gondim Da Silva, Luana &lt;<a class="email" href="mailto:lgondim@indracompany.com">lgondim@indracompany.com</a>&gt;; Ferreira Rocha, Luana &lt;<a class="email" href="mailto:lfrocha@indracompany.com">lfrocha@indracompany.com</a>&gt;<br />\r\nCc: <a class="email" href="mailto:ceratfo05@caixa.gov.br">ceratfo05@caixa.gov.br</a>; <a class="email" href="mailto:ceratfo02@caixa.gov.br">ceratfo02@caixa.gov.br</a>; Evandro Nascimento Almeida Junior &lt;<a class="email" href="mailto:evandro.n.almeida@caixa.gov.br">evandro.n.almeida@caixa.gov.br</a>&gt;; Leandro Caetano de Faria &lt;<a class="email" href="mailto:leandro.c.faria@caixa.gov.br">leandro.c.faria@caixa.gov.br</a>&gt;; Fabiano Leal Lisboas &lt;<a class="email" href="mailto:fabiano.lisboas@caixa.gov.br">fabiano.lisboas@caixa.gov.br</a>&gt;; Givanildo da Silva &lt;<a class="email" href="mailto:givanildo.silva@caixa.gov.br">givanildo.silva@caixa.gov.br</a>&gt;; Eduardo Araujo Mendonca &lt;<a class="email" href="mailto:eduardo.mendonca@caixa.gov.br">eduardo.mendonca@caixa.gov.br</a>&gt;; Thiago Oliveira Barros &lt;<a class="email" href="mailto:thiago.o.barros@caixa.gov.br">thiago.o.barros@caixa.gov.br</a>&gt;; Jayme Gilberto Amatnecks Junior &lt;<a class="email" href="mailto:jayme.a.junior@caixa.gov.br">jayme.a.junior@caixa.gov.br</a>&gt;<br />\r\nAssunto: RES: Diverg&ecirc;ncia tb_eventos_dac x tb_fila_acumulado NS</p>\r\n\r\n<p>&Agrave;<br />\r\nIndra<br />\r\nA/C Alexandre</p>\r\n\r\n<p>1 Solicitamos posicionamento quanto &agrave; regulariza&ccedil;&atilde;o da inconsist&ecirc;ncia constatada abaixo.</p>\r\n\r\n<p>2 Aguardamos retorno.</p>\r\n\r\n<p>Atenciosamente</p>\r\n\r\n<p>Marilandia Mota Holanda<br />\r\nCoordenadora de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n\r\n<p>Evandro Nascimento Almeida J&uacute;nior<br />\r\nGerente de Centralizadora SE<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n\r\n<p>De: CERATFO08 - Cart&otilde;es Atendimento<br />\r\nEnviada em: sexta-feira, 23 de dezembro de 2016 18:31<br />\r\nPara: Silva Saldanha, Alexandre; De Lima Nobre, Iraciana; Da Silva, Luiz Antonio; Gondim Da Silva, Luana; Ferreira Rocha, Luana<br />\r\nCc: CERATFO08 - Cart&otilde;es Atendimento; CERATFO05 - Tecnologia Cart&otilde;es; CERATFO02 - Qualidade Cart&otilde;es de Cr&eacute;dito; Evandro Nascimento Almeida Junior; Leandro Caetano de Faria; Fabiano Leal Lisboas; Givanildo da Silva; Eduardo Araujo Mendonca; Thiago Oliveira Barros; Jayme Gilberto Amatnecks Junior<br />\r\nAssunto: Diverg&ecirc;ncia tb_eventos_dac x tb_fila_acumulado NS<br />\r\nPrioridade: Alta</p>\r\n\r\n<p>&Agrave;<br />\r\nINDRA</p>\r\n\r\n<p>1. Solicitamos verificar diverg&ecirc;ncia de alimenta&ccedil;&atilde;o de dados nas tabelas tb_fila_acumulado, tb_eventos_dac e CMS.<br />\r\n2. Pegamos como exemplo a fila 125 CXA_AVISO_VIAGEM em 22/12/2016. No anexo (CMS) e na tb_fila_acumulado constam 668 liga&ccedil;&otilde;es e 3 abandonos, nenhum deles acima de 0-5 segundos.</p>\r\n\r\n<p>3. J&aacute; na tb_eventos_dac constam 71 registros para a fila 125 atendidos com tempo de espera maior que 45 segundos.</p>\r\n\r\n<p>4. Usando o primeiro call id para uma nova consulta, v&ecirc;-se que durante o percurso da chamada as filas percorridas tiveram tempo de espera diferentes. Desta forma n&atilde;o parece ser apropria&ccedil;&atilde;o do tempo em espera na URA at&eacute; o primeiro atendimento.</p>\r\n\r\n<p>5. Solicitamos verifica&ccedil;&atilde;o do script de alimenta&ccedil;&atilde;o das tabelas e confer&ecirc;ncia deste caso.<br />\r\n6. Aguardamos retorno.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>Thiago Oliveira Barros<br />\r\nAssistente Pleno</p>\r\n\r\n<p>Marilandia Mota Holanda<br />\r\nCoordenadora de Centralizadora</p>\r\n\r\n<p>Evandro Nascimento Almeida Junior<br />\r\nGerente de Centralizadora S.E.<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '2017-11-01'),
(7, 'PJ - Clientes PJ reportam o não recebimento de fatura por e-mail ', 1, 5, 3, '2017-11-25', 8, 4, '2017-05-23', NULL, 4, 4, '<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<p>&Agrave;<br />\r\nGEATE09</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>1 Informamos a ocorr&ecirc;ncia de v&aacute;rios casos relacionados a clientes PJ que reportam o n&atilde;o recebimento mensal de suas faturas por email, apesar das configura&ccedil;&otilde;es das contas atenderem os requisitos necess&aacute;rios ao envio.</p>\r\n\r\n<p>Caso 1<br />\r\nCPF............: 67019099068<br />\r\nCart&atilde;o REP: 3391<br />\r\nCart&atilde;o TIT..: 9558</p>\r\n\r\n<p>Figura 1 &ndash; Manuten&ccedil;&atilde;o Cart&atilde;o TIT (FrontEnd)</p>\r\n\r\n<p>Caso 2<br />\r\nCPF............: 03607185743<br />\r\nCart&atilde;o REP: 0888<br />\r\nCart&atilde;o TIT..: 9445</p>\r\n\r\n<p>Figura 2 &ndash; Manuten&ccedil;&atilde;o Cart&atilde;o TIT (FrontEnd)</p>\r\n\r\n<p>Caso 3<br />\r\nCPF............: 94867607649<br />\r\nCart&atilde;o REP: 2679<br />\r\nCart&atilde;o TIT..: 1975</p>\r\n\r\n<p>Figura 3 &ndash; Manuten&ccedil;&atilde;o Cart&atilde;o TIT (FrontEnd)</p>\r\n\r\n<p>Caso 4<br />\r\nCNPJ..........: 12968747000117<br />\r\nCart&atilde;o REP: 6166<br />\r\nCart&atilde;o TIT..: 8929</p>\r\n\r\n<p>Figura 4 &ndash; Manuten&ccedil;&atilde;o Cart&atilde;o TIT (FrontEnd)</p>\r\n\r\n<p>2 Adicionamente foram observados que o problema n&atilde;o esta relacionado a funcionalidade de envio ou a potenciais filtros (anti-spam) aplicados a caixa de email do usu&aacute;rio, tendo em vista que o mesmo confirma o recebimento da mensagem quando esta &eacute; &#39;disparada&#39; manualmente pelo operador.</p>\r\n\r\n<p>3 Solicitamos apoio na an&aacute;lise dos casos citados e nos colocamos a disposi&ccedil;&atilde;o.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>FABIANO LEAL LISBOAS<br />\r\nAssistente Pleno</p>\r\n\r\n<p>LEANDRO DE ARRUDA LEAL<br />\r\nCoordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FREITAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '2017-06-07'),
(8, 'PF - Erro concessão de desconto de anuidade', 1, 12, 3, '2017-11-25', 8, 9, '2017-05-24', NULL, 4, 4, '<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<p>&Aacute;</p>\r\n\r\n<p>CEDEBR805</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>1 Conforme solicitado, segue a sequ&ecirc;ncia de servi&ccedil;os utilizados na funcionalidade RETEN&Ccedil;&Atilde;O.</p>\r\n\r\n<p>1.1 Se cliente for RETIDO ser&aacute; executado o PCSPO217.</p>\r\n\r\n<p>1.2 Se n&atilde;o for RETIDO executa o TIMOBLO. Tendo sucesso no acionamento do TIMOBLO, executa o DESCONTO DE ANUIDADE:</p>\r\n\r\n<p>1.2.1 Executa o TICLANV e depois o WSMO129.</p>\r\n\r\n<p>1.2.2 Em seguida, se o servi&ccedil;o TICLANV possuir valor ESTCUOPOSTADA 02, ser&aacute; executado o servi&ccedil;o OPALIME.</p>\r\n\r\n<p>2 Caso seja necess&aacute;rio informa&ccedil;&otilde;es complementares, por favor, nos acionar.</p>\r\n\r\n<p>3 Aguardamos retorno e nos colocamos a disposi&ccedil;&atilde;o.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>LEANDRO ARRUDA LEAL<br />\r\nCoordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n\r\n<p>De: CEDESBR805 &ndash; Cart&otilde;es:Cadastro&amp;Canais/Monet&aacute;rio/Controladoria<br />\r\nEnviada em: quinta-feira, 27 de abril de 2017 11:44<br />\r\nPara: CERATFO08 - Cart&otilde;es Atendimento; CERATFO05 - Tecnologia Cart&otilde;es; CERATFO02 - Qualidade Cart&otilde;es de Cr&eacute;dito; CEDESBR805 &ndash; Cart&otilde;es:Cadastro&amp;Canais/Monet&aacute;rio/Controladoria; CERATRJ04 - Solu&ccedil;&atilde;o - TI<br />\r\nCc: GEATE09 - Cart&otilde;es; GECOP03 - Atendimento; Thiago Oliveira Barros; Givanildo da Silva; Marilandia Mota Holanda; Leandro Caetano de Faria; Fabiano Leal Lisboas; Marcia Helena Marinho de Farias; Leandro Arruda Leal<br />\r\nAssunto: ENC: URGENTE! INDRANET coleta de evid&ecirc;ncia - erro de webservice no Reten&ccedil;&atilde;o / desconto sobre desconto anuidade</p>\r\n\r\n<p>&Agrave;<br />\r\nCERATRJ04 - Solu&ccedil;&atilde;o - TI<br />\r\nCERATFO08 - Cart&otilde;es Atendimento</p>\r\n\r\n<p>1. Para continuidade da an&aacute;lise, solicitamos retorno com as informa&ccedil;&otilde;es pedidas na mensagem abaxo.</p>\r\n\r\n<p>2. Aguardamos retorno.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>Thiago Ferreira de Ara&uacute;jo<br />\r\nAssistente Pleno<br />\r\nCN Desenvolvimento de TI Bras&iacute;lia/DF<br />\r\n(61) 3448-5669</p>\r\n\r\n<p>Maria Solange Lacerda<br />\r\nCoordenadora de Projetos TI<br />\r\nCN Desenvolvimento de TI Bras&iacute;lia/DF &ndash; CEDESBR805</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '2017-06-03');
INSERT INTO `tarefas` (`id`, `assunto`, `id_tipo`, `id_status`, `id_prioridade`, `data_cacad`, `id_projeto`, `id_categoria`, `data_inicio`, `data_fim`, `id_atribuido`, `id_criador`, `descricao`, `data_prev_fim`) VALUES
(9, 'PF - COMPRA INTERNACIONAL AUTORIZADA SEM AVISO DE VIAGEM', 1, 5, 3, '2017-11-25', 8, 24, '2017-07-06', NULL, 4, 4, '<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<p>&Aacute;</p>\r\n\r\n<p>GEATE09</p>\r\n\r\n<p>Senhor Gerente,</p>\r\n\r\n<p>1 Encaminhamos evidencias de clientes que n&atilde;o possuem PERMISS&Atilde;O INTERNACIONAL cadastradas, no entanto despesas internacionais s&atilde;o autorizadas com o status TRANSA&Ccedil;&Atilde;O APROVADA.</p>\r\n\r\n<p>CASO 1<br />\r\nCPF: 36420328934<br />\r\nCART&Atilde;O: 3295</p>\r\n\r\n<p>FIG01: TELA DE PERMISS&Otilde;ES INTERNACIONAIS.</p>\r\n\r\n<p>FIG02: TELA DE AUTORIZA&Ccedil;&Otilde;ES</p>\r\n\r\n<p>FIG03: TELA DE FATURA</p>\r\n\r\n<p>CASO 2<br />\r\nCPF: 40251462900<br />\r\nCART&Atilde;O: 0178</p>\r\n\r\n<p>FIG01: TELA DE PERMISS&Otilde;ES INTERNACIONAIS.</p>\r\n\r\n<p>FIG02: TELA DE AUTORIZA&Ccedil;&Otilde;ES</p>\r\n\r\n<p>FIG03: TELA DE FATURA</p>\r\n\r\n<p>2 Solicitamos apoio na an&aacute;lise, junto ao gestor do produto, verificando se houve falha no autorizador ou se existe limite de valor para compras internacionais, sem a necessidade de Aviso de Viagem. Caso exista a possibilidade de compras sem a necessidade de Aviso de viagem, por favor, analisar a inclus&atilde;o da informa&ccedil;&atilde;o nos script de atendimento pertinente.</p>\r\n\r\n<p>3 Aguardamos retorno e nos colocamos a disposi&ccedil;&atilde;o.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>LEANDRO ARRUDA LEAL<br />\r\nCoordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', '2017-06-30');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `periodos_entrega`
--
ALTER TABLE `periodos_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
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