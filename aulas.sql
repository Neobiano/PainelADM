-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24-Nov-2017 às 18:17
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
  `cor` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `periodos_entrega`
--

INSERT INTO `periodos_entrega` (`id`, `nome`, `inter_ini`, `inter_fim`, `cor`) VALUES
(1, 'Semana da Entrega', -7, -1, '#eee710'),
(2, '7 dias de Vencido', 1, 7, '#de4294'),
(3, 'Mais de 7 dias de Atraso', 8, 365, '#e94343'),
(4, 'Entrega pro poderoso', 366, 100000, '#100707');

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
  `cor` varchar(50) NOT NULL,
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
(7, 'Esperando na Janela', 'N', '#798a31', NULL),
(8, 'Em Execução', 'N', '#37e1d6', 'N');

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
(1, 'Primeira tarefa', 3, 5, 1, '2017-11-23', 9, 3, '2017-11-20', '2017-11-23', 4, 4, '<p>&Agrave; Caixa,</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol>\r\n	<li>1. Solicitamos verificar o retorno abaixo, pois ao realizar redu&ccedil;&atilde;o de limite o sistema apres<u><strong>enta a cr&iacute;tica &ldquo;MPA0002 - CAMPO OBRIGATORIO&rdquo;</strong></u></li>\r\n	<li>2. Qual orienta&ccedil;&atilde;o devemos informar ao cliente, visto que foi feito v&aacute;rios testes e n&atilde;o &eacute; poss&iacute;vel reduzir.</li>\r\n</ol>\r\n\r\n<p>Att,</p>\r\n\r\n<p><strong>Luana Ferreira Rocha</strong></p>\r\n\r\n<p>Analista &ndash;&nbsp;BPO</p>\r\n\r\n<p><a href="mailto:lfrocha@indracompany.com" style="color:#0563c1; text-decoration:underline">lfrocha@indracompany.com</a></p>\r\n\r\n<p><u><a href="https://webmail.indra.es/owa/redir.aspx?C=opUz3Vnlz0yUS4EweMfdwtYuFaA5ZdJIa0fyBQQvyK2gznjuvvSVWAoCiCimVLaXMqrj7fsXCFA.&amp;URL=http%3a%2f%2fwww.indracompany.com%2f" style="color:#0563c1; text-decoration:underline" target="_blank">www.indracompany.com</a></u></p>\r\n', '2017-11-15'),
(2, 'CAMPOS INVERTIDOS NA FUNCIONALIDADE VALOR ANUIDADE - FRONT END INDRA', 1, 1, 4, '2017-11-23', 8, 5, '2017-11-21', NULL, 4, 4, '<div>\r\n<p>&Aacute;</p>\r\n\r\n<p>INDRA</p>\r\n\r\n<p>Prezados,</p>\r\n\r\n<p>1. Encaminhamos tela do Mind4Card, da funcionalidade Valor Anuidade, na qual consta valores invertidos nas colunas &ldquo;VALOR TOTAL&rdquo; e &ldquo;VALOR PARCELA&rdquo;, conforme evidencia abaixo</p>\r\n\r\n<p>2. A consulta em quest&atilde;o se deu para o cliente CPF 269.878.888-76 (Luciana A. Fumoto) cart&atilde;o 5411.</p>\r\n\r\n<p>3 Solicitamos verificar o retorno dos campos relacionados aos servi&ccedil;os, realizando as corre&ccedil;&otilde;es caso necess&aacute;rio.</p>\r\n\r\n<p>4 Abaixo segue servi&ccedil;o e campos a serem utilizados nas referidas colunas.</p>\r\n\r\n<p>4.1 Servi&ccedil;o: TICL129 (SAT)<br />\r\n&bull; Valor Total &gt; Campo: IMPCUOTOT<br />\r\n&bull; Valor Parcela &gt; Campo: IMPCUOPER</p>\r\n\r\n<p>5 Aguardamos retorno e nos colocamos a disposi&ccedil;&atilde;o para demais esclarecimentos.</p>\r\n\r\n<p>Atenciosamente,</p>\r\n\r\n<p>LEANDRO ARRUDA LEAL<br />\r\nCoordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS<br />\r\nGerente de Centralizadora<br />\r\nAtendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n</div>\r\n', '2017-11-30'),
(3, 'Avaya Recorder - Falha na Gravação de Tela (19/09/2017 - ID: 1117941505822410) (RM #120)', 1, 8, 2, '2017-11-23', 8, 5, '2017-11-23', NULL, 4, 4, '<p>&Agrave;</p>\r\n\r\n<p>INDRA</p>\r\n\r\n<p>Prezados</p>\r\n\r\n<p>1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Segue evid&ecirc;ncia de atendimento sem grava&ccedil;&atilde;o de tela no aplicativo <em>Avaya Recorder</em>:</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Data: 19/09/2017, ID: <strong>1117941505822410</strong></p>\r\n\r\n<p><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAccAAAECCAIAAAAEu4viAAAgAElEQVR4nO2d21cTWb7Hzx/Sj/M+D1mzZh7OmvM0a8TITZue7vTNcTndat+0pe9NTbdte+mRwYmIIshEARHBtkdtFe9xRMJVBEISCAlNuCUkgASSctaaVedhJ5Vd1xS4E0S/3/VZM6Gya9/3t361q2L/T3h+CQAAACv+Z9VrAAAAzxNwVQAAYAlcFQAAWAJXBQAAlsBVAQCAJXBVAABgSRpX9U7NbzvT8X9lt/639CYAAIC0pHHVHQ2dq15FAABYQ6Rx1Rvu6fnYf36JLEVe+hUAAIC0pHHVVa8fAACsLeCqAADAErgqAACwBK4KAAAsgasCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEvgqgAAwJJMuapg50wmi80vrHoLAQAgm6zcVQXBb7OYkpIbqJ0zcXYVSxXsnMlk4uyJs1XTgBeExAyy2PxCZqeB4LdZOPuqtxe8IKzQVROmmFwP4h9pyxNdddVbDlYdv81islgsGb6nES/gq95e8IKwUlfVvsEnvkkkuqcY1nKcSqyq/FYrH/DcICTmkN1mMVlsfvE4fQeknD+p6UHNH/H+J3Gt5ziLmJS+o7LY/IKAeQUyzQpdVSs4pUJYIXWzn5r1iSlNu6rOt7J8Vr2zAEPEC7M4ESLS+ZP8XtA5qOqqJCylThJLwLwC2YCxq1LzN7UEJAcV+6qq36rms+qdBRii6o90aCkOv/pBnVjV5o9Qrk27KuYVyAJPswOgcp2HqwIjSO7Dk36p9i1lrbKDcFXwrML4aZXiDit18Ol2APCS1nOF7F5HaYvK+aN9MHnbb8BVMa9AFmD/ZhWeVgF9ZJfkSHKsiRvKZhVJoHowOUEsFl1XTaXE0yqQFZ6t31YhfAAArHVW31UlIS/2uQAAa5zVd1UAAHiegKsCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEtW6Ko8zzudzu7u7i7oBVB3d7fT6YzH46ym3X/+8x+Px4P5Az2XWqGrOp1Ot9vthV4Yud1up9PJylU9Ho/f7w9D0POoFbpqd3f31NTULPTCaGpqqru7m5Wrdnd38zwvQNDzqBW6aldX12ovcyjb6urqYuWqXV1dqz3zIShTgqtCRgVXhSAjgqtCRgVXhSAjgqtCRgVXhSAjgqtCRgVXhZ5ODmtRkdUhOKxWx2pXJaNi5qq3DhURHbq1Kkseyrgy7qqB88VFmVlvgfPFRZSYFuKwFp8PsKmYRkYOK6lx4HxxBu1IUpWMlOOwWh2B88XLyz199zqsRVKpZZ/sQ30FzltThdGnpDqHqk0idbJ88ZsAI1e9dSjppqlP0HOmTLuqw1pktT6NRemtFsqPAueLWRbytK6afrFnwVVlFzSHVcvhsy7D3avvm0ZclerfhFMm/qR7J5URMVWxq5IfAueLme8AwFWfW2XYVcnySU3a1HJK2mAqKLE6ZPO7OHlEPVzRcFUxfSrMkMYksgwD54uLixOxVvKr1IVAlhud2MhCpjpC1graVa2ywEivycXFxQYTa3iOWnvFzk8zOmk7U68+BrpXIUkbFInpeZV2kgTOn3dI/05dh0UXJaZKfZUogrGrkk2AXXXO7C94KAvKqKuKUzg1l2UhmnKSJ49oJqBzL6JEklHLMJUD7RXF8gglFbNIFmnSM6S5GdrPUN52q7SC6ogisZMkPaDe5MQBA4klHpmqjaRA2blGRofuTKtVKwdB6eoGulch9eyoC65W9yo7QVkO1S0Jm0/c/lOJUlOY/dMqZ90uGOtzqUy6qnRvLBWdWB3SkFSagsxjnQTKBaLmH+IJ0nUlWb0Oa/H5gLgQ6a/IScrclBsN0ttKZRmKFVykcNWUb6QsM12TDSRWxKrihUElipfUSrvzFbfusgTK7lXtFa3uFeRSrQlVm3STRDEU6u6d6JPkDqwyVhWYPa26dUh0Urjq86oMuqp0VYt/kVveYvn0lYRh+glUl6kYb8oXp+xOr6hIFv1I9g4UkZfSRNLvCKotZUUrNF3VYJPTJxYC54ulz2GKJe1dSecrOlNlyyB9rKrZvQpJslMkTt2ea3aCTqyqiJ1Tj7UU+6qCw8r+HQBsqz6vypirqszvVDBKL8ZkiJG6m6Sfq6gnkC8Q2UIQJfo4fUBlX1XqukVFxcWKXdqiIqkF60gZD6m0QjtWNdbk9IklLZL0hiLKld7K63a+pDPVEhjYV9XsXoXU91WLZJvwhieJ4l5FOhGk7wqQDMVDeF8VMqpn8X1VQ9YFrZ4k/vOMS2PDdvmCq0JG9ay5auB8seYDYeiZETOvyoIYXQPgqpBRPWuuCj37kmyovjCCq0JGBVeFICOCq0JGBVeFICOCq0JGBVeFICNauatGIpHVXuZQ9hSJRBj+F1a6urr++9//rvbkh6CMaIWuOjAwMDIyAmN9QRSJRPx+P8P/GqDL5ZqYmICxQs+lVuiqS0tL+C9Xvzgi/+XqpSXN+bBc4vG42+3G/IGeS63QVQEAAKgCVwUAAJbAVQEAgCVwVQAAYAlcFQAAWAJXBQAAlsBVAQCAJXBVAABgCVwVAABYAlcFAACWwFUBAIAla9JV/TaLycTZBTtnsfkFYdXrAwAAIit0VcFvs5hS4uyMrU1IGqfqt3aOswt+m8VksflXvQcBAIDmqVyVswuCQD5abH7EjAAAwMJVBcHOmRJho2DnlAEsHdeqHOTskZd+lciE4yzkEBWrylJGXvpVqpDkDoBquQAAkH2YuGryD/pgwmmpUJY6pvatnaNdUsxKmdLOaWeSyAbGCgBYLVi6qnSvNRE2CgIdawpSG6aVsENZ/mop6SyVaVKBMwAAZB+WOwB0yKiQeIvO2bVdVXRDHVeVRbdwVQDAMwULV1W7E099L789lxii7JDSVZUpxQMkYBU/yYpY9Z4FALyYMH6zSpA+SCIH6bSib6YOSu2Qzl/+tIoybJPJZOI4/adkAACQfdbArwCSNsrZ8cI/AOCZZw24aiTx3hXu6wEAa4A14KqJm3v8OBUAsBZYA64KAABrCLgqAACwBK4KAAAsgasCAABL4KoAAMCSFbrqIwiCIEhNK3dVHoIgCFIIrgpBEMRScFUIgiCWgqtCEASxFFwVgiCIpeCqEARBLAVXhSAIYim4KgRBEEvBVSEIglgKrqqpmzdvrqHM2WaY0bavXT2X3fIMNmqtVymzrhqPx3meDwQC8/PzsuOTk5MzMzNpcwiHwz09PT09PQ8fPuzp6RkeHjbeNlpOpzMYDHZ2dv4pqc7OzmAw6HQ6tU7R6sdQKNTS0rK0tBSLxVpaWq5duxYOh3men5+fb2lpuX79eiQSSVuf7Ljq4uKiz+cb1pDX6/X5fIuLi8ar9+jRo3/+85+NjY1nzpxpaGhoaGg4c+bM5OQkGejnXssdtVgstoJSYrFYNBqNRqNLS0vRaHQFOSxLOo2Kx+PiyMalMp5/LBZbWloip5DPtFSzMtLPi4uLjx8/Nl6Np5TBXiLKhqt2dXV1d3cvLS2JNYhEIg6HIxAIpM1hcnLS5XItLi4uLCwsLi66XC6n07ncNexyud5///2hoaFNmzYVFBTk5uYWFBRs2rRpaGjovffec7lcqmep9mMwGLTZbMeOHWtubg4EAlu3bj1+/HhNTc309HRDQ8OxY8eOHz8+MTGRtkrZcdXR0dGDBw+eOHHi+PHjlZWVx6WqrKw8ePDg6Oio8eo1Nzfv2bPnxo0b165da2lpaWlpKSsrs1qtRpr8HEh/1Hw+n9vt9ng8Xq93eHh4amqKX6axEqP54YcfCgoKNm7cmJ+fb7Val1vJkZGRwcFBcUTcbrf454ot7Gnk9Xp7e3vn5uZ4nh8bGyPhUXd3d3d3d09PjyzeSlsl0danp6d9Pl88Hl9cXNT3aB1NTEwYHKBnLlYdHBxsbW3t7+8nYdHc3FxbW1tbW1swGEybw9TU1NDQkJhVPB5/9OiRz+fjNaaIqurr68vLy2Ox2I0bN65evXrlypWrV6+2tLTEYrGysrJTp06pnqXaj11dXVu3bh0ZGXn99dfb2to2b9786NGjLVu2dHV1vfHGGyMjIyMjI0YuofqDFA6Hg8FgKBSKxWKxWCwUCgWDQRIRLyvDjo6O999/3+Fw1NfXX716tYuSw+Ho7OzcsWNHZ2en8eo1NDScPHkyFostLi6Sye3xeEpLS48cORIIBJYRxXjrtq87cNdQ0mdIWt1CIoaPP/44Pz8/Ly9v06ZNL7/88l/+8pcHDx7wy5moPM/Pzc3ZbLaioqKCgoLS0lJyc2YwB1KNHTt2vPLKK6dPnyYHX331VfFP4/clJKubN2+WlZXFYjG/33/y5MmqqqrKysrq6uqTJ08ODg4aqdL4+PjBgwd37959+fJlnucfPHhArvHHjh2rqKg4fvw4ufYYqRLphJmZmcePH4fD4UAg4Ha7Z2dnJycnp6enp6amJicnSbXTSrTmR48eLSwsiKYci8W0ulpnwfb29trtdnrVZ2NfdX5+vrW1tbW11ev1RqPR7u7uBw8e9PX1Gbm2iK4qKhaLGbnFptXY2FhdXR2Px5eWlhaTIgNw4cKFlpYW1bNU+7G1tfX111/3eDxFRUWtra1/+tOfamtr9+/f39fX9+qrrz558sTgAtAapHg8fu3atYMHD1ZWVp44cYLcZZ84cYLEldeuXVvWqLe1tZWWljqdznfeeecf//iH7PYtHo9/9913HR0dxqtHKkO6kfxvPB4fGRnZt2/fuXPn+ORqTMlbt31dQtvrvPRhVU+9e4CkuntgBZ5LlSUrTl9364wm1XfVQ4cO5efnv/fee1euXGlqasrNzV2/fn1vb288Hl9WxBqPx7dt2/bOO+8YP4Wuxu7du/Py8i5dukQObt68OTc391//+he/HFcldR4dHd2+fXsoFAoEAs3NzU1NTY2Njc3Nzc3NzV6voT6z2+35+fm5ubnbtm3jeb6np+fs2bMNDQ319fVkE0k1tNJx1cnJydnZ2ampqUAg4PV6JycnPR6Px+MZHh4eGRlJu2FCMhkbGyNGPDg4ODMzMzQ0NDQ05PF4BgcHSUxtsEoLCwvl5eWFhYV5eXlbtmyZnZ2NxWILCwtZelrl8/na2tocDkdfX19ra2tHRweJvNJ6EOk1nufD4XBvby/5h7b6+/u1bttV1dDQUFVVxfP87OxsR0fHzZs3b9y4cePGjVu3bt24caO9vX1hYUF5lmo/9vb25ubmNjY2rl+/vr29/eWXX25ubv7www87Oztfe+01Iy3SyZzn+aGhoc8++6y5ufn06dM2m+2111577bXXbDbb6dOnm5ubP/vsM9k1Rj/Dtra2H3744c6dO++9996XX35JdrXItl04HI7FYiUlJct11crKyng87nK5/v3vf5MLJM/z169f37dvH8/z0ml990DK3AxFp0lXXZG0rJpdmfquWlpamp+f//3335ODr7/+utlsvnXrFm94H4AkGxgYMJvNH374IdldNVa1VDV27dq1fv160VXfeOONnJycCxcuaFVDp1HxePzDDz8MBoM+n+/48eMVFRXl5eVkm2tgYMBIlVwuV3Fx8fbt2ysrK3mef/jw4blz586dO9fQ0NDY2NjY2BgKhYxXKRqNiiHh2NjY0NBQKBTy+/2jo6MzMzMGl148Ho9Go4uLi9FodGBgIBwO+/1+n89HHv9ojZRqlVwu16ZNm8xm87p163Jycn766See51taWrLhqqS1Xq+3tbX1/v37ra2t5AJlpBempqbcbnc8Hp+YmBA3WKPR6ODgoNPpNDhZSYTF8/zQ0NDLL79cXl5eVVVF7mgqKiosFkt/f7/yLNV+bG9v37hxY3t7+x/+8Ie7d++uW7euqalp27ZtfX19n3/+uc1ms9lspHVHjx4lQVNTU5PBzMnx6upqq9V66tSpc+fO1dbW1tbWnjt37tSpU1artbq6WudE1dp+88038/Pz165do69Dra2tZAaswFVPnjw5Njb2zTff1NTU3Lx586OPPnK5XK2trcRNaBfw1m1X9au7B5LxZNIEk0cOHJDHqmL8KX6lcnqqPIWryhN767Zv376dimYTCQ7cpRNr2WzaWDU3N3fXrl19fX1Hjx4tKCgoLy/nlfG7tkgsWV9fn5+ff/bsWX6Zuweiq5rN5osXL5KDb7zxhtlsJrGqak20GkVuRLZt2zY2Nvb48WOyu+X1esmH2dlZI1WKx+M9PT3Xr183mF6nSrFYbGRkZGhoaGZmJhKJBAKB4eFh4qp+v39iYiIcDhvvauLm/f39kUhkdHR0dHR0cnJyuVUaHx9/8803zWbzH//4xw0bNpA+9/l8GXdVcT80EAg8ePCgtbX1wYMHCwsLBvfgJicnyb3G5OSkbIO1r69vbGzMSB3EWLW3t3fv3r0ul4s8qzl27Fhvb+/f//73trY25VlaV6eamponT54cO3bM7XZ/++23R44c6ezsHB4efvvtt3Nycvbu3SsOz9GjR1UtVStznuevX79eVVV14sSJsrKy8vLy/fv379+/v7y8vKys7MSJE1VVVdevXzeeYUdHR0lJCc/zk5OTg4ODJPrweDxbt259++23iTm2t7cbr15DQ0NNTU1NTc2GDRt6e3sDgcCf//xnjuOuXr26f/9+XnqPqR47Ujf3iY+pI2JsmzhE+XLyK+XpdHmpDYCkTcoSp3IUP6nsOmhFvfquevDgwfXr169bt85sNhcWFq5bt+7atWtGXnQRRXqvqqoqLy9vBQ8ASTV27txpNpvJPmY8HifLfgWuKj5q1ropNiKykyBeaxcXF+elMv4ALRqNPnr06OHDh0NDQ6Ojo+Pj4+SRIP1aS9rQfm5ujjy+6+zsDIVCsh0Al8ul+vRMq0rxeNztdtfU1JBNgOnpaXIwG666tLQUCATu37/f29s7ODjocDg6OjqCwaCRC0swGOzo6PB4PBMTE6KrEoVCIbI5kFZirNrX1/fVV18NDQ1dunTpypUrly5dcrlce/fuNe4ssViM3IPMzc3FYrG5ublgMDgwMLBjx47f/OY3R48enZiYMHK10JrKXq93586dtbW1P/74448//rhly5YtW7aQz7W1tTt37tTaz9KKVUtKSqLRaE1Nzfvvv9/R0TE2NvbJJ5+YzeYNGzaUlpZ+8skn3d3dxqvX0NBQXV3d0NBQUFDQ3t7ucrnefffdb7/99tKlS8RVJdNadm/tvXvXKzWsuwe213npIzKHo32TfKU8PRVsKrxQmZg+lCpre51XviurHq7qu+rf/va3vLy8jz/+uL29/erVq5999llhYWFdXR2vsaGpqmg0+sUXX2zYsMFgemU1Pvroo9zcXHLLz/P8W2+9lZOTQy7Gy3LVYDDY09Pj8Xji8Th5wbG7u5u8z9PT00McxEhz7t+/f/HiRb/fz/O81+u9d++e3W6/c+fO3bt37Xa7agyrVaWZmRlylSJR2vDw8MzMzC+//DI2NkZ2ANIuvaWlpXA4HAqFXC7XwsLCwMAACXvHxsbGx8dnZma0TEnLVePx+MzMzObNm3ft2kVKX1payqCrkjKCwWBfX19bW1t7ezvxo2AwSCJWl8uV9tpCnk2Fw2HZywA8Fb2m1dmzZ6urq6PRaG9vL8dxPT095eXlZJOovb19//79DodDeZbOU79oNHrq1KmmpqZ4PN7b2/vOO+/8+te/Pnz4sMGpppP54uLivXv3SktLrVbrkSNHyNOqI0eOWK3W0tLSe/fuaa1P1QwdDseePXu6urrefPPNvLy8zZs3Hzp0aP369Tk5OSSkWr9+vdvtNl49EvUHg8F9+/ZVVlZevnz5yy+/9Hg8t2/fNrKvur3OqxurUvHjymJVWYSpGqtquKqR/VUj+6p79uwhi83hcBQVFZGNESMBBAnrPB5PYWHh119/vYI3VcWNiMLCwm+++SYajfb09JjN5o0bN5LXZpa1r+p2u+vr63fu3Dk3N/fLL7+cOXOmrq7u9OnT5EGTwYDG6XRu27bNbDaXlpbyPH///v2jR4+Wl5cfPnyYzHDV+26dpTc/P08CXuKq09PT5DkV2QEwsiVIRofcLvf19YXDYbKnMT4+rmPKWu+D8zxfVVWVn58vbvhmNlYVt96Hh4fn5uYePnw4NjYWj8eHh4fJ+2tdXV3j4+MGe2Fqasrj8cSSisfjxl21rq7u8OHDpDJfffWV0+msq6urr6+vra3t7e3dt2/fClz1rbfe+v3vf2+z2d59912TyXT48OFgMPjkyRMj9dHPfGFhgQyzz+cLhUKhUMjn85Ejqk/VdDLs6en54IMPvvjii9zcXLPZnJOTs2HDBjEcM5vNZrN5ua568uRJnufdbrfD4SB3UjzPq+6r8rz6OwDa+6rbt2/P/L6q0lVle6xqeet3C7Gzw4cPb9q06dNPP3W5XC6Xa+vWrYWFhdXV1SrdohBZLCUlJeSJeUFBwa5du/jl/44gFosFg8EPPviAvJG9cePGvLy8gwcPkuczqqdoNWpwcPDkyZNFRUWzs7MjIyMVFRVHjx61Wq0VFRUVFRUGn1bZ7XaLxWI2m3fs2MEnn1Y1NjY2NDScPXt2WU+riOWNj4+Hw+GJiQmyA0CepPl8Pq/XOzQ0ZPAdgImJCRL2Dg4OhsNh8n4x+V2M1muRWr304MGDDz74QHazm/FYdWRk5NGjR+FwuK2tjbz2PzQ01N3dPTc3193drf8OJp3P1NSU7OaXbIikPZ3neY/HU1xc/O233/b09JSUlIyMjPz0008XL168cOGC2+3eu3ev8X1VoidPnly8eDEvL+93v/vdb3/722VFqWkzJy82E5ErCv3nsjL0+XzFxcWff/757t27i4uLd+/eTT6I+vTTT5f7K4C//vWvV69evXz58s8///zzzz9fvnz5ypUr5MUv3oB9LEvSWHX132/Vd9Xdu3cXFhYWFBQUFRW98sorOTk5Bw4cIHM+7Z0pcc/Tp0+XlpaWlZUdOnSI3MIv97V2osXFxZ9++qm2tra+vn5gYEA/UtZq1IULF77++uumpqbFxcXp6ek7d+7cvn375s2bt2/fvnPnjpGf8PA8HwqFKioqvvvuu3v37vE87/P5yMOV+/fvkwfXqpu2+gENeaWPbAlGo9H5+fnHSRnsrpmZmdnZ2bm5uf7+fvLG60RSWoGLapWmp6evXLni8/noi18wGMzGvurw8LDT6aRXr8fjcTqdBp81kZ4KhUIdHR0DlB4+fGjwB6zkNeaHDx+Ojo6+9dZbX3zxRUlJCcdxJSUlX3755ebNm1VvZ/Rf1H/y5MmNGzfefPPNQ4cOGfk5w7IyV75YmnbPSGsXOKIr8oad8er19/fX1tY2Nzc3NjaSoOPs2bNNTU1nzpy5c+cOv9LfaGorFes+xStXzKT/YKe1tZX8wIT88Iy8c5Y1kVD08uXL33///XfffUfcuays7MCBA3v27Nm3b19PT4/qiVqNun379ueff15aWvr48eOlpSXZzDG+Uzw3NyfGHHGFllUlWpFIZLmhjChysxuPxwcHB4lNp/11ltb6IqfQ161YLLZm/nUVYhAzlMLhsMHIiPQg6crZ2dmZmRnya6VQKESuWstyFlFPnjwpLy/v7+83fuNvPPPVzVDnhcGxsTFyuzSU1PDwsN/vX9arM2tUBq+FRoxDVeSH/+I/ArCsupGC/H5/V1dXZ2enw+FwOBxtbW0dHR3k13Ra136tRoXDYY/H43a7yepYWaNkKZX/DsCyqsRcJLw10i79m0vZkTXjqhAEQWtCcFUIgiCWgqtCEASxFFwVgiCIpeCqEARBLAVXhSAIYim4KgRBEEvBVSEIglgKrgpBEMRScFUIgiCWWrmrQhAEQUqt3FW1vgIAgBcZuCoAALAErgoAACyBqwIAAEvgqgAAwBK4KgAAsASuCgAALIGrAgAAS+CqAADAErgqAACwBK4KAAAsgasCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEvgqgAAwBK4KgAAsASuCgAALIGrAgAAS+CqAADAErgqAACwBK4KAAAsgasCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEvgqgAAwBK4KgAAsASuCgAALIGrAgAAS+CqAADAErgqAACwBK4KAAAsgasCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEvgqgAAwBK4KgAAsASuCgAALIGrAgAAS+CqAADAErgqAACwBK4KAAAsgasCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEvgqgAAwBK4KgAAsASuCgAALIGrAgAAS+CqAADAErgqAACwBK4KnkX8NovJxNkFYdVrAsByyZ6rCoLfZjElZLH5M7xgqMJMnF29LEGwcybOLgjiB60EkZd+ZbdlvM4G+pCqD0f6Ub3mT08yf80+Efw2C2d/ylZISkz2MElgs1ksNv/KssryWFCdptJjTzcKjDNUKcLAxM5CNYxXRqt6DCfDUy72LLqqnTMlFyFpfebGRvDbLBZxiSb+UElmeBgEITFwmavz8hqYYTfRyf/pXdV4D/v9aVz1WWPNuarBiZ0dV13xKmNbvadf7KuzA+C3WTLuqmpxlp1Lha8RjVg1FeRabP7k8cSJnF0lE7/NwnFc8gy7+CkVUVKJk3/TzRfnhHgxEM8iwZrfZrFYyB2xtD7UEUXNBVnRVCaCVocojtNlKTqNarhWe1MjQuco5iBthrKHSfN1elh74OTV1pqHOqcIyS5LFafWCrq7uORQao9g+lL0M1Q2R5aYvtrZNeojP1dtYhuphup8XnGyNHMgXS+pzkydJamVs36fpBxGnPyK9bUKrkoHrZmDnr2poSUWKlnWElcVfS350ZZKQI6TC4JAJfXbLKlMEvMmZX7SEpO5CHQUJnZIIm/qLHKElBBRuwxo1pzjZPUUM5HODEkaae+lAlJJe+mvEnWgukIjQ7rhYg7yg9LsU4Xr9LDh5qvMENkpFot8eqQSJD6ptoKqsJ0T16XWCKrOH2kp+hnK7vNUEitcVVkfyUArumPDUCUAAAfiSURBVF0xezWroTOf0ydTnVo6cyBtL6nMTL0lqZmzdp9IKk8VLxliO5dtVyWtzLSlKgu12PypQUz1m8KbxPEX6M6UfCHfHk5OYnGYxCFUKTF5Mh0ypOZeci2bKJGaJ66rOq4qr7m8nmImNLI0Kq6qbK/aDkBq2WhlSDVcOvupg+JFStp8nR423nwVV5Weoj5YsgaqtYI+UTrIKiOo7HNlKaoZyupGj6AssWqGsvooXVVZhJFqqM5ng8lUusLAHNDpJeXMVF2SaXPW6RO1S0Kqu8T7kmw/rcrojT+9YOgHYlqRo37EJ9g5E8fJXFUey/r1hlCtRMmpkonIJYZN1SDSu6qs5uItMhWrKue0LI3SVVXaq+2qOhmm5iKJ+ajOkAeCiuYbctV0zVeZJIpTVGJVxWVDUmF5rJoKo7RGUGf+RFRCS2VcphOrKoPfVIypvKDKXFU3VtWshrRDBEWV9JKpT610c0Cvlwy4qqGcVxqrius3e65K3ZDLw5NMGCt9URKnlHy7R+FN0hNT8WNqpaa+Tt5lag+hskTxT9nVRfBLNoLpvpIMmLarymuuqKfSVQVFGqWrKtPoxaraGdINp5et9KBif9Nk0u9h481XnWzSsRbk00PRQNVWUK2zWJIOrjmC2vNHLCVNhpr7qonE1DCo7YdK5556t8v3VTWroTWfjSTTmFpp5oBOLxlxVWVXqLuqdp+kKq/cV02uL7yvCl4IMnoJf0bI2vtPgPZiJXBVAJ4T4KpZA64KAADZA64KAAAsgasCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEvgqgAAwBK4KgAAsASuCgAALIGrAgAAS+CqAADAErgqAACwBK4KAAAsgasCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEvgqgAAwBK4KgAAsASuCgAALIGrAgAAS+CqAADAErgqAACwBK4KAAAsgasCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEvgqgAAwBK4KgAAsASuCgAALIGrAgAAS+CqAADAErgqAACwBK4KAAAsgasCAABL4KoAAMASuCoAALAErgoAACyBqwIAAEvgqgAAwBK4KtBE8NssJs4uCKteEyBDEOycyWLzr/7QCIKdM5k4u2DnMFUSZNVV7ZyJiLNno/czZwp2bnUmtN1m82d44tJF+G0W/ZEi/SAIdi5dPwuC32ZJjL7JkipCdq4g+G2czU9WajKp7HSLzZ/9nlc0J32TM14HO6ffFcZH52naK9g5zu63WUwmzr7q45KJBq4gk+y5KimRVQOMYOdMHJdm5q0051VwVUFILJNnpwjj/SCOfmJc7ELiYOIim3RVYqqJOEwMyMTroyCaRJY7X6WjVttVGY4OYDugq7ADkJ0ZmTSIVFlUvEPMVhD8NktqqSemoBhQExfw2ywWi4Ws/ORXidOViQW/zcJxXDKksoufBLXEYnaUR6gVl4jORAvSq2Tyk065NLKvVItQXpZk/UAPqE5ZdBs5uyAIfpvNnhiDVHTM2fyC32Yh+Yo5U0cSTqvaCtlxwUBvqI4CqSQdWcvP0m1ymnOfepIYG1P56NBZ0XWgr3ZaRdPt1W+dTt2MFKo6/9PO27S9RCaGLJm0IZoDqrMktTLJtquSamXhJi65dAXxNla6VtVdVRBPSy5kEiVFktGW8nQ6MRVTJTabIsnQjDo98TF5gyb4/X662orixHJkt3SprFJnpRqZ/KRILJ3l0vqrFSHbB1DpB/GQIkPluNBBayRxqaMue5y0XwV6GJNTXXr/oVdVA72hOgq0iycWlfQs5f+rXgH8NouF45hPEp1+1hkdOis6+DdStGSI9VunP99kheosN0Nt1O0lxcSQ9wDdEJtNaw7rLUmNTFbnaRWpTOYslb7O0RfVZJ8Ido1YVVDs/4lVpZa6oJVYzJA2C9H4xNMT5ydPpruCLk6lBTIzT2YlnqVskTKxbCAkJVBFyEqnT1H0Q6prZRnKxoW4iHSkKFf127hk22WxKi3Z5NGpqpHeUB2F1ADTS0jSZoUtiF9Jz83EJFEOnKHRobISFOn0i6avIvqt05lvykJVT1cJA7XbqL+U5CuIbpG8IZpzWG9JamSS1X1Vur8y66rSgEicsiqxauJQ4oj82kP1qbTb1RPrLBiVoEaQnCrrGeX01Y9VtVxVJ3ZQqT9VhNYAKftBK0qTxBfJQEWeG9VRJFJNFCFmLG+yXfbsW6+qBnpDdRTkOw4m08piVXJuhiaJej9rj44kKwOxqrRolVhVvXXLiVV1lpuxNuoOosoKkvYA3RCO05rDektSI5PVeQcgtTlF9QIzS1UdBvpSldpyUhxJXY8SNzf0BSBZf4vFop5YZ8Eomy/+qXQ6eXel9rbUN7N0XFVZrnSWS+uvWoTmdlWyHxTRkJihytBLYwrJPT6XmgxiEeI4qnaXakfpuKrBUYhIApOE58inrsY2nPzcDEwSnX7WGR06K8GffotTkp5qr37r0sw3aaE6y81YG9MMomxiyJJJh1hzDussSa1MXqD3VZX3lateJQBWBfp6s7LTueXfaz5loWuIF8hVJZehZ+CdRwBWi6c3OH+6d5kzUeha4QVyVQAAE8R9olWvybMJXBUAAFgCVwUAAJbAVQEAgCVwVQAAYAlcFQAAWAJXBQAAlsBVAQCAJXBVAABgCVwVAABYAlcFAACWwFUBAIAl/w8PViTLloI+lgAAAABJRU5ErkJgggA=" /></p>\r\n\r\n<p>2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Solicitamos verificar a falha sist&ecirc;mica, considerando que todos os atendimento precisar realizar grava&ccedil;&atilde;o de tela e voz.</p>\r\n\r\n<p>3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Aguardamos retorno at&eacute; dia 21/09 e nos colocamos &agrave; disposi&ccedil;&atilde;o para os esclarecimentos necess&aacute;rios.</p>\r\n\r\n<p>Atenciosamente</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>LEANDRO CAETANO DE FARIA</strong></p>\r\n\r\n<p><strong>Auxiliar Operacional</strong></p>\r\n\r\n<p>LEANDRO ARRUDA LEAL</p>\r\n\r\n<p>Coordenador de Centralizadora</p>\r\n\r\n<p>MARCIA HELENA MARINHO DE FARIAS</p>\r\n\r\n<p>Gerente de Centralizadora</p>\r\n\r\n<p>Atendimento em Telesservi&ccedil;os Fortaleza/CE</p>\r\n', '2017-11-01');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
