SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `bdcpmhconecta`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `abasmidias`
--
-- CREATE DATABASE `bdcpmhconecta`;
DROP TABLE IF EXISTS `abasmidias`;
CREATE TABLE IF NOT EXISTS `abasmidias` (
  `abmId` int NOT NULL AUTO_INCREMENT,
  `abmNome` varchar(100) NOT NULL,
  PRIMARY KEY (`abmId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `abasmidias`
--

INSERT INTO `abasmidias` (`abmId`, `abmNome`) VALUES
(8, 'CMF'),
(2, 'ORTODONTIA'),
(3, 'CRÂNIO'),
(4, 'COLUNA'),
(5, 'ORTOPEDIA'),
(6, 'RADIOFREQUÊNCIA'),
(7, 'DESCARTÁVEIS');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aceite`
--

DROP TABLE IF EXISTS `aceite`;
CREATE TABLE IF NOT EXISTS `aceite` (
  `aceiteId` int NOT NULL AUTO_INCREMENT,
  `aceiteNumPed` varchar(20) NOT NULL,
  `aceiteDeAcordo` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `aceiteObs` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `aceiteStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`aceiteId`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `aceite`
--

INSERT INTO `aceite` (`aceiteId`, `aceiteNumPed`, `aceiteDeAcordo`, `aceiteObs`, `aceiteStatus`) VALUES
(2, '3094', '', '', 'VAZIO'),
(3, '3093', 'Aceito', '', 'ENVIADO'),
(4, '3095', '', '', 'VAZIO'),
(5, '3099', NULL, NULL, 'VAZIO'),
(6, '123', NULL, NULL, 'VAZIO'),
(7, '123', NULL, NULL, 'VAZIO'),
(8, '2550', NULL, NULL, 'VAZIO'),
(9, '6598', NULL, NULL, 'VAZIO'),
(10, '6598', NULL, NULL, 'VAZIO'),
(11, '2550', NULL, NULL, 'VAZIO'),
(12, '2550', NULL, NULL, 'VAZIO'),
(13, '2550', NULL, NULL, 'VAZIO'),
(14, '2550', NULL, NULL, 'VAZIO'),
(15, '2550', NULL, NULL, 'VAZIO'),
(16, '2550', NULL, NULL, 'VAZIO'),
(17, '2550', NULL, NULL, 'VAZIO'),
(18, '2550', NULL, NULL, 'VAZIO'),
(19, '2550', NULL, NULL, 'VAZIO'),
(20, '2550', NULL, NULL, 'VAZIO'),
(21, '2550', NULL, NULL, 'VAZIO'),
(22, '2550', NULL, NULL, 'VAZIO'),
(23, '2550', NULL, NULL, 'VAZIO'),
(24, '2550', NULL, NULL, 'VAZIO'),
(25, '2550', NULL, NULL, 'VAZIO'),
(26, '2550', NULL, NULL, 'VAZIO'),
(27, '2550', NULL, NULL, 'VAZIO'),
(28, '2550', NULL, NULL, 'VAZIO'),
(29, '2550', NULL, NULL, 'VAZIO'),
(30, '2550', NULL, NULL, 'VAZIO'),
(31, '45463', NULL, NULL, 'VAZIO'),
(32, '45463', NULL, NULL, 'VAZIO'),
(33, '45463', NULL, NULL, 'VAZIO'),
(34, '45463', NULL, NULL, 'VAZIO'),
(35, '45463', NULL, NULL, 'VAZIO'),
(36, '45463', NULL, NULL, 'VAZIO'),
(37, '45463', NULL, NULL, 'VAZIO'),
(38, '45463', NULL, NULL, 'VAZIO'),
(39, '45463', NULL, NULL, 'VAZIO'),
(40, '45463', NULL, NULL, 'VAZIO'),
(41, '8754', NULL, NULL, 'VAZIO'),
(42, '8754', NULL, NULL, 'VAZIO'),
(43, '8754', NULL, NULL, 'VAZIO'),
(44, '8754', NULL, NULL, 'VAZIO'),
(45, '4857', NULL, NULL, 'VAZIO'),
(46, '6589', NULL, NULL, 'VAZIO'),
(47, '123', NULL, NULL, 'VAZIO'),
(48, '1684', NULL, NULL, 'VAZIO'),
(49, '9876', NULL, NULL, 'VAZIO'),
(50, '1111', NULL, NULL, 'VAZIO'),
(51, '1237', NULL, NULL, 'VAZIO'),
(52, '8638', NULL, NULL, 'VAZIO'),
(53, '991', NULL, NULL, 'VAZIO'),
(54, '6598', NULL, NULL, 'VAZIO'),
(55, '89565', NULL, NULL, 'VAZIO'),
(56, '65487', NULL, NULL, 'VAZIO'),
(57, '65487', NULL, NULL, 'VAZIO'),
(58, '65487', NULL, NULL, 'VAZIO'),
(59, '65487', NULL, NULL, 'VAZIO'),
(60, '1234', NULL, NULL, 'VAZIO'),
(61, '9685', NULL, NULL, 'VAZIO'),
(62, '98656', NULL, NULL, 'VAZIO'),
(63, '1122', NULL, NULL, 'VAZIO'),
(64, '1122', NULL, NULL, 'VAZIO'),
(65, '1123', NULL, NULL, 'VAZIO'),
(66, '5254', NULL, NULL, 'VAZIO'),
(67, '5253', NULL, NULL, 'VAZIO'),
(68, '5252', NULL, NULL, 'VAZIO'),
(69, '5251', NULL, NULL, 'VAZIO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aceiteproposta`
--

DROP TABLE IF EXISTS `aceiteproposta`;
CREATE TABLE IF NOT EXISTS `aceiteproposta` (
  `apropId` int NOT NULL AUTO_INCREMENT,
  `apropNumProp` varchar(10) NOT NULL,
  `apropNomeUsuario` varchar(100) NOT NULL,
  `apropData` varchar(30) NOT NULL,
  `apropIp` varchar(20) NOT NULL,
  `apropCPFCNPJ` varchar(30) NOT NULL,
  `apropFormaPgto` varchar(50) NOT NULL,
  `apropCaminhoArquivo` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `apropStatus` varchar(30) NOT NULL,
  `apropExtensionFile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`apropId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `aceiteproposta`
--

INSERT INTO `aceiteproposta` (`apropId`, `apropNumProp`, `apropNomeUsuario`, `apropData`, `apropIp`, `apropCPFCNPJ`, `apropFormaPgto`, `apropCaminhoArquivo`, `apropStatus`, `apropExtensionFile`) VALUES
(15, '105', 'osires', '11/03/2022 14:19:21', '10.1.1.224', '39.896.712/0001-76', 'Boleto', '../arquivos/fincanceiro/105', 'Em Análise', 'png'),
(12, '91', 'osires', '06/12/2021 11:40:22', '10.1.1.224', '39.896.712/0001-76', 'Cartão de Débito', '../arquivos/fincanceiro/91', 'Aprovado', 'pdf'),
(11, '90', 'osires', '06/12/2021 10:08:40', '10.1.1.224', '39.896.712/0001-76', 'Cartão de Crédito', '../arquivos/fincanceiro/90', 'Aprovado', 'png'),
(16, '106', 'osires', '11/03/2022 14:32:09', '10.1.1.224', '39.896.712/0001-76', 'Cartão de Crédito', '../arquivos/fincanceiro/106', 'Aprovado', 'png'),
(17, '109', 'osires', '24/05/2022 14:59:31', '10.1.1.224', '39.896.712/0001-76', 'Boleto', '../arquivos/fincanceiro/109', 'Em Análise', 'png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adiantamentos`
--

DROP TABLE IF EXISTS `adiantamentos`;
CREATE TABLE IF NOT EXISTS `adiantamentos` (
  `adiantId` int NOT NULL AUTO_INCREMENT,
  `adiantUser` varchar(50) NOT NULL,
  `adiantNPed` varchar(10) NOT NULL,
  `adiantProduto` varchar(20) NOT NULL,
  `adiantDataSolicitacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `adiantStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`adiantId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `adiantamentos`
--

INSERT INTO `adiantamentos` (`adiantId`, `adiantUser`, `adiantNPed`, `adiantProduto`, `adiantDataSolicitacao`, `adiantStatus`) VALUES
(1, 'mariarosario', '1212', 'SMARTMOLD', '2021-12-08 17:00:11', 'Aprovado'),
(2, 'mariarosario', '5465', 'ATA HOF', '2021-12-08 17:11:26', 'Reprovado'),
(3, 'mariarosario', '9563', 'SMARTMOLD', '2021-12-08 17:13:37', 'Aprovado'),
(4, 'josejotform', '6598', 'ORTOGNÁTICA', '2021-12-08 18:01:34', 'Em Análise');

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda`
--

DROP TABLE IF EXISTS `agenda`;
CREATE TABLE IF NOT EXISTS `agenda` (
  `agdId` int NOT NULL AUTO_INCREMENT,
  `agdUserCriador` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `agdNumPedRef` varchar(10) NOT NULL,
  `agdNomeDr` varchar(30) NOT NULL,
  `agdNomPac` varchar(100) NOT NULL,
  `agdProd` varchar(30) NOT NULL,
  `agdStatus` varchar(20) NOT NULL,
  `agdStatusVideo` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `agdTipo` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `agdData` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `agdHora` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `agdCodHora` varchar(10) DEFAULT NULL,
  `agdResponsavel` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `agdFeedback` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `agdObs` text,
  PRIMARY KEY (`agdId`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `agenda`
--

INSERT INTO `agenda` (`agdId`, `agdUserCriador`, `agdNumPedRef`, `agdNomeDr`, `agdNomPac`, `agdProd`, `agdStatus`, `agdStatusVideo`, `agdTipo`, `agdData`, `agdHora`, `agdCodHora`, `agdResponsavel`, `agdFeedback`, `agdObs`) VALUES
(12, 'vanessapaiva', '3094', 'Fulano de Tal', 'JKHJ', 'SMARTMOLD - sdfs', 'MARCADO', 'A Fazer', '1ª Video', '2021-11-09', ' 10:00 - 10:30', 'h5', 'João', 'Escolha uma opção', NULL),
(13, 'vanessapaiva', '3093', 'Fulano de Tal', 'SAD', 'SMARTMOLD - zigoma', 'MARCADO', 'A Fazer', '1ª Video', '2021-11-09', ' 9:30 - 10:00', 'h4', 'Zille', 'Escolha uma opção', NULL),
(14, 'vanessapaiva', '3095', 'Fulano de Tal', 'SDF', 'SMARTMOLD - ', 'MARCADO', 'A Fazer', '1ª Video', '2021-11-09', ' 13:00 - 13:30', 'h11', 'Lucas', 'Atrasado', NULL),
(15, NULL, '3099', ' Maria', 'MARIA ROSáRIO', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'vanessapaiva', '', 'Marcio André', 'HGFS', 'Coluna', 'MARCADO', 'A Fazer', 'Técnica Cirúrgica', '2021-11-10', ' 16:30 - 17:00', 'h18', 'Lucas', '+ 45 min', ' ghsDHJGSUYG'),
(17, 'vanessapaiva', '', 'Marcio Andre', 'DGHug', 'CustomLIFE', 'MARCADO', 'A Fazer', 'Técnica Cirúrgica', '2021-11-10', ' 16:00 - 16:30', 'h17', NULL, NULL, ' GHfudguh'),
(18, 'vanessapaiva', '', 'JGYD', 'ijsodj', 'ATM', 'MARCADO', 'A Fazer', 'Técnica Cirúrgica', '2021-11-10', ' 12:00 - 12:30', 'h9', NULL, NULL, ' sfdsaf'),
(19, NULL, '123', 'Fulano de Tal', 'SGF', 'SMARTMOLD', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, NULL, '123', 'Fulano de Tal', 'SGF', 'SMARTMOLD', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, '6598', 'Joao Heitor', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, NULL, '6598', 'Joao Heitor', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, NULL, '2550', 'Fulano de Tal', 'DSFD', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, NULL, '45463', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, NULL, '8754', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, NULL, '8754', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, NULL, '8754', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, NULL, '8754', 'Fulano de Tal', 'PPP', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, NULL, '4857', 'Heitor Jorge', 'TRREE', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, NULL, '6589', 'Fulano de Tal', 'HJDHF', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'vanessa', '', 'Teste', 'ABC', 'ATM', 'MARCADO', 'A Fazer', 'Técnica Cirúrgica', '2022-03-10', ' 9:00 - 9:30', 'h3', NULL, NULL, ' Observacoes observacoes observacoes  observacoes observacoes observacoes'),
(61, 'vanessa', '', 'John Doe', 'ABC', 'CustomLIFE', 'MARCADO', 'A Fazer', 'Técnica Cirúrgica', '2022-03-11', ' 9:30 - 10:00', 'h4', NULL, NULL, ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tincidunt quis velit at vehicula. Proin ut pulvinar sapien. Ut venenatis, sapien a dignissim finibus, mi velit ultricies leo, eu porttitor.'),
(62, 'vanessa', '', 'John Doe', 'ABC', 'CustomLIFE', 'MARCADO', 'A Fazer', 'Técnica Cirúrgica', '2022-03-11', ' 10:00 - 10:30', 'h5', NULL, NULL, ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tincidunt quis velit at vehicula. Proin ut pulvinar sapien. Ut venenatis, sapien a dignissim finibus, mi velit ultricies leo, eu porttitor.'),
(63, 'vanessa', '', 'John Doe 2', 'DEF', 'Reconstrução', 'MARCADO', 'A Fazer', 'Técnica Cirúrgica', '2022-03-11', ' 8:30 - 9:00', 'h2', NULL, NULL, ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tincidunt quis velit at vehicula. Proin ut pulvinar sapien. Ut venenatis, sapien a dignissim finibus, mi velit ultricies leo, eu porttitor.'),
(64, 'vanessa', '', 'John Doe', 'ABC', 'ATM', 'MARCADO', 'A Fazer', 'Técnica Cirúrgica', '2022-03-11', ' 9:00 - 9:30', 'h3', NULL, NULL, ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tincidunt quis velit at vehicula. Proin ut pulvinar sapien. Ut venenatis, sapien a dignissim finibus, mi velit ultricies leo, eu porttitor.'),
(65, NULL, '123', 'Fulano de Tal', 'YTFYU', 'ATM', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, NULL, '1684', 'Doutor Teste', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, NULL, '9876', 'Teste Teste', 'DEF', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, NULL, '1111', 'Fulano de Tal', 'FSDFS', 'SMARTMOLD', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, NULL, '1237', 'Doutor Teste 2', 'ABCD', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, NULL, '8638', 'Doutor Teste', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, NULL, '991', 'Doutor Teste', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, NULL, '6598', 'Doutor Teste 3', 'DEF', 'RECONSTRUÇÃO ÓSSEA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'vanessa', '89565', 'Doutor Teste', 'ABC', 'ORTOGNÁTICA - KITPC-6000/PC-92', 'MARCADO', 'A Fazer', '1ª Video', '2022-11-08', '10:00', '30', NULL, NULL, NULL),
(74, NULL, '65487', 'Heitor Jorge', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, NULL, '1234', 'Doutor Doutor', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'vanessa', '9685', 'Fulano de Tal', 'ABC', 'ORTOGNÁTICA - KITPC-6002/PC-92', 'MARCADO', 'A Fazer', '1ª Video', '2022-10-11', '10:00', '30', NULL, NULL, NULL),
(78, 'vanessa', '98656', 'Doutor Doutor', 'ABC', 'ORTOGNÁTICA - KITPC-6002/PC-92', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, NULL, '1122', 'Teste', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, NULL, '1122', 'Teste', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, NULL, '1123', 'Teste', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, NULL, '5254', 'Saads', 'MARIAROSáRIO', 'ATA BUCO', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, NULL, '5253', 'Joao Heitor', 'ABC', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, NULL, '5252', 'Fulano De Tal', 'TRE', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, NULL, '5251', 'Fulano De Tal', 'HIJ', 'ORTOGNÁTICA', 'VAZIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunoteste`
--

DROP TABLE IF EXISTS `alunoteste`;
CREATE TABLE IF NOT EXISTS `alunoteste` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `alunoteste`
--

INSERT INTO `alunoteste` (`id`, `nome`, `tel`, `email`) VALUES
(1, 'Vanessa Paiva', '(61) 98365-2810', 'vanespaiva@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivoproposta`
--

DROP TABLE IF EXISTS `arquivoproposta`;
CREATE TABLE IF NOT EXISTS `arquivoproposta` (
  `arqId` int NOT NULL AUTO_INCREMENT,
  `arqNumProp` int NOT NULL,
  `arqTC` varchar(10) NOT NULL,
  `arqLaudo` varchar(10) NOT NULL,
  `arqModelo` varchar(10) NOT NULL,
  `arqImagem` varchar(10) NOT NULL,
  PRIMARY KEY (`arqId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `arquivoproposta`
--

INSERT INTO `arquivoproposta` (`arqId`, `arqNumProp`, `arqTC`, `arqLaudo`, `arqModelo`, `arqImagem`) VALUES
(1, 130, 'true', 'true', 'false', 'false');

-- --------------------------------------------------------

--
-- Estrutura da tabela `bancosdadosnotificacoes`
--

DROP TABLE IF EXISTS `bancosdadosnotificacoes`;
CREATE TABLE IF NOT EXISTS `bancosdadosnotificacoes` (
  `bdntfId` int NOT NULL AUTO_INCREMENT,
  `bdntfNome` varchar(200) NOT NULL,
  PRIMARY KEY (`bdntfId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `bancosdadosnotificacoes`
--

INSERT INTO `bancosdadosnotificacoes` (`bdntfId`, `bdntfNome`) VALUES
(1, 'propostas'),
(5, 'pedido');

-- --------------------------------------------------------

--
-- Estrutura da tabela `caddoutoresdistribuidores`
--

DROP TABLE IF EXISTS `caddoutoresdistribuidores`;
CREATE TABLE IF NOT EXISTS `caddoutoresdistribuidores` (
  `drId` int NOT NULL AUTO_INCREMENT,
  `drUidDr` varchar(200) NOT NULL,
  `drUidDistribuidor` varchar(200) NOT NULL,
  `drDistCNPJ` varchar(30) NOT NULL,
  PRIMARY KEY (`drId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `caddoutoresdistribuidores`
--

INSERT INTO `caddoutoresdistribuidores` (`drId`, `drUidDr`, `drUidDistribuidor`, `drDistCNPJ`) VALUES
(1, 'fulanodetal', 'distribuidor', '00.000.000/0000-00'),
(2, 'user', 'distribuidor', '00.000.000/0000-00'),
(3, 'fulanodetal', 'osires', '39.896.712/0001-76'),
(4, 'fulanodetal', 'josejotform', 'as684d');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentariosforum`
--

DROP TABLE IF EXISTS `comentariosforum`;
CREATE TABLE IF NOT EXISTS `comentariosforum` (
  `faqcomentId` int NOT NULL AUTO_INCREMENT,
  `faqcomentUserCriador` varchar(200) NOT NULL,
  `faqcomentFaqId` varchar(100) NOT NULL,
  `faqcomentDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `faqcomentTexto` text NOT NULL,
  PRIMARY KEY (`faqcomentId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `comentariosforum`
--

INSERT INTO `comentariosforum` (`faqcomentId`, `faqcomentUserCriador`, `faqcomentFaqId`, `faqcomentDataCriacao`, `faqcomentTexto`) VALUES
(14, 'vanessapaiva', '12', '2021-11-01 16:27:56', 'Interessante. acredito que tbm poderia ser de tal jeito');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentariosproposta`
--

DROP TABLE IF EXISTS `comentariosproposta`;
CREATE TABLE IF NOT EXISTS `comentariosproposta` (
  `comentVisId` int NOT NULL AUTO_INCREMENT,
  `comentVisUser` varchar(20) NOT NULL,
  `comentVisNumProp` varchar(20) NOT NULL,
  `comentVisText` varchar(300) NOT NULL,
  `comentVisHorario` varchar(20) NOT NULL,
  `comentVisTipoUser` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`comentVisId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `comentariosproposta`
--

INSERT INTO `comentariosproposta` (`comentVisId`, `comentVisUser`, `comentVisNumProp`, `comentVisText`, `comentVisHorario`, `comentVisTipoUser`) VALUES
(1, 'saulzapatta', '118', 'teste', '31/10/2022 10:46', 'representante'),
(2, 'vanessa', '118', '123', '16/11/2022 10:32:52', 'Administrador'),
(3, 'vanessa', '118', '456', '16/11/2022 10:37:12', 'Administrador'),
(4, 'vanessa', '118', 'hyudfhafu', '16/11/2022 10:41:48', 'Administrador'),
(5, 'vanessa', '118', 'dfsafd', '16/11/2022 10:43:28', 'Administrador'),
(6, 'daianesoares', '118', 'iuhsdfj', '16/11/2022 10:46:00', 'Comercial'),
(7, 'daianesoares', '118', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the', '16/11/2022 10:46:22', 'Comercial'),
(8, 'saulzapatta', '118', 'yujgsdnfo', '16/11/2022 11:18:58', 'Representante'),
(9, 'saulzapatta', '118', 'tfuigh788', '16/11/2022 11:19:28', 'Representante'),
(10, 'saulzapatta', '118', '87445', '16/11/2022 11:23:01', 'Representante'),
(11, 'saulzapatta', '118', '16871696adasfdsdfsd', '16/11/2022 11:23:53', 'Representante'),
(12, 'plan1', '130', 'teste 123', '16/11/2022 11:32:34', 'Planejador(a)'),
(13, 'plan1', '130', 'qrgregergew', '16/11/2022 11:33:52', 'Planejador(a)'),
(14, 'plan1', '130', 'ytdifyghulj', '16/11/2022 11:34:01', 'Planejador(a)'),
(15, 'vanessa', '130', 'yusidwsf', '16/11/2022 11:34:37', 'Administrador'),
(16, 'plan4', '130', 'tyfuighuoi', '16/11/2022 11:35:00', 'Planejador(a)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentariosvisualizador`
--

DROP TABLE IF EXISTS `comentariosvisualizador`;
CREATE TABLE IF NOT EXISTS `comentariosvisualizador` (
  `comentVisId` int NOT NULL AUTO_INCREMENT,
  `comentVisUser` varchar(20) NOT NULL,
  `comentVisNumPed` varchar(20) NOT NULL,
  `comentVisText` varchar(300) NOT NULL,
  `comentVisHorario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comentVisId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `comentariosvisualizador`
--

INSERT INTO `comentariosvisualizador` (`comentVisId`, `comentVisUser`, `comentVisNumPed`, `comentVisText`, `comentVisHorario`) VALUES
(1, 'vanessapaiva', '1524', 'Teste  feedback test', '0000-00-00 00:00:00'),
(2, 'vanessapaiva', '1524', 'Teste  feedback test', '0000-00-00 00:00:00'),
(3, 'vanessapaiva', '1524', 'Nova mensagem', '0000-00-00 00:00:00'),
(4, 'plan1', '1524', 'Então não sei pq', '0000-00-00 00:00:00'),
(5, 'vanessapaiva', '1524', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in accumsan justo. Vivamus lacinia interdum accumsan. Etiam dictum dui id libero tincidunt, aliquet consectetur ipsum ullamcorper. Nunc sed luctus nibh. Mauris urna lectus, lobortis ac dignissim eu, tempus quis velit. Phasellus eleifend id.', '0000-00-00 00:00:00'),
(6, 'vanessapaiva', '1524', 'Testej hjdhsdk sdhsdgifas fkf yifgsdifsdjfhi gsdj fisdgfisfb ytg sdufah sii', '0000-00-00 00:00:00'),
(7, 'vanessapaiva', '1524', 'Bom dia a todos, acredito que esteja faltando o link para compartilhar', '0000-00-00 00:00:00'),
(8, 'vanessapaiva', '1524', 'Novo teste', '0000-00-00 00:00:00'),
(9, 'vanessapaiva', '1525', 'New feedback sent to project 1525. I guess what i\'m trying to say is that this project is amazing. Nothing to change! Keep up the good work :)', '0000-00-00 00:00:00'),
(10, 'vanessapaiva', '1525', 'New msg', '0000-00-00 00:00:00'),
(11, 'plan3', '1525', 'Well, thanks a lot dear Vanessa!', '0000-00-00 00:00:00'),
(12, 'user', '1524', 'husgfuasgfugsdfusdnifuhisdfhisduhfisdhufniusdhnfnihusdfihusdfyusdfisduhyfmsdufmoisadufamisdfmohsdfuhsduigyfusdgugysdgsugfyisaddtfisaugfoiusatiusdyfsgdfjgysdfiyudigfsdigfuidosgyusdfioguhisagfuisdrtrwetui', '0000-00-00 00:00:00'),
(13, 'user', '1524', 'fgsdfhsdjfsaoifsdf', '0000-00-00 00:00:00'),
(14, 'user', '1525', 'That really was a good one!', '0000-00-00 00:00:00'),
(15, 'comercial', '1524', 'teste 123', '2021-10-14 17:19:23'),
(16, 'comercial', '1524', 'Então é isso', '2021-10-14 17:24:14'),
(17, 'comercial', '1524', 'daosjod pfjopsajd fojsopdoks\r\njsfjs\r\n\r\nksopdpkpl', '2021-10-14 17:29:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conselhosprofissionais`
--

DROP TABLE IF EXISTS `conselhosprofissionais`;
CREATE TABLE IF NOT EXISTS `conselhosprofissionais` (
  `consId` int NOT NULL AUTO_INCREMENT,
  `consNomeExtenso` varchar(100) NOT NULL,
  `consAbreviacao` varchar(5) NOT NULL,
  PRIMARY KEY (`consId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `conselhosprofissionais`
--

INSERT INTO `conselhosprofissionais` (`consId`, `consNomeExtenso`, `consAbreviacao`) VALUES
(1, 'de Medicina', 'CRM'),
(2, 'de Odontologia', 'CRO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `convenios`
--

DROP TABLE IF EXISTS `convenios`;
CREATE TABLE IF NOT EXISTS `convenios` (
  `convId` int NOT NULL AUTO_INCREMENT,
  `convName` varchar(200) NOT NULL,
  PRIMARY KEY (`convId`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `convenios`
--

INSERT INTO `convenios` (`convId`, `convName`) VALUES
(2, 'ALLIANZ'),
(3, 'AMIL'),
(4, 'BRADESCO'),
(5, 'ASSEFAZ'),
(6, 'CEF'),
(7, 'ASSIM'),
(8, 'CARE PLUS'),
(9, 'CASSEB'),
(10, 'CASSI'),
(11, 'DIX'),
(12, 'FOMENTO'),
(13, 'GEAP'),
(14, 'GOLDEN GROSS'),
(15, 'GREANLINE'),
(16, 'HAPVIDA'),
(17, 'MEDSENIOR'),
(18, 'MEDSERVICE'),
(19, 'NOTREDAME'),
(20, 'OMINT'),
(21, 'PARTICULAR'),
(22, 'PETROBRAS'),
(23, 'PORTO SEGURO'),
(24, 'POSTAL SAUDE (correios)'),
(25, 'PREVENT SENIOR'),
(26, 'SULAMERICA'),
(27, 'SUS'),
(28, 'UNIMED LOCAL'),
(29, 'UNIMED NACIONAL (CNU)'),
(31, 'Teste Convenio'),
(32, 'TESTE CONVENIO2'),
(33, ' AMIL'),
(34, ' MEDSERVICE'),
(35, 'PESQUISA CLÍNICA'),
(36, ' GREANLINE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `especialidades`
--

DROP TABLE IF EXISTS `especialidades`;
CREATE TABLE IF NOT EXISTS `especialidades` (
  `especId` int NOT NULL AUTO_INCREMENT,
  `especNome` varchar(100) NOT NULL,
  PRIMARY KEY (`especId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `especialidades`
--

INSERT INTO `especialidades` (`especId`, `especNome`) VALUES
(1, 'Implantodontia'),
(2, 'Bucomaxilo'),
(4, 'Peridontia'),
(5, 'HOF'),
(10, 'Prótese'),
(7, 'Ortodontia'),
(8, 'Neuro'),
(9, 'Ortopedia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE IF NOT EXISTS `estados` (
  `ufId` int NOT NULL AUTO_INCREMENT,
  `ufNomeExtenso` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ufAbreviacao` varchar(2) NOT NULL,
  `ufRegiao` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`ufId`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`ufId`, `ufNomeExtenso`, `ufAbreviacao`, `ufRegiao`) VALUES
(1, 'Acre', 'AC', 'Norte'),
(2, 'Alagoas', 'AL', 'Nordeste'),
(3, 'Amapá', 'AP', 'Norte'),
(4, 'Amazonas', 'AM', 'Norte'),
(5, 'Bahia', 'BA', 'Nordeste'),
(6, 'Ceará', 'CE', 'Nordeste'),
(7, 'Distrito Federal', 'DF', 'Centro-Oeste'),
(8, 'Espírito Santo', 'ES', 'Sudeste'),
(9, 'Goiás', 'GO', 'Centro-Oeste'),
(10, 'Maranhão', 'MA', 'Nordeste'),
(11, 'Mato Grosso', 'MT', 'Centro-Oeste'),
(12, 'Mato Grosso do Sul', 'MS', 'Centro-Oeste'),
(13, 'Minas Gerais', 'MG', 'Sudeste'),
(14, 'Pará', 'PA', 'Norte'),
(15, 'Paraíba', 'PB', 'Nordeste'),
(16, 'Pará', 'PR', 'Sul'),
(17, 'Pernambuco', 'PE', 'Nordeste'),
(18, 'Piauí', 'PI', 'Nordeste'),
(19, 'Rio de Janeiro', 'RJ', 'Sudeste'),
(20, 'Rio Grande do Norte', 'RN', 'Nordeste'),
(21, 'Rio Grande do Sul', 'RS', 'Sul'),
(22, 'Rondônia', 'RO', 'Norte'),
(23, 'Roraima', 'RR', 'Norte'),
(24, 'Santa Catarina', 'SC', 'Sul'),
(25, 'São Paulo', 'SP', 'Sudeste'),
(26, 'Sergipe', 'SE', 'Nordeste'),
(27, 'Tocantins', 'TO', 'Norte'),
(28, 'Internacional', 'IN', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapasanaliseplanejamento`
--

DROP TABLE IF EXISTS `etapasanaliseplanejamento`;
CREATE TABLE IF NOT EXISTS `etapasanaliseplanejamento` (
  `etpId` int NOT NULL AUTO_INCREMENT,
  `etpNumProp` int NOT NULL,
  `etpFluxo` int NOT NULL,
  PRIMARY KEY (`etpId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `etapasanaliseplanejamento`
--

INSERT INTO `etapasanaliseplanejamento` (`etpId`, `etpNumProp`, `etpFluxo`) VALUES
(1, 112, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedbackaceite`
--

DROP TABLE IF EXISTS `feedbackaceite`;
CREATE TABLE IF NOT EXISTS `feedbackaceite` (
  `fdaceiteId` int NOT NULL AUTO_INCREMENT,
  `fdaceiteNumPed` varchar(20) NOT NULL,
  `fdaceiteResposta` varchar(15) DEFAULT NULL,
  `fdaceiteComentario` varchar(300) DEFAULT NULL,
  `fdaceiteStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`fdaceiteId`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `feedbackaceite`
--

INSERT INTO `feedbackaceite` (`fdaceiteId`, `fdaceiteNumPed`, `fdaceiteResposta`, `fdaceiteComentario`, `fdaceiteStatus`) VALUES
(1, '3093', 'Melhorar', 'Achoj sfugsdgugs gygs ugfusy isudi', 'ENVIADO'),
(2, '3099', NULL, NULL, 'VAZIO'),
(3, '123', NULL, NULL, 'VAZIO'),
(4, '123', NULL, NULL, 'VAZIO'),
(5, '2550', NULL, NULL, 'VAZIO'),
(6, '6598', NULL, NULL, 'VAZIO'),
(7, '6598', NULL, NULL, 'VAZIO'),
(8, '2550', NULL, NULL, 'VAZIO'),
(9, '2550', NULL, NULL, 'VAZIO'),
(10, '2550', NULL, NULL, 'VAZIO'),
(11, '2550', NULL, NULL, 'VAZIO'),
(12, '2550', NULL, NULL, 'VAZIO'),
(13, '2550', NULL, NULL, 'VAZIO'),
(14, '2550', NULL, NULL, 'VAZIO'),
(15, '2550', NULL, NULL, 'VAZIO'),
(16, '2550', NULL, NULL, 'VAZIO'),
(17, '2550', NULL, NULL, 'VAZIO'),
(18, '2550', NULL, NULL, 'VAZIO'),
(19, '2550', NULL, NULL, 'VAZIO'),
(20, '2550', NULL, NULL, 'VAZIO'),
(21, '2550', NULL, NULL, 'VAZIO'),
(22, '2550', NULL, NULL, 'VAZIO'),
(23, '2550', NULL, NULL, 'VAZIO'),
(24, '2550', NULL, NULL, 'VAZIO'),
(25, '2550', NULL, NULL, 'VAZIO'),
(26, '2550', NULL, NULL, 'VAZIO'),
(27, '2550', NULL, NULL, 'VAZIO'),
(28, '45463', NULL, NULL, 'VAZIO'),
(29, '45463', NULL, NULL, 'VAZIO'),
(30, '45463', NULL, NULL, 'VAZIO'),
(31, '45463', NULL, NULL, 'VAZIO'),
(32, '45463', NULL, NULL, 'VAZIO'),
(33, '45463', NULL, NULL, 'VAZIO'),
(34, '45463', NULL, NULL, 'VAZIO'),
(35, '45463', NULL, NULL, 'VAZIO'),
(36, '45463', NULL, NULL, 'VAZIO'),
(37, '45463', NULL, NULL, 'VAZIO'),
(38, '8754', NULL, NULL, 'VAZIO'),
(39, '8754', NULL, NULL, 'VAZIO'),
(40, '8754', NULL, NULL, 'VAZIO'),
(41, '8754', NULL, NULL, 'VAZIO'),
(42, '4857', NULL, NULL, 'VAZIO'),
(43, '6589', NULL, NULL, 'VAZIO'),
(44, '123', NULL, NULL, 'VAZIO'),
(45, '1684', NULL, NULL, 'VAZIO'),
(46, '9876', NULL, NULL, 'VAZIO'),
(47, '1111', NULL, NULL, 'VAZIO'),
(48, '1237', NULL, NULL, 'VAZIO'),
(49, '8638', NULL, NULL, 'VAZIO'),
(50, '991', NULL, NULL, 'VAZIO'),
(51, '6598', NULL, NULL, 'VAZIO'),
(52, '89565', NULL, NULL, 'VAZIO'),
(53, '65487', NULL, NULL, 'VAZIO'),
(54, '65487', NULL, NULL, 'VAZIO'),
(55, '65487', NULL, NULL, 'VAZIO'),
(56, '65487', NULL, NULL, 'VAZIO'),
(57, '1234', NULL, NULL, 'VAZIO'),
(58, '9685', NULL, NULL, 'VAZIO'),
(59, '98656', NULL, NULL, 'VAZIO'),
(60, '1122', NULL, NULL, 'VAZIO'),
(61, '1122', NULL, NULL, 'VAZIO'),
(62, '1123', NULL, NULL, 'VAZIO'),
(63, '5254', NULL, NULL, 'VAZIO'),
(64, '5253', NULL, NULL, 'VAZIO'),
(65, '5252', NULL, NULL, 'VAZIO'),
(66, '5251', NULL, NULL, 'VAZIO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedbackagenda`
--

DROP TABLE IF EXISTS `feedbackagenda`;
CREATE TABLE IF NOT EXISTS `feedbackagenda` (
  `feedbackagendaId` int NOT NULL AUTO_INCREMENT,
  `feedbackagendaNome` varchar(30) NOT NULL,
  PRIMARY KEY (`feedbackagendaId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `feedbackagenda`
--

INSERT INTO `feedbackagenda` (`feedbackagendaId`, `feedbackagendaNome`) VALUES
(1, '+ 45 min'),
(5, 'Atrasado'),
(3, 'Não Compareceu'),
(6, 'Rápida');

-- --------------------------------------------------------

--
-- Estrutura da tabela `filedownload`
--

DROP TABLE IF EXISTS `filedownload`;
CREATE TABLE IF NOT EXISTS `filedownload` (
  `fileId` int NOT NULL AUTO_INCREMENT,
  `fileNumPropRef` int NOT NULL,
  `fileUuid` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fileRealName` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fileIsStored` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fileSize` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fileCdnUrl` varchar(200) NOT NULL,
  `fileDownloadAtivo` int NOT NULL,
  PRIMARY KEY (`fileId`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `filedownload`
--

INSERT INTO `filedownload` (`fileId`, `fileNumPropRef`, `fileUuid`, `fileRealName`, `fileIsStored`, `fileSize`, `fileCdnUrl`, `fileDownloadAtivo`) VALUES
(5, 98, '8d5006fd-8b72-40dc-b801-ad927084ff0f~1', '1 arquivo', 'true', '9847315', 'https://ucarecdn.com/8d5006fd-8b72-40dc-b801-ad927084ff0f~1/', 0),
(6, 99, '81ce5aa4-b3fc-4d69-83b6-383b1616bcac~2', '2 arquivos', 'true', '11264870', 'https://ucarecdn.com/81ce5aa4-b3fc-4d69-83b6-383b1616bcac~2/', 0),
(7, 100, '3bf69efd-8eaa-41c7-b5ad-2a6ee667b8f3~1', '1 arquivo', 'true', '11261055', 'https://ucarecdn.com/3bf69efd-8eaa-41c7-b5ad-2a6ee667b8f3~1/', 0),
(8, 101, '4a086fa3-eac5-4361-ae00-06355c5453cd~1', '1 arquivo', 'true', '11261055', 'https://ucarecdn.com/4a086fa3-eac5-4361-ae00-06355c5453cd~1/', 0),
(9, 102, 'cf791ad5-3a62-4d9f-a142-25774e536a7b~1', '1 arquivo', 'true', '11261055', 'https://ucarecdn.com/cf791ad5-3a62-4d9f-a142-25774e536a7b~1/', 0),
(10, 103, 'a7d379e1-02cf-4fe9-b6e0-512aded0888b~1', '1 arquivo', 'true', '11261055', 'https://ucarecdn.com/a7d379e1-02cf-4fe9-b6e0-512aded0888b~1/', 0),
(11, 104, '483a5c53-a653-4f63-a325-0cc7272e576b~1', '1 arquivo', 'true', '11261055', 'https://ucarecdn.com/483a5c53-a653-4f63-a325-0cc7272e576b~1/', 0),
(12, 105, 'a264ec6c-7c41-465a-9547-455f8208cb6f~1', '1 arquivo', 'true', '11261055', 'https://ucarecdn.com/a264ec6c-7c41-465a-9547-455f8208cb6f~1/', 0),
(13, 105, 'a264ec6c-7c41-465a-9547-455f8208cb6f~1', '1 arquivo', 'true', '11261055', 'https://ucarecdn.com/a264ec6c-7c41-465a-9547-455f8208cb6f~1/', 0),
(14, 107, '310ae9b0-cfca-435e-965d-2ea2b8e91375~2', '2 arquivos', 'true', '329575587', 'https://ucarecdn.com/310ae9b0-cfca-435e-965d-2ea2b8e91375~2/', 0),
(15, 108, '', '', '', '', 'https://drive.google.com/drive/folders/1UQ5Vh8Hj5t6PJhzrk-H75aMSgv9vLEsB', 0),
(16, 109, 'cdb549bb-e5f5-4cff-9bea-27a5044dfbba', 'A1089DFEFB0F5285E044E7F0C4B9A172.txt', 'true', '93', 'https://drive.google.com/drive/folders/1UQ5Vh8Hj5t6PJhzrk-H75aMSgv9vLEsB', 0),
(17, 110, '', '', '', '', 'teste', 0),
(18, 111, '', '', '', '', '', 0),
(43, 133, '', '', '', '', '', 0),
(19, 112, '', '', '', '', '', 0),
(20, 112, '', '', '', '', '', 0),
(21, 113, '', '', '', '', '', 0),
(22, 112, '', '', '', '', '', 0),
(23, 112, '', '', '', '', '', 0),
(24, 114, '', '', '', '', '', 0),
(25, 115, '', '', '', '', '', 0),
(26, 116, '', '', '', '', '', 0),
(27, 117, '', '', '', '', '', 0),
(28, 118, '', '', '', '', '', 0),
(29, 119, '', '', '', '', '', 0),
(30, 120, '', '', '', '', '', 0),
(31, 121, '', '', '', '', '', 0),
(32, 122, '', '', '', '', '', 0),
(33, 123, '', '', '', '', '', 0),
(34, 124, '', '', '', '', '', 0),
(35, 125, '', '', '', '', 'https://drive.google.com/drive/folders/149k6OmbAwFimlpOA2vOQRDgUad19AsJr', 0),
(36, 126, '', '', '', '', '', 0),
(37, 127, '', '', '', '', 'https://drive.google.com/drive/folders/1-kg3yEo0TroTjyHxT7A_17pYEq4YC1Vl', 0),
(38, 128, '', '', '', '', '', 0),
(39, 129, '', '', '', '', 'https://drive.google.com/drive/folders/1iU6RCobbJT3wQf3e1-hWZWacuRl6nN3h', 0),
(40, 130, '', '', '', '', 'https://drive.google.com/drive/folders/1xRf2z_zIiVXsZYjGrOUce87_SzxDZBmf', 0),
(41, 131, '', '', '', '', 'https://drive.google.com/drive/folders/19nWGZ0MNoxJG7zk2FNNlKdBYjHkGgoRI', 0),
(42, 132, '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `filedownloadlaudo`
--

DROP TABLE IF EXISTS `filedownloadlaudo`;
CREATE TABLE IF NOT EXISTS `filedownloadlaudo` (
  `fileId` int NOT NULL AUTO_INCREMENT,
  `fileNumPropRef` int NOT NULL,
  `fileUuid` text NOT NULL,
  `fileRealName` text NOT NULL,
  `fileIsStored` varchar(5) NOT NULL,
  `fileSize` varchar(200) NOT NULL,
  `fileCdnUrl` text NOT NULL,
  `fileDownloadAtivo` int NOT NULL,
  PRIMARY KEY (`fileId`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `filedownloadlaudo`
--

INSERT INTO `filedownloadlaudo` (`fileId`, `fileNumPropRef`, `fileUuid`, `fileRealName`, `fileIsStored`, `fileSize`, `fileCdnUrl`, `fileDownloadAtivo`) VALUES
(1, 76, '', '', '', '', '', 0),
(2, 112, '', '', '', '', '', 0),
(3, 113, '', '', '', '', '', 0),
(4, 112, '', '', '', '', '', 0),
(5, 112, '', '', '', '', '', 0),
(6, 114, '', '', '', '', '', 0),
(7, 115, '', '', '', '', '', 0),
(8, 116, '', '', '', '', '', 0),
(9, 117, '', '', '', '', '', 0),
(10, 118, '', '', '', '', '', 0),
(11, 119, '', '', '', '', '', 0),
(12, 120, '', '', '', '', 'https://drive.google.com/drive/folders/198NXyvPwdqCjQymPRQQasTqT3KoTcwHn', 0),
(13, 121, '', '', '', '', '', 0),
(14, 122, '', '', '', '', '', 0),
(15, 123, '', '', '', '', '', 0),
(16, 124, '', '', '', '', '', 0),
(17, 125, '', '', '', '', '', 0),
(18, 126, '', '', '', '', '', 0),
(19, 127, '', '', '', '', '', 0),
(20, 128, '', '', '', '', '', 0),
(21, 129, '', '', '', '', '', 0),
(22, 130, '', '', '', '', '', 0),
(23, 131, '', '', '', '', '', 0),
(24, 132, '', '', '', '', '', 0),
(25, 133, '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `filefinanceiro`
--

DROP TABLE IF EXISTS `filefinanceiro`;
CREATE TABLE IF NOT EXISTS `filefinanceiro` (
  `filefinId` int NOT NULL AUTO_INCREMENT,
  `filefinRealName` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `filefinPropId` varchar(20) NOT NULL,
  `filefinPath` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`filefinId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `filefinanceiro`
--

INSERT INTO `filefinanceiro` (`filefinId`, `filefinRealName`, `filefinPropId`, `filefinPath`) VALUES
(8, '9286-Jonathan-Schefer-Gelocha-033-416-810-43 (1).pdf', '95', '../arquivos/fincanceiro/95'),
(6, '2835-id-vanessa.pdf', '92', '../arquivos/fincanceiro/92'),
(4, '2690-Captura de tela 2021-05-24 102912.png', '90', '../arquivos/fincanceiro/90'),
(7, '4076-procuracao-prefeitura-luziania-go-11-06-2021.pdf', '91', '../arquivos/fincanceiro/91'),
(9, '6342-image (30).png', '105', '../arquivos/fincanceiro/105'),
(10, '2371-errorzappier.png', '106', '../arquivos/fincanceiro/106'),
(11, '6166-signature.png', '109', '../arquivos/fincanceiro/109');

-- --------------------------------------------------------

--
-- Estrutura da tabela `formapagamento`
--

DROP TABLE IF EXISTS `formapagamento`;
CREATE TABLE IF NOT EXISTS `formapagamento` (
  `pgtoId` int NOT NULL AUTO_INCREMENT,
  `pgtoNome` varchar(100) NOT NULL,
  PRIMARY KEY (`pgtoId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `formapagamento`
--

INSERT INTO `formapagamento` (`pgtoId`, `pgtoNome`) VALUES
(5, 'PIX'),
(2, 'Cartão de Crédito'),
(3, 'Cartão de Débito'),
(4, 'Boleto');

-- --------------------------------------------------------

--
-- Estrutura da tabela `forum`
--

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `faqId` int NOT NULL AUTO_INCREMENT,
  `faqUserCriador` varchar(200) NOT NULL,
  `faqTipoConta` varchar(200) NOT NULL,
  `faqSetor` varchar(200) NOT NULL,
  `faqDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `faqStatus` varchar(15) NOT NULL,
  `faqAssuntoPrincipal` varchar(300) NOT NULL,
  `faqTipoTexto` varchar(10) NOT NULL,
  `faqTexto` text NOT NULL,
  PRIMARY KEY (`faqId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `forum`
--

INSERT INTO `forum` (`faqId`, `faqUserCriador`, `faqTipoConta`, `faqSetor`, `faqDataCriacao`, `faqStatus`, `faqAssuntoPrincipal`, `faqTipoTexto`, `faqTexto`) VALUES
(12, 'vanessapaiva', 'Administrador', 'Central de Negócios', '2021-11-01 16:27:00', 'A Fazer', 'Novo SAC', 'Melhoria', 'yfugyuhyyiujiuioo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `horasdisponiveisagenda`
--

DROP TABLE IF EXISTS `horasdisponiveisagenda`;
CREATE TABLE IF NOT EXISTS `horasdisponiveisagenda` (
  `hrId` int NOT NULL AUTO_INCREMENT,
  `hrCodigo` varchar(10) NOT NULL,
  `hrHorario` varchar(20) NOT NULL,
  PRIMARY KEY (`hrId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `horasdisponiveisagenda`
--

INSERT INTO `horasdisponiveisagenda` (`hrId`, `hrCodigo`, `hrHorario`) VALUES
(3, 'h1', '8:00 - 8:30'),
(2, 'h2', '8:30 - 9:00'),
(4, 'h3', '9:00 - 9:30'),
(5, 'h4', '9:30 - 10:00'),
(7, 'h5', '10:00 - 10:30'),
(8, 'h6', '10:30 - 11:00'),
(9, 'h7', '11:00 - 11:30'),
(10, 'h8', '11:30 - 12:00'),
(11, 'h9', '12:00 - 12:30'),
(12, 'h10', '12:30 - 13:00'),
(13, 'h11', '13:00 - 13:30'),
(14, 'h12', '13:30 - 14:00'),
(15, 'h13', '14:00 - 14:30'),
(16, 'h14', '14:30 - 15:00'),
(17, 'h15', '15:00 - 15:30'),
(18, 'h16', '15:30 - 16:00'),
(19, 'h17', '16:00 - 16:30'),
(20, 'h18', '16:30 - 17:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagemreferenciaplana`
--

DROP TABLE IF EXISTS `imagemreferenciaplana`;
CREATE TABLE IF NOT EXISTS `imagemreferenciaplana` (
  `imgplanId` int NOT NULL AUTO_INCREMENT,
  `imgplanNomeImg` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `imgplanPathImg` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `imgplanNumProp` int NOT NULL,
  PRIMARY KEY (`imgplanId`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `imagemreferenciaplana`
--

INSERT INTO `imagemreferenciaplana` (`imgplanId`, `imgplanNomeImg`, `imgplanPathImg`, `imgplanNumProp`) VALUES
(28, '2 arquivos', 'https://ucarecdn.com/90a146ce-d4dc-484c-884a-55f8d1028563~2/', 126),
(26, 'training.png', 'https://ucarecdn.com/1b469159-242b-4f82-b486-0075cee3bf9b/', 111),
(27, 'como_se_identifica_04 (1) (1).jpg', 'https://ucarecdn.com/018004f8-2e6b-4efe-ad05-fd5a03b740ce/', 110),
(29, '3 arquivos', 'https://ucarecdn.com/6d9ab3bb-229f-41cf-8eaf-ceec7f2c6ab3~3/', 125),
(30, '2 arquivos', 'https://ucarecdn.com/827491ea-5102-4c87-8d3d-d832e0a75b0c~2/', 127),
(31, '', 'none', 132);

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagemreferenciaplanb`
--

DROP TABLE IF EXISTS `imagemreferenciaplanb`;
CREATE TABLE IF NOT EXISTS `imagemreferenciaplanb` (
  `imgplanId` int NOT NULL AUTO_INCREMENT,
  `imgplanNomeImg` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `imgplanPathImg` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `imgplanNumProp` int NOT NULL,
  PRIMARY KEY (`imgplanId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `imagemreferenciaplanb`
--

INSERT INTO `imagemreferenciaplanb` (`imgplanId`, `imgplanNomeImg`, `imgplanPathImg`, `imgplanNumProp`) VALUES
(9, 'como_se_identifica_01.jpg', 'https://ucarecdn.com/6ee44319-ff28-488a-b7d4-f089bfd5cc55/', 110),
(8, 'noun-3d-printer-4435775.png', 'https://ucarecdn.com/78ab9c2f-f340-4b3c-b12a-e8a295afc5cd/', 111),
(10, '2 arquivos', 'https://ucarecdn.com/6f67380a-921d-41dc-9982-337fe7810032~2/', 126),
(11, '3 arquivos', 'https://ucarecdn.com/14f0ac16-5f7e-4e83-84e6-c627f069c9d7~3/', 125),
(12, '2 arquivos', 'https://ucarecdn.com/aec95c2c-cd9b-4a01-8671-cdacf2e4017e~2/', 127),
(13, '', 'none', 132);

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagensprodutos`
--

DROP TABLE IF EXISTS `imagensprodutos`;
CREATE TABLE IF NOT EXISTS `imagensprodutos` (
  `imgprodId` int NOT NULL AUTO_INCREMENT,
  `imgprodCategoria` varchar(20) NOT NULL,
  `imgprodNome` varchar(30) NOT NULL,
  `imgprodCodCallisto` varchar(20) NOT NULL,
  `imgprodLink` varchar(600) NOT NULL,
  `imgprodDataEnvio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`imgprodId`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `imagensprodutos`
--

INSERT INTO `imagensprodutos` (`imgprodId`, `imgprodCategoria`, `imgprodNome`, `imgprodCodCallisto`, `imgprodLink`) VALUES
(13, 'CMF', 'Smartmold Pré-Maxila', 'E200.011-L', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_58c76c919599dcd927d0a0ee186a758a.png'),
(10, 'CMF', 'Smartmold Mento', 'E200.011-H', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_91c1690357c075a3e2bc5293dc86fd5c.png'),
(9, 'CMF', 'Smartmold Paranasal', 'E200.011-G', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_40800f29644720b65edcc4724b7b247f.png'),
(8, 'CMF', 'Smartmold Zigoma', 'E200.013-1 D', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_f6e41f38d0dc5cad42ce029cef257a7d.png'),
(14, 'CMF', 'Smartmold Ang de Mandíbula', 'E200.011-J', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_15b941481b95c7a83cbed902557294b4.png'),
(15, 'CMF', 'Smartmold Ang de Mandíbula', 'E200.011-KE', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_15b941481b95c7a83cbed902557294b4.png'),
(16, 'CMF', 'Smartmold Zigoma', 'E200.011-F', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_f6e41f38d0dc5cad42ce029cef257a7d.png'),
(17, 'CMF', 'Smartmold Zigoma', 'E200.013-1 E', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_f6e41f38d0dc5cad42ce029cef257a7d.png'),
(18, 'CMF', 'Smartmold Mento', 'E200.011-I', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_91c1690357c075a3e2bc5293dc86fd5c.png'),
(19, 'CMF', 'Smartmold Ang de Mandíbula', 'E200.011-KD', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_15b941481b95c7a83cbed902557294b4.png'),
(20, 'BIOMODELO', 'Biomodelo Mandíbula', '999.517', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_27da8d7b12ad1a9756f2edb0afabc611.png'),
(21, 'CMF', 'Reconstrução Órbita', 'PC-301-P1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b33fa5475e8faff97c688356ab681f94.png'),
(22, 'CMF', 'Reconstrução Órbita', 'PC-301-P2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b33fa5475e8faff97c688356ab681f94.png'),
(23, 'CMF', 'Reconstrução Maxilar', 'PC-302-P1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_48d7deeedfd7aa037d6cecda324f3396.png'),
(24, 'CMF', 'Reconstrução Maxilar', 'PC-302-P2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_48d7deeedfd7aa037d6cecda324f3396.png'),
(25, 'CMF', 'ATM Esquerda', 'P-5.10.01-E', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_c3a625eb41d74274c76eb737c65ec0a3.png'),
(26, 'CMF', 'ATM Direita', 'P-5.10.01-D	', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_c6134ca3498aea85a96612592fa82a08.png'),
(27, 'CMF', 'Reconstrução Mandibular', 'PC-303-P1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b25e5c258da4318a4f45be86ccd2c042.png'),
(28, 'CMF', 'Reconstrução Mandibular', 'PC-303-P2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b25e5c258da4318a4f45be86ccd2c042.png'),
(29, 'CMF', 'Reconstrução Zigoma', 'PC-304-P1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3513edbaac99a8c5441d55234868b418.png'),
(30, 'CMF', 'Reconstrução Zigoma', 'PC-304-P2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3513edbaac99a8c5441d55234868b418.png'),
(31, 'CMF', 'Reconstrução Zigoma', 'PC-304-T1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3513edbaac99a8c5441d55234868b418.png'),
(32, 'CMF', 'Reconstrução Zigoma', 'PC-304-T2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3513edbaac99a8c5441d55234868b418.png'),
(33, 'CMF', 'Reconstrução Órbita', 'PC-301-T1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b33fa5475e8faff97c688356ab681f94.png'),
(34, 'CMF', 'Reconstrução Órbita', 'PC-301-T2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b33fa5475e8faff97c688356ab681f94.png'),
(35, 'CMF', 'Reconstrução Maxilar', 'PC-302-T1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_48d7deeedfd7aa037d6cecda324f3396.png'),
(36, 'CMF', 'Reconstrução Maxilar', 'PC-302-T2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_48d7deeedfd7aa037d6cecda324f3396.png'),
(37, 'CMF', 'Reconstrução Mandibular', 'PC-303-T1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b25e5c258da4318a4f45be86ccd2c042.png'),
(38, 'CMF', 'Reconstrução Mandibular', 'PC-303-T2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_b25e5c258da4318a4f45be86ccd2c042.png'),
(39, 'CMF', 'Reconstrução Infraorbitário', 'PC-305-P1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3626ee59ca7bb4dc2f01fc56962674eb.png'),
(40, 'CMF', 'Reconstrução Infraorbitário', 'PC-305-P2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3626ee59ca7bb4dc2f01fc56962674eb.png'),
(41, 'CMF', 'Reconstrução Infraorbitário', 'PC-305-T1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3626ee59ca7bb4dc2f01fc56962674eb.png'),
(42, 'CMF', 'Reconstrução Infraorbitário', 'PC-305-T2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_3626ee59ca7bb4dc2f01fc56962674eb.png'),
(43, 'CMF', 'Reconstrução Glabela', 'PC-306-P1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_587b98495043917493de7660029d0c7d.png'),
(44, 'CMF', 'Reconstrução Glabela', 'PC-306-P2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_587b98495043917493de7660029d0c7d.png'),
(45, 'CMF', 'Reconstrução Glabela', 'PC-306-T1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_587b98495043917493de7660029d0c7d.png'),
(46, 'CMF', 'Reconstrução Glabela', 'PC-306-T2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_587b98495043917493de7660029d0c7d.png'),
(47, 'CMF', 'Reconstrução Frontal', 'PC-501-P1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_35ab0063c68ae0cec13e40e95f359ae7.png'),
(48, 'CMF', 'Reconstrução Frontal', 'PC-501-P2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_35ab0063c68ae0cec13e40e95f359ae7.png'),
(49, 'CMF', 'Reconstrução Frontal', 'PC-501-T1*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_35ab0063c68ae0cec13e40e95f359ae7.png'),
(50, 'CMF', 'Reconstrução Frontal', 'PC-501-T2*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_35ab0063c68ae0cec13e40e95f359ae7.png'),
(51, 'CMF', 'Reconstrução Ang de Mandíbula', 'PC-507-P1', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_68feed2e8b08aa7a27a86100dcf2b9f7.png'),
(52, 'CMF', 'Reconstrução Ang de Mandíbula', 'PC-507-P2', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_68feed2e8b08aa7a27a86100dcf2b9f7.png'),
(53, 'CMF', 'Reconstrução Ang de Mandíbula', 'PC-507-P3', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_68feed2e8b08aa7a27a86100dcf2b9f7.png'),
(54, 'CMF', 'Reconstrução Ang de Mandíbula', 'PC-507-T1', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_68feed2e8b08aa7a27a86100dcf2b9f7.png'),
(55, 'CMF', 'Reconstrução Ang de Mandíbula', 'PC-507-T2', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_68feed2e8b08aa7a27a86100dcf2b9f7.png'),
(56, 'CMF', 'Reconstrução Mento', 'PC-402-P1 MEN*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_4659ef9ccb2cee4fb4653e2383ab63d4.png'),
(57, 'CMF', 'Reconstrução Mento', 'PC-402MEN	', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_4659ef9ccb2cee4fb4653e2383ab63d4.png'),
(58, 'CMF', 'Reconstrução Mento', 'PC-402-P2 MEN*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_4659ef9ccb2cee4fb4653e2383ab63d4.png'),
(59, 'CMF', 'Reconstrução Mento', 'PC-403MEN', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_4659ef9ccb2cee4fb4653e2383ab63d4.png'),
(60, 'CMF', 'ATM Direita', 'KITPC-505D*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_c6134ca3498aea85a96612592fa82a08.png'),
(61, 'CMF', 'ATM Direita', 'KITPC-506D*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_c6134ca3498aea85a96612592fa82a08.png'),
(62, 'CMF', 'ATM Esquerda', 'KITPC-505E*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_c3a625eb41d74274c76eb737c65ec0a3.png'),
(63, 'CMF', 'ATM Esquerda', 'KITPC-506E*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_c3a625eb41d74274c76eb737c65ec0a3.png'),
(64, 'CMF', 'Customlife Maxila e Mandíbula', 'PC-700 MAX MAN', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_4d7d970dba439c1aa627564de14e738f.png'),
(65, 'CMF', 'Ortognática Maxila', 'KITPC-6000', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_9409caebf255b9812183c3cc3552364d.png'),
(66, 'CMF', 'Ortognática Mandíbula', 'KITPC-6001', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_e859aa13903f395dc18a1e08f69b02c4.png'),
(67, 'CMF', 'Ortognática Combinada', 'KITPC-6002', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_5e1362f451af18fca9113c96e4d605ac.png'),
(68, 'CMF', 'Customlife Maxila', 'PC-701-MAXP*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_aaf6693fd0039a2ca55699e30b857bd8.png'),
(69, 'CMF', 'Customlife Maxila', 'PC-702-MAXT*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_aaf6693fd0039a2ca55699e30b857bd8.png'),
(70, 'CMF', 'Customlife Mandíbula', 'PC-701-MANP*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_6dda75535d89a44803acfa6915ee3dfe.png'),
(71, 'CMF', 'Customlife Mandíbula', 'PC-702-MANT*', 'https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_6dda75535d89a44803acfa6915ee3dfe.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itensproposta`
--

DROP TABLE IF EXISTS `itensproposta`;
CREATE TABLE IF NOT EXISTS `itensproposta` (
  `itemId` int NOT NULL AUTO_INCREMENT,
  `itemCdg` varchar(128) NOT NULL,
  `itemNome` varchar(200) NOT NULL,
  `itemAnvisa` varchar(200) NOT NULL,
  `itemQtd` int NOT NULL,
  `itemValor` float NOT NULL,
  `itemValorBase` float NOT NULL,
  `itemPropRef` varchar(128) NOT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `itensproposta`
--

INSERT INTO `itensproposta` (`itemId`, `itemCdg`, `itemNome`, `itemAnvisa`, `itemQtd`, `itemValor`, `itemValorBase`, `itemPropRef`) VALUES
(57, 'PC-201-P1*', 'CRÂNIO SOB MEDIDA PEEK P< 30cm3', 'Licença Especial', 1, 38500, 0, '64'),
(56, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', 1, 10000, 0, '63'),
(55, 'E200.011-H', 'SMARTMOLD MENTO  PMMA', '80859840124', 1, 8600, 0, '63'),
(54, 'E200.011-H', 'SMARTMOLD MENTO  PMMA', '80859840124', 1, 8600, 0, '62'),
(53, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', 1, 10000, 0, '61'),
(48, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', 1, 10000, 0, '53'),
(49, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', 1, 16000, 0, '54'),
(50, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', 1, 10000, 0, '54'),
(51, 'E200.011-I', 'SMARTMOLD MENTO BIPARTIDO PMMA', '80859840124', 1, 8600, 0, '54'),
(52, 'E200.013-1 D', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Dir', '80859840124', 1, 8600, 0, '60'),
(47, 'E200.013-1 E', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Esq', '80859840124', 1, 8600, 0, '53'),
(46, 'E200.013-1 D', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Dir', '80859840124', 1, 8600, 0, '52'),
(44, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', 1, 16000, 0, '44'),
(45, 'E200.013-1 E', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Esq', '80859840124', 1, 8600, 0, '46'),
(43, 'E200.013-1 D', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Dir', '80859840124', 1, 8600, 0, '43'),
(58, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', 1, 10000, 0, '65'),
(59, 'E200.013-1 D', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Dir', '80859840124', 1, 8600, 0, '68'),
(60, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', 1, 10000, 0, '69'),
(61, 'E200.011-I', 'SMARTMOLD MENTO BIPARTIDO PMMA', '80859840124', 1, 8600, 0, '70'),
(62, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', 1, 16000, 0, '71'),
(63, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', 1, 16000, 0, '72'),
(64, 'PC-700 MAX MAN', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA + MANDÍBULA', 'Licença Especial', 1, 78200, 0, '73'),
(65, 'PC-700 MAX MAN', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA + MANDÍBULA', 'Licença Especial', 1, 78200, 0, '75'),
(66, 'PC-700 MAX MAN', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA + MANDÍBULA', 'Licença Especial', 1, 78200, 0, '75'),
(67, 'PC-700 MAX MAN', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA + MANDÍBULA', 'Licença Especial', 1, 78200, 0, '75'),
(93, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', 1, 10000, 0, '77'),
(98, 'E200.011-KD', 'SMARTMOLD ANG DE MANDIBULA  PMMA - DIR', '80859840124', 2, 17200, 8600, '78'),
(99, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '79'),
(97, 'E200.011-KD', 'SMARTMOLD ANG DE MANDIBULA  PMMA - DIR', '80859840124', 1, 8600, 8600, '76'),
(100, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '80'),
(101, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '80'),
(102, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '81'),
(103, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 50, 3400, 68, '81'),
(104, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '82'),
(105, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 68, 68, '82'),
(106, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 3, 68, 68, '82'),
(107, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 3, 68, 68, '82'),
(108, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 3, 68, 68, '84'),
(109, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 3, 68, 68, '84'),
(115, 'E200.011-KD', 'SMARTMOLD ANG DE MANDIBULA  PMMA - DIR', '80859840124', 1, 8600, 8600, '85'),
(116, 'PC-301-P1*', 'RECONSTRUÇÃO ORBITA EM PEEK - 1', 'Licença Especial', 1, 41900, 41900, '85'),
(122, 'E200.011-KD', 'SMARTMOLD ANG DE MANDIBULA  PMMA - DIR', '80859840124', 1, 8600, 8600, '86'),
(123, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 20, 1360, 68, '86'),
(124, 'PC-201-P1*', 'CRÂNIO SOB MEDIDA PEEK P< 30cm3', 'Licença Especial', 1, 38500, 38500, '87'),
(125, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 6, 408, 68, '87'),
(126, 'E200.013-1 E', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Esq', '80859840124', 1, 8600, 8600, '88'),
(127, 'PC-301-P1*', 'RECONSTRUÇÃO ORBITA EM PEEK - 1', 'Licença Especial', 1, 41900, 41900, '89'),
(128, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 24, 1632, 68, '89'),
(129, 'KITPC-6001', 'ORTOGNATICA SOB MEDIDA MANDIBULA', 'Licença Especial', 1, 18000, 18000, '88'),
(130, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '88'),
(131, 'E200.013-1 D', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Dir', '80859840124', 1, 8600, 8600, '91'),
(139, 'E200.012-1', 'Guia de Osteotomia A / corticotomia', '80859840201', 1, 2700, 2500, '91'),
(133, 'E200.011-KD', 'SMARTMOLD ANG DE MANDIBULA  PMMA - DIR', '80859840124', 1, 8600, 8600, '93'),
(134, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 8, 544, 68, '93'),
(137, 'E200.012-1', 'Guia de Osteotomia A / corticotomia', '80859840201', 1, 2700, 2500, '92'),
(141, 'E200.013-1 E', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Esq', '80859840124', 1, 8600, 8600, '94'),
(142, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', 1, 16000, 16000, '94'),
(143, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', 1, 16000, 16000, '95'),
(144, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', 1, 10000, 10000, '95'),
(145, 'E200.011-KD', 'SMARTMOLD ANG DE MANDIBULA  PMMA - DIR', '80859840124', 1, 8600, 8600, '90'),
(151, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '96'),
(152, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '98'),
(150, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '96'),
(153, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '98'),
(154, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '99'),
(155, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '99'),
(156, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '100'),
(157, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '100'),
(158, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '101'),
(159, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '101'),
(160, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '102'),
(161, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '102'),
(163, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '103'),
(164, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '103'),
(165, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '104'),
(166, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '104'),
(167, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '105'),
(168, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '105'),
(169, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '105'),
(170, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '105'),
(171, 'KITPC-506E*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º- E - 2', 'Licença Especial', 1, 57800, 57800, '107'),
(172, 'KITPC-506D*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º - D - 2', 'Licença Especial', 1, 57800, 57800, '107'),
(173, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 24, 1632, 68, '107'),
(174, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '108'),
(175, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '108'),
(176, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 1, 18000, 18000, '109'),
(177, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '109'),
(178, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '110'),
(179, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '110'),
(180, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 1, 18000, 18000, '111'),
(181, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '111'),
(189, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 1, 18000, 18000, '114'),
(190, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '114'),
(191, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 1, 18000, 18000, '115'),
(192, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '115'),
(186, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', 1, 16000, 16000, '113'),
(193, 'P-5.10.01-D', 'Placa mandibular curta com cabeça condilar P - Direita', '80859840212', 1, 16500, 16500, '116'),
(194, 'P-5.10.DM-D', 'Dispositivo mandibular P para corte e perfuração – Direita', '80859840169', 1, 1000, 1000, '116'),
(195, 'P-5.00.01-D', 'Fossa articular P – Direita', '80859840212', 1, 4000, 4000, '116'),
(196, 'P-5.DF.01-D', 'Dispositivo fossa de corte e perfuração para articulação pequena - Direita', '80859840169', 1, 1000, 1000, '116'),
(197, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 3, 204, 68, '116'),
(198, 'PC-920.205', 'Parafuso 2,0 x 05 Bloqueado', '80859840212', 6, 408, 68, '116'),
(199, 'PC-924.210', 'Parafuso 2,4 x 10 Bloqueado', '80859840212', 8, 544, 68, '116'),
(200, 'P-5.10.01-E', 'Placa mandibular curta com cabeça condilar P - Esquerda', '80859840212', 1, 16500, 16500, '116'),
(201, 'P-5.10.DM-E', 'Dispositivo mandibular CURTA P para corte e perfuração – esquerda ', '80859840169', 1, 1000, 1000, '116'),
(202, 'P-5.10.DM-E', 'Dispositivo mandibular CURTA P para corte e perfuração – esquerda', '80859840169', 1, 1000, 1000, '116'),
(203, 'P-5.00.01-E', ' Fossa Articular P', '80859840212', 1, 4000, 4000, '116'),
(204, 'P-5.00.01-E', 'Fossa Articular M', '80859840212', 1, 4000, 4000, '116'),
(205, 'P-5.DF.01-E', 'Dispositivo fossa de corte e perfuração para articulação pequena – esquerda', '80859840169', 1, 1000, 1000, '116'),
(206, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 3, 204, 68, '116'),
(207, 'PC-920.205', 'Parafuso 2,0 x 05 Bloqueado', '80859840212', 6, 408, 68, '116'),
(208, 'PC-924.210', 'Parafuso 2,4 x 10 Bloqueado', '80859840212', 8, 544, 68, '116'),
(209, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 1, 18000, 18000, '117'),
(210, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '117'),
(211, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 1, 18000, 18000, '118'),
(212, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '118'),
(213, 'P-5.10.01-D', 'Placa mandibular curta com cabeça condilar P - Direita', '80859840212', 1, 16500, 16500, '119'),
(214, 'P-5.10.DM-D', 'Dispositivo mandibular P para corte e perfuração – Direita', '80859840169', 1, 1000, 1000, '119'),
(215, 'P-5.00.01-D', 'Fossa articular P – Direita', '80859840212', 1, 4000, 4000, '119'),
(216, 'P-5.DF.01-D', 'Dispositivo fossa de corte e perfuração para articulação pequena - Direita', '80859840169', 1, 1000, 1000, '119'),
(217, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 3, 204, 68, '119'),
(218, 'PC-920.205', 'Parafuso 2,0 x 05 Bloqueado', '80859840212', 6, 408, 68, '119'),
(219, 'PC-924.210', 'Parafuso 2,4 x 10 Bloqueado', '80859840212', 8, 544, 68, '119'),
(220, 'P-5.10.01-E', 'Placa mandibular curta com cabeça condilar P - Esquerda', '80859840212', 1, 16500, 16500, '119'),
(221, 'P-5.10.DM-E', 'Dispositivo mandibular CURTA P para corte e perfuração – esquerda ', '80859840169', 1, 1000, 1000, '119'),
(222, 'P-5.10.DM-E', 'Dispositivo mandibular CURTA P para corte e perfuração – esquerda', '80859840169', 1, 1000, 1000, '119'),
(223, 'P-5.00.01-E', ' Fossa Articular P', '80859840212', 1, 4000, 4000, '119'),
(224, 'P-5.00.01-E', 'Fossa Articular M', '80859840212', 1, 4000, 4000, '119'),
(225, 'P-5.DF.01-E', 'Dispositivo fossa de corte e perfuração para articulação pequena – esquerda', '80859840169', 1, 1000, 1000, '119'),
(226, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 3, 204, 68, '119'),
(227, 'PC-920.205', 'Parafuso 2,0 x 05 Bloqueado', '80859840212', 6, 408, 68, '119'),
(228, 'PC-924.210', 'Parafuso 2,4 x 10 Bloqueado', '80859840212', 8, 544, 68, '119'),
(229, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 1, 18000, 18000, '120'),
(230, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '120'),
(231, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '121'),
(232, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '121'),
(233, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '122'),
(234, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '122'),
(235, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '123'),
(236, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '123'),
(237, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '124'),
(238, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '124'),
(239, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 1, 18000, 18000, '125'),
(240, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '125'),
(241, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '126'),
(242, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '126'),
(243, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', 1, 18000, 18000, '127'),
(244, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 30, 2040, 68, '127'),
(245, 'PC-301-T1*', 'RECONSTRUÇÃO ORBITA TIÂNIO TRABECULADO - 1', 'Licença Especial', 1, 31800, 31800, '128'),
(246, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 24, 1632, 68, '128'),
(247, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '129'),
(248, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 24, 1632, 68, '129'),
(249, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '130'),
(250, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '130'),
(251, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', 1, 16000, 16000, '131'),
(252, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '132'),
(253, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4560, 68, '132'),
(254, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', 1, 32800, 32800, '133'),
(255, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', 70, 4760, 68, '133');

-- --------------------------------------------------------

--
-- Estrutura da tabela `laudostomograficos`
--

DROP TABLE IF EXISTS `laudostomograficos`;
CREATE TABLE IF NOT EXISTS `laudostomograficos` (
  `laudoId` int NOT NULL AUTO_INCREMENT,
  `laudoNumProp` int NOT NULL,
  `laudoStatus` varchar(100) NOT NULL,
  `laudoDataDocumento` varchar(10) NOT NULL,
  `laudoDataExame` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`laudoId`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `laudostomograficos`
--

INSERT INTO `laudostomograficos` (`laudoId`, `laudoNumProp`, `laudoStatus`, `laudoDataDocumento`, `laudoDataExame`) VALUES
(1, 76, 'Pendente', '30/03/2022', '23/03/2022'),
(2, 110, 'Pendente', '17/03/2022', '21/03/2022'),
(3, 109, 'Pendente', '11/08/2021', NULL),
(4, 108, 'Pendente', '11/08/2021', NULL),
(5, 112, 'Pendente', '2022-03-25', NULL),
(6, 113, 'Pendente', '2022-03-25', NULL),
(7, 112, 'Pendente', '2022-03-31', NULL),
(8, 112, 'Pendente', '2022-03-31', NULL),
(9, 114, 'Pendente', '2022-03-31', NULL),
(10, 115, 'Pendente', '2022-03-31', NULL),
(11, 116, 'Pendente', '2022-03-24', NULL),
(12, 117, 'Pendente', '2022-03-31', NULL),
(13, 118, 'Pendente', '2022-03-31', NULL),
(14, 119, 'Pendente', '2022-03-31', NULL),
(15, 120, 'Pendente', '2022-03-31', NULL),
(16, 121, 'Pendente', '2022-03-30', NULL),
(17, 122, 'Pendente', '2022-03-30', NULL),
(18, 123, 'Pendente', '2022-03-31', NULL),
(19, 124, 'Pendente', '2022-03-30', ''),
(20, 125, 'Pendente', '2022-03-31', NULL),
(21, 126, 'Pendente', '2022-04-05', NULL),
(22, 127, 'Pendente', '2022-04-04', NULL),
(23, 128, 'Pendente', '2022-04-05', '05/04/2022'),
(24, 129, 'Pendente', '', NULL),
(25, 130, 'Pendente', '', '30/08/2022'),
(26, 131, 'Pendente', '', NULL),
(27, 132, 'Pendente', '', NULL),
(28, 133, 'Pendente', '', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `logdeatividades`
--

DROP TABLE IF EXISTS `logdeatividades`;
CREATE TABLE IF NOT EXISTS `logdeatividades` (
  `logId` int NOT NULL AUTO_INCREMENT,
  `logDtHora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logUser` varchar(200) NOT NULL,
  `logAtividade` text NOT NULL,
  PRIMARY KEY (`logId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `logdeatividades`
--

INSERT INTO `logdeatividades` (`logId`, `logDtHora`, `logUser`, `logAtividade`) VALUES
(1, '2021-12-01 19:16:24', 'dsd4fd54', 'Novo usuário criado por adm'),
(2, '2021-12-01 19:38:18', 'fdys', 'Novo usuário cadastrado'),
(3, '2021-12-03 18:15:43', 'antonia', 'Novo usuário criado por adm'),
(4, '2021-12-03 18:17:34', 'antonia', 'Novo usuário criado por adm'),
(5, '2021-12-03 18:21:11', 'antonia', 'Novo usuário criado por adm'),
(6, '2021-12-09 11:06:25', 'alan', 'Novo usuário criado por adm'),
(7, '2021-12-09 11:08:56', 'alan', 'Novo usuário criado por adm'),
(8, '2021-12-13 13:53:51', 'sdfsdf', 'Novo usuário cadastrado'),
(9, '2022-02-18 12:30:49', 'neandro', 'Novo usuário criado por adm'),
(10, '2022-02-23 13:46:06', 'doutordoutor', 'Novo usuário cadastrado'),
(11, '2022-02-23 13:56:59', 'osteofixnovo', 'Novo usuário cadastrado'),
(12, '2022-02-23 13:58:26', 'oesteonew', 'Novo usuário cadastrado'),
(13, '2022-02-23 14:00:59', 'pacientepaciente', 'Novo usuário cadastrado'),
(14, '2022-03-02 18:21:01', 'liberauser', 'Novo usuário criado por adm'),
(15, '2022-05-04 15:31:08', 'andreamartins', 'Novo usuário criado por adm'),
(16, '2022-05-04 15:31:41', 'julianaaguiar', 'Novo usuário criado por adm'),
(17, '2022-05-05 19:19:29', 'saulzapatta', 'Novo usuário criado por adm');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logstatus`
--

DROP TABLE IF EXISTS `logstatus`;
CREATE TABLE IF NOT EXISTS `logstatus` (
  `logstId` int NOT NULL AUTO_INCREMENT,
  `logstPropRef` int NOT NULL,
  `logstData` varchar(30) NOT NULL,
  `logstUsuario` varchar(200) NOT NULL,
  `logstDescricao` text NOT NULL,
  `logstOrigem` varchar(50) NOT NULL,
  PRIMARY KEY (`logstId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `logstatus`
--

INSERT INTO `logstatus` (`logstId`, `logstPropRef`, `logstData`, `logstUsuario`, `logstDescricao`, `logstOrigem`) VALUES
(1, 132, '16/05/2022 10:50:50', 'vanessa', 'PENDENTE', 'PROPOSTA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `materiaismidias`
--

DROP TABLE IF EXISTS `materiaismidias`;
CREATE TABLE IF NOT EXISTS `materiaismidias` (
  `mtmId` int NOT NULL AUTO_INCREMENT,
  `mtmAba` varchar(100) NOT NULL,
  `mtmSessao` varchar(100) NOT NULL,
  `mtmTitulo` varchar(100) NOT NULL,
  `mtmDescricao` varchar(100) NOT NULL,
  `mtmLink` text NOT NULL,
  `mtmDtCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mtmDtAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mtmRelevancia` int NOT NULL,
  PRIMARY KEY (`mtmId`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `materiaismidias`
--

INSERT INTO `materiaismidias` (`mtmId`, `mtmAba`, `mtmSessao`, `mtmTitulo`, `mtmDescricao`, `mtmLink`, `mtmDtCriacao`, `mtmRelevancia`) VALUES
(2, 'CMF', 'Apresentação', 'ATM e Reconstrução', 'Descrição do produto', 'https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/12/descricao-de-produto-atm-rec-rev4.pdf', '2021-12-09 17:09:29', 5),
(3, 'CMF', 'Apresentação', 'ATM sob medida', 'Apresentação', 'https://docs.google.com/presentation/d/e/2PACX-1vTlpL95uANABNGNLu4qvV_ZdIFUd4hpY-oGQrY17XAdH7vfMRHD_cgIGBSzkn1Dhtm6f3o_Ba_TOpYP/pub?start=false&loop=false&delayms=3000#slide=id.g63e76a2e42_0_0', '2021-12-09 17:10:08', 5),
(4, 'CMF', 'Apresentação', 'Reconstruções', 'Apresentação', 'https://conecta.cpmhdigital.com.br/wp-content/uploads/2021/10/Flyer-rec-buco-2021-desafiandolimites.pdf', '2021-12-09 17:10:47', 4),
(5, 'CMF', 'Apresentação', 'Reconstrução Facial', 'Apresentação', 'https://docs.google.com/presentation/d/e/2PACX-1vSYu6V9u6JXmEImTo3rjmAbqdkoc5lotO7ktQThPO6EgVe3Lp6lfiQfdD9NCWw6pgEqq-XifmaUfZEt/pub?start=false&loop=false&delayms=5000#slide=id.g63f98617d9_0_0', '2021-12-09 17:11:13', 4),
(6, 'CMF', 'Apresentação', 'Soluções CMF', 'Flyer', 'https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/flyer-craniomaxilofacial.png', '2021-12-09 17:11:39', 4),
(7, 'CMF', 'Apresentação', 'Smartmold Implantes Faciais', 'Apresentação', 'https://docs.google.com/presentation/d/1J5GrphFHSQ2rtTad-972J7V2FmH8B6r4rbr0p0ZOyE4/edit#slide=id.p', '2021-12-09 17:13:04', 3),
(8, 'CMF', 'Apresentação', 'Smartmold Implantes Faciais', 'Flyer', 'https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/flyer-implante-facial.png', '2021-12-09 17:13:25', 3),
(9, 'CMF', 'Apresentação', 'Reconstrução atrófica - Custom Life', 'Apresentação', 'https://docs.google.com/presentation/d/e/2PACX-1vSwgRjAEUIVhHx_pJe-Z3K4jlgFEBxHWPBIzDxYgMbY4NRctoXaWUzJkq4uuhA6O-08CSkQHSqC9oJB/pub?start=false&loop=false&delayms=3000#slide=id.gc85f952e89_0_0', '2021-12-09 17:13:47', 3),
(10, 'CMF', 'Apresentação', 'Reconstrução atrófica + Malha de reconstrução', 'Flyer', 'https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/flyer-customlife-mesh4u-digital.pdf', '2021-12-09 17:14:08', 2),
(11, 'CMF', 'Vídeos - ATM', 'ATM - Dr. Killian Evandro', 'Vídeo', 'https://www.youtube.com/watch?v=PcxFlMQLM-o', '2021-12-09 17:14:36', 5),
(12, 'CMF', 'Vídeos - ATM', 'ATM - Técnica cirúrgica', 'Vídeo', 'https://www.youtube.com/watch?v=_lkjKGJ_aX4&feature=emb_logo&ab_channel=CPMHDigital', '2021-12-09 17:16:03', 4),
(13, 'CMF', 'Vídeos - ATM', 'ATM - Dr. Jucélio Freitas', 'Vídeo', 'https://www.youtube.com/watch?v=vDqu-SSjUiw', '2021-12-09 17:16:22', 3),
(14, 'CMF', 'Vídeos - Smartmold', 'Smartmold - Apresentação', 'Vídeo', 'https://www.youtube.com/watch?v=1vzpkGBHF5Q&feature=emb_logo&ab_channel=CPMHDigital', '2021-12-09 17:41:06', 4),
(15, 'CMF', 'Vídeos - Smartmold', 'Smartmold - Dra. Vanessa Castro', 'Vídeo', 'https://www.youtube.com/watch?v=mp4AtJSyMas&feature=emb_logo&ab_channel=CPMHDigital', '2021-12-09 17:42:54', 3),
(16, 'CMF', 'Vídeos - Smartmold', 'Smartmold - Dr. Júlio Bisinotto', 'Vídeo', 'https://www.youtube.com/watch?v=WrZBPlmKiuE', '2021-12-09 17:43:17', 3),
(17, 'CMF', 'Vídeos - Reconstruções', 'Reconstruções CMF', 'Vídeo', 'https://www.youtube.com/playlist?list=PL1hJupdHr03cNfjwDWAXSeFUVqBAXC0QB', '2021-12-09 17:44:03', 4),
(18, 'CMF', 'Vídeos - Reconstruções', 'Reconstruções - Vidas transformardas', 'Playlist', 'https://www.youtube.com/playlist?list=PL1hJupdHr03dGx6gSP6JPUMVU9bCyjIfu', '2021-12-09 17:44:22', 3),
(19, 'CMF', 'Vídeos - Reconstrução atrófica', 'CustomLIFE - simulação em tecido', 'Vídeo', 'https://www.youtube.com/watch?v=jeuvuLfuGKs&feature=emb_logo&ab_channel=CPMHDigital', '2021-12-09 17:45:04', 3),
(20, 'COLUNA', 'Apresentação', 'Guia vertebral', 'Apresentação', 'https://docs.google.com/presentation/d/e/2PACX-1vSe-R-JT7eBzhH5TBcEDuxsHkcypyYy6Ovh1gv-buHpI-od3xUEIHrUO__3YDtUZOhLyx64KyJPFHQu/pub?start=false&loop=false&delayms=5000#slide=id.g63fa04458b_0_0', '2021-12-09 17:49:13', 3),
(21, 'COLUNA', 'Vídeos - Coluna', 'O que é ATA Coluna?', 'Vídeo', 'https://www.youtube.com/watch?v=3IuiB0d4xBE', '2021-12-09 17:49:31', 4),
(22, 'COLUNA', 'Vídeos - Coluna', 'Soluções para cirurgia de coluna', 'Vídeo', 'https://www.youtube.com/watch?v=BLy4xLA3OzY&feature=emb_logo&ab_channel=CPMHDigital', '2021-12-09 17:49:53', 3),
(23, 'COLUNA', 'Vídeos - Coluna', 'Inovações cirurgia de coluna - Dr. Gilmar Saad', 'Vídeo', 'https://www.youtube.com/watch?v=9YOTqRZ1DG8&feature=emb_logo&ab_channel=CPMHDigital', '2021-12-09 17:50:13', 2),
(24, 'COLUNA', 'Vídeos - Coluna', 'ATA Coluna - Dr. Márcio Vinhal', 'Vídeo', 'https://www.youtube.com/watch?v=9sUT49DYsY4', '2021-12-09 17:50:33', 2),
(25, 'CRÂNIO', 'Apresentação', 'Crânioplastia', 'Apresentação', 'https://docs.google.com/presentation/d/e/2PACX-1vRczKjIK8UdP9Df8o2PeBU9YfwUttWfeaxbzxXpEBN64dBwX7HGty7tkIp3YXv0b48x6F44TjhLpC2j/pub?start=false&loop=false&delayms=10000#slide=id.g63fa04458b_0_0', '2021-12-09 17:53:02', 3),
(26, 'CRÂNIO', 'Vídeos - Cranioplastia', 'Crânio - Calotas personalizadas CPMH', 'Vídeo', 'https://www.youtube.com/watch?v=sSZZl3Vo4cg', '2021-12-09 17:53:30', 4),
(27, 'CRÂNIO', 'Vídeos - Cranioplastia', 'Crânio - Técnica cirúrgica Fastmold', 'Vídeo', 'https://www.youtube.com/watch?v=d6ZxudOKD_w&feature=emb_logo&ab_channel=CPMHDigital', '2021-12-09 17:53:56', 4),
(28, 'CRÂNIO', 'Vídeos - Cranioplastia', 'Crânio - Dra. Alessandra Gorgulho', 'Vídeo', 'https://www.youtube.com/watch?v=DfEdvjS9nw0&feature=emb_logo&ab_channel=CPMHDigital', '2021-12-09 17:54:13', 3),
(29, 'DESCARTÁVEIS', 'Apresentação', 'Brocas', 'Apresentação', 'https://www.cpmhdigital.com.br/wp-content/uploads/2019/04/catalogo-brocas-e-piezo.pdf', '2021-12-09 17:54:55', 4),
(30, 'DESCARTÁVEIS', 'Apresentação', 'Ponteiras de Piezo', 'Apresentação', 'https://www.cpmhdigital.com.br/wp-content/uploads/2019/02/CATALOGO-PIEZO.pdf', '2021-12-09 17:55:12', 3),
(31, 'DESCARTÁVEIS', 'Apresentação', 'Pulse de lavagem', 'Apresentação', 'https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/Flyer-pulse-A4-cientifico.pdf', '2021-12-09 17:56:25', 3),
(32, 'ORTODONTIA', 'Apresentação', 'Miniplacas ortodônticas - Ancorfix', 'Apresentação', 'https://docs.google.com/presentation/d/e/2PACX-1vT44eYXD05rm079omsP5ATaLG0S2B--rs7u5uV6MuX09owvUsJw7vG03kGUhmxhh9LypTBB4KcZzvI2/pub?start=false&loop=false&delayms=5000#slide=id.p3', '2021-12-09 17:57:11', 4),
(33, 'ORTODONTIA', 'Apresentação', 'Ficha Técnica - Ancorfix', 'Catálogo', 'https://www.cpmhdigital.com.br/wp-content/uploads/2021/04/FICHA-TECNICA-ANCORFIX-05-04-2021.pdf', '2021-12-09 17:58:24', 3),
(34, 'ORTODONTIA', 'Vídeos - Ancorfix', 'Ancorfix - Depoimentos de profissionais', 'Playlist', 'https://www.youtube.com/playlist?list=PL1hJupdHr03eHkGdRk9bhi0habzLm9H7z', '2021-12-09 17:58:45', 3),
(35, 'ORTOPEDIA', 'Apresentação', 'Fixador Externo', 'Apresentação', 'https://docs.google.com/presentation/d/e/2PACX-1vRSO32fn3kHNi9zEnek5IASY1sKqNzX31BdDCkexfzv-7rA2OVJr94GKDR_bLuNdM2tUfqojrSCYLE7/pub?start=false&loop=false&delayms=5000#slide=id.g63e76a2e42_0_0', '2021-12-09 17:59:55', 3),
(36, 'ORTOPEDIA', 'Apresentação', 'Implantes personalizados', 'Apresentação', 'https://docs.google.com/presentation/d/e/2PACX-1vSK5eV1aA_qgVzRDwDqoz_6Xf6Blh_qR74NPvDqkz4El5s6M5DzmpWKODGszUY4G5Vjs0e04VvPwAwX/pub?start=false&loop=false&delayms=3000#slide=id.g9632109c0e_1_0', '2021-12-09 18:00:20', 3),
(37, 'RADIOFREQUÊNCIA', 'Apresentação', 'Radiofrequência DIROS', 'Apresentação', 'https://www.cpmhdigital.com.br/wp-content/uploads/2020/11/CATALOGO-RF-CPMH-2019.pdf', '2021-12-09 18:00:56', 3),
(38, 'RADIOFREQUÊNCIA', 'Apresentação', 'Tratamento da dor - Diros', 'Flyer', 'https://conecta.cpmhdigital.com.br/wp-content/uploads/2020/11/FLYER-A4-DIROS-1.pdf', '2021-12-09 18:01:22', 3),
(39, 'RADIOFREQUÊNCIA', 'Vídeos - Radiofrequência', 'Treinamento DIROS', 'Vídeo', 'https://www.youtube.com/watch?v=w3VamevcXNY&ab_channel=CPMHDigital', '2021-12-09 18:01:42', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoesexternasemail`
--

DROP TABLE IF EXISTS `notificacoesexternasemail`;
CREATE TABLE IF NOT EXISTS `notificacoesexternasemail` (
  `ntfEmailId` int NOT NULL AUTO_INCREMENT,
  `ntfEmailBDRef` varchar(100) NOT NULL,
  `ntfEmailNomeTemplate` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ntfEmailAssuntoEmail` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ntfEmailTexto` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ntfEmailDestinatario` varchar(100) NOT NULL,
  `ntfEmailDtCriacao` varchar(100) NOT NULL,
  `ntfEmailUserCriacao` varchar(100) NOT NULL,
  `ntfEmailDtUpdate` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ntfEmailUserUpdate` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`ntfEmailId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `notificacoesexternasemail`
--

INSERT INTO `notificacoesexternasemail` (`ntfEmailId`, `ntfEmailBDRef`, `ntfEmailNomeTemplate`, `ntfEmailAssuntoEmail`, `ntfEmailTexto`, `ntfEmailDestinatario`, `ntfEmailDtCriacao`, `ntfEmailUserCriacao`, `ntfEmailDtUpdate`, `ntfEmailUserUpdate`) VALUES
(4, 'propostas', 'Nova Solicitação Proposta - user criador', 'Portal Conecta - Solicitação de Proposta Recebida', '&lt;p&gt;Ol&amp;aacute;, [nome_criador]! Sua solicita&amp;ccedil;&amp;atilde;o foi recebida e j&amp;aacute; est&amp;aacute; em processo de an&amp;aacute;lise.&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Produto:&lt;/strong&gt; [tipo_produto]&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Dr(a):&lt;/strong&gt; [doutor]&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Paciente:&lt;/strong&gt; [paciente]&lt;/p&gt;\r\n&lt;p&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/minhassolicitacoes e acompanhe o andamento da sua proposta.&lt;/p&gt;\r\n&lt;div&gt;&lt;span style=&quot;color: #95a5a6;&quot;&gt; &lt;small&gt;Caso voc&amp;ecirc; n&amp;atilde;o tenha realizado essa solicita&amp;ccedil;&amp;atilde;o, mude sua senha na plataforma para sua seguran&amp;ccedil;a e nos comunique para verifica&amp;ccedil;&amp;atilde;o de usu&amp;aacute;rio.&lt;/small&gt; &lt;/span&gt;&lt;/div&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #95a5a6;&quot;&gt; &lt;small&gt;&amp;copy; Portal Conecta 2022&lt;/small&gt;&lt;/span&gt;&lt;/p&gt;', '[nome_criador]', 'vanessa', '20/12/2021 09:54:19', '11/03/2022 14:38:45', ''),
(5, 'propostas', 'Nova Solicitação Proposta - comercial', 'Portal Conecta - Nova Solicitação de Proposta', '&lt;p&gt;Ol&amp;aacute;, Comercial! Nova solicita&amp;ccedil;&amp;atilde;o de proposta recebida pelo Portal Conecta.&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;N&amp;deg; Proposta:&lt;/strong&gt; [num_proposta]&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Produto:&lt;/strong&gt; [tipo_produto]&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Dr(a):&lt;/strong&gt; [doutor]&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Paciente:&lt;/strong&gt; [paciente]&lt;/p&gt;\r\n&lt;p&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/comercial e altere os dados da proposta.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '[sistema_emailComercial]', 'vanessa', '20/12/2021 10:02:19', '11/03/2022 14:38:54', ''),
(6, 'propostas', 'Nova Solicitação Proposta - representante', 'Portal Conecta - Nova Solicitação de Proposta', '&lt;p&gt;Ol&amp;aacute;, [nome_representante]! Nova solicita&amp;ccedil;&amp;atilde;o de proposta recebida pelo Portal Conecta.&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;N&amp;deg; Proposta:&lt;/strong&gt; [num_proposta]&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Produto:&lt;/strong&gt; [tipo_produto]&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Dr(a):&lt;/strong&gt; [doutor]&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Paciente:&lt;/strong&gt; [paciente]&lt;br /&gt;&lt;br /&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/solicitacoes e acompanhe o andamento dessa proposta.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;/p&gt;', '[nome_representante]', 'vanessa', '20/12/2021 10:09:45', '11/03/2022 14:39:02', ''),
(7, 'propostas', 'Proposta Enviada - user criador', 'Portal Conecta - Devolutiva Proposta', '&lt;p&gt;Ol&amp;aacute;, [nome_criador]! Sua proposta N&amp;deg; [num_proposta]&amp;nbsp; j&amp;aacute; est&amp;aacute; dispon&amp;iacute;vel para confer&amp;ecirc;ncia.&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;Produto:&lt;/strong&gt; [tipo_produto]&lt;br /&gt;&lt;br /&gt;&lt;strong&gt;Dr(a):&lt;/strong&gt; [doutor]&lt;br /&gt;&lt;br /&gt;&lt;strong&gt;Paciente:&lt;/strong&gt; [paciente]&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Entre no Portal Conecta e verifique seus dados para aceitar a proposta.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #95a5a6; font-size: 10pt;&quot;&gt;Caso voc&amp;ecirc; n&amp;atilde;o tenha realizado essa solicita&amp;ccedil;&amp;atilde;o, mude sua senha na plataforma para sua seguran&amp;ccedil;a e nos comunique para verifica&amp;ccedil;&amp;atilde;o de usu&amp;aacute;rio.&lt;/span&gt;&lt;br /&gt;&lt;br /&gt;&lt;span style=&quot;color: #95a5a6; font-size: 10pt;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;/p&gt;', '[nome_criador]', 'vanessa', '20/12/2021 10:23:43', '21/12/2021 15:27:29', ''),
(8, 'propostas', 'Proposta Aceita - comercial', 'Portal Conecta - Proposta Aceita', '&lt;p&gt;Ol&amp;aacute;, Comercial! A Proposta N&amp;ordm; [num_proposta] foi aceita pelo cliente. O recibo de pagamento est&amp;aacute; sob an&amp;aacute;lise do Financeiro, aguarde atualiza&amp;ccedil;&amp;otilde;es.&lt;br /&gt;&lt;br /&gt;Produto: [tipo_produto]&lt;br /&gt;&lt;br /&gt;Dr(a): [doutor]&lt;br /&gt;&lt;br /&gt;Paciente: [paciente]&lt;br /&gt;&lt;br /&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/comercial e altere os dados da proposta.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;/p&gt;', '[sistema_emailComercial]', 'vanessa', '20/12/2021 11:10:34', '11/03/2022 14:39:19', ''),
(10, 'propostas', 'Proposta Aceita - financeiro', 'Portal Conecta - Recibo de Pagamento Enviado', '&lt;p&gt;Ol&amp;aacute;, Financeiro! Novo recibo de pagamento foi recebido no Portal Conecta.&lt;br /&gt;&lt;br /&gt;&lt;/p&gt;\r\n&lt;p&gt;Proposta N&amp;ordm;: [num_proposta]&lt;/p&gt;\r\n&lt;p&gt;Produto: [tipo_produto]&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/aceitesfinanceiros e atualize o status da proposta.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;/p&gt;', '[sistema_emailFinanceiro]', 'vanessa', '20/12/2021 11:20:40', '11/03/2022 14:39:29', ''),
(11, 'propostas', 'Recibo Pagamento Avaliado - comercial', 'Portal Conecta - Recibo de Pagamento Avaliado', '&lt;p&gt;Ol&amp;aacute;, Comercial! Recibo de pagamento da Proposta N&amp;ordm; [num_proposta] foi avaliado.&lt;/p&gt;\r\n&lt;p&gt;Proposta N&amp;ordm;: [num_proposta]&lt;br /&gt;Produto: [tipo_produto]&lt;/p&gt;\r\n&lt;p&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/comercial e altere os dados da proposta.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;/p&gt;', '[sistema_emailComercial]', 'vanessa', '20/12/2021 11:31:18', '11/03/2022 14:39:39', ''),
(12, 'propostas', 'Recibo Pagamento Avaliado - user criador', 'Portal Conecta - Recibo de Pagamento Avaliado', '&lt;p&gt;Ol&amp;aacute;, [nome_criador]! Seu recibo de pagamento da Proposta N&amp;ordm; [num_proposta] foi avaliado.&lt;br /&gt;&lt;br /&gt;Proposta N&amp;ordm;: [num_proposta]&lt;br /&gt;Produto: [tipo_produto]&lt;/p&gt;\r\n&lt;p&gt;&lt;br /&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/minhassolicitacoes e acompanhe o andamento da sua proposta, ou pelo link https://conecta.cpmhdigital.com.br/financeiro e acompanhe sua situa&amp;ccedil;&amp;atilde;o financeira.&lt;/p&gt;\r\n&lt;p&gt;&lt;br /&gt;&lt;span style=&quot;color: #95a5a6; font-size: 10pt;&quot;&gt;Caso voc&amp;ecirc; n&amp;atilde;o tenha realizado essa solicita&amp;ccedil;&amp;atilde;o, mude sua senha na plataforma para sua seguran&amp;ccedil;a e nos comunique para verifica&amp;ccedil;&amp;atilde;o de usu&amp;aacute;rio.&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;/p&gt;', '[nome_criador]', 'vanessa', '20/12/2021 11:38:55', '11/03/2022 14:39:58', ''),
(13, 'propostas', 'Proposta vira Pedido - user criador', 'Portal Conecta - Novo Pedido', '&lt;p&gt;Ol&amp;aacute;, [nome_criador]! J&amp;aacute; est&amp;aacute; tudo pronto!&lt;/p&gt;\r\n&lt;p&gt;Sua Proposta de N&amp;ordm; [num_proposta] do produto [tipo_produto] virou pedido. Seu novo n&amp;uacute;mero de acompanhamento &amp;eacute; o Pedido N&amp;ordm; [num_pedido].&lt;/p&gt;\r\n&lt;p&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/meuscasos e acompanhe as novas ativiadades.&lt;/p&gt;\r\n&lt;p&gt;&lt;br /&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;Caso voc&amp;ecirc; n&amp;atilde;o tenha realizado essa solicita&amp;ccedil;&amp;atilde;o, mude sua senha na plataforma para sua seguran&amp;ccedil;a e nos comunique para verifica&amp;ccedil;&amp;atilde;o de usu&amp;aacute;rio.&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;/p&gt;', '[nome_criador]', 'vanessa', '20/12/2021 11:45:03', '11/03/2022 14:40:08', ''),
(14, 'propostas', 'Proposta vira Pedido - planejamento', 'Portal Conecta - Novo Pedido', '&lt;p&gt;Ol&amp;aacute;, Planejamento! Novo pedido de N&amp;ordm; [num_pedido] criado.&lt;/p&gt;\r\n&lt;p&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/lista-casos e d&amp;ecirc; continuidade ao processo.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;/p&gt;', '[sistema_emailPlanejamento]', 'vanessa', '20/12/2021 11:49:07', '11/03/2022 14:40:19', ''),
(15, 'propostas', 'Nova TC Enviada - planejamento', 'Portal Conecta - Nova TC Enviada', '&lt;p&gt;Ol&amp;aacute;, Planejamento! Nova TC recebida pelo Portal Conecta.&lt;br /&gt;&lt;br /&gt;Produto: [tipo_produto]&lt;br /&gt;&lt;br /&gt;Dr(a): &lt;span class=&quot;badge bg-secondary my-1&quot; style=&quot;font-size: 1rem;&quot;&gt;[doutor]&lt;/span&gt;&lt;br /&gt;&lt;br /&gt;Paciente: [paciente]&lt;/p&gt;\r\n&lt;p&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/planejamento e d&amp;ecirc; continuidade ao processo.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #95a5a6; font-size: 10pt;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '[sistema_emailPlanejamento]', 'vanessa', '20/12/2021 12:00:45', '11/03/2022 14:40:30', ''),
(16, 'propostas', 'TC Avaliada - user criador', 'Portal Conecta - TC Avaliada', '&lt;p&gt;Ol&amp;aacute;, [nome_criador]! Sua TC da Proposta N&amp;ordm; [num_proposta] foi avaliada.&lt;br /&gt;&lt;br /&gt;Proposta N&amp;ordm;: [num_proposta]&lt;/p&gt;\r\n&lt;p&gt;Produto: [tipo_produto]&lt;/p&gt;\r\n&lt;p&gt;Status TC: [status_tc]&lt;/p&gt;\r\n&lt;p&gt;&lt;br /&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/minhassolicitacoes e acompanhe o andamento da sua proposta.&lt;/p&gt;\r\n&lt;p&gt;&lt;br /&gt;&lt;span style=&quot;color: #95a5a6; font-size: 10pt;&quot;&gt;Caso voc&amp;ecirc; n&amp;atilde;o tenha realizado essa solicita&amp;ccedil;&amp;atilde;o, mude sua senha na plataforma para sua seguran&amp;ccedil;a e nos comunique para verifica&amp;ccedil;&amp;atilde;o de usu&amp;aacute;rio.&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;color: #95a5a6; font-size: 10pt;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '[nome_criador]', 'vanessa', '20/12/2021 12:11:49', '11/03/2022 14:40:55', ''),
(17, 'propostas', 'TC Avaliada - comercial', 'Portal Conecta - TC Avaliada', '&lt;p&gt;Ol&amp;aacute;, Comercial! TC da Proposta N&amp;ordm; [num_proposta] foi avaliada.&lt;br /&gt;&lt;br /&gt;Proposta N&amp;ordm;: [num_proposta]&lt;/p&gt;\r\n&lt;p&gt;Produto: [tipo_produto]&lt;/p&gt;\r\n&lt;p&gt;Status TC: [status_tc]&lt;/p&gt;\r\n&lt;p&gt;&lt;br /&gt;Para mais informa&amp;ccedil;&amp;otilde;es acesse o portal conecta pelo link https://conecta.cpmhdigital.com.br/comercial e altere os dados da proposta.&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; color: #95a5a6;&quot;&gt;&amp;copy; Portal Conecta 2022&lt;/span&gt;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;br /&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;br /&gt;&lt;br /&gt;&lt;/p&gt;', '[sistema_emailComercial]', 'vanessa', '20/12/2021 12:14:57', '11/03/2022 14:41:05', ''),
(18, 'propostas', 'Qualificação do Cliente - Envio de Link', 'Portal Conecta - Qualificação do Cliente', '&lt;p&gt;Ol&amp;aacute;,&amp;nbsp;[nome_criador].&lt;/p&gt;\r\n&lt;p&gt;Agradecemos a confian&amp;ccedil;a com a CPMH. Notamos que voc&amp;ecirc; ainda n&amp;atilde;o est&amp;aacute; qualificado em nosso sistema de Gest&amp;atilde;o da Qualidade. Por favor preencha o formul&amp;aacute;rio de&amp;nbsp;&lt;strong data-stringify-type=\\&quot;\\\\&amp;quot;bold\\\\&amp;quot;\\&quot;&gt;Qualifica&amp;ccedil;&amp;atilde;o de Distribuidor&amp;nbsp;&lt;/strong&gt;para darmos continuidade &amp;agrave; sua solicita&amp;ccedil;&amp;atilde;o&lt;strong data-stringify-type=\\&quot;\\\\&amp;quot;bold\\\\&amp;quot;\\&quot;&gt;.&lt;/strong&gt;&lt;br /&gt;Link:&amp;nbsp;&lt;a class=\\&quot;\\\\&amp;quot;c-link\\\\&amp;quot;\\&quot; tabindex=\\&quot;\\\\&amp;quot;-1\\\\&amp;quot;\\&quot; href=\\&quot;\\\\&amp;quot;https:/form.jotform.com/GRUPOFIX/qualificao-de-clientes\\\\&amp;quot;\\&quot; target=\\&quot;\\\\&amp;quot;_blank\\\\&amp;quot;\\&quot; rel=\\&quot;\\\\&amp;quot;noopener\\&quot; data-stringify-link=\\&quot;\\\\&amp;quot;https://form.jotform.com/GRUPOFIX/qualificao-de-clientes\\\\&amp;quot;\\&quot; data-sk=\\&quot;\\\\&amp;quot;tooltip_parent\\\\&amp;quot;\\&quot; data-remove-tab-index=\\&quot;\\\\&amp;quot;true\\\\&amp;quot;\\&quot;&gt;https://form.jotform.com/GRUPOFIX/qualificao-de-clientes?id=[num_proposta]&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;Em breve entraremos em contato com a devolutiva da qualifica&amp;ccedil;&amp;atilde;o e cadastro de sua empresa junto ao nosso SGQ.&lt;br /&gt;Ficaremos muitos felizes em t&amp;ecirc;-lo como parceiro.&lt;/p&gt;\r\n&lt;p&gt;&lt;br /&gt;Em caso de d&amp;uacute;vida, estamos a disposi&amp;ccedil;&amp;atilde;o por meio do n&amp;uacute;mero (61)3028-8878&lt;br /&gt;Atenciosamente,&lt;br /&gt;Equipe CPMH&lt;span class=\\&quot;\\\\&amp;quot;c-message__edited_label\\\\&amp;quot;\\&quot; dir=\\&quot;\\\\&amp;quot;ltr\\\\&amp;quot;\\&quot; data-sk=\\&quot;\\\\&amp;quot;tooltip_parent\\\\&amp;quot;\\&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;/p&gt;', '[nome_criador]', 'vanessa', '31/05/2022 10:25:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoesexternaswpp`
--

DROP TABLE IF EXISTS `notificacoesexternaswpp`;
CREATE TABLE IF NOT EXISTS `notificacoesexternaswpp` (
  `ntfWppId` int NOT NULL AUTO_INCREMENT,
  `ntfWppBDRef` varchar(100) NOT NULL,
  `ntfWppNomeTemplate` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ntfWppTitulo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ntfWppTexto` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ntfWppDestinatario` varchar(100) NOT NULL,
  `ntfWppDtCriacao` varchar(100) NOT NULL,
  `ntfWppUserCriacao` varchar(100) NOT NULL,
  `ntfWppDtUpdate` varchar(100) DEFAULT NULL,
  `ntfWppUserUpdate` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ntfWppId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `notificacoesexternaswpp`
--

INSERT INTO `notificacoesexternaswpp` (`ntfWppId`, `ntfWppBDRef`, `ntfWppNomeTemplate`, `ntfWppTitulo`, `ntfWppTexto`, `ntfWppDestinatario`, `ntfWppDtCriacao`, `ntfWppUserCriacao`, `ntfWppDtUpdate`, `ntfWppUserUpdate`) VALUES
(2, 'propostas', 'Nova Solicitação Proposta - user criador', 'Portal Conecta - Solicitação de Proposta Recebida', '&lt;p dir=&quot;ltr&quot; style=&quot;line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;Ola [doutor]! Somos o *&lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;Portal Conecta*&lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt; &lt;/span&gt;&lt;a style=&quot;text-decoration: none;&quot; href=&quot;https://emojipedia.org/winking-face/&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #2458a1; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;😉&lt;/span&gt;&lt;/a&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt; e estamos felizes por ter nos escolhido para te auxiliar na realizacao do seu projeto. &lt;/span&gt;&lt;a style=&quot;text-decoration: none;&quot; href=&quot;https://emojipedia.org/party-popper/&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #2458a1; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;🎉&lt;/span&gt;&lt;/a&gt;&lt;a style=&quot;text-decoration: none;&quot; href=&quot;https://emojipedia.org/partying-face/&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #2458a1; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;🥳&lt;/span&gt;&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;Dentro da Plataforma voce podera acessar o link &lt;/span&gt;&lt;a style=&quot;text-decoration: none;&quot; href=&quot;projeto?id=O%E2%D0X%D7%93x0%23%BC%A3RD%DB%A9%C6%3ADpFoXS9HJkWt9%2BsAhweboA%3D%3D&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #0097a7; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: underline; -webkit-text-decoration-skip: none; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;https://conecta.cpmhdigital.com.br/projeto?id=&lt;/span&gt;&lt;/a&gt;&lt;span style=&quot;font-family: Arial; font-size: 13.3333px; white-space: pre-wrap;&quot;&gt;[num_pedido]&lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt; para *&lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;AGENDAR A VIDEO* &lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;com nossos especialistas! Te aguardamos!&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;&lt;span style=&quot;background-color: #ffffff; color: #333333; font-family: \'Segoe UI Emoji\';&quot;&gt;🖥 &lt;/span&gt;*Projeto:* [num_pedido]&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;&lt;span style=&quot;background-color: #ffffff; color: #333333; font-family: \'Segoe UI Emoji\';&quot;&gt;🏷 &lt;/span&gt;*Produto:* [tipo_produto]&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;&lt;span style=&quot;background-color: #ffffff; color: #333333; font-family: \'Segoe UI Emoji\';&quot;&gt;👤 &lt;/span&gt;*Paciente:* [paciente]&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;_Em caso de duvidas, entre em contato com nossa equipe pelo wpp no numero (61)99946-8880._&lt;/span&gt;&lt;/p&gt;', '[nome_criador]', 'vanessa', '24/02/2022 16:33:42', '19/10/2022 12:08:58', ''),
(3, 'pedido', 'Agendamento de Vídeo Liberado', 'Agendamento de Vídeo Liberado', '&lt;p dir=&quot;ltr&quot; style=&quot;line-height: 1.2; margin-top: 0pt; margin-bottom: 0pt;&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;Ola [nome_dr]! Somos o *&lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;Portal Conecta*&lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt; &lt;/span&gt;&lt;a style=&quot;text-decoration: none;&quot; href=&quot;https://emojipedia.org/winking-face/&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #2458a1; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;😉&lt;/span&gt;&lt;/a&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt; e estamos felizes por ter nos escolhido para te auxiliar na realizacao do seu projeto. &lt;/span&gt;&lt;a style=&quot;text-decoration: none;&quot; href=&quot;https://emojipedia.org/party-popper/&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #2458a1; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;🎉&lt;/span&gt;&lt;/a&gt;&lt;a style=&quot;text-decoration: none;&quot; href=&quot;https://emojipedia.org/partying-face/&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #2458a1; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;🥳&lt;/span&gt;&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;Dentro da Plataforma voce podera acessar o link &lt;/span&gt;&lt;a style=&quot;text-decoration: none;&quot; href=&quot;projeto?id=O%E2%D0X%D7%93x0%23%BC%A3RD%DB%A9%C6%3ADpFoXS9HJkWt9%2BsAhweboA%3D%3D&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #0097a7; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: underline; -webkit-text-decoration-skip: none; text-decoration-skip-ink: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;https://conecta.cpmhdigital.com.br/projeto?id=&lt;/span&gt;&lt;/a&gt;&lt;span style=&quot;font-family: Arial; font-size: 13.3333px; white-space: pre-wrap;&quot;&gt;[num_pedido]&lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt; para *&lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: bold; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;AGENDAR A VIDEO* &lt;/span&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;com nossos especialistas! Te aguardamos!&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;&lt;span style=&quot;background-color: #ffffff; color: #333333; font-family: \'Segoe UI Emoji\';&quot;&gt;🖥 &lt;/span&gt;*Projeto:* [num_pedido]&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;&lt;span style=&quot;background-color: #ffffff; color: #333333; font-family: \'Segoe UI Emoji\';&quot;&gt;🏷 &lt;/span&gt;*Produto:* [tipo_produto]&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;&lt;span style=&quot;background-color: #ffffff; color: #333333; font-family: \'Segoe UI Emoji\';&quot;&gt;👤 &lt;/span&gt;*Paciente:* [nome_pac]&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 10pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;&quot;&gt;_Em caso de duvidas, entre em contato com nossa equipe pelo wpp no numero (61)99946-8880._&lt;/span&gt;&lt;/p&gt;', '[nome_criador]', 'vanessa', '07/10/2022 14:30:13', '19/10/2022 15:54:50', ''),
(7, 'pedido', 'Agendamento de Vídeo Marcado', 'Agendamento de Vídeo Marcado', '&lt;p dir=&quot;\\&amp;quot;ltr\\&amp;quot;&quot;&gt;Ola [nome_dr]!&lt;/p&gt;\r\n&lt;p&gt;✔️O *Portal Conecta* agradece a oportunidade de realizarmos o projeto junto e por ter agendado a videoconferencia. Preparamos o projeto para demonstrar e ter seu aceite para envio a producao.&lt;/p&gt;\r\n&lt;p dir=&quot;\\&amp;quot;ltr\\&amp;quot;&quot;&gt;🖥️ Para acessar a sala no dia agendado, basta acessar o link *https://meet.google.com/aft-tadt-cyh*.&lt;/p&gt;\r\n&lt;p dir=&quot;\\&amp;quot;ltr\\&amp;quot;&quot;&gt;📧 *Fique atento ao seu e-mail*, nele voce recebera informacoes&amp;nbsp; importantes sobre a video.&lt;/p&gt;\r\n&lt;p dir=&quot;\\&amp;quot;ltr\\&amp;quot;&quot;&gt;_Em caso de duvidas, entre em contato com nossa equipe pelo wpp no numero (61) 99946-8880._&lt;/p&gt;\r\n&lt;p dir=&quot;\\&amp;quot;ltr\\&amp;quot;&quot;&gt;Ate la!&lt;/p&gt;', '[nome_criador]', 'vanessa', '19/10/2022 17:00:34', '19/10/2022 17:04:22', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `pedId` int NOT NULL AUTO_INCREMENT,
  `pedNumPedido` varchar(20) NOT NULL,
  `pedPropRef` varchar(20) NOT NULL,
  `pedUserCriador` varchar(50) NOT NULL,
  `pedRep` varchar(50) NOT NULL,
  `pedSharedUsers` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `pedNomeDr` varchar(100) NOT NULL,
  `pedNomePac` varchar(100) NOT NULL,
  `pedCrmDr` varchar(20) NOT NULL,
  `pedProduto` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pedTipoProduto` varchar(20) NOT NULL,
  `pedStatus` varchar(20) NOT NULL,
  `pedPosicaoFluxo` int NOT NULL,
  `pedDtCriacaoPed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pedAbaAgenda` varchar(8) NOT NULL,
  `pedAbaVisualizacao` varchar(8) NOT NULL,
  `pedAbaAceite` varchar(8) NOT NULL,
  `pedAbaRelatorio` varchar(8) NOT NULL,
  `pedAbaDocumentos` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pedAndamento` varchar(10) NOT NULL,
  PRIMARY KEY (`pedId`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`pedId`, `pedNumPedido`, `pedPropRef`, `pedUserCriador`, `pedRep`, `pedSharedUsers`, `pedNomeDr`, `pedNomePac`, `pedCrmDr`, `pedProduto`, `pedTipoProduto`, `pedStatus`, `pedPosicaoFluxo`, `pedDtCriacaoPed`, `pedAbaAgenda`, `pedAbaVisualizacao`, `pedAbaAceite`, `pedAbaRelatorio`, `pedAbaDocumentos`, `pedAndamento`) VALUES
(85, '5251', '106', 'fulanodetal', 'luisaragao', NULL, 'Fulano De Tal', 'HIJ', '659', '', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-05-25 17:07:11', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(84, '5252', '109', 'fulanodetal', 'luisaragao', NULL, 'Fulano De Tal', 'TRE', '6855', 'KITPC-6000/PC-920.210', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-05-25 17:05:47', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(83, '5253', '78', 'doutordoutor', 'julianaaguiar', NULL, 'Joao Heitor', 'ABC', '4654', 'E200.011-KD', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-05-25 17:04:16', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(82, '5254', '93', 'Escolha um Dr(a)', 'luisaragao', NULL, 'Saads', 'MARIAROSáRIO', '5465464', 'E200.011-KD/PC-920.210', 'ATA BUCO', 'CRIADO', 0, '2022-05-25 17:02:10', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(81, '1123', '132', 'doutordoutor', 'julianaaguiar', NULL, 'Teste', 'ABC', '', 'KITPC-6002/PC-920.210', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-05-25 17:00:47', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(80, '5255', '94', 'doutordoutor', 'julianaaguiar', NULL, 'Fulano De Tal', 'SFFD', '454', 'E200.013-1 E/E200.011-F', 'SMARTMOLD', 'CRIADO', 0, '2022-05-25 16:57:38', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(79, '5257', '133', 'teste', 'julianaaguiar', NULL, 'Teste', 'Paciente', 'CRO-DF-123', 'PC700', 'CUSTOMLIFE', 'CRIADO', 0, '2022-05-25 16:53:45', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(78, '5257', '133', 'teste', 'julianaaguiar', NULL, 'Teste', 'Paciente', 'CRO-DF-123', 'PC700', 'CUSTOMLIFE', 'CRIADO', 0, '2022-05-25 16:53:22', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(77, '5257', '133', 'teste', 'julianaaguiar', NULL, 'Teste', 'Paciente', 'CRO-DF-123', 'PC700', 'CUSTOMLIFE', 'CRIADO', 0, '2022-05-25 16:51:31', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(74, '5258', '132', 'teste', 'julianaaguiar', NULL, 'Teste', 'Paciente', 'CRO-DF-123', 'PC700', 'CUSTOMLIFE', 'CRIADO', 0, '2022-05-25 16:39:38', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(75, '5257', '133', 'teste', 'julianaaguiar', NULL, 'Teste', 'Paciente', 'CRO-DF-123', 'PC700', 'CUSTOMLIFE', 'CRIADO', 0, '2022-05-25 16:40:12', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(76, '5257', '133', 'teste', 'julianaaguiar', NULL, 'Teste', 'Paciente', 'CRO-DF-123', 'PC700', 'CUSTOMLIFE', 'CRIADO', 0, '2022-05-25 16:50:05', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(73, '5258', '132', 'teste', 'julianaaguiar', NULL, 'Teste', 'Paciente', 'CRO-DF-123', 'PC700', 'CUSTOMLIFE', 'CRIADO', 0, '2022-05-25 16:39:38', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(68, '98656', '129', 'vanessa', 'neandro', NULL, 'Doutor Doutor', 'ABC', 'CRO-PB-2154', 'KITPC-6002/PC-920.210', 'ORTOGNÁTICA', 'PROD', 4, '2022-04-07 18:03:01', 'liberado', 'fechado', 'liberado', 'liberado', 'liberado', 'PENDENTE'),
(67, '9685', '121', 'vanessa', 'neandro', NULL, 'Fulano de Tal', 'ABC', '12145', 'KITPC-6002/PC-920.210', 'ORTOGNÁTICA', 'PLAN', 1, '2022-04-06 19:25:05', 'liberado', 'liberado', 'liberado', 'liberado', 'liberado', 'ABERTO'),
(66, '1234', '122', 'vanessa', 'neandro', NULL, 'Doutor Doutor', 'ABC', 'CRO-PB-2154', 'KITPC-6002/PC-920.210', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-04-06 19:23:14', 'fechado', 'fechado', 'fechado', 'fechado', 'fechado', 'ABERTO'),
(65, '65487', '123', 'fulanodetal', 'neandro', NULL, 'Heitor Jorge', 'ABC', 'CRO-DF-55454', 'KITPC-6002/PC-920.210', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-04-06 18:56:12', 'fechado', 'fechado', 'fechado', 'fechado', 'liberado', 'ABERTO'),
(64, '89565', '125', 'fulanodetal', 'neandro', NULL, 'Doutor Teste', 'ABC', ' ', 'KITPC-6000/PC-920.210', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-04-06 18:03:47', 'liberado', 'fechado', 'liberado', 'liberado', 'liberado', 'ABERTO'),
(63, '6598', '128', 'fulanodetal', 'neandro', NULL, 'Doutor Teste 3', 'DEF', ' ', 'PC-301-T1*/PC-920.210', 'RECONSTRUÇÃO ÓSSEA', 'CRIADO', 0, '2022-04-06 15:41:51', 'fechado', 'fechado', 'fechado', 'fechado', 'liberado', 'FINALIZADO'),
(62, '991', '124', 'doutordoutor', 'neandro', NULL, 'Doutor Teste', 'ABC', ' ', 'KITPC-6002/PC-920.210', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-04-06 15:00:50', 'fechado', 'fechado', 'fechado', 'fechado', 'liberado', 'ARQUIVADO'),
(61, '8638', '126', 'doutordoutor', 'neandro', NULL, 'Doutor Teste', 'ABC', ' ', 'KITPC-6002/PC-920.210', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-04-06 14:59:19', 'fechado', 'fechado', 'fechado', 'fechado', 'liberado', 'PENDENTE'),
(60, '1237', '127', 'doutordoutor', 'neandro', NULL, 'Doutor Teste 2', 'ABCD', ' ', 'KITPC-6000/PC-920.210', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-04-06 14:57:40', 'fechado', 'fechado', 'fechado', 'fechado', 'liberado', 'PENDENTE'),
(59, '1111', '95', 'heitorjorge', 'ikaro', NULL, 'Fulano de Tal', 'FSDFS', ' ', 'E200.011-F/E200.011-G', 'SMARTMOLD', 'CRIADO', 0, '2022-03-24 21:30:46', 'liberado', 'liberado', 'liberado', 'liberado', 'liberado', 'ABERTO'),
(58, '9876', '111', 'heitorjorge', 'neandro', NULL, 'Teste Teste', 'DEF', ' ', 'KITPC-6000/PC-920.210', 'ORTOGNÁTICA', 'CRIADO', 0, '2022-03-22 17:35:44', 'fechado', 'fechado', 'fechado', 'fechado', 'liberado', 'ABERTO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `placeholdersnotificacao`
--

DROP TABLE IF EXISTS `placeholdersnotificacao`;
CREATE TABLE IF NOT EXISTS `placeholdersnotificacao` (
  `plntfId` int NOT NULL AUTO_INCREMENT,
  `plntfBd` varchar(200) NOT NULL,
  `plntfNome` varchar(200) NOT NULL,
  `plntfVariavel` varchar(200) NOT NULL,
  PRIMARY KEY (`plntfId`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `placeholdersnotificacao`
--

INSERT INTO `placeholdersnotificacao` (`plntfId`, `plntfBd`, `plntfNome`, `plntfVariavel`) VALUES
(1, 'propostas', '[doutor]', 'propNomeDr'),
(2, 'propostas', '[nome_criador]', 'propUserCriacao'),
(3, 'propostas', '[status_comercial]', 'propStatus'),
(4, 'propostas', '[status_tc]', 'propStatusTC'),
(20, 'propostas', '[uf]', 'propUf'),
(6, 'propostas', '[email_criador]', 'propEmailCriacao'),
(7, 'propostas', '[data_criacao]', 'propDataCriacao'),
(8, 'propostas', '[num_proposta]', 'propId'),
(9, 'propostas', '[empresa]', 'propEmpresa'),
(10, 'propostas', '[num_conselho]', 'propNConselhoDr'),
(11, 'propostas', '[email_dr]', 'propEmailDr'),
(12, 'propostas', '[telefone_dr]', 'propTelefoneDr'),
(13, 'propostas', '[paciente]', 'propNomePac'),
(14, 'propostas', '[convenio]', 'propConvenio'),
(15, 'propostas', '[email_envio]', 'propEmailEnvio'),
(16, 'propostas', '[tipo_produto]', 'propTipoProd'),
(17, 'propostas', '[lista_itens_json]', 'propLongListaItens'),
(18, 'propostas', '[lista_itens_cdgs]', 'propListaItens'),
(19, 'propostas', '[espessura]', 'propEspessura'),
(21, 'propostas', '[nome_representante]', 'propRepresentante'),
(22, 'propostas', '[validade_proposta]', 'propValidade'),
(23, 'propostas', '[valor_total]', 'propValorPosDesconto'),
(24, 'propostas', '[porcentagem_desconto]', 'propDesconto'),
(25, 'propostas', '[valor_desconto]', 'propValorDesconto'),
(26, 'propostas', '[texto_tc_reprovada]', 'propTxtReprov'),
(27, 'propostas', '[num_pedido]', 'propPedido'),
(28, 'propostas', '[taxa_extra]', 'propTaxaExtra'),
(29, 'propostas', '[plano_de_venda]', 'propPlanoVenda'),
(30, 'propostas', '[dr_uid]', 'propDrUid'),
(31, 'propostas', '[cnpj_cpf]', 'propCnpjCpf'),
(32, 'pedido', '[num_pedido]', 'pedNumPedido'),
(33, 'pedido', '[num_proposta]', 'pedPropRef'),
(34, 'pedido', '[nome_criador]', 'pedUserCriador'),
(35, 'pedido', '[representante]', 'pedRep'),
(36, 'pedido', '[nome_dr]', 'pedNomeDr'),
(37, 'pedido', '[nome_pac]', 'pedNomePac'),
(38, 'pedido', '[num_conselho]', 'pedCrmDr'),
(40, 'pedido', '[tipo_produto]', 'pedTipoProduto'),
(41, 'pedido', '[lista_itens_cdgs]', 'pedProduto'),
(42, 'pedido', '[status]', 'pedStatus'),
(43, 'pedido', '[data_criacao]', 'pedDtCriacaoPed'),
(45, 'propostas', '[sistema_emailComercial]', 'negocios@cpmh.com.br'),
(46, 'propostas', '[sistema_emailFinanceiro]', 'financeiro@fixgrupo.com.br'),
(47, 'propostas', '[sistema_emailPlanejamento]', 'planejamento@cpmh.com.br'),
(48, 'propostas', '[sistema_celComercial]', '5561999468880'),
(49, 'propostas', '[sistema_celFinanceiro]', '5561999658880');

-- --------------------------------------------------------

--
-- Estrutura da tabela `planosfinanceiros`
--

DROP TABLE IF EXISTS `planosfinanceiros`;
CREATE TABLE IF NOT EXISTS `planosfinanceiros` (
  `finId` int NOT NULL AUTO_INCREMENT,
  `finModalidade` varchar(256) NOT NULL,
  PRIMARY KEY (`finId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `planosfinanceiros`
--

INSERT INTO `planosfinanceiros` (`finId`, `finModalidade`) VALUES
(4, 'Antecipado'),
(5, 'Entrada Antecipado 20% + 30 e 60 dias'),
(6, 'Entrada Antecipado 30% + 28/56/84 dias'),
(7, 'Entrada Antecipado 50% + 30/60 dias'),
(8, 'Entrada Antecipado 50% + 50%'),
(11, '35% antecipado + 35% + 30%');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtoagenda`
--

DROP TABLE IF EXISTS `produtoagenda`;
CREATE TABLE IF NOT EXISTS `produtoagenda` (
  `produtoagendaId` int NOT NULL AUTO_INCREMENT,
  `produtoagendaNome` varchar(30) NOT NULL,
  PRIMARY KEY (`produtoagendaId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `produtoagenda`
--

INSERT INTO `produtoagenda` (`produtoagendaId`, `produtoagendaNome`) VALUES
(1, 'CustomLIFE'),
(2, 'Smartmold'),
(3, 'ATM'),
(4, 'Reconstrução'),
(5, 'Crânio'),
(6, 'Coluna'),
(7, 'Ortopedia'),
(8, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `prodId` int NOT NULL AUTO_INCREMENT,
  `prodCodCallisto` varchar(48) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prodDescricao` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prodAnvisa` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prodPreco` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prodParafuso` int NOT NULL,
  `prodKitDr` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prodTxtCotacao` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prodTxtAcompanha` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prodCodPropPadrao` varchar(48) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prodCategoria` varchar(48) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prodImposto` int DEFAULT NULL,
  `prodNCM` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`prodId`)
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`prodId`, `prodCodCallisto`, `prodDescricao`, `prodAnvisa`, `prodPreco`, `prodParafuso`, `prodKitDr`, `prodTxtCotacao`, `prodTxtAcompanha`, `prodCodPropPadrao`, `prodCategoria`, `prodImposto`, `prodNCM`) VALUES
(23, 'E200.016-2*', 'FAST CMF CRANIO EM PMMA (s/ template >51cm3)', 'E- 80859840195', '16500.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha no Kit: FastCMF (molde)  *Prod. Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como: chave, placa e parafusos. LEMBRETE Distribuidor cotar e levar cimento cirúrgico e levar prensa.', '6056/20', 'CRÂNIO', NULL, '90213999'),
(21, 'PC-704MAX*', 'MESH MAXILA TITÂNIO SOB MEDIDA G', 'Licença Especial', '4200.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra separadamente.', '6113/20', 'CRÂNIO', NULL, '90211020'),
(22, 'E200.016-1*', 'FAST CMF CRANIO EM PMMA (s/ template <50cm3)', 'E- 80859840195', '11500.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha no Kit: FastCMF (molde)  *Prod. Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como: chave, placa e parafusos. LEMBRETE Distribuidor cotar e levar cimento cirúrgico e levar prensa.', '5539/20', 'CRÂNIO', NULL, '90213999'),
(19, 'PC-703-MAX*', 'MESH MAXILA TITÂNIO SOB MEDIDA M', 'Licença Especial ', '3700.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra separadamente.', '6112/20', 'CRÂNIO', NULL, '90211020'),
(20, 'PC-704MAN*', 'MESH MAND TITÂNIO SOB MEDIDA G', 'Licença Especial ', '4200.00', 0, 'NÃO SE APLICA.', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra separadamente.', '6111/20', 'CRÂNIO', NULL, '90211020'),
(17, 'E200.011-L', 'SMARTMOLD PRÉ-MAXILA  ', '80859840124', '8600.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha: Smartmold (molde)  / E200R Reborto Estéril / PC-300IT  Template *Prods Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra. ', '6071/20', 'CMF', NULL, '90213999'),
(18, 'PC-703-MAN*', 'MESH MAND TITÂNIO SOB MEDIDA M', 'Licença Especial ', '3700.00', 0, 'NÃO SE APLICA.', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra separadamente.', '6110/20', 'CRÂNIO', NULL, '90211020'),
(16, 'E200.011-J', 'SMARTMOLD ANG DE MANDIBULA  PMMA - Dir + Esq', '80859840124', '16000.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha: Smartmold (molde)  / E200R Reborto Estéril / PC-300IT  Template *Prods Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra. ', '5550/20', 'CMF', NULL, '90213999'),
(15, 'E200.011-KE', 'SMARTMOLD ANG DE MANDIBULA  PMMA - ESQ', '80859840124', '8600.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha: Smartmold (molde)  / E200R Reborto Estéril / PC-300IT  Template *Prods Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra. ', '6059/20', 'CMF', NULL, '90213999'),
(9, 'E200.011-F', 'SMARTMOLD ZIGOMA PMMA - BILATERAL ', '80859840124', '16000.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha: Smartmold (molde)  / E200R Reborto Estéril / PC-300IT  Template *Prods Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra. ', '5547/20', 'CMF', NULL, '90213999'),
(8, 'E200.013-1 E', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Esq', '80859840124', '8600.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha: Smartmold (molde)  / E200R Reborto Estéril / PC-300IT  Template *Prods Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra. ', '5546/20', 'CMF', NULL, '90213999'),
(7, 'E200.013-1 D', 'SMARTMOLD ZIGOMA PMMA - UNILATERAL Dir', '80859840124', '8600.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha: Smartmold (molde)  / E200R Reborto Estéril / PC-300IT  Template *Prods Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra. ', '5546/20', 'CMF', NULL, '90213999'),
(11, 'E200.011-G', 'SMARTMOLD PARANASAL PMMA - Dir + Esq', '80859840124', '10000.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha: Smartmold (molde)  / E200R Reborto Estéril / PC-300IT  Template *Prods Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra. ', '5548/20', 'CMF', NULL, '90213999'),
(12, 'E200.011-H', 'SMARTMOLD MENTO  PMMA', '80859840124', '8600.00', 0, '', '&lt;p&gt;Ol&amp;aacute;, tudo bem? Encaminho a proposta solicitada em anexo e aguardamos a sua autoriza&amp;ccedil;&amp;atilde;o para efetiva&amp;ccedil;&amp;atilde;o.&lt;/p&gt;\r\n&lt;p&gt;***&lt;strong&gt;ATEN&amp;Ccedil;&amp;Atilde;O!!! &lt;/strong&gt;Caso tenha diverg&amp;ecirc;ncia comunicar.***&lt;/p&gt;\r\n&lt;p&gt;Em caso de aceite, por favor informar a forma de envio: D&amp;uacute;vidas? Por favor, retornar. CPMH (61) 3028-8858 ou (61) 99946-8880&lt;/p&gt;', '&lt;p&gt;-Smartmold (molde)&lt;/p&gt;\r\n&lt;p&gt;-E200R Reborto Est&amp;eacute;ril&lt;/p&gt;\r\n&lt;p&gt;-PC-300IT Template *Prods Esteril&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;IMPORTANTE!!!&lt;/strong&gt; Produto n&amp;atilde;o acompanha material de fixa&amp;ccedil;&amp;atilde;o como chave e parafusos, necess&amp;aacute;rio solicitar compra.&lt;/p&gt;', '6060/20', 'CMF', 0, '90213999'),
(13, 'E200.011-I', 'SMARTMOLD MENTO BIPARTIDO PMMA', '80859840124', '8600.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha: Smartmold (molde)  / E200R Reborto Estéril / PC-300IT  Template *Prods Esteril   IMPORTANTE!!!  Produto não acompanha material de fixação como chave e parafusos, necessário solicitar compra. ', '5667/20', 'CMF', NULL, '90213999'),
(14, 'E200.011-KD', 'SMARTMOLD ANG DE MANDIBULA  PMMA - DIR', '80859840124', '8600.00', 0, '', '&lt;p&gt;Ol&amp;aacute;, tudo bem? Encaminho a proposta solicitada em anexo e aguardamos a sua autoriza&amp;ccedil;&amp;atilde;o para efetiva&amp;ccedil;&amp;atilde;o.&lt;/p&gt;\r\n&lt;p&gt;***&lt;strong&gt;ATEN&amp;Ccedil;&amp;Atilde;O!!! &lt;/strong&gt;Caso tenha diverg&amp;ecirc;ncia comunicar.***&lt;/p&gt;\r\n&lt;p&gt;Em caso de aceite, por favor informar a forma de envio: D&amp;uacute;vidas? Por favor, retornar. CPMH (61) 3028-8858 ou (61) 99946-8880&lt;/p&gt;', '&lt;p&gt;-Smartmold (molde)&lt;/p&gt;\r\n&lt;p&gt;-E200R Reborto Est&amp;eacute;ril&lt;/p&gt;\r\n&lt;p&gt;-PC-300IT Template *Prods Esteril&lt;/p&gt;\r\n&lt;p&gt;&lt;strong&gt;IMPORTANTE!!!&lt;/strong&gt; Produto n&amp;atilde;o acompanha material de fixa&amp;ccedil;&amp;atilde;o como chave e parafusos, necess&amp;aacute;rio solicitar compra.&lt;/p&gt;', '5549/20', 'CMF', 0, '90213999'),
(24, 'E200.013-1', 'FASTMOLD CRANIO PMMA P < 30cm3', 'E - 80859849002', '16500.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha no Kit : Fastmold (molde)  PC-300IT  Template c furo \r\nE200R Rebordo Teste  *Prod. Esteril  - IMPORTANTE!!!  Produto não acompanha material de fixação como: chave, placa e parafusos. LEMBRETE Distribuidor cotar e levar cimento cirúrgico e levar prensa.', '5536/20', 'CRÂNIO', NULL, '90213999'),
(25, 'E200.013-5*', ' FASTMOLD CRANIO PMMA M 31 a 60cm3', 'E - 80859849002', '19500.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha no Kit : Fastmold (molde)  PC-300IT  Template c furo \r\nE200R Rebordo Teste  *Prod. Esteril  - IMPORTANTE!!!  Produto não acompanha material de fixação como: chave, placa e parafusos. LEMBRETE Distribuidor cotar e levar cimento cirúrgico e levar prensa.', '5535/20', 'CRÂNIO', NULL, '90213999'),
(26, 'E200.013-6*', 'FASTMOLD CRANIO PMMA  G > 61cm3', 'E - 80859849002', '22500.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Acompanha no Kit : Fastmold (molde)  PC-300IT  Template c furo \r\nE200R Rebordo Teste  *Prod. Esteril  - IMPORTANTE!!!  Produto não acompanha material de fixação como: chave, placa e parafusos. LEMBRETE Distribuidor cotar e levar cimento cirúrgico e levar prensa.', '5537/20', 'CRÂNIO', NULL, '90211020'),
(27, 'PC-201-P1*', 'CRÂNIO SOB MEDIDA PEEK  P < 30cm³', 'Licença Especial', '38350.00', 0, 'NÃO SE APLICA', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\n\r\n\r\nOBS: Quanto ao material de PEEK, no momento atual estamos com restrições da matéria prima específica da espessura necessária para este produto. O motivo é que foi feita a devolução recente de toda a importação pelo nosso setor de Qualidade, por motivos do fornecedor não estar conforme as certificações exigidas pela CPMH, sendo assim, nosso tempo de estabilidade para este produto em específico está estimado em 3 a 4 meses para normalidade. Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de implantes seguros e eficazes não conseguimos realizar este projeto em PEEK no momento.\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Calota em Peek \r\nET40.001- Chave de fixação descartável \r\nE200R Rebordo teste  A920-2.0xx - Parafusos de fixação conforme projeto ', ' 5532/20', 'CRÂNIO', NULL, '90211020'),
(28, 'PC-201-P2*', 'CRÂNIO SOB MEDIDA PEEK  M - 31 a 60cm3', 'Licença Especial ', '46200.00', 0, 'NÃO SE APLICA', 'Quanto ao material de PEEK, no momento atual estamos com restrições da matéria prima específica da espessura necessária para este produto. O motivo é que foi feita a devolução recente de toda a importação pelo nosso setor de Qualidade, por motivos do fornecedor não estar conforme as certificações exigidas pela CPMH, sendo assim, nosso tempo de estabilidade para este produto em específico está estimado em 3 a 4 meses para normalidade. Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de implantes seguros e eficazes não conseguimos realizar este projeto em PEEK no momento.', 'Kit acompanha: Calota em Peek \r\nET40.001- Chave de fixação descartável \r\nE200R Rebordo teste  A920-2.0xx - Parafusos de fixação conforme projeto ', '5530/20', 'CRÂNIO', NULL, '90211020'),
(29, 'PC-201-P3*', 'CRÂNIO SOB MEDIDA  PEEK G > 61cm3', 'Licença Especial ', '55250.00', 0, 'NÃO SE APLICA.', 'Quanto ao material de PEEK, no momento atual estamos com restrições da matéria prima específica da espessura necessária para este produto. O motivo é que foi feita a devolução recente de toda a importação pelo nosso setor de Qualidade, por motivos do fornecedor não estar conforme as certificações exigidas pela CPMH, sendo assim, nosso tempo de estabilidade para este produto em específico está estimado em 3 a 4 meses para normalidade. Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de implantes seguros e eficazes não conseguimos realizar este projeto em PEEK no momento.', 'Kit acompanha: Calota em Peek \r\nET40.001- Chave de fixação descartável \r\nE200R Rebordo teste  A920-2.0xx - Parafusos de fixação conforme projeto ', '5533/20', 'CRÂNIO', NULL, '90211020'),
(30, 'PC-201-T1*', 'CRÂNIO TITÂNIO C/ TRABECULADO - P <30cm³', 'Licença Especial ', '29500.00', 0, 'NÃO SE APLICA.', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\n\r\nobs: Quanto ao material de titânio, no momento atual estamos com restrições da matéria prima específica da espessura necessária para este produto. O motivo é que foi feita a devolução recente de toda a importação pelo nosso setor de Qualidade, por motivos do fornecedor não estar conforme as certificações exigidas pela CPMH, sendo assim, nosso tempo de estabilidade para este produto em específico está estimado em 3 a 4 meses para normalidade. Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de implantes seguros e eficazes não conseguimos realizar este projeto em titânio no momento. \r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Calota em Titânio\r\nET40.001- Chave de fixação descartável \r\nE200R Rebordo teste  A920-2.0xx - Parafusos de fixação conforme projeto ', '5542/20', 'CRÂNIO', NULL, '90211020'),
(31, 'PC-201-T2*', 'CRÂNIO TITÂNIO C/ TRABECULADO  - M - 31 a 60cm3', 'Licença Especial ', '35400.00', 0, 'NÃO SE APLICA.', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\n\r\nobs: Quanto ao material de titânio, no momento atual estamos com restrições da matéria prima específica da espessura necessária para este produto. O motivo é que foi feita a devolução recente de toda a importação pelo nosso setor de Qualidade, por motivos do fornecedor não estar conforme as certificações exigidas pela CPMH, sendo assim, nosso tempo de estabilidade para este produto em específico está estimado em 3 a 4 meses para normalidade. Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de implantes seguros e eficazes não conseguimos realizar este projeto em titânio no momento. \r\n\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Calota em Titânio\r\nET40.001- Chave de fixação descartável \r\nE200R Rebordo teste  A920-2.0xx - Parafusos de fixação conforme projeto ', ' 5543/20', 'CRÂNIO', NULL, '90211020'),
(32, 'PC-201-T3*', 'CRÂNIO TITÂNIO C/ TRABECULADO G > 61cm3', 'Licença Especial ', '42500.00', 0, 'NÃO SE APLICA.', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\nobs: Quanto ao material de titânio, no momento atual estamos com restrições da matéria prima específica da espessura necessária para este produto. O motivo é que foi feita a devolução recente de toda a importação pelo nosso setor de Qualidade, por motivos do fornecedor não estar conforme as certificações exigidas pela CPMH, sendo assim, nosso tempo de estabilidade para este produto em específico está estimado em 3 a 4 meses para normalidade. Infelizmente a intercorrência de terceiros prejudica a todos e pedimos desculpas, mas prezando sempre por entrega de implantes seguros e eficazes não conseguimos realizar este projeto em titânio no momento. \r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880\r\n', 'Kit acompanha: Calota em Titânio\r\nET40.001- Chave de fixação descartável \r\nE200R Rebordo teste  A920-2.0xx - Parafusos de fixação conforme projeto ', ' 5544/20', 'CRÂNIO', NULL, '90211020'),
(33, 'PC-301-P1*', 'RECONSTRUÇÃO ORBITA EM PEEK - 1', 'Licença Especial', '41900.00', 0, 'ID: 5427   PROP: 5635/2- 2 KIT DR RECONSTRUÇÃO 1 PRÓTES', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6120/20', 'CMF', NULL, '90211020'),
(34, 'PC-301-P2*', 'RECONSTRUÇÃO ORBITA EM PEEK - 2', 'Licença Especial ', '58200.00', 0, 'ID: 5427   PROP: 5635/2- 2 KIT DR RECONSTRUÇÃO 1 PRÓTES     ', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', ' 6121/20', 'CMF', NULL, '90211020'),
(35, 'PC-302-P1*', 'RECONSTRUÇÃO MAXILAR EM PEEK - 1 ', 'Licença Especial ', '54600', 0, 'ID: 5427   PROP: 5635/2- 2 KIT DR RECONSTRUÇÃO 1 PRÓTES     ', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6122/20', 'CMF', NULL, '90211020'),
(36, 'PC-302-P2*', 'RECONSTRUÇÃO MAXILAR EM PEEK - 2 ', 'Licença Especial ', '71500', 0, 'ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', ' 6123/20', 'CMF', NULL, '90211020'),
(37, 'PC-303-P1*', 'RECONSTRUÇÃO MANDIBULAR EM PEEK - 1 ', 'Licença Especial ', '54600', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6835/21', 'CMF', NULL, '90211020'),
(38, 'PC-303-P2*', 'RECONSTRUÇÃO MANDIBULAR EM PEEK - 2', 'Licença Especial ', '71500', 0, 'ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6124/20', 'CMF', NULL, '90211020'),
(39, 'PC-304-P1*', 'RECONSTRUÇÃO  ZIGOMA PEEK - 1', 'Licença Especial ', '41340', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6127/20', 'CMF', NULL, '90211020'),
(40, 'PC-304-P2*', 'RECONSTRUÇÃO  ZIGOMA PEEK  - 2', 'Licença Especial ', '55120', 0, 'ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6128/20', 'CMF', NULL, '90211020'),
(41, 'PC-305-P1*', 'RECONSTRUÇÃO INFRAORBITÁRIO  EM PEEK - 1', 'Licença Especial ', '36200', 0, 'ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6131/20', 'CMF', NULL, '90211020'),
(42, 'PC-305-P2*', 'RECONSTRUÇÃO INFRAORBITÁRIO  PEEK - 2', 'Licença Especial ', '42200', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6132/20', 'CMF', NULL, '90211020'),
(43, 'PC-306-P1*', 'RECONSTRUÇÃO GLABELA PEEK-1', 'Licença Especial', '32240.00', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6135/20', 'CMF', NULL, '90211020'),
(44, 'PC-306-P2*', 'RECONSTRUÇÃO GLABELA PEEK-2', 'Licença Especial', '41340.00', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6136/20', 'CMF', NULL, '90211020'),
(45, 'PC-501-P1*', 'RECONSTRUÇÃO FRONTAL EM PEEK-1', 'Licença Especial', '41900.00', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6144/20', 'CMF', NULL, '90211020'),
(46, 'PC-501-P2*', 'RECONSTRUÇÃO FRONTAL EM PEEK-2', 'Licença Especial', '48620.00', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6145/20', 'CMF', NULL, '90211020'),
(47, 'PC-507-P1', 'RECONSTRUÇÃO ANG DE MAND. Dir.+Esq PEEK', 'Licença Especial', '55120.00', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6830/21', 'CMF', NULL, '90211020'),
(48, 'PC-507-P2', 'RECONSTRUÇÃO ANG DE MAND. Esq PEEK', 'Licença Especial', '55120.00', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6831/21', 'CMF', NULL, '90211020'),
(49, 'PC-507-P3', 'RECONSTRUÇÃO ANG DE MAND. Dir. PEEK', 'Licença Especial', '55120.00', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6832/21', 'CMF', NULL, '90211020'),
(50, 'PC-402-P1 MEN*', 'RECONSTRUÇÃO MENTO PEEK 1', 'Licença Especial', '37400.00', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6833/21', 'CMF', NULL, '90211020'),
(51, 'PC-402-P2 MEN*', 'RECONSTRUÇÃO MENTO PEEK 2', 'Licença Especial', '46800.00', 0, ' ID: 6531     PROP: 6812/21 - 2 KIT DR RECONSTRUÇÃO 2 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6834/21', 'Selecione categoria', NULL, '90211020'),
(52, 'PC-301-T1*', 'RECONSTRUÇÃO ORBITA TIÂNIO TRABECULADO - 1', 'Licença Especial', '31800.00', 0, 'ID: 5427   PROP: 5635/2- 2 KIT DR RECONSTRUÇÃO 1 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6118/20', 'CMF', NULL, '90211020'),
(53, 'PC-301-T2*', 'RECONSTRUÇÃO ORBITA TIÂNIO TRABECULADO - 2', 'Licença Especial', '37200.00', 0, 'ID: 5427   PROP: 5635/2- 2 KIT DR RECONSTRUÇÃO 1 PRÓTESE', 'Olá, tudo bem?\r\n  Encaminho a proposta solicitada em anexo e aguardamos a sua autorização para efetivação.\r\n***ATENÇÃO!!! Caso tenha divergência comunicar.***\r\nEm caso de aceite, por favor informar a forma de envio:\r\nDúvidas? Por favor, retornar.\r\nCPMH\r\n61 30288858 ou 61 999468880', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '6119/20', 'CMF', NULL, '90211020'),
(54, 'PC-302-T1*', 'RECONSTRUÇÃO MAXILA TITÂNIO TRABECULADO- 1 ', 'Licença Especial', '42000.00', 0, ',', 'NÃO ACOMPANHA A920.XXX  (estimado 24unds) à definir no projeto', 'Kit acompanha: Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável IMPORTANTE!!!  Parafusos de fixação são cobrados separadamentoe e as qtds são estimadas, podendo sofrer alterações após definição do projeto.', '5503/20', 'CMF', NULL, '90211020'),
(55, 'PC-302-T2*', 'RECONSTRUÇÃO MAXILA TITÂNIO TRABECULADO- 2 ', 'Licença Especial ', '55000.00', 0, '0', ',', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '5504/20  -  5635/2- 2', 'CMF', NULL, '90211020'),
(56, 'PC-303-T1*', 'RECONSTRUÇÃO MANDIBULA TITÂNIO TRABECULADO - 1', 'Licença Especial', '42000.00', 0, '0', '0', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '5505/20 -  5635/2- 2', 'CMF', NULL, '90211020'),
(57, 'PC-303-T2*', 'RECONSTRUÇÃO MANDIBULA TITÂNIO TRABECULADO - 2', 'Licença Especial', '55000.00', 0, '0', '0', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6829/21  -  5635/2- 2', 'CMF', NULL, '90211020'),
(58, 'PC-304-T1*', 'RECONSTRUÇÃO ZIGOMA TITÂNIO TRABECULADO- 1', 'Licença Especial', '21800.00', 0, '0', '0', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6825/21  -  5635/2- 2', 'CMF', NULL, '90211020'),
(59, 'PC-304-T2*', 'RECONSTRUÇÃO  ZIGOMA TITÂNIO TRABECULADO- 2', 'Licença Especial', '42400.00', 0, '0', '0', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6126/20  -  5635/2- 2', 'CMF', NULL, '90211020'),
(60, 'PC-305-T1*', 'RECONSTRUÇÃO INFRAORBITÁRIO TITÂNIO TRABECULADO - 1', 'Licença Especial', '31800.00', 0, '0', '0', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6129/20  -  5635/2- 2', 'CMF', NULL, '90211020'),
(61, 'PC-305-T2*', 'RECONSTRUÇÃO INFRAORBITÁRIO TITÂNIO TRABECULADO - 2', 'Licença Especial', '37200.00', 0, '0', '0', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6130/20  -  5635/2- 2', 'CMF', NULL, '90211020'),
(62, 'PC-306-T1*', 'RECONSTRUÇÃO GLABELA  TITÂNIO TRABECULADO- 1', 'Licença Especial', '31800.00', 0, '0', '0', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6133/20  -  5635/2- 2', 'CMF', NULL, '90211020'),
(63, 'PC-306-T2*', 'RECONSTRUÇÃO GLABELA  TITÂNIO TRABECULADO- 2', 'Licença Especial', '37200.00', 0, '0', '0', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6134/20  -  5635/2- 2', 'CMF', NULL, '90211020'),
(64, 'PC-402MEN ', 'RECONSTRUÇÃO MENTO TITÂNIO TRABECULADO- 1', 'Licença Especial', '32240.00', 0, '0', '0', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6141/20  -  5635/2- 2', 'CMF', NULL, '90211020'),
(65, 'PC-403MEN ', 'RECONSTRUÇÃO MENTO TITÂNIO TRABECULADO- 2', 'Licença Especial', '37400.00', 0, '', '', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6826/21  -  5635/2- 2', 'CMF', NULL, '90211020'),
(66, 'PC-507-T1 ', 'RECONSTRUÇÃO ANG DE MAND. Esq TITÂNIO TRABECULADO- 1', 'Licença Especial', '31800.00', 0, '', '', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6827/21  -  5635/2- 2', 'CMF', NULL, '90211020'),
(67, 'PC-507-T2 ', 'RECONSTRUÇÃO ANG DE MAND. Dir. TITÂNIO TRABECULADO- 2', 'Licença Especial', '31800.00', 0, '', '', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6828/21  -  5635/2- 2', 'CMF', NULL, '90211020'),
(68, 'PC-501-T1*', 'RECONSTRUÇÃO FRONTAL TITÂNIO TRABECULADO - 1', 'Licença Especial', '32240.00', 0, '', '', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6142/20  -  5635/2- 2', 'CMF', NULL, '90211020'),
(69, 'PC-501-T2*', 'RECONSTRUÇÃO FRONTAL TITÂNIO TRABECULADO - 2', 'Licença Especial', '37400.00', 0, '', '', 'Implante para reconstrução \r\nE200R Rebordo teste  / Biomodelo\r\nE200.200-5 Dispositivo em titânio para osteotomia de segmentação \r\nET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '6143/20  -  5635/2- 2', 'CMF', NULL, '90211020'),
(70, 'KITPC-505D*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º - D - 1', 'Licença Especial', '48900.00', 0, '', '', 'Placa Bloq. \r\n- FOSSA TEMPORAL \r\nPc-500TF Template Implante Temporal  em Resina \r\nPc-500TM Template Implante em aluminio\r\nE200R Rebordo \r\nE200.008 Surgicalguide - Guia de oclusão 200.200-14D - Dispositivo em titânio para osteotomia, perfuração e posicionamento da fossa \r\nE200.200-16D - Dispositivo em titânio para osteotomia, perfuração e posicionamento mandibular  ET40.001- Chave de fixação descartável \r\n\r\n\r\n', '5494/20  -   5637/20  - 2', 'CMF', NULL, '90211020'),
(71, 'PC-700 MAX MAN', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA + MANDIBULA', 'Licença Especial', '78200.00', 0, '', '', 'Implante CustomLIFE \r\nE999.501- Biomodelo                                                                            \r\nPC-705 microunit\r\nET41.001 Broca 1.6 x 21 x 100mm\r\nPC-711-500 Tampa de proteção \r\nMM3042-2 conexão cruciforme 1.5/2.0', '5555/20', 'CMF', NULL, '90211020'),
(72, 'KITPC-505E*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º - E - 1', 'Licença Especial', '48900.00', 0, '', '', 'Placa Bloq. \r\n- FOSSA TEMPORAL \r\nPc-500TF Template Implante Temporal  em Resina \r\nPc-500TM Template Implante em aluminio\r\nE200R Rebordo \r\nE200.008 Surgicalguide - Guia de oclusão 200.200-14D - Dispositivo em titânio para osteotomia, perfuração e posicionamento da fossa \r\nE200.200-16D - Dispositivo em titânio para osteotomia, perfuração e posicionamento mandibular  ET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n', '5495/20 -   5637/20  - 2', 'CMF', NULL, '90211020'),
(73, 'KITPC-506D*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º - D - 2', 'Licença Especial', '57800.00', 0, '', '', 'Placa Bloq. \r\n- FOSSA TEMPORAL \r\nPc-500TF Template Implante Temporal  em Resina \r\nPc-500TM Template Implante em aluminio\r\nE200R Rebordo \r\nE200.008 Surgicalguide - Guia de oclusão 200.200-14D - Dispositivo em titânio para osteotomia, perfuração e posicionamento da fossa \r\nE200.200-16D - Dispositivo em titânio para osteotomia, perfuração e posicionamento mandibular  ET40.001- Chave de fixação descartável \r\n\r\n\r\n', '5499/20  -   5637/20  - 2', 'CMF', NULL, '90211020'),
(74, 'KITPC-506E*', 'SISTEMA ATM TITÂNIO TRABECULADO COM SLA / PAR. BLOQUEADO E FOSSA SINTERIZADA DE 30º- E - 2', 'Licença Especial', '57800.00', 0, '', '', 'Placa Bloq. \r\n- FOSSA TEMPORAL \r\nPc-500TF Template Implante Temporal  em Resina \r\nPc-500TM Template Implante em aluminio\r\nE200R Rebordo \r\nE200.008 Surgicalguide - Guia de oclusão 200.200-14D - Dispositivo em titânio para osteotomia, perfuração e posicionamento da fossa \r\nE200.200-16D - Dispositivo em titânio para osteotomia, perfuração e posicionamento mandibular  ET40.001- Chave de fixação descartável \r\n\r\n\r\n\r\n\r\n', '5498/20  -   5637/20  - 2', 'CMF', NULL, '90211020'),
(75, 'KITPC-6000', 'ORTOGNATICA SOB MEDIDA MAXILA', 'Licença Especial', '18000.00', 0, '0', '0', 'Placa Maxila  / Biomodelo\r\nE200.200-5 dispositivo em titânio para osteotomia de segmentação \r\nE200.008 - Surgicalguide Final\r\nE200R  Rebordo \r\n ET40.001- Chave de fixação descartável ', '6058/20  -  6813/21 - 2 ', 'CMF', NULL, '90211020'),
(76, 'KITPC-6001', 'ORTOGNATICA SOB MEDIDA MANDIBULA', 'Licença Especial', '18000.00', 0, '0', '0', 'Placa Mandibula  / Biomodelo\r\nE200.200-5 dispositivo em titânio para osteotomia de segmentação \r\nE200.008 - Surgicalguide Final\r\nE200R  Rebordo \r\n ET40.001- Chave de fixação descartável \r\n', '5553/20  -  6814/21 - 2 ', 'CMF', NULL, '90211020'),
(77, 'KITPC-6002', 'ORTOGNATICA SOB MEDIDA MAXILA, MANDIBULA E MENTO', 'Licença Especial', '32800.00', 0, ' ', ' ', 'KIT Ortog - Pc-6000  Placa  Max.  / Pc-6001 Placa  Mand.  / Pc-6002 Placa  Mento \r\n Biomodelo  / ET40.001- Chave de fixação descartável \r\nE200.008 - Surgicalguide Final  E200.200-5 dispositivo em titânio para osteotomoa \r\nE200.200-11 dispositivo em titânio para osteotomia, perfuração e posicionamento 003\r\nE200.200-15 dispositivo em titânio para osteotomia, perfuração e posicioamento do mento \r\nE200R Rebordo  ', '5823/20  -   5636/20        2 ', 'CMF', NULL, '90211020'),
(78, 'PC-701-MAXP*', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA ATROFICA  PARCIAL', 'Licença Especial', '38900.00', 0, '0', '0', 'Implante CustomLIFE \r\nE999.501- Biomodelo                                                                            \r\nPC-705        microunit\r\nET41.001        Broca 1.6 x 21 x 100mm\r\nPC-711-500        Tampa de proteção \r\nMM3042-2    conexão cruciforme 1.5/2.0\r\n\r\n\r\n\r\n', '5555/20', 'CMF', NULL, '99999999'),
(79, 'PC-701-MANP*', 'CUSTOMLIFE - RECONSTRUÇÃO MANDIBULA ATROFICA PARCIAL', 'Licença Especial', '38900.00', 0, '', '', 'Implante CustomLIFE \r\nE999.501- Biomodelo                                                                            \r\nPC-705        microunit\r\nET41.001        Broca 1.6 x 21 x 100mm\r\nPC-711-500        Tampa de proteção \r\nMM3042-2    conexão cruciforme 1.5/2.0\r\n\r\n\r\n\r\n', '6054/20 ', 'CMF', NULL, '99999999'),
(80, 'ATA.B', 'ATA BUCO-MAXILO-FACIAL', 'N/A', '2000.00', 0, ' ', ' ', 'ATAB: Envio do arquivo digital / Prazo para envio 5 a 7 dias úteis após o video de aceite do Dr(a) \r\n\r\n\r\n\r\n\r\n\r\n\r\n', '0', 'ATA', NULL, '99999999'),
(81, 'ATA.B 2976  - HOF', 'ATA HOF (Harmonização) ', 'N/A', '2000.00', 0, '0', '0', 'Material: Envio do arquivo digital / Prazo para envio 5 a 7 dias úteis após o video de aceite do Dr(a) \r\n\r\n\r\n\r\n\r\n\r\n\r\n', '0', 'ATA', NULL, '99999999'),
(82, 'ATA.Cl', 'ATA COLUNA LOMBAR', 'N/A', '2000.00', 0, '0', '0', 'Material: Envio do arquivo digital / Prazo para envio 5 a 7 dias úteis após o video de aceite do Dr(a) \r\n\r\n\r\n\r\n\r\n\r\n\r\n', '0', 'ATA', NULL, '99999999');
INSERT INTO `produtos` (`prodId`, `prodCodCallisto`, `prodDescricao`, `prodAnvisa`, `prodPreco`, `prodParafuso`, `prodKitDr`, `prodTxtCotacao`, `prodTxtAcompanha`, `prodCodPropPadrao`, `prodCategoria`, `prodImposto`, `prodNCM`) VALUES
(83, 'ATA.O', 'ATA OTORRINOLARINGISTA', 'N/A', '2000.00', 0, '0', '0', 'Material: Envio do arquivo digital / Prazo para envio 5 a 7 dias úteis após o video de aceite do Dr(a) \r\n\r\n\r\n\r\n\r\n\r\n\r\n', '0', 'ATA', NULL, '99999999'),
(84, 'ATA.Cl', 'ATA COLUNA CERVICAL ', 'N/A', '2000.00', 0, '0', '0', 'Material: Envio do arquivo digital / Prazo para envio 5 a 7 dias úteis após o video de aceite do Dr(a) \r\n\r\n\r\n\r\n\r\n\r\n\r\n', '0', 'ATA', NULL, '99999999'),
(85, 'ATA HOF', 'ATA pre smartmold (abatimento depois na compra so smartmold)', 'N/A', '2000.00', 0, '0', '0', 'Material: Envio do arquivo digital / Prazo para envio 5 a 7 dias úteis após o video de aceite do Dr(a) \r\n\r\n\r\n\r\n\r\n\r\n\r\n', '0', 'ATA', NULL, '99999999'),
(86, 'ATA PP', 'ATA pre-projeto (abatimento depois no customlife) ', 'N/A', '3000.00', 0, '0', '0', 'Material: Envio do arquivo digital / Prazo para envio 5 a 7 dias úteis após o video de aceite do Dr(a) \r\n\r\n\r\n\r\n\r\n\r\n\r\n', '0', 'ATA', NULL, '90189099'),
(87, 'ATA.OM', 'ATA OMBRO ', 'N/A', '2000.00', 0, '0', '0', 'Material: Envio do arquivo digital / Prazo para envio 5 a 7 dias úteis após o video de aceite do Dr(a) \r\n\r\n\r\n\r\n\r\n\r\n\r\n', '0', 'ATA', NULL, '90189099'),
(88, 'E200.012-1', 'Guia de Osteotomia A / corticotomia', '80859840201', '2500.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90189099'),
(89, 'E200.012-10', 'Guia de Osteotomia J / MAX ', '80859840201', '2500.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90189099'),
(90, 'E200.012-11', 'Guia de Osteotomia K / MAND', '80859840201', '2500.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90189099'),
(91, 'E200.012-12', 'Guia de Osteotomia L / mento ', '80859840201', '2750.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90189099'),
(92, 'E200.012-13', 'Guia de Osteotomia M / cranio ', '80859840201', '2500.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90189099'),
(93, 'E200.012-14', 'Guia de Osteotomia N', '80859840201', '2500.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90189099'),
(94, 'E200.012-15', 'Guia de Osteotomia O', '80859840201', '2500.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90189099'),
(95, 'E200.012-16', 'Guia de Osteotomia P / coluna ', '80859840201', '2500.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90189099'),
(96, 'E200.007', 'Surgicalguide Intermediário', '80859840069', '2500.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90211020'),
(97, 'E200.008', 'Surgicalguide Final', '80859840069', '2500.00', 0, '0', '0', '0', '0', 'CMF', NULL, '90211020'),
(98, 'P-5.00.01-D', 'Fossa articular P – Direita', '80859840212', '4000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(99, 'P-5.DF.01-D', 'Dispositivo fossa de corte e perfuração para articulação pequena - Direita', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(100, 'P-5.10.01-D', 'Placa mandibular curta com cabeça condilar P - Direita', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(102, 'P-5.20.01-D', 'Placa mandibular média com cabeça condilar P – Direita  ', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(103, 'P-5.20.DM-D', 'Dispositivo mandibular MEDIA M para corte e perfuração - Direita', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(104, 'P-5.30.01-D', 'Placa mandibular longa com cabeça condilar P – Direita', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(105, 'P-5.30.DM-D', 'Dispositivo mandibular G para corte e perfuração – Direita', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(106, 'P-5.00.01-E', ' Fossa Articular P', '80859840212', '4000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(107, 'P-5.DF.01-E', 'Dispositivo fossa de corte e perfuração para articulação pequena – esquerda', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(108, 'P-5.10.01-E', 'Placa mandibular curta com cabeça condilar P - Esquerda', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(109, 'P-5.10.DM-E', 'Dispositivo mandibular CURTA P para corte e perfuração – esquerda ', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(110, 'P-5.20.01-E', 'Placa mandibular média com cabeça condilar P – Esquerda', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(111, 'P-5.20.DM-E', 'Dispositivo mandibular MEDIA M para corte e perfuração – esquerda', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(112, 'P-5.30.01-E', 'Placa mandibular longa com cabeça condilar P – Esquerda', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(113, 'P-5.30.DM-E', 'Dispositivo mandibular LONGA G para corte e perfuração – esquerda ', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(114, 'P-5.00.02-D', 'Fossa articular M – Direita', '80859840212', '4000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(115, 'P-5.DF.02-D', 'Dispositivo fossa de corte e perfuração para articulação média - Direita', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(116, 'P-5.10.02-D', 'Placa mandibular curta com cabeça condilar M – Direita', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(117, 'P-5.20.02-D', 'Placa mandibular média com cabeça condilar M – Direita ', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(118, 'P-5.30.02-D', 'Placa mandibular longa com cabeça condilar M – Direita', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(138, 'PC-702-MANT*', 'CUSTOMLIFE - RECONSTRUÇÃO MANDIBULA ATROFICA TOTAL', 'Licença Especial', '44800.00', 0, '', '', '', '5520/20', 'CMF', NULL, '90189099'),
(137, 'PC-702-MAXT*', 'CUSTOMLIFE - RECONSTRUÇÃO MAXILA ATROFICA TOTAL', 'Licença Especial', '44800.00', 0, '', '', '', '6055/20', 'CMF', NULL, '90189099'),
(135, 'T30.200', 'Caixa ATM Super Instrumental', ' ', '3500.00', 0, '', '', '', '', 'EXTRA', NULL, '90211020'),
(136, 'T30.101', 'Caixa ATM Básica Parafusos', ' ', '750.00', 0, '', '', '', '', 'EXTRA', NULL, '90211020'),
(122, 'P-5.00.01-E', 'Fossa Articular M', '80859840212', '4000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(123, 'P-5.DF.02-E', 'Dispositivo fossa de corte e perfuração para articulação média – esquerda', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(124, 'P-5.10.02-E', 'Placa mandibular curta com cabeça condilar M – Esquerda', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(125, 'P-5.20.02-E', 'Placa mandibular média com cabeça condilar M – Esquerda', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(126, 'P-5.30.02-E', 'Placa mandibular longa com cabeça condilar M – Esquerda', '80859840212', '16500.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(127, 'P-5.10.DM-E', 'Dispositivo mandibular CURTA P para corte e perfuração – esquerda', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(128, 'P-5.20.DM-E', 'Dispositivo mandibular MEDIA M para corte e perfuração – esquerda', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(129, 'P-5.30.DM-E', 'Dispositivo mandibular LONGA G para corte e perfuração – esquerda', '80859840169', '1000.00', 0, ' ', ' ', ' ', '0', 'CMF', NULL, '90211020'),
(130, 'PC-920.210', 'Parafuso 2,0 x 10 Bloqueado', '80859840212', '68.00', 0, '', '', '', '', 'EXTRA', NULL, '90211020'),
(131, 'PC-920.205', 'Parafuso 2,0 x 05 Bloqueado', '80859840212', '68.00', 0, '', '', '', '', 'EXTRA', NULL, '90211020'),
(132, 'PC-924.210', 'Parafuso 2,4 x 10 Bloqueado', '80859840212', '68.00', 0, '', '', '', '', 'EXTRA', NULL, '90211020'),
(134, 'P-5.10.DM-D', 'Dispositivo mandibular P para corte e perfuração – Direita', '80859840169', '1000.00', 0, '', '', '', '', 'CMF', NULL, '90211020');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtosproposta`
--

DROP TABLE IF EXISTS `produtosproposta`;
CREATE TABLE IF NOT EXISTS `produtosproposta` (
  `prodpropId` int NOT NULL AUTO_INCREMENT,
  `prodpropNome` varchar(100) NOT NULL,
  PRIMARY KEY (`prodpropId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `produtosproposta`
--

INSERT INTO `produtosproposta` (`prodpropId`, `prodpropNome`) VALUES
(1, 'ORTOGNÁTICA'),
(2, 'ATM'),
(3, 'RECONSTRUÇÃO ÓSSEA'),
(4, 'SMARTMOLD'),
(5, 'MESH 4U'),
(6, 'CUSTOMLIFE'),
(7, 'GUIA DE BUCO'),
(8, 'CRÂNIO EM PEEK'),
(9, 'CRÂNIO EM TITÂNIO'),
(10, 'FASTMOLD PMMA'),
(11, 'FASTCMF PMMA'),
(12, 'DISPOSITIVO DE OSTEOTOMIA'),
(13, 'BIOMODELO CRÂNIO'),
(14, 'ATA BUCO'),
(15, 'ATA HOF'),
(16, 'ATA OTORRINO'),
(17, 'ATA COLUNA'),
(18, 'BIOMODELO VÉRTEBRA'),
(19, 'BIOMODELO MAXILA'),
(20, 'BIOMODELO MANDÍBULA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `propostas`
--

DROP TABLE IF EXISTS `propostas`;
CREATE TABLE IF NOT EXISTS `propostas` (
  `propId` int NOT NULL AUTO_INCREMENT,
  `propUserCriacao` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propEmailCriacao` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propDataCriacao` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propStatus` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propStatusTC` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `propEmpresa` varchar(200) DEFAULT NULL,
  `propNomeDr` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propNConselhoDr` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propEmailDr` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propTelefoneDr` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propNomePac` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propConvenio` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propEmailEnvio` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propTipoProd` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propLongListaItens` text NOT NULL,
  `propListaItens` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `propEspessura` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `propUf` varchar(200) NOT NULL,
  `propRepresentante` varchar(200) NOT NULL,
  `propValidade` varchar(200) NOT NULL,
  `propValorSomaItens` float DEFAULT NULL,
  `propValorSomaTotal` float DEFAULT NULL,
  `propDesconto` int DEFAULT NULL,
  `propoValorDesconto` float NOT NULL,
  `propValorPosDesconto` float DEFAULT NULL,
  `propListaItensBD` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `propTxtReprov` varchar(200) DEFAULT NULL,
  `propProjetistas` varchar(30) DEFAULT NULL,
  `propPedido` varchar(10) DEFAULT NULL,
  `propTaxaExtra` varchar(3) NOT NULL,
  `propPlanoVenda` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `propBdDtCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `propDrUid` varchar(200) DEFAULT NULL,
  `propCnpjCpf` varchar(30) NOT NULL,
  `propTxtLaudo` text,
  `propNomeEnvio` varchar(200) DEFAULT NULL,
  `propTelEnvio` varchar(15) DEFAULT NULL,
  `propTxtComercial` text,
  `propTxtRepresentante` text,
  PRIMARY KEY (`propId`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `propostas`
--

INSERT INTO `propostas` (`propId`, `propUserCriacao`, `propEmailCriacao`, `propDataCriacao`, `propStatus`, `propStatusTC`, `propEmpresa`, `propNomeDr`, `propNConselhoDr`, `propEmailDr`, `propTelefoneDr`, `propNomePac`, `propConvenio`, `propEmailEnvio`, `propTipoProd`, `propLongListaItens`, `propListaItens`, `propEspessura`, `propUf`, `propRepresentante`, `propValidade`, `propValorSomaItens`, `propValorSomaTotal`, `propDesconto`, `propoValorDesconto`, `propValorPosDesconto`, `propListaItensBD`, `propTxtReprov`, `propProjetistas`, `propPedido`, `propTaxaExtra`, `propPlanoVenda`, `propBdDtCriacao`, `propDrUid`, `propCnpjCpf`, `propTxtLaudo`, `propNomeEnvio`, `propTelEnvio`, `propTxtComercial`, `propTxtRepresentante`) VALUES
(76, 'joaoheitor', 'joaoheitor@teste.com', '05/11/2021 15:54:32', 'PEDIDO', 'TC REPROVADA SEM ARQUIVO', NULL, 'Joao Heitor', ' 4654', 'joaoheitor@teste.com', '(61) 98365-2810', 'ABC', 'ALLIANZ', 'joaoheitor@teste.com', 'ORTOGNÁTICA', '', ',E200.011-KD', '', 'MS', 'luisaragao', '30', NULL, 8600, 10, 860, 0, '', '', 'PLAN1', '6598', 'não', 'Antecipado', '2021-09-05 19:52:05', NULL, '', 'Data não bate com data informada mudando texto', NULL, NULL, NULL, NULL),
(78, 'joaoheitor', 'joaoheitor@teste.com', '10/11/2021 16:45:38', 'PEDIDO', 'ANALISAR', '', 'Joao Heitor', '4654', 'joaoheitor@teste.com', '(61) 98365-2810', 'ABC', 'DIX', 'joaoheitor@teste.com', 'ORTOGNÁTICA', '', 'KITPC-6000,E200.011-KD', '', 'DF', 'julianaaguiar', '30', 17200, 17200, 0, 0, 17200, '', NULL, NULL, '5253', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2021-11-17 19:52:05', 'doutordoutor', '', NULL, '', '', '', NULL),
(90, 'iris', 'iris@teste.com', '22/11/2021 17:47:50', 'APROVADO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'DSJUI', 'ALLIANZ', 'iris@comercial.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"88\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MANDÍBULA\\\",\\\"cdg\\\":\\\"KITPC-6001\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"88\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6001,PC-920.210,E200.011-KD', NULL, 'DF', 'julianaaguiar', '30', NULL, 8600, 0, 0, 8600, '126,129,130', NULL, NULL, '', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2021-11-22 20:48:25', 'fulanodetal', '39.896.712/0001-76', NULL, NULL, NULL, NULL, NULL),
(91, 'iris', 'iris@teste.com', '22/11/2021 17:52:39', 'APROVADO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'SJA', 'ALLIANZ', 'iris@comercial.com', 'SMARTMOLD', '[{\\\"idProp\\\":\\\"91\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"SMARTMOLD\\\",\\\"nome\\\":\\\"ZIGOMA DIREITO \\\",\\\"cdg\\\":\\\"E200.013-1 D\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"91\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave descartável (estéril e não autoclavável)\\\",\\\"cdg\\\":\\\"ET40.001\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"91\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave permanente (Não estéril)\\\",\\\"cdg\\\":\\\"MM3017\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"91\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Conexão\\\",\\\"nome\\\":\\\"Conexão\\\",\\\"cdg\\\":\\\"MM3042-2\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"91\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso autoperfurante 2.0\\\",\\\"cdg\\\":\\\"A920xxx\\\",\\\"qtd\\\":\\\"2\\\"},{\\\"idProp\\\":\\\"91\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso de emergência 2.3\\\",\\\"cdg\\\":\\\"A920.503\\\",\\\"qtd\\\":\\\"1\\\"}]', 'E200.013-1 D,E200.012-1', '4 mm', 'DF', 'julianaaguiar', '30', NULL, 11300, 10, 1130, 10170, '131,139', NULL, NULL, '', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2021-11-22 20:53:11', 'fulanodetal', '39.896.712/0001-76', NULL, NULL, NULL, NULL, NULL),
(92, 'osires', 'osires@teste.com', '22/11/2021 17:57:25', 'APROVADO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'HJDS', 'ALLIANZ', 'osires@comercial.com', 'ATA BUCO', '[{\\\"idProp\\\":\\\"92\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"MESH4U\\\",\\\"nome\\\":\\\"MANDIBULAR TIÂNIO P\\\",\\\"cdg\\\":\\\"PC-703-MAN*\\\"}]', 'E200.012-1', NULL, 'AC', 'luisaragao', '30', NULL, 2700, 10, 270, 2430, '137', NULL, NULL, '', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2021-11-22 20:57:58', 'fulanodetal', '39.896.712/0001-76', NULL, NULL, NULL, NULL, NULL),
(93, 'mariarosario', 'maria@teste.com', '22/11/2021 18:09:32', 'PEDIDO', 'ANALISAR', '', 'Saads', '5465464', 'dsad@etwe.cm', '45454545', 'MARIAROSáRIO', 'ALLIANZ', 'dsad@etwe.cm', 'ATA BUCO', '[{\\\"idProp\\\":\\\"93\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"MESH4U\\\",\\\"nome\\\":\\\"MAXILA TIÂNIO P\\\",\\\"cdg\\\":\\\"PC-703-MAX*\\\"}]', 'PC-703-MAX*,E200.011-KD,PC-920.210', NULL, 'SP', 'luisaragao', '30', 9144, 9144, 10, 914.4, 8229.6, '', NULL, NULL, '5254', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2021-11-22 21:09:57', 'Escolha um Dr(a)', '052.581.961-43', NULL, '', '', '', NULL),
(87, 'fulanodetal', 'fulano@teste.com', '16/11/2021 18:36:30', 'PEDIDO', 'ANALISAR', NULL, 'Fulano de Tal', ' 12145', 'fulano@teste.com', '(61)5698-8754', 'DSFD', 'ALLIANZ', 'fulano@teste.com', 'ATA BUCO', '[{\\\"idProp\\\":\\\"87\\\",\\\"tipo\\\":\\\"CRÂNIO\\\",\\\"produto\\\":\\\"CRÂNIO PEEK\\\",\\\"nome\\\":\\\"CRÂNIO PEEK - P\\\",\\\"cdg\\\":\\\"PC-201-P1*\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"87\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"6\\\"}]', 'PC-201-P1*,PC-920.210', '', 'AC', 'luisaragao', '30', NULL, 38976, 0, 0, 0, '124,125', NULL, NULL, '2550', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2021-11-17 19:52:05', NULL, '', NULL, NULL, NULL, NULL, NULL),
(94, 'vanessa', 'vanessa.paiva@fixgrupo.com', '30/11/2021 16:53:07', 'PEDIDO', 'ANALISAR', '', 'Fulano De Tal', '454', 'vanessa@teste.com', '(61) 98365-2810', 'SFFD', 'ALLIANZ', 'vanessa.paiva@fixgrupo.com.br', 'SMARTMOLD', '[{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"SMARTMOLD\\\",\\\"nome\\\":\\\"ZIGOMA ESQUERDO\\\",\\\"cdg\\\":\\\"E200.013-1 E\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave descartável (estéril e não autoclavável)\\\",\\\"cdg\\\":\\\"ET40.001\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave permanente (Não estéril)\\\",\\\"cdg\\\":\\\"MM3017\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Conexão\\\",\\\"nome\\\":\\\"Conexão\\\",\\\"cdg\\\":\\\"MM3042-2\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso autoperfurante 2.0\\\",\\\"cdg\\\":\\\"A920xxx\\\",\\\"qtd\\\":\\\"2\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso de emergência 2.3\\\",\\\"cdg\\\":\\\"A920.503\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"SMARTMOLD\\\",\\\"nome\\\":\\\"ZIGOMA BILATERAL\\\",\\\"cdg\\\":\\\"E200.011-F\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave descartável (estéril e não autoclavável)\\\",\\\"cdg\\\":\\\"ET40.001\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave permanente (Não estéril)\\\",\\\"cdg\\\":\\\"MM3017\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Conexão\\\",\\\"nome\\\":\\\"Conexão\\\",\\\"cdg\\\":\\\"MM3042-2\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso autoperfurante 2.0\\\",\\\"cdg\\\":\\\"A920xxx\\\",\\\"qtd\\\":\\\"4\\\"},{\\\"idProp\\\":\\\"94\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso de emergência 2.3\\\",\\\"cdg\\\":\\\"A920.503\\\",\\\"qtd\\\":\\\"1\\\"}]', 'E200.013-1 E,ET40.001,MM3017,MM3042-2,A920xxx,A920.503,E200.011-F,ET40.001,MM3017,MM3042-2,A920xxx,A', '4 mm', 'DF', 'julianaaguiar', '30', 24600, 24600, 0, 0, 24600, '141,142', NULL, NULL, '5255', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2021-11-30 19:54:17', 'doutordoutor', '052.581.961-43', NULL, '', '', '', NULL),
(95, 'josejotform', 'jose@teste.com', '02/12/2021 15:11:37', 'PEDIDO', 'ANALISAR', 'Empresa Fake', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'FSDFS', 'ALLIANZ', 'email@fake.com', 'SMARTMOLD', '[{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"SMARTMOLD\\\",\\\"nome\\\":\\\"ZIGOMA BILATERAL\\\",\\\"cdg\\\":\\\"E200.011-F\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave descartável (estéril e não autoclavável)\\\",\\\"cdg\\\":\\\"ET40.001\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave permanente (Não estéril)\\\",\\\"cdg\\\":\\\"MM3017\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Conexão\\\",\\\"nome\\\":\\\"Conexão\\\",\\\"cdg\\\":\\\"MM3042-2\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso autoperfurante 2.0\\\",\\\"cdg\\\":\\\"A920xxx\\\",\\\"qtd\\\":\\\"4\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso de emergência 2.3\\\",\\\"cdg\\\":\\\"A920.503\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"SMARTMOLD\\\",\\\"nome\\\":\\\"PARANASAL BILATERAL\\\",\\\"cdg\\\":\\\"E200.011-G\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave descartável (estéril e não autoclavável)\\\",\\\"cdg\\\":\\\"ET40.001\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave permanente (Não estéril)\\\",\\\"cdg\\\":\\\"MM3017\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Conexão\\\",\\\"nome\\\":\\\"Conexão\\\",\\\"cdg\\\":\\\"MM3042-2\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso autoperfurante 2.0\\\",\\\"cdg\\\":\\\"A920xxx\\\",\\\"qtd\\\":\\\"4\\\"},{\\\"idProp\\\":\\\"95\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso de emergência 2.3\\\",\\\"cdg\\\":\\\"A920.503\\\",\\\"qtd\\\":\\\"1\\\"}]', 'E200.011-F,ET40.001,MM3017,MM3042-2,A920xxx,A920.503,E200.011-G,ET40.001,MM3017,MM3042-2,A920xxx,A92', '4 mm', 'DF', 'julianaaguiar', '30', 26000, 26000, 0, 0, 26000, '143,144', NULL, NULL, '1111', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2021-12-02 18:12:32', 'heitorjorge', 'as684d', NULL, '', '', '', NULL),
(97, 'distribuidor', 'distribuidor@teste.com', '21/12/2021 15:03:55', 'PEDIDO', 'ANALISAR', 'Empresa', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'SFSA', 'ALLIANZ', 'empresa@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"96\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMPLETA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"96\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210,E200.016-2*', NULL, 'AL', 'marcelaiizuka', '30', 0, 0, 0, 0, 0, '151,150', NULL, NULL, '1111', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2021-12-21 18:04:37', 'fulanodetal', '00.000.000/0000-00', NULL, '', '', '', NULL),
(98, 'osires', 'osires@teste.com', '17/02/2022 14:30:40', 'PEDIDO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'YUJ', 'ASSEFAZ', 'osires@comercial.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"98\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMPLETA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"98\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'AC', 'luisaragao', '30', 37560, 37560, 0, 0, 37560, '152,153', NULL, NULL, '1111', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-17 17:31:59', 'fulanodetal', '39.896.712/0001-76', NULL, '', '', '', NULL),
(99, 'osires', 'osires@teste.com', '17/02/2022 17:02:55', 'PROP. ENVIADA', 'ANALISAR', 'Osires Teste', 'Fulano De Tal', '', 'fulano@teste.com', '(61)5698-87545', 'TYRE', 'BRADESCO', 'osires@comercial.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"99\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMPLETA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"99\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'AC', 'luisaragao', '30', 37560, 37560, 0, 0, 37560, '154,155', NULL, NULL, '', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-17 20:04:56', 'fulanodetal', '39.896.712/0001-76', NULL, '', '', '', NULL),
(100, 'osires', 'osires@teste.com', '17/02/2022 17:50:25', 'PEDIDO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'HJDHF', 'ALLIANZ', 'osires@comercial.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"100\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMPLETA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"100\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'AC', 'luisaragao', '30', 37560, 37560, 0, 0, 37560, '156,157', NULL, NULL, '6589', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-17 20:52:46', 'fulanodetal', '39.896.712/0001-76', NULL, NULL, NULL, NULL, NULL),
(101, 'osires', 'osires@teste.com', '17/02/2022 18:01:59', 'PEDIDO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'PPP', 'ALLIANZ', 'osires@comercial.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"101\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMPLETA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"101\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'AC', 'luisaragao', '30', 37560, 37560, 0, 0, 37560, '158,159', NULL, NULL, '8754', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-17 21:02:51', 'fulanodetal', '39.896.712/0001-76', NULL, NULL, NULL, NULL, NULL),
(102, 'heitorjorge', 'heitorjorge@teste.com', '18/02/2022 09:49:06', 'PEDIDO', 'ANALISAR', NULL, 'Heitor Jorge', ' CRO-DF-55454', 'heitorjorge@teste.com', '(63) 2323-2323', 'TRREE', 'DIX', 'heitorjorge@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"102\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMPLETA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"102\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 37560, 37560, 0, 0, 37560, '160,161', NULL, NULL, '4857', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-18 12:49:57', NULL, ' ', NULL, NULL, NULL, NULL, NULL),
(103, 'osires', 'osires@teste.com', '23/02/2022 14:22:38', 'AGUARD. INFOS ADICIO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'ABC', 'ALLIANZ', 'osires@comercial.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"103\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"103\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'AC', 'luisaragao', '30', 37560, 37560, 0, 0, 37560, '163,164', NULL, NULL, '', 'não', 'Entrada Antecipado 30% + 28/56/84 dias', '2022-02-23 17:23:44', 'fulanodetal', '39.896.712/0001-76', NULL, '', '', '', NULL),
(104, 'osires', 'osires@teste.com', '23/02/2022 14:26:01', 'NÃO COTAR', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'DEF', 'ALLIANZ', 'osires@comercial.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"104\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"104\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'AC', 'luisaragao', '30', 37560, 37560, 0, 0, 37560, '165,166', NULL, NULL, '', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-23 17:26:53', 'fulanodetal', '39.896.712/0001-76', NULL, NULL, NULL, NULL, NULL),
(105, 'osires', 'osires@teste.com', '23/02/2022 14:35:32', 'CLIENTE QUALIFICADO', 'ANALISAR', 'Osires', 'Fulano De Tal', '', 'fulano@teste.com', '(61)5698-8754', 'HIJ', 'ALLIANZ', 'osires@comercial.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"105\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"105\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'AC', 'luisaragao', '30', 75120, 75120, 0, 0, 75120, '167,168,169,170', NULL, NULL, '', 'não', 'Antecipado', '2022-02-23 17:36:20', 'fulanodetal', '39.896.712/0001-76', NULL, '', '', '', NULL),
(106, 'vanessa', 'vanespaiva@gmail.com', '23/02/2022 14:35:32', 'PEDIDO', 'ANALISAR', '', 'Fulano De Tal', '659', 'fulano@teste.com', '(61)5698-87543', 'HIJ', 'ALLIANZ', 'vanespaiva@gmail.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"105\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"105\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'AC', 'luisaragao', '30', 0, 0, 0, 0, 0, '167,168,169,170', NULL, NULL, '5251', 'não', 'Entrada Antecipado 30% + 28/56/84 dias', '2022-02-23 17:36:20', 'fulanodetal', '052.581.961-43', NULL, '', '', '', NULL),
(107, 'osires', 'osires@teste.com', '23/02/2022 15:08:36', 'PEDIDO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'YTFYU', 'ALLIANZ', 'osires@comercial.com', 'ATM', '[{\\\"idProp\\\":\\\"107\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"ATM ESQUERDO M\\\",\\\"cdg\\\":\\\"KITPC-506E*\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"107\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"ATM DIREITO M\\\",\\\"cdg\\\":\\\"KITPC-506D*\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"107\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"24\\\"}]', 'KITPC-506E*,KITPC-506D*,PC-920.210', NULL, 'AC', 'luisaragao', '30', 117232, 117232, 0, 0, 117232, '171,172,173', NULL, NULL, '123', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-23 18:10:08', 'fulanodetal', '39.896.712/0001-76', NULL, NULL, NULL, NULL, NULL),
(108, 'osires', 'osires@teste.com', '23/02/2022 16:43:07', 'PEDIDO', 'ANALISAR', 'Osires', 'Fulano De Tal', '659', 'fulano@teste.com', '(61)5698-8754', 'TRE', 'ALLIANZ', 'marketing@fixgrupo.com.br', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"108\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"108\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'AC', 'luisaragao', '30', 37560, 37560, 0, 0, 37560, '174,175', NULL, NULL, '16598', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-23 19:46:08', 'fulanodetal', '39.896.712/0001-76', NULL, '', '', '', NULL),
(109, 'osires', 'osires@teste.com', '23/02/2022 16:47:22', 'PEDIDO', 'TC REPROVADA SEM ARQUIVO', 'Osires', 'Fulano De Tal', '6855', 'fulano@teste.com', '(61)5698-8754', 'TRE', 'ALLIANZ', 'osires@comercial.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"109\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MAXILA\\\",\\\"cdg\\\":\\\"KITPC-6000\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"109\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6000,PC-920.210', NULL, 'AC', 'luisaragao', '30', 20040, 20040, 0, 0, 20040, '176,177', 'asdasdasdasd', 'Escolha um projetista...', '5252', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-23 19:48:05', 'fulanodetal', '39.896.712/0001-76', NULL, '', '', '', NULL),
(110, 'vanessa', 'vanessa.paiva@fixgrupo.com', '24/02/2022 16:16:44', 'PEDIDO', 'TC REPROVADA SEM ARQUIVO', '', 'Teste', '454', 'teste@teste.com', '(61) 98365-2810', 'ABC', 'ALLIANZ', 'marketing@fixgrupo.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"110\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"110\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 37560, 37560, 0, 0, 37560, '178,179', '', 'Escolha um projetista...', '5256', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-24 19:27:09', 'doutordoutor', '052.581.961-43', '', '', '', '', NULL),
(111, 'vanessa', 'vanessa.paiva@fixgrupo.com', '24/02/2022 17:44:00', 'PEDIDO', 'TC REPROVADA SEM ARQUIVO', '', 'Teste Teste', ' ', 'vanespaiva@gmail.com', '(61) 98365-2810', 'DEF', 'ALLIANZ', 'vanespaiva@gmail.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"111\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MAXILA\\\",\\\"cdg\\\":\\\"KITPC-6000\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"111\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6000,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 20040, 20040, 0, 0, 20040, '180,181', 'testesdfsdfgsd', 'PLAN1', '9876', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-02-24 20:45:02', 'heitorjorge', '052.581.961-43', NULL, '', '', '', NULL),
(112, 'vanessa', 'vanespaiva@gmail.com', '31/03/2022 14:26:33', 'EM ANÁLISE', 'ANALISAR', '', 'Otavio Da Silva', '', 'otavio@teste.com', '000000000', 'KIAU', 'MEDSENIOR', 'orcamentos.neimplantes@gmail.com', 'ATA BUCO', '[{\\\"idProp\\\":\\\"113\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"MESH4U\\\",\\\"nome\\\":\\\"MANDIBULAR TIÂNIO P\\\",\\\"cdg\\\":\\\"PC-703-MAN*\\\"}]', 'PC-703-MAN*', NULL, 'DF', 'julianaaguiar', '30', 0, 0, 0, 0, 0, '', NULL, NULL, '1684', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-11 19:37:52', 'Escolha um Dr(a)', '', NULL, '', '', 'TEXTO', NULL),
(114, 'vanessa', 'vanespaiva@gmail.com', '31/03/2022 14:54:37', 'CLIENTE QUALIFICADO', 'ANALISAR', '', 'Marcio Andre', '', 'dr@teste.com', '000000000', 'ABC', 'MEDSENIOR', 'orcamentos.neimplantes@gmail.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"113\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MAXILA\\\",\\\"cdg\\\":\\\"KITPC-6000\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"113\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6000,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 20040, 20040, 0, 0, 20040, '189,190', NULL, NULL, '', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 17:56:21', 'Escolha um Dr(a)', '', NULL, '', '', '', '54sd6f4g56g'),
(115, 'vanessa', 'vanespaiva@gmail.com', '31/03/2022 15:04:20', 'CLIENTE QUALIFICADO', 'ANALISAR', '', 'Devid Zille', '', 'zille@cpmh.com.br', '000000000', 'HSO', 'MEDSENIOR', 'orcamentos.neimplantes@gmail.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"115\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MAXILA\\\",\\\"cdg\\\":\\\"KITPC-6000\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"115\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6000,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 20040, 20040, 0, 0, 20040, '191,192', NULL, NULL, '', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 18:05:29', 'Escolha um Dr(a)', '', NULL, '', '', '', 'teste'),
(117, 'osires', 'vanespaiva@gmail.com', '31/03/2022 15:13:26', 'PEDIDO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'ABC', 'HAPVIDA', 'vanespaiva@gmail.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"116\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MAXILA\\\",\\\"cdg\\\":\\\"KITPC-6000\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"116\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6000,PC-920.210', NULL, 'AC', 'luisaragao', '30', 20040, 20040, 0, 0, 20040, '209,210', NULL, NULL, '1111', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 18:14:02', 'fulanodetal', '39.896.712/0001-76', NULL, '', '', '', NULL),
(118, 'osires', 'vanespaiva@gmail.com', '31/03/2022 15:24:20', 'PENDENTE', 'REENVIADA ', 'Osires', 'Fulano De Tal', '12145', 'fulano@teste.com', '(61)5698-8754', 'HSO', 'AMIL', 'vanespaiva@gmail.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"118\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MAXILA\\\",\\\"cdg\\\":\\\"KITPC-6000\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"118\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6000,PC-920.210', NULL, 'IN', 'saulzapatta', '30', 20040, 20040, 0, 0, 20040, '211,212', NULL, NULL, '', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 18:25:04', 'fulanodetal', '39.896.712/0001-76', NULL, '', '', '', NULL),
(119, 'osires', 'vanespaiva@gmail.com', '31/03/2022 15:26:28', 'CLIENTE QUALIFICADO', 'ANALISAR', 'Osires', 'Fulano De Tal', '', 'fulano@teste.com', '(61)5698-8754', 'ABC', 'MEDSERVICE', 'vanespaiva@gmail.com', 'ATM', '[{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"Placa mandibular curta com cabeça condilar P – DIREITA\\\",\\\"cdg\\\":\\\"P-5.10.01-D\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"Dispositivo mandibular P para corte e perfuração – DIREITA\\\",\\\"cdg\\\":\\\"P-5.10.DM-D\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"Fossa articular pequena – DIREITA\\\",\\\"cdg\\\":\\\"P-5.00.01-D\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"Dispositivo fossa de corte e perfuração para articulação pequena - DIREITA\\\",\\\"cdg\\\":\\\"P-5.DF.01-D\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"3\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 05 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.205\\\",\\\"qtd\\\":\\\"6\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,4 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-924.210\\\",\\\"qtd\\\":\\\"8\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"Placa mandibular curta com cabeça condilar P – ESQUERDA\\\",\\\"cdg\\\":\\\"P-5.10.01-E\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"Dispositivo mandibular P para corte e perfuração – ESQUERDA\\\",\\\"cdg\\\":\\\"P-5.10.DM-E\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"Fossa articular pequena – ESQUERDA\\\",\\\"cdg\\\":\\\"P-5.00.01-E\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ATM\\\",\\\"nome\\\":\\\"Dispositivo fossa de corte e perfuração para articulação pequena - ESQUERDA\\\",\\\"cdg\\\":\\\"P-5.DF.01-E\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"3\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 05 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.205\\\",\\\"qtd\\\":\\\"6\\\"},{\\\"idProp\\\":\\\"119\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,4 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-924.210\\\",\\\"qtd\\\":\\\"8\\\"}]', 'P-5.10.01-D,P-5.10.DM-D,P-5.00.01-D,P-5.DF.01-D,PC-920.210,PC-920.205,PC-924.210,P-5.10.01-E,P-5.10.', NULL, 'IN', 'saulzapatta', '30', 52312, 52312, 0, 0, 52312, '213,214,215,216,217,218,219,220,221,222,223,224,225,226,227,228', NULL, NULL, '', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 18:27:03', 'fulanodetal', '39.896.712/0001-76', NULL, '', '', '', NULL),
(120, 'osires', 'vanespaiva@gmail.com', '31/03/2022 15:41:56', 'PEDIDO', 'ANALISAR', 'OSIRES', 'Fulano de Tal', ' ', 'fulano@teste.com', '(61)5698-8754', 'HSO', 'ASSIM', 'vanespaiva@gmail.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"120\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MAXILA\\\",\\\"cdg\\\":\\\"KITPC-6000\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"120\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6000,PC-920.210', NULL, 'AC', 'luisaragao', '30', 20040, 20040, 0, 0, 20040, '229,230', NULL, NULL, '1111', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 18:45:10', 'doutordoutor', '39.896.712/0001-76', NULL, '', '', '', NULL),
(121, 'josejotform', 'jose@teste.com', '31/03/2022 17:44:14', 'PEDIDO', 'ANALISAR', 'Empresa Fake', 'Fulano de Tal', '12145', 'fulano@teste.com', '(61)5698-8754', 'ABC', 'ALLIANZ', 'jose@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"121\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"121\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 37560, 37560, 0, 0, 37560, '231,232', NULL, NULL, '9685', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 20:45:09', 'fulanodetal', 'as684d', NULL, '', '', '', NULL),
(122, 'josejotform', 'jose@teste.com', '31/03/2022 17:44:14', 'PEDIDO', 'ANALISAR', 'Empresa Fake', 'Doutor Doutor', 'CRO-PB-2154', '(66) 6666-6666', 'doutordoutor@teste.c', 'ABC', 'ALLIANZ', 'jose@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"121\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"121\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'IN', 'saulzapatta', '30', 37560, 37560, 0, 0, 37560, '233,234', NULL, NULL, '1234', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 20:45:15', 'doutordoutor', 'as684d', NULL, '', '', '', NULL),
(123, 'josejotform', 'jose@teste.com', '31/03/2022 17:48:51', 'PEDIDO', 'ANALISAR', 'Empresa Fake', 'Heitor Jorge', 'CRO-DF-55454', '(63) 2323-2323', 'heitorjorge@teste.co', 'ABC', 'NOTREDAME', 'jose@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"123\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"123\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 37560, 37560, 0, 0, 37560, '235,236', NULL, NULL, '65487', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 20:49:33', 'heitorjorge', 'as684d', NULL, '', '', '', NULL),
(124, 'vanessa', 'vanespaiva@gmail.com', '31/03/2022 17:50:07', 'PEDIDO', 'ANALISAR', ' ', 'Doutor Teste', ' ', 'teste@teste.com', '(61) 98365-2810', 'ABC', 'NOTREDAME', 'teste@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"124\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"124\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 37560, 37560, 0, 0, 37560, '237,238', NULL, NULL, '991', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 20:50:46', 'doutordoutor', ' ', NULL, '', '', '', NULL),
(125, 'vanessa', 'vanespaiva@gmail.com', '31/03/2022 17:53:24', 'PEDIDO', 'TC REPROVADA COTAR', ' ', 'Doutor Teste', ' ', 'teste@teste.com', '(61) 98365-2810', 'ABC', 'AMIL', 'teste@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"125\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MAXILA\\\",\\\"cdg\\\":\\\"KITPC-6000\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"125\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6000,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 20040, 20040, 0, 0, 20040, '239,240', 'Teste123', 'Escolha um projetista...', '89565', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-03-31 20:54:17', 'heitorjorge', ' ', NULL, '', '', '', NULL),
(126, 'vanessa', 'vanespaiva@gmail.com', '04/04/2022 11:56:36', 'PEDIDO', 'TC REPROVADA SEM ARQUIVO', ' ', 'Doutor Teste', ' ', 'teste@teste.com', '(61) 98365-2810', 'ABC', 'ALLIANZ', 'teste@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"126\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"126\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 37560, 37560, 0, 0, 37560, '241,242', 'Teste', 'Escolha um projetista...', '8638', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-04-04 15:01:10', 'doutordoutor', ' ', NULL, '', '', 'terte', NULL),
(127, 'vanessa', 'vanespaiva@gmail.com', '04/04/2022 12:17:31', 'PEDIDO', 'TC REPROVADA SEM ARQUIVO', ' ', 'Doutor Teste 2', ' ', 'teste@teste.com', '(61) 98365-2810', 'ABCD', 'MEDSENIOR', 'teste@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"127\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA MAXILA\\\",\\\"cdg\\\":\\\"KITPC-6000\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"127\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"30\\\"}]', 'KITPC-6000,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 20040, 20040, 0, 0, 20040, '243,244', 'teste', 'Escolha um projetista...', '1237', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-04-04 15:19:42', 'doutordoutor', ' ', NULL, '', '', '', NULL),
(128, 'vanessa', 'vanespaiva@gmail.com', '04/04/2022 12:26:26', 'PEDIDO', 'TC APROVADA', '', 'Doutor Teste 3', ' ', 'teste@teste.com', '(61) 98365-2810', 'DEF', 'NOTREDAME', 'vanespaiva@gmail.com', 'RECONSTRUÇÃO ÓSSEA', '[{\\\"idProp\\\":\\\"128\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"RECONSTRUÇÃO\\\",\\\"nome\\\":\\\"ORBITA EM TITÂNIO - P\\\",\\\"cdg\\\":\\\"PC-301-T1*\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"128\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"24\\\"}]', 'PC-301-T1*,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 33432, 33432, 0, 0, 33432, '245,246', '23456', 'PLAN1', '6598', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-04-04 15:27:14', 'doutordoutor', '052.581.961-43', NULL, '', '', '', NULL),
(129, 'vanessa', 'vanespaiva@gmail.com', '06/04/2022 17:16:58', 'PEDIDO', 'REENVIADA ', '', 'Doutor Doutor', 'CRO-PB-2154', 'doutordoutor@teste.com', '(66) 6666-6666', 'ABC', 'ALLIANZ', 'vanessa.paiva@fixgrupo.com.br', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"129\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"129\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 34432, 34432, 0, 0, 34432, '247,248', NULL, NULL, '98656', 'não', 'Entrada Antecipado 50% + 30/60 dias', '2022-04-06 20:17:32', 'doutordoutor', '', NULL, '', '', '', NULL),
(130, 'vanessa', 'vanespaiva@gmail.com', '06/04/2022 17:19:46', 'PEDIDO', 'ANALISAR', '', '', '', '', '', 'KIAU', 'ALLIANZ', 'vanessa.paiva@fixgrupo.com.br', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"130\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"130\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 37560, 37560, 0, 0, 37560, '249,250', NULL, NULL, '1547', 'não', 'Entrada Antecipado 50% + 30/60 dias', '2022-04-06 20:20:34', 'doutordoutor', '', NULL, '', '', '', NULL),
(131, 'oesteonew', 'oesteonew@teste.com', '11/04/2022 10:51:54', 'PEDIDO', 'REENVIADA ', 'Osteofix Bom', 'Devid Zille', '', 'zille.doutor@cpmh.com.br', '(61) 98365-2810', 'ABC', 'AMIL', 'oesteonew@teste.com', 'SMARTMOLD', '[{\\\"idProp\\\":\\\"131\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"SMARTMOLD\\\",\\\"nome\\\":\\\"ZIGOMA BILATERAL\\\",\\\"cdg\\\":\\\"E200.011-F\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"131\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave descartável (estéril e não autoclavável)\\\",\\\"cdg\\\":\\\"ET40.001\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"131\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Chave\\\",\\\"nome\\\":\\\"Chave permanente (Não estéril)\\\",\\\"cdg\\\":\\\"MM3017\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"131\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Conexão\\\",\\\"nome\\\":\\\"Conexão\\\",\\\"cdg\\\":\\\"MM3042-2\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"131\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso autoperfurante 2.0\\\",\\\"cdg\\\":\\\"A920xxx\\\",\\\"qtd\\\":\\\"4\\\"},{\\\"idProp\\\":\\\"131\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso de emergência 2.3\\\",\\\"cdg\\\":\\\"A920.503\\\",\\\"qtd\\\":\\\"1\\\"}]', 'E200.011-F,ET40.001,MM3017,MM3042-2,A920xxx,A920.503', '4 mm', 'DF', 'julianaaguiar', '30', 16000, 16000, 0, 0, 16000, '251', NULL, NULL, '1564', 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-04-11 13:53:44', 'doutordoutor', '24.679.678/0001-00', NULL, '', '', '', NULL),
(132, 'vanessa', 'vanespaiva@gmail.com', '16/05/2022 10:40:28', 'PEDIDO', 'TC APROVADA', '', 'Teste', '', 'teste@teste.com', '(61) 98365-281754', 'ABC', 'MEDSERVICE', 'teste@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"132\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"132\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 37360, 37360, 0, 0, 37360, '252,253', '', 'Escolha um projetista...', '1123', 'não', '35% antecipado + 35% + 30%', '2022-05-16 13:50:45', 'doutordoutor', '', NULL, '', '', 'Teste', 'Teste 4'),
(133, 'osteofixnovo', 'osteofixnovo@teste.com', '03/10/2022 12:22:02', 'PROP. ENVIADA', 'REENVIADA ', 'Osteofix Bom', 'Doutor Teste', '', 'vanespaiva@gmail.com', '(61) 98365-2810', 'ABC', 'GREANLINE', 'osteofixnovo@teste.com', 'ORTOGNÁTICA', '[{\\\"idProp\\\":\\\"133\\\",\\\"tipo\\\":\\\"CMF\\\",\\\"produto\\\":\\\"ORTOGNÁTICA\\\",\\\"nome\\\":\\\"ORTOGNÁTICA COMBINADA\\\",\\\"cdg\\\":\\\"KITPC-6002\\\",\\\"qtd\\\":\\\"1\\\"},{\\\"idProp\\\":\\\"133\\\",\\\"tipo\\\":\\\"EXTRA\\\",\\\"produto\\\":\\\"Parafuso\\\",\\\"nome\\\":\\\"Parafuso 2,0 x 10 Bloqueado\\\",\\\"cdg\\\":\\\"PC-920.210\\\",\\\"qtd\\\":\\\"70\\\"}]', 'KITPC-6002,PC-920.210', NULL, 'DF', 'julianaaguiar', '30', 37560, 37560, 0, 0, 37560, '254,255', NULL, NULL, NULL, 'não', 'Entrada Antecipado 20% + 30 e 60 dias', '2022-10-03 15:22:39', 'Escolha um Dr(a)', '24.679.678/0001-00', NULL, '', '', '', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoidr`
--

DROP TABLE IF EXISTS `qualianexoidr`;
CREATE TABLE IF NOT EXISTS `qualianexoidr` (
  `xidrId` int NOT NULL AUTO_INCREMENT,
  `xidrUserCriador` varchar(30) NOT NULL,
  `xidrTipoContaCriador` varchar(30) NOT NULL,
  `xidrDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xidrDataUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `xidrStatusEnvio` varchar(30) NOT NULL,
  `xidrStatusQualidade` varchar(30) NOT NULL,
  `xidrIdProjeto` varchar(30) NOT NULL,
  `xidrComentariosQualidade` varchar(500) NOT NULL,
  `xidrNomeDr` varchar(300) NOT NULL,
  `xidrNumConselho` varchar(20) NOT NULL,
  `xidrTipoConselho` varchar(30) NOT NULL,
  `xidrTelefone` varchar(14) NOT NULL,
  `xidrEmail` varchar(300) NOT NULL,
  `xidrNomePaciente` varchar(300) NOT NULL,
  `xidrSexo` varchar(20) NOT NULL,
  `xidrIdade` varchar(2) NOT NULL,
  `xidrDiagnostico` varchar(500) NOT NULL,
  `xidrCodigoCID` varchar(20) NOT NULL,
  `xidrTextoProduto` text NOT NULL,
  `xidrProduto` varchar(30) NOT NULL,
  `xidrCidade` varchar(100) NOT NULL,
  `xidrData` varchar(30) NOT NULL,
  `xidrNomeArquivoAss` varchar(500) NOT NULL,
  `xidrPathArquivoAss` varchar(500) NOT NULL,
  PRIMARY KEY (`xidrId`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `qualianexoidr`
--

INSERT INTO `qualianexoidr` (`xidrId`, `xidrUserCriador`, `xidrTipoContaCriador`, `xidrDataCriacao`, `xidrStatusEnvio`, `xidrStatusQualidade`, `xidrIdProjeto`, `xidrComentariosQualidade`, `xidrNomeDr`, `xidrNumConselho`, `xidrTipoConselho`, `xidrTelefone`, `xidrEmail`, `xidrNomePaciente`, `xidrSexo`, `xidrIdade`, `xidrDiagnostico`, `xidrCodigoCID`, `xidrTextoProduto`, `xidrProduto`, `xidrCidade`, `xidrData`, `xidrNomeArquivoAss`, `xidrPathArquivoAss`) VALUES
(2, 'fulanodetal', 'Doutor(a)', '2021-10-20 20:24:23', 'ENVIADO', 'APROVADO', '3094', 'Mudar nome do paciente', 'Fulano de Tal', '12145', '0', '(61)5698-8754', 'fulano@teste.com', 'SFD', 'Feminino', '78', 'HJaugfgs ugudyaguyg ugyugy u iuhiahuij', '545', 'Placa de reconstrução maxilo facial sob medida', 'ATM', 'Brasilia', '2021-10-21', '', ''),
(4, 'fulanodetal', 'Doutor(a)', '2021-10-25 13:07:48', 'ENVIADO', 'APROVADO', '3093', '', 'Fulano de Tal', '12145', '0', '(61)5698-8754', 'fulano@teste.com', 'FD', 'Feminino', '65', 'Jhdgshkh ojioj f dsfsdfsdf sdfd', '564', 'Placa de reconstrução maxilo facial sob medida', 'ATM', 'Brasilia', '2021-10-25', '', ''),
(5, 'vanessapaiva', 'Administrador', '2021-11-02 18:30:37', 'ENVIADO', 'EM ANÁLISE', '3095', '', 'Vanessa Paz Araújo Paiva', '', 'de Medicina', '+5561983652810', 'vanespaiva@gmail.com', 'VERONICA P A PAIVA', 'Feminino', '98', 'YTFYG', '70745070', 'Placa de reconstrução maxilo facial sob medida', 'ATM', 'Brasília', '', '61826464a0a24.png', 'signatures/61826464a0a24.png'),
(6, '', '', '2021-11-02 23:53:58', 'VAZIO', '', '3099', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, '', '', '2021-11-17 14:41:50', 'VAZIO', '', '123', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, '', '', '2021-11-17 14:42:05', 'VAZIO', '', '123', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, '', '', '2021-11-17 18:32:51', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(10, '', '', '2021-11-17 19:56:48', 'VAZIO', '', '6598', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, '', '', '2021-11-17 19:57:10', 'VAZIO', '', '6598', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, '', '', '2021-11-17 21:05:16', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, '', '', '2021-11-17 21:05:33', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, '', '', '2021-11-17 21:07:19', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(15, '', '', '2021-11-17 21:07:28', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(16, '', '', '2021-11-17 21:07:52', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(17, '', '', '2021-11-17 21:08:07', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(18, '', '', '2021-11-18 12:34:57', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(19, '', '', '2021-11-18 12:36:00', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(20, '', '', '2021-11-18 12:36:04', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(21, '', '', '2021-11-18 12:36:35', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(22, '', '', '2021-11-18 12:37:00', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(23, '', '', '2021-11-18 12:37:14', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(24, '', '', '2021-11-18 12:44:14', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(25, '', '', '2021-11-18 12:48:16', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(26, '', '', '2021-11-18 12:49:10', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(27, '', '', '2021-11-18 12:49:58', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(28, '', '', '2021-11-18 12:50:00', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(29, '', '', '2021-11-18 12:51:20', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(30, '', '', '2021-11-18 12:56:12', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(31, '', '', '2021-11-18 13:37:51', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(32, '', '', '2022-02-21 16:57:56', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(33, '', '', '2022-02-21 16:58:00', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(34, '', '', '2022-02-21 16:58:01', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(35, '', '', '2022-02-21 16:58:10', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(36, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(37, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(38, '', '', '2022-02-21 16:59:22', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(39, '', '', '2022-02-21 16:59:24', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(40, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(41, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(42, '', '', '2022-02-21 17:12:14', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(43, '', '', '2022-02-21 17:14:54', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(44, '', '', '2022-02-21 17:16:03', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(45, '', '', '2022-02-21 17:17:26', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(46, '', '', '2022-02-21 17:18:20', 'VAZIO', '', '4857', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(47, '', '', '2022-02-21 17:24:45', 'VAZIO', '', '6589', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(48, '', '', '2022-03-09 21:10:10', 'VAZIO', '', '123', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(49, '', '', '2022-03-22 16:02:42', 'VAZIO', '', '1684', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(50, '', '', '2022-03-22 17:35:44', 'VAZIO', '', '9876', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(51, '', '', '2022-03-24 21:30:46', 'VAZIO', '', '1111', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(52, '', '', '2022-04-06 14:57:40', 'VAZIO', '', '1237', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(53, '', '', '2022-04-06 14:59:19', 'VAZIO', '', '8638', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(54, '', '', '2022-04-06 15:00:50', 'VAZIO', '', '991', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(55, '', '', '2022-04-06 15:41:51', 'VAZIO', '', '6598', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(56, 'fulanodetal', '3DTR', '2022-04-06 18:03:47', 'ENVIADO', 'EM ANÁLISE', '89565', '', 'Fulano de Tal', '', 'de Medicina', '(61)5698-8754', 'fulano@teste.com', 'ABC', 'Feminino', '65', 'IOdh sah ishufiusdfiohsdiogh uhdifhySOUIFOU', 'F6SD4F', 'Placa de reconstrução maxilo facial sob medida', 'Reconstrução Facial', 'Brasilia', '', '62839a045fb0a.png', 'signatures/62839a045fb0a.png'),
(57, '', '', '2022-04-06 18:54:18', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(58, '', '', '2022-04-06 18:54:47', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(59, '', '', '2022-04-06 18:55:34', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(60, '', '', '2022-04-06 18:56:12', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(61, '', '', '2022-04-06 19:23:14', 'VAZIO', '', '1234', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(62, '', '', '2022-04-06 19:25:05', 'VAZIO', '', '9685', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(63, '', '', '2022-04-07 18:03:01', 'VAZIO', '', '98656', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(64, '', '', '2022-05-25 14:50:19', 'VAZIO', '', '1122', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(65, '', '', '2022-05-25 15:02:36', 'VAZIO', '', '1122', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(66, '', '', '2022-05-25 17:00:47', 'VAZIO', '', '1123', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(67, '', '', '2022-05-25 17:02:10', 'VAZIO', '', '5254', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(68, '', '', '2022-05-25 17:04:16', 'VAZIO', '', '5253', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(69, '', '', '2022-05-25 17:05:47', 'VAZIO', '', '5252', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(70, '', '', '2022-05-25 17:07:11', 'VAZIO', '', '5251', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoii`
--

DROP TABLE IF EXISTS `qualianexoii`;
CREATE TABLE IF NOT EXISTS `qualianexoii` (
  `xiiId` int NOT NULL AUTO_INCREMENT,
  `xiiUserCriador` varchar(30) NOT NULL,
  `xiiTipoContaCriador` varchar(30) NOT NULL,
  `xiiDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xiiDataUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `xiiStatusEnvio` varchar(30) NOT NULL,
  `xiiStatusQualidade` varchar(30) NOT NULL,
  `xiiIdProjeto` varchar(30) NOT NULL,
  `xiiComentariosQualidade` varchar(500) NOT NULL,
  `xiiNomeDr` varchar(300) NOT NULL,
  `xiiCPFDr` varchar(14) NOT NULL,
  `xiiEspecialidade` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `xiiNumConselho` varchar(20) NOT NULL,
  `xiiTelefoneDr` varchar(15) NOT NULL,
  `xiiCidadeDr` varchar(100) NOT NULL,
  `xiiData` varchar(30) NOT NULL,
  `xiiNomePac` varchar(300) NOT NULL,
  `xiiDataNascPac` varchar(30) NOT NULL,
  `xiiCPFPac` varchar(14) NOT NULL,
  `xiiProcedimento` varchar(300) NOT NULL,
  `xiiHospital` varchar(200) NOT NULL,
  `xiiBairro` varchar(100) NOT NULL,
  `xiiCidade` varchar(100) NOT NULL,
  `xiiEstado` varchar(2) NOT NULL,
  `xiiNumCID` varchar(20) NOT NULL,
  `xiiNomePatologia` varchar(300) NOT NULL,
  `xiiResumoCirurgia` text NOT NULL,
  `xiiDescricaoCaso` text NOT NULL,
  `xiiImplanteCirurgia` text NOT NULL,
  `xiiTextoProduto` text NOT NULL,
  PRIMARY KEY (`xiiId`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `qualianexoii`
--

INSERT INTO `qualianexoii` (`xiiId`, `xiiUserCriador`, `xiiTipoContaCriador`, `xiiDataCriacao`, `xiiStatusEnvio`, `xiiStatusQualidade`, `xiiIdProjeto`, `xiiComentariosQualidade`, `xiiNomeDr`, `xiiCPFDr`, `xiiEspecialidade`, `xiiNumConselho`, `xiiTelefoneDr`, `xiiCidadeDr`, `xiiData`, `xiiNomePac`, `xiiDataNascPac`, `xiiCPFPac`, `xiiProcedimento`, `xiiHospital`, `xiiBairro`, `xiiCidade`, `xiiEstado`, `xiiNumCID`, `xiiNomePatologia`, `xiiResumoCirurgia`, `xiiDescricaoCaso`, `xiiImplanteCirurgia`, `xiiTextoProduto`) VALUES
(2, '', '', '2021-10-20 20:24:23', 'VAZIO', '', '3094', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 'fulanodetal', 'Doutor(a)', '2021-10-25 13:07:48', 'ENVIADO', 'APROVADO', '3093', '', 'Felipe Guedes Bueno', '023.509.481-10', 'Cirurgia Bucomaxilofacial', 'CRO-GO-1245', '(62)98529-8665', 'Goiânia', '2021-10-26', 'Victor Paulo de Mesquita Nascimento', '1989-02-06', '043.873.045-37', 'Reconstrução total de ATM Bilateral com prótese customizada', 'São Lucas', 'Setor Central', 'Goiânia', 'GO', 'K07.6', 'Anquilose bilateral de ATM', 'Ressecção de anquiliose de atm bilateral com reconstrução imediata com prótese bilateral customizada.', 'Caso complexo com necessidade de componente customizado, que apresenta melhores resultados a curto, médio e longo prazo quando comparado com as opções de prótese de prateleira. Além disso será removido estrutura óssea considerável, o que impede o uso de prótese de prateleira, uma vez que a mesma não conseguiria se adaptar ao defeito ósseo.', 'ATM Bilateral', 'Placa de reconstrução maxilo facial sob medida'),
(5, '', '', '2021-11-02 18:30:37', 'VAZIO', '', '3095', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, '', '', '2021-11-02 23:53:58', 'VAZIO', '', '3099', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, '', '', '2021-11-17 14:41:50', 'VAZIO', '', '123', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, '', '', '2021-11-17 14:42:05', 'VAZIO', '', '123', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, '', '', '2021-11-17 18:32:51', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(10, '', '', '2021-11-17 19:56:48', 'VAZIO', '', '6598', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, '', '', '2021-11-17 19:57:10', 'VAZIO', '', '6598', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, '', '', '2021-11-17 21:05:16', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, '', '', '2021-11-17 21:05:33', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, '', '', '2021-11-17 21:07:19', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(15, '', '', '2021-11-17 21:07:28', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(16, '', '', '2021-11-17 21:07:52', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(17, '', '', '2021-11-17 21:08:07', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(18, '', '', '2021-11-18 12:34:57', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(19, '', '', '2021-11-18 12:36:00', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(20, '', '', '2021-11-18 12:36:04', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(21, '', '', '2021-11-18 12:36:35', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(22, '', '', '2021-11-18 12:37:00', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(23, '', '', '2021-11-18 12:37:14', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(24, '', '', '2021-11-18 12:44:14', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(25, '', '', '2021-11-18 12:48:16', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(26, '', '', '2021-11-18 12:49:10', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(27, '', '', '2021-11-18 12:49:58', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(28, '', '', '2021-11-18 12:50:00', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(29, '', '', '2021-11-18 12:51:20', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(30, '', '', '2021-11-18 12:56:12', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(31, '', '', '2021-11-18 13:37:51', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(32, '', '', '2022-02-21 16:57:56', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(33, '', '', '2022-02-21 16:58:00', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(34, '', '', '2022-02-21 16:58:01', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(35, '', '', '2022-02-21 16:58:10', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(36, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(37, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(38, '', '', '2022-02-21 16:59:22', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(39, '', '', '2022-02-21 16:59:24', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(40, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(41, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(42, '', '', '2022-02-21 17:12:14', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(43, '', '', '2022-02-21 17:14:54', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(44, '', '', '2022-02-21 17:16:03', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(45, '', '', '2022-02-21 17:17:26', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(46, '', '', '2022-02-21 17:18:20', 'VAZIO', '', '4857', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(47, '', '', '2022-02-21 17:24:45', 'VAZIO', '', '6589', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(48, '', '', '2022-03-09 21:10:10', 'VAZIO', '', '123', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(49, '', '', '2022-03-22 16:02:42', 'VAZIO', '', '1684', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(50, '', '', '2022-03-22 17:35:44', 'VAZIO', '', '9876', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(51, '', '', '2022-03-24 21:30:46', 'VAZIO', '', '1111', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(52, '', '', '2022-04-06 14:57:40', 'VAZIO', '', '1237', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(53, '', '', '2022-04-06 14:59:19', 'VAZIO', '', '8638', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(54, '', '', '2022-04-06 15:00:50', 'VAZIO', '', '991', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(55, '', '', '2022-04-06 15:41:51', 'VAZIO', '', '6598', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(56, '', '', '2022-04-06 18:03:47', 'VAZIO', '', '89565', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(57, '', '', '2022-04-06 18:54:18', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(58, '', '', '2022-04-06 18:54:47', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(59, '', '', '2022-04-06 18:55:34', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(60, '', '', '2022-04-06 18:56:12', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(61, '', '', '2022-04-06 19:23:14', 'VAZIO', '', '1234', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(62, '', '', '2022-04-06 19:25:05', 'VAZIO', '', '9685', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(63, '', '', '2022-04-07 18:03:01', 'VAZIO', '', '98656', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(64, '', '', '2022-05-25 14:50:19', 'VAZIO', '', '1122', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(65, '', '', '2022-05-25 15:02:36', 'VAZIO', '', '1122', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(66, '', '', '2022-05-25 17:00:47', 'VAZIO', '', '1123', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(67, '', '', '2022-05-25 17:02:10', 'VAZIO', '', '5254', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(68, '', '', '2022-05-25 17:04:16', 'VAZIO', '', '5253', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(69, '', '', '2022-05-25 17:05:47', 'VAZIO', '', '5252', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(70, '', '', '2022-05-25 17:07:11', 'VAZIO', '', '5251', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoiiidr`
--

DROP TABLE IF EXISTS `qualianexoiiidr`;
CREATE TABLE IF NOT EXISTS `qualianexoiiidr` (
  `xiiidrId` int NOT NULL AUTO_INCREMENT,
  `xiiidrUserCriador` varchar(30) NOT NULL,
  `xiiidrTipoContaCriador` varchar(30) NOT NULL,
  `xiiidrDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xiiidrDataUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `xiiidrStatusEnvio` varchar(30) NOT NULL,
  `xiiidrStatusQualidade` varchar(30) NOT NULL,
  `xiiidrIdProjeto` varchar(30) NOT NULL,
  `xiiidrComentariosQualidade` varchar(500) NOT NULL,
  `xiiidrNomeDr` varchar(100) NOT NULL,
  `xiiidrNumConselho` varchar(15) NOT NULL,
  `xiiidrData` varchar(20) NOT NULL,
  PRIMARY KEY (`xiiidrId`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `qualianexoiiidr`
--

INSERT INTO `qualianexoiiidr` (`xiiidrId`, `xiiidrUserCriador`, `xiiidrTipoContaCriador`, `xiiidrDataCriacao`, `xiiidrStatusEnvio`, `xiiidrStatusQualidade`, `xiiidrIdProjeto`, `xiiidrComentariosQualidade`, `xiiidrNomeDr`, `xiiidrNumConselho`, `xiiidrData`) VALUES
(2, '', '', '2021-10-20 20:24:23', 'VAZIO', '', '3094', '', '', '', ''),
(4, 'fulanodetal', 'Doutor(a)', '2021-10-25 13:07:48', 'ENVIADO', 'APROVADO', '3093', '', 'Fulano de Tal', '12145', '2021-10-25'),
(5, '', '', '2021-11-02 18:30:37', 'VAZIO', '', '3095', '', '', '', ''),
(6, '', '', '2021-11-02 23:53:58', 'VAZIO', '', '3099', '', '', '', ''),
(7, '', '', '2021-11-17 14:41:50', 'VAZIO', '', '123', '', '', '', ''),
(8, '', '', '2021-11-17 14:42:05', 'VAZIO', '', '123', '', '', '', ''),
(9, '', '', '2021-11-17 18:32:51', 'VAZIO', '', '2550', '', '', '', ''),
(10, '', '', '2021-11-17 19:56:48', 'VAZIO', '', '6598', '', '', '', ''),
(11, '', '', '2021-11-17 19:57:10', 'VAZIO', '', '6598', '', '', '', ''),
(12, '', '', '2021-11-17 21:05:16', 'VAZIO', '', '2550', '', '', '', ''),
(13, '', '', '2021-11-17 21:05:33', 'VAZIO', '', '2550', '', '', '', ''),
(14, '', '', '2021-11-17 21:07:19', 'VAZIO', '', '2550', '', '', '', ''),
(15, '', '', '2021-11-17 21:07:28', 'VAZIO', '', '2550', '', '', '', ''),
(16, '', '', '2021-11-17 21:07:52', 'VAZIO', '', '2550', '', '', '', ''),
(17, '', '', '2021-11-17 21:08:07', 'VAZIO', '', '2550', '', '', '', ''),
(18, '', '', '2021-11-18 12:34:57', 'VAZIO', '', '2550', '', '', '', ''),
(19, '', '', '2021-11-18 12:36:00', 'VAZIO', '', '2550', '', '', '', ''),
(20, '', '', '2021-11-18 12:36:04', 'VAZIO', '', '2550', '', '', '', ''),
(21, '', '', '2021-11-18 12:36:35', 'VAZIO', '', '2550', '', '', '', ''),
(22, '', '', '2021-11-18 12:37:00', 'VAZIO', '', '2550', '', '', '', ''),
(23, '', '', '2021-11-18 12:37:14', 'VAZIO', '', '2550', '', '', '', ''),
(24, '', '', '2021-11-18 12:44:14', 'VAZIO', '', '2550', '', '', '', ''),
(25, '', '', '2021-11-18 12:48:16', 'VAZIO', '', '2550', '', '', '', ''),
(26, '', '', '2021-11-18 12:49:10', 'VAZIO', '', '2550', '', '', '', ''),
(27, '', '', '2021-11-18 12:49:58', 'VAZIO', '', '2550', '', '', '', ''),
(28, '', '', '2021-11-18 12:50:00', 'VAZIO', '', '2550', '', '', '', ''),
(29, '', '', '2021-11-18 12:51:20', 'VAZIO', '', '2550', '', '', '', ''),
(30, '', '', '2021-11-18 12:56:12', 'VAZIO', '', '2550', '', '', '', ''),
(31, '', '', '2021-11-18 13:37:51', 'VAZIO', '', '2550', '', '', '', ''),
(32, '', '', '2022-02-21 16:57:56', 'VAZIO', '', '45463', '', '', '', ''),
(33, '', '', '2022-02-21 16:58:00', 'VAZIO', '', '45463', '', '', '', ''),
(34, '', '', '2022-02-21 16:58:01', 'VAZIO', '', '45463', '', '', '', ''),
(35, '', '', '2022-02-21 16:58:10', 'VAZIO', '', '45463', '', '', '', ''),
(36, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', '', ''),
(37, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', '', ''),
(38, '', '', '2022-02-21 16:59:22', 'VAZIO', '', '45463', '', '', '', ''),
(39, '', '', '2022-02-21 16:59:24', 'VAZIO', '', '45463', '', '', '', ''),
(40, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', '', ''),
(41, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', '', ''),
(42, '', '', '2022-02-21 17:12:14', 'VAZIO', '', '8754', '', '', '', ''),
(43, '', '', '2022-02-21 17:14:54', 'VAZIO', '', '8754', '', '', '', ''),
(44, '', '', '2022-02-21 17:16:03', 'VAZIO', '', '8754', '', '', '', ''),
(45, '', '', '2022-02-21 17:17:26', 'VAZIO', '', '8754', '', '', '', ''),
(46, '', '', '2022-02-21 17:18:20', 'VAZIO', '', '4857', '', '', '', ''),
(47, '', '', '2022-02-21 17:24:45', 'VAZIO', '', '6589', '', '', '', ''),
(48, '', '', '2022-03-09 21:10:10', 'VAZIO', '', '123', '', '', '', ''),
(49, '', '', '2022-03-22 16:02:42', 'VAZIO', '', '1684', '', '', '', ''),
(50, '', '', '2022-03-22 17:35:44', 'VAZIO', '', '9876', '', '', '', ''),
(51, '', '', '2022-03-24 21:30:46', 'VAZIO', '', '1111', '', '', '', ''),
(52, '', '', '2022-04-06 14:57:40', 'VAZIO', '', '1237', '', '', '', ''),
(53, '', '', '2022-04-06 14:59:19', 'VAZIO', '', '8638', '', '', '', ''),
(54, '', '', '2022-04-06 15:00:50', 'VAZIO', '', '991', '', '', '', ''),
(55, '', '', '2022-04-06 15:41:51', 'VAZIO', '', '6598', '', '', '', ''),
(56, '', '', '2022-04-06 18:03:47', 'VAZIO', '', '89565', '', '', '', ''),
(57, '', '', '2022-04-06 18:54:18', 'VAZIO', '', '65487', '', '', '', ''),
(58, '', '', '2022-04-06 18:54:47', 'VAZIO', '', '65487', '', '', '', ''),
(59, '', '', '2022-04-06 18:55:34', 'VAZIO', '', '65487', '', '', '', ''),
(60, '', '', '2022-04-06 18:56:12', 'VAZIO', '', '65487', '', '', '', ''),
(61, '', '', '2022-04-06 19:23:14', 'VAZIO', '', '1234', '', '', '', ''),
(62, '', '', '2022-04-06 19:25:05', 'VAZIO', '', '9685', '', '', '', ''),
(63, '', '', '2022-04-07 18:03:01', 'VAZIO', '', '98656', '', '', '', ''),
(64, '', '', '2022-05-25 14:50:20', 'VAZIO', '', '1122', '', '', '', ''),
(65, '', '', '2022-05-25 15:02:36', 'VAZIO', '', '1122', '', '', '', ''),
(66, '', '', '2022-05-25 17:00:47', 'VAZIO', '', '1123', '', '', '', ''),
(67, '', '', '2022-05-25 17:02:10', 'VAZIO', '', '5254', '', '', '', ''),
(68, '', '', '2022-05-25 17:04:16', 'VAZIO', '', '5253', '', '', '', ''),
(69, '', '', '2022-05-25 17:05:47', 'VAZIO', '', '5252', '', '', '', ''),
(70, '', '', '2022-05-25 17:07:11', 'VAZIO', '', '5251', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoiiipac`
--

DROP TABLE IF EXISTS `qualianexoiiipac`;
CREATE TABLE IF NOT EXISTS `qualianexoiiipac` (
  `xiiipacId` int NOT NULL AUTO_INCREMENT,
  `xiiipacUserCriador` varchar(30) NOT NULL,
  `xiiipacTipoContaCriador` varchar(30) NOT NULL,
  `xiiipacDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xiiipacDataUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `xiiipacStatusEnvio` varchar(30) NOT NULL,
  `xiiipacStatusQualidade` varchar(30) NOT NULL,
  `xiiipacIdProjeto` varchar(30) NOT NULL,
  `xiiipacComentariosQualidade` varchar(500) NOT NULL,
  `xiiipacNomePac` varchar(100) NOT NULL,
  `xiiipacData` varchar(20) NOT NULL,
  PRIMARY KEY (`xiiipacId`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `qualianexoiiipac`
--

INSERT INTO `qualianexoiiipac` (`xiiipacId`, `xiiipacUserCriador`, `xiiipacTipoContaCriador`, `xiiipacDataCriacao`, `xiiipacStatusEnvio`, `xiiipacStatusQualidade`, `xiiipacIdProjeto`, `xiiipacComentariosQualidade`, `xiiipacNomePac`, `xiiipacData`) VALUES
(2, '', '', '2021-10-20 20:24:23', 'VAZIO', '', '3094', '', '', ''),
(4, 'vanessapaiva', 'Administrador', '2021-10-25 13:07:48', 'ENVIADO', 'APROVADO', '3093', '', 'Vanessa Paz Araújo Paiva', '2021-10-25'),
(5, '', '', '2021-11-02 18:30:37', 'VAZIO', '', '3095', '', '', ''),
(6, '', '', '2021-11-02 23:53:59', 'VAZIO', '', '3099', '', '', ''),
(7, '', '', '2021-11-17 14:41:50', 'VAZIO', '', '123', '', '', ''),
(8, '', '', '2021-11-17 14:42:05', 'VAZIO', '', '123', '', '', ''),
(9, '', '', '2021-11-17 18:32:51', 'VAZIO', '', '2550', '', '', ''),
(10, '', '', '2021-11-17 19:56:48', 'VAZIO', '', '6598', '', '', ''),
(11, '', '', '2021-11-17 19:57:10', 'VAZIO', '', '6598', '', '', ''),
(12, '', '', '2021-11-17 21:05:16', 'VAZIO', '', '2550', '', '', ''),
(13, '', '', '2021-11-17 21:05:33', 'VAZIO', '', '2550', '', '', ''),
(14, '', '', '2021-11-17 21:07:19', 'VAZIO', '', '2550', '', '', ''),
(15, '', '', '2021-11-17 21:07:28', 'VAZIO', '', '2550', '', '', ''),
(16, '', '', '2021-11-17 21:07:52', 'VAZIO', '', '2550', '', '', ''),
(17, '', '', '2021-11-17 21:08:07', 'VAZIO', '', '2550', '', '', ''),
(18, '', '', '2021-11-18 12:34:57', 'VAZIO', '', '2550', '', '', ''),
(19, '', '', '2021-11-18 12:36:00', 'VAZIO', '', '2550', '', '', ''),
(20, '', '', '2021-11-18 12:36:04', 'VAZIO', '', '2550', '', '', ''),
(21, '', '', '2021-11-18 12:36:35', 'VAZIO', '', '2550', '', '', ''),
(22, '', '', '2021-11-18 12:37:00', 'VAZIO', '', '2550', '', '', ''),
(23, '', '', '2021-11-18 12:37:14', 'VAZIO', '', '2550', '', '', ''),
(24, '', '', '2021-11-18 12:44:14', 'VAZIO', '', '2550', '', '', ''),
(25, '', '', '2021-11-18 12:48:16', 'VAZIO', '', '2550', '', '', ''),
(26, '', '', '2021-11-18 12:49:10', 'VAZIO', '', '2550', '', '', ''),
(27, '', '', '2021-11-18 12:49:58', 'VAZIO', '', '2550', '', '', ''),
(28, '', '', '2021-11-18 12:50:00', 'VAZIO', '', '2550', '', '', ''),
(29, '', '', '2021-11-18 12:51:20', 'VAZIO', '', '2550', '', '', ''),
(30, '', '', '2021-11-18 12:56:12', 'VAZIO', '', '2550', '', '', ''),
(31, '', '', '2021-11-18 13:37:51', 'VAZIO', '', '2550', '', '', ''),
(32, '', '', '2022-02-21 16:57:56', 'VAZIO', '', '45463', '', '', ''),
(33, '', '', '2022-02-21 16:58:00', 'VAZIO', '', '45463', '', '', ''),
(34, '', '', '2022-02-21 16:58:01', 'VAZIO', '', '45463', '', '', ''),
(35, '', '', '2022-02-21 16:58:10', 'VAZIO', '', '45463', '', '', ''),
(36, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', ''),
(37, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', ''),
(38, '', '', '2022-02-21 16:59:22', 'VAZIO', '', '45463', '', '', ''),
(39, '', '', '2022-02-21 16:59:24', 'VAZIO', '', '45463', '', '', ''),
(40, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', ''),
(41, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', ''),
(42, '', '', '2022-02-21 17:12:14', 'VAZIO', '', '8754', '', '', ''),
(43, '', '', '2022-02-21 17:14:54', 'VAZIO', '', '8754', '', '', ''),
(44, '', '', '2022-02-21 17:16:03', 'VAZIO', '', '8754', '', '', ''),
(45, '', '', '2022-02-21 17:17:26', 'VAZIO', '', '8754', '', '', ''),
(46, '', '', '2022-02-21 17:18:20', 'VAZIO', '', '4857', '', '', ''),
(47, '', '', '2022-02-21 17:24:45', 'VAZIO', '', '6589', '', '', ''),
(48, '', '', '2022-03-09 21:10:10', 'VAZIO', '', '123', '', '', ''),
(49, '', '', '2022-03-22 16:02:42', 'VAZIO', '', '1684', '', '', ''),
(50, '', '', '2022-03-22 17:35:44', 'VAZIO', '', '9876', '', '', ''),
(51, '', '', '2022-03-24 21:30:46', 'VAZIO', '', '1111', '', '', ''),
(52, '', '', '2022-04-06 14:57:40', 'VAZIO', '', '1237', '', '', ''),
(53, '', '', '2022-04-06 14:59:19', 'VAZIO', '', '8638', '', '', ''),
(54, '', '', '2022-04-06 15:00:50', 'VAZIO', '', '991', '', '', ''),
(55, '', '', '2022-04-06 15:41:51', 'VAZIO', '', '6598', '', '', ''),
(56, '', '', '2022-04-06 18:03:47', 'VAZIO', '', '89565', '', '', ''),
(57, '', '', '2022-04-06 18:54:18', 'VAZIO', '', '65487', '', '', ''),
(58, '', '', '2022-04-06 18:54:47', 'VAZIO', '', '65487', '', '', ''),
(59, '', '', '2022-04-06 18:55:34', 'VAZIO', '', '65487', '', '', ''),
(60, '', '', '2022-04-06 18:56:12', 'VAZIO', '', '65487', '', '', ''),
(61, '', '', '2022-04-06 19:23:14', 'VAZIO', '', '1234', '', '', ''),
(62, '', '', '2022-04-06 19:25:05', 'VAZIO', '', '9685', '', '', ''),
(63, '', '', '2022-04-07 18:03:01', 'VAZIO', '', '98656', '', '', ''),
(64, '', '', '2022-05-25 14:50:20', 'VAZIO', '', '1122', '', '', ''),
(65, '', '', '2022-05-25 15:02:36', 'VAZIO', '', '1122', '', '', ''),
(66, '', '', '2022-05-25 17:00:47', 'VAZIO', '', '1123', '', '', ''),
(67, '', '', '2022-05-25 17:02:10', 'VAZIO', '', '5254', '', '', ''),
(68, '', '', '2022-05-25 17:04:16', 'VAZIO', '', '5253', '', '', ''),
(69, '', '', '2022-05-25 17:05:47', 'VAZIO', '', '5252', '', '', ''),
(70, '', '', '2022-05-25 17:07:11', 'VAZIO', '', '5251', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoipac`
--

DROP TABLE IF EXISTS `qualianexoipac`;
CREATE TABLE IF NOT EXISTS `qualianexoipac` (
  `xipacId` int NOT NULL AUTO_INCREMENT,
  `xipacUserCriador` varchar(30) NOT NULL,
  `xipacTipoContaCriador` varchar(30) NOT NULL,
  `xipacDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xipacDataUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `xipacStatusEnvio` varchar(30) NOT NULL,
  `xipacStatusQualidade` varchar(30) NOT NULL,
  `xipacIdProjeto` varchar(30) NOT NULL,
  `xipacComentariosQualidade` varchar(500) NOT NULL,
  `xipacNomePac` varchar(100) NOT NULL,
  `xipacIdentidade` varchar(20) NOT NULL,
  `xipacOrgaoId` varchar(100) NOT NULL,
  `xipacCPF` varchar(14) NOT NULL,
  `xipacReside` varchar(300) NOT NULL,
  `xipacBairro` varchar(100) NOT NULL,
  `xipacCidade` varchar(100) NOT NULL,
  `xipacEstado` varchar(2) NOT NULL,
  `xipacTelefone` varchar(15) NOT NULL,
  `xipacEmail` varchar(300) NOT NULL,
  PRIMARY KEY (`xipacId`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `qualianexoipac`
--

INSERT INTO `qualianexoipac` (`xipacId`, `xipacUserCriador`, `xipacTipoContaCriador`, `xipacDataCriacao`, `xipacStatusEnvio`, `xipacStatusQualidade`, `xipacIdProjeto`, `xipacComentariosQualidade`, `xipacNomePac`, `xipacIdentidade`, `xipacOrgaoId`, `xipacCPF`, `xipacReside`, `xipacBairro`, `xipacCidade`, `xipacEstado`, `xipacTelefone`, `xipacEmail`) VALUES
(2, '', '', '2021-10-20 20:24:23', 'VAZIO', '', '3094', '', '', '', '', '', '', '', '', '', '', ''),
(4, 'mariarosario', 'Paciente', '2021-10-25 13:07:48', 'ENVIADO', 'APROVADO', '3093', '', 'Maria Rosário', '5615', 'hvybu', '05600460464', '', 'Asa Norte', 'Brasilia', 'DF', '00000000000', 'maria@teste.com'),
(5, '', '', '2021-11-02 18:30:37', 'VAZIO', '', '3095', '', '', '', '', '', '', '', '', '', '', ''),
(6, '', '', '2021-11-02 23:53:58', 'VAZIO', '', '3099', '', '', '', '', '', '', '', '', '', '', ''),
(7, '', '', '2021-11-17 14:41:50', 'VAZIO', '', '123', '', '', '', '', '', '', '', '', '', '', ''),
(8, '', '', '2021-11-17 14:42:05', 'VAZIO', '', '123', '', '', '', '', '', '', '', '', '', '', ''),
(9, '', '', '2021-11-17 18:32:51', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(10, '', '', '2021-11-17 19:56:48', 'VAZIO', '', '6598', '', '', '', '', '', '', '', '', '', '', ''),
(11, '', '', '2021-11-17 19:57:10', 'VAZIO', '', '6598', '', '', '', '', '', '', '', '', '', '', ''),
(12, '', '', '2021-11-17 21:05:16', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(13, '', '', '2021-11-17 21:05:33', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(14, '', '', '2021-11-17 21:07:19', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(15, '', '', '2021-11-17 21:07:28', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(16, '', '', '2021-11-17 21:07:52', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(17, '', '', '2021-11-17 21:08:07', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(18, '', '', '2021-11-18 12:34:57', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(19, '', '', '2021-11-18 12:36:00', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(20, '', '', '2021-11-18 12:36:04', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(21, '', '', '2021-11-18 12:36:35', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(22, '', '', '2021-11-18 12:37:00', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(23, '', '', '2021-11-18 12:37:14', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(24, '', '', '2021-11-18 12:44:14', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(25, '', '', '2021-11-18 12:48:16', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(26, '', '', '2021-11-18 12:49:10', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(27, '', '', '2021-11-18 12:49:58', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(28, '', '', '2021-11-18 12:50:00', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(29, '', '', '2021-11-18 12:51:20', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(30, '', '', '2021-11-18 12:56:12', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(31, '', '', '2021-11-18 13:37:51', 'VAZIO', '', '2550', '', '', '', '', '', '', '', '', '', '', ''),
(32, '', '', '2022-02-21 16:57:56', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(33, '', '', '2022-02-21 16:58:00', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(34, '', '', '2022-02-21 16:58:01', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(35, '', '', '2022-02-21 16:58:10', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(36, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(37, '', '', '2022-02-21 16:58:11', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(38, '', '', '2022-02-21 16:59:22', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(39, '', '', '2022-02-21 16:59:24', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(40, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(41, '', '', '2022-02-21 16:59:25', 'VAZIO', '', '45463', '', '', '', '', '', '', '', '', '', '', ''),
(42, '', '', '2022-02-21 17:12:14', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', ''),
(43, '', '', '2022-02-21 17:14:54', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', ''),
(44, '', '', '2022-02-21 17:16:03', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', ''),
(45, '', '', '2022-02-21 17:17:26', 'VAZIO', '', '8754', '', '', '', '', '', '', '', '', '', '', ''),
(46, '', '', '2022-02-21 17:18:20', 'VAZIO', '', '4857', '', '', '', '', '', '', '', '', '', '', ''),
(47, '', '', '2022-02-21 17:24:45', 'VAZIO', '', '6589', '', '', '', '', '', '', '', '', '', '', ''),
(48, '', '', '2022-03-09 21:10:10', 'VAZIO', '', '123', '', '', '', '', '', '', '', '', '', '', ''),
(49, '', '', '2022-03-22 16:02:42', 'VAZIO', '', '1684', '', '', '', '', '', '', '', '', '', '', ''),
(50, '', '', '2022-03-22 17:35:44', 'VAZIO', '', '9876', '', '', '', '', '', '', '', '', '', '', ''),
(51, '', '', '2022-03-24 21:30:46', 'VAZIO', '', '1111', '', '', '', '', '', '', '', '', '', '', ''),
(52, '', '', '2022-04-06 14:57:40', 'VAZIO', '', '1237', '', '', '', '', '', '', '', '', '', '', ''),
(53, '', '', '2022-04-06 14:59:19', 'VAZIO', '', '8638', '', '', '', '', '', '', '', '', '', '', ''),
(54, '', '', '2022-04-06 15:00:50', 'VAZIO', '', '991', '', '', '', '', '', '', '', '', '', '', ''),
(55, '', '', '2022-04-06 15:41:51', 'VAZIO', '', '6598', '', '', '', '', '', '', '', '', '', '', ''),
(56, '', '', '2022-04-06 18:03:47', 'VAZIO', '', '89565', '', '', '', '', '', '', '', '', '', '', ''),
(57, '', '', '2022-04-06 18:54:18', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', ''),
(58, '', '', '2022-04-06 18:54:47', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', ''),
(59, '', '', '2022-04-06 18:55:34', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', ''),
(60, '', '', '2022-04-06 18:56:12', 'VAZIO', '', '65487', '', '', '', '', '', '', '', '', '', '', ''),
(61, '', '', '2022-04-06 19:23:14', 'VAZIO', '', '1234', '', '', '', '', '', '', '', '', '', '', ''),
(62, '', '', '2022-04-06 19:25:05', 'VAZIO', '', '9685', '', '', '', '', '', '', '', '', '', '', ''),
(63, '', '', '2022-04-07 18:03:01', 'VAZIO', '', '98656', '', '', '', '', '', '', '', '', '', '', ''),
(64, '', '', '2022-05-25 14:50:19', 'VAZIO', '', '1122', '', '', '', '', '', '', '', '', '', '', ''),
(65, '', '', '2022-05-25 15:02:36', 'VAZIO', '', '1122', '', '', '', '', '', '', '', '', '', '', ''),
(66, '', '', '2022-05-25 17:00:47', 'VAZIO', '', '1123', '', '', '', '', '', '', '', '', '', '', ''),
(67, '', '', '2022-05-25 17:02:10', 'VAZIO', '', '5254', '', '', '', '', '', '', '', '', '', '', ''),
(68, '', '', '2022-05-25 17:04:16', 'VAZIO', '', '5253', '', '', '', '', '', '', '', '', '', '', ''),
(69, '', '', '2022-05-25 17:05:47', 'VAZIO', '', '5252', '', '', '', '', '', '', '', '', '', '', ''),
(70, '', '', '2022-05-25 17:07:11', 'VAZIO', '', '5251', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualificacaocliente`
--

DROP TABLE IF EXISTS `qualificacaocliente`;
CREATE TABLE IF NOT EXISTS `qualificacaocliente` (
  `qualiId` int NOT NULL AUTO_INCREMENT,
  `qualiDtChegada` text NOT NULL,
  `qualiUsuario` text NOT NULL,
  `qualiStatus` text NOT NULL,
  `qualiResultado` int NOT NULL DEFAULT '0',
  `qualiRazaoSocial` text,
  `qualiPreenchidoPor` text,
  `qualiFuncao` text,
  `qualiUF` varchar(2) DEFAULT NULL,
  `qualiCNPJ` text,
  `qualiIDForm` text,
  `qualiDtPreenchimento` text,
  `qualiMsg` text,
  `qualiValidade` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`qualiId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `qualificacaocliente`
--

INSERT INTO `qualificacaocliente` (`qualiId`, `qualiDtChegada`, `qualiUsuario`, `qualiStatus`, `qualiResultado`, `qualiRazaoSocial`, `qualiPreenchidoPor`, `qualiFuncao`, `qualiUF`, `qualiCNPJ`, `qualiIDForm`, `qualiDtPreenchimento`, `qualiMsg`, `qualiValidade`) VALUES
(3, '25/05/2022 18:06:56', 'osires', 'Qualificado', 0, 'Osteofix', NULL, NULL, 'DF', '015446165446164', NULL, '2022-06-26', 'Teste', '2022-06-28'),
(4, '27/05/2022 11:16:06', 'vanessa', 'Qualificado', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Teste', '2022-06-27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `registroenvioqualificacao`
--

DROP TABLE IF EXISTS `registroenvioqualificacao`;
CREATE TABLE IF NOT EXISTS `registroenvioqualificacao` (
  `regEnvId` int NOT NULL AUTO_INCREMENT,
  `regEnvUsuario` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `regEnvData` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`regEnvId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `registroenvioqualificacao`
--

INSERT INTO `registroenvioqualificacao` (`regEnvId`, `regEnvUsuario`, `regEnvData`) VALUES
(1, 'osires', '31/05/2022 10:01:34'),
(2, 'osires', '31/05/2022 10:02:31'),
(3, 'osires', '31/05/2022 10:20:00'),
(4, 'vanessa', '31/05/2022 10:20:15'),
(5, 'vanessa', '31/05/2022 10:20:30'),
(6, 'osires', '31/05/2022 11:10:21'),
(7, 'vanessa', '31/05/2022 11:23:01'),
(8, 'vanessa', '31/05/2022 11:23:05'),
(9, 'vanessa', '31/05/2022 11:37:44'),
(10, 'vanessa', '31/05/2022 12:08:45'),
(11, 'vanessa', '31/05/2022 12:09:48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `registropreenchimentoqualificacao`
--

DROP TABLE IF EXISTS `registropreenchimentoqualificacao`;
CREATE TABLE IF NOT EXISTS `registropreenchimentoqualificacao` (
  `regPreId` int NOT NULL AUTO_INCREMENT,
  `regPreUsuario` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `regPreData` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `regPreIdForm` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `regPreNome` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`regPreId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorios`
--

DROP TABLE IF EXISTS `relatorios`;
CREATE TABLE IF NOT EXISTS `relatorios` (
  `relId` int NOT NULL AUTO_INCREMENT,
  `relNumPedRef` varchar(20) NOT NULL,
  `relPath` varchar(300) NOT NULL,
  `relFileName` varchar(100) NOT NULL,
  `relUserCriacao` varchar(30) NOT NULL,
  `relDataEnvio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `relDataUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `relStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`relId`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `relatorios`
--

INSERT INTO `relatorios` (`relId`, `relNumPedRef`, `relPath`, `relFileName`, `relUserCriacao`, `relDataEnvio`, `relStatus`) VALUES
(12, '3094', '', '', '', '2021-10-25 13:07:38', 'VAZIO'),
(13, '3093', 'files/9850-NFAe Vanessa - Outubro.pdf', '9850-NFAe Vanessa - Outubro.pdf', 'vanessapaiva', '2021-10-25 13:07:48', 'ENVIADO'),
(14, '3095', 'files/7398-Relatório de atividades -01_10_2021-31_10_2021.pdf', '7398-Relatório de atividades -01_10_2021-31_10_2021.pdf', 'vanessapaiva', '2021-11-02 18:30:37', 'ENVIADO'),
(15, '3099', '', '', '', '2021-11-02 23:53:59', 'VAZIO'),
(16, '123', '', '', '', '2021-11-17 14:41:50', 'VAZIO'),
(17, '123', '', '', '', '2021-11-17 14:42:05', 'VAZIO'),
(18, '2550', '', '', '', '2021-11-17 18:32:51', 'VAZIO'),
(19, '6598', '', '', '', '2021-11-17 19:56:48', 'VAZIO'),
(20, '6598', '', '', '', '2021-11-17 19:57:10', 'VAZIO'),
(21, '2550', '', '', '', '2021-11-17 21:05:16', 'VAZIO'),
(22, '2550', '', '', '', '2021-11-17 21:05:33', 'VAZIO'),
(23, '2550', '', '', '', '2021-11-17 21:07:19', 'VAZIO'),
(24, '2550', '', '', '', '2021-11-17 21:07:28', 'VAZIO'),
(25, '2550', '', '', '', '2021-11-17 21:07:52', 'VAZIO'),
(26, '2550', '', '', '', '2021-11-17 21:08:07', 'VAZIO'),
(27, '2550', '', '', '', '2021-11-18 12:34:57', 'VAZIO'),
(28, '2550', '', '', '', '2021-11-18 12:36:00', 'VAZIO'),
(29, '2550', '', '', '', '2021-11-18 12:36:04', 'VAZIO'),
(30, '2550', '', '', '', '2021-11-18 12:36:35', 'VAZIO'),
(31, '2550', '', '', '', '2021-11-18 12:37:00', 'VAZIO'),
(32, '2550', '', '', '', '2021-11-18 12:37:14', 'VAZIO'),
(33, '2550', '', '', '', '2021-11-18 12:44:14', 'VAZIO'),
(34, '2550', '', '', '', '2021-11-18 12:48:16', 'VAZIO'),
(35, '2550', '', '', '', '2021-11-18 12:49:10', 'VAZIO'),
(36, '2550', '', '', '', '2021-11-18 12:49:58', 'VAZIO'),
(37, '2550', '', '', '', '2021-11-18 12:50:00', 'VAZIO'),
(38, '2550', '', '', '', '2021-11-18 12:51:20', 'VAZIO'),
(39, '2550', '', '', '', '2021-11-18 12:56:12', 'VAZIO'),
(40, '2550', '', '', '', '2021-11-18 13:37:51', 'VAZIO'),
(41, '45463', '', '', '', '2022-02-21 16:57:56', 'VAZIO'),
(42, '45463', '', '', '', '2022-02-21 16:58:00', 'VAZIO'),
(43, '45463', '', '', '', '2022-02-21 16:58:01', 'VAZIO'),
(44, '45463', '', '', '', '2022-02-21 16:58:10', 'VAZIO'),
(45, '45463', '', '', '', '2022-02-21 16:58:11', 'VAZIO'),
(46, '45463', '', '', '', '2022-02-21 16:58:11', 'VAZIO'),
(47, '45463', '', '', '', '2022-02-21 16:59:22', 'VAZIO'),
(48, '45463', '', '', '', '2022-02-21 16:59:24', 'VAZIO'),
(49, '45463', '', '', '', '2022-02-21 16:59:25', 'VAZIO'),
(50, '45463', '', '', '', '2022-02-21 16:59:25', 'VAZIO'),
(51, '8754', '', '', '', '2022-02-21 17:12:14', 'VAZIO'),
(52, '8754', '', '', '', '2022-02-21 17:14:54', 'VAZIO'),
(53, '8754', '', '', '', '2022-02-21 17:16:03', 'VAZIO'),
(54, '8754', '', '', '', '2022-02-21 17:17:26', 'VAZIO'),
(55, '4857', '', '', '', '2022-02-21 17:18:20', 'VAZIO'),
(56, '6589', '', '', '', '2022-02-21 17:24:45', 'VAZIO'),
(57, '123', '', '', '', '2022-03-09 21:10:10', 'VAZIO'),
(58, '1684', '', '', '', '2022-03-22 16:02:42', 'VAZIO'),
(59, '9876', '', '', '', '2022-03-22 17:35:44', 'VAZIO'),
(60, '1111', '', '', '', '2022-03-24 21:30:46', 'VAZIO'),
(61, '1237', '', '', '', '2022-04-06 14:57:40', 'VAZIO'),
(62, '8638', '', '', '', '2022-04-06 14:59:19', 'VAZIO'),
(63, '991', '', '', '', '2022-04-06 15:00:50', 'VAZIO'),
(64, '6598', '', '', '', '2022-04-06 15:41:51', 'VAZIO'),
(65, '89565', '', '', '', '2022-04-06 18:03:47', 'VAZIO'),
(66, '65487', '', '', '', '2022-04-06 18:54:18', 'VAZIO'),
(67, '65487', '', '', '', '2022-04-06 18:54:47', 'VAZIO'),
(68, '65487', '', '', '', '2022-04-06 18:55:34', 'VAZIO'),
(69, '65487', '', '', '', '2022-04-06 18:56:12', 'VAZIO'),
(70, '1234', '', '', '', '2022-04-06 19:23:14', 'VAZIO'),
(71, '9685', '', '', '', '2022-04-06 19:25:05', 'VAZIO'),
(72, '98656', '', '', '', '2022-04-07 18:03:01', 'VAZIO'),
(73, '1122', '', '', '', '2022-05-25 14:50:20', 'VAZIO'),
(74, '1122', '', '', '', '2022-05-25 15:02:36', 'VAZIO'),
(75, '1123', '', '', '', '2022-05-25 17:00:47', 'VAZIO'),
(76, '5254', '', '', '', '2022-05-25 17:02:10', 'VAZIO'),
(77, '5253', '', '', '', '2022-05-25 17:04:16', 'VAZIO'),
(78, '5252', '', '', '', '2022-05-25 17:05:47', 'VAZIO'),
(79, '5251', '', '', '', '2022-05-25 17:07:11', 'VAZIO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorioupload`
--

DROP TABLE IF EXISTS `relatorioupload`;
CREATE TABLE IF NOT EXISTS `relatorioupload` (
  `fileId` int NOT NULL AUTO_INCREMENT,
  `fileNumPed` varchar(30) NOT NULL,
  `filePath` varchar(300) NOT NULL,
  `fileRealName` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`fileId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `relatorioupload`
--

INSERT INTO `relatorioupload` (`fileId`, `fileNumPed`, `filePath`, `fileRealName`) VALUES
(1, '3093', 'files/9850-NFAe Vanessa - Outubro.pdf', '9850-NFAe Vanessa - Outubro.pdf'),
(2, '3095', 'files/7398-Relatório de atividades -01_10_2021-31_10_2021.pdf', '7398-Relatório de atividades -01_10_2021-31_10_2021.pdf');

-- --------------------------------------------------------

--
-- Estrutura da tabela `representantes`
--

DROP TABLE IF EXISTS `representantes`;
CREATE TABLE IF NOT EXISTS `representantes` (
  `repID` int NOT NULL AUTO_INCREMENT,
  `repNome` varchar(100) NOT NULL,
  `repUid` varchar(100) NOT NULL,
  `repFone` varchar(20) NOT NULL,
  `repEmail` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `repUF` varchar(2) NOT NULL,
  `repNomeUF` varchar(100) NOT NULL,
  `repRegião` varchar(100) NOT NULL,
  PRIMARY KEY (`repID`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `representantes`
--

INSERT INTO `representantes` (`repID`, `repNome`, `repUid`, `repFone`, `repEmail`, `repUF`, `repNomeUF`, `repRegião`) VALUES
(3, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'AC', 'Acre', 'Norte'),
(4, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'AP', 'Amapá', 'Norte'),
(5, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'AM', 'Amazonas', 'Norte'),
(6, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'PA', 'Pará', 'Norte'),
(7, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'RO', 'Rondônia', 'Norte'),
(8, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'RR', 'Roraima', 'Norte'),
(54, 'Juliana Aguiar', 'julianaaguiar', '000000000', 'testejuliana@teste.com', 'TO', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(42, 'Neandro Barbosa', 'neandro', '0000000', 'neandro@teste.com', 'PE', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(43, 'Neandro Barbosa', 'neandro', '0000000', 'neandro@teste.com', 'RN', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(52, 'Juliana Aguiar', 'julianaaguiar', '000000000', 'testejuliana@teste.com', 'DF', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(21, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'MT', 'Mato Grosso', 'Centro-Oeste'),
(22, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'MS', 'Mato Grosso do Sul', 'Centro-Oeste'),
(23, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'ES', 'Espírito Santo', 'Sudeste'),
(25, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'RJ', 'Rio de Janeiro', 'Sudeste'),
(30, 'Luis Aragão', 'luisaragao', '(00) 0000-0000', 'luis@teste.com', 'SP', 'São Paulo', 'Sudeste'),
(38, 'Neandro Barbosa', 'neandro', '0000000', 'neandro@teste.com', 'BA', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(53, 'Juliana Aguiar', 'julianaaguiar', '000000000', 'testejuliana@teste.com', 'GO', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(37, 'Neandro Barbosa', 'neandro', '0000000', 'neandro@teste.com', 'AL', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(40, 'Neandro Barbosa', 'neandro', '0000000', 'neandro@teste.com', 'MA', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(39, 'Neandro Barbosa', 'neandro', '0000000', 'neandro@teste.com', 'CE', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(51, 'Saul Zapatta', 'saulzapatta', '000000000', 'testesaul@teste.com', 'IN', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(44, 'Neandro Barbosa', 'neandro', '0000000', 'neandro@teste.com', 'SE', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(45, 'Juliana Aguiar', 'julianaaguiar', '000000000', 'testejuliana@teste.com', 'PB', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(46, 'Juliana Aguiar', 'julianaaguiar', '000000000', 'testejuliana@teste.com', 'PI', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(47, 'Juliana Aguiar', 'julianaaguiar', '000000000', 'testejuliana@teste.com', 'MG', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(48, 'Juliana Aguiar', 'julianaaguiar', '000000000', 'testejuliana@teste.com', 'PR', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(49, 'Juliana Aguiar', 'julianaaguiar', '000000000', 'testejuliana@teste.com', 'RS', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\''),
(50, 'Juliana Aguiar', 'julianaaguiar', '000000000', 'testejuliana@teste.com', 'SC', '<br ', '><font size=\\\'1\\\'><table class=\\\'xdebug-error xe-notice\\\' dir=\\\'ltr\\\' border=\\\'1\\\' cellspacing=\\\'0\\\'');

-- --------------------------------------------------------

--
-- Estrutura da tabela `responsavelagenda`
--

DROP TABLE IF EXISTS `responsavelagenda`;
CREATE TABLE IF NOT EXISTS `responsavelagenda` (
  `responsavelagendaId` int NOT NULL AUTO_INCREMENT,
  `responsavelagendaNome` varchar(30) NOT NULL,
  PRIMARY KEY (`responsavelagendaId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `responsavelagenda`
--

INSERT INTO `responsavelagenda` (`responsavelagendaId`, `responsavelagendaNome`) VALUES
(2, 'Rander'),
(3, 'Matias'),
(4, 'Zille'),
(5, 'João'),
(6, 'Lucas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessaomidias`
--

DROP TABLE IF EXISTS `sessaomidias`;
CREATE TABLE IF NOT EXISTS `sessaomidias` (
  `ssmId` int NOT NULL AUTO_INCREMENT,
  `ssmAba` varchar(100) NOT NULL,
  `ssmNome` varchar(100) NOT NULL,
  `ssmIcon` text NOT NULL,
  PRIMARY KEY (`ssmId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `sessaomidias`
--

INSERT INTO `sessaomidias` (`ssmId`, `ssmAba`, `ssmNome`, `ssmIcon`) VALUES
(3, 'CMF', 'Apresentação', 'bi bi-file-slides'),
(13, 'COLUNA', 'Vídeos - Coluna', 'bi bi-camera-video'),
(4, 'CMF', 'Vídeos - ATM', 'bi bi-camera-video'),
(5, 'CMF', 'Vídeos - Smartmold', 'bi bi-camera-video'),
(6, 'CMF', 'Vídeos - Reconstruções', 'bi bi-camera-video'),
(7, 'CMF', 'Vídeos - Reconstrução atrófica', 'bi bi-camera-video'),
(8, 'ORTODONTIA', 'Apresentação', 'bi bi-file-slides'),
(9, 'ORTODONTIA', 'Vídeos - Ancorfix', 'bi bi-camera-video'),
(10, 'CRÂNIO', 'Apresentação', 'bi bi-file-slides'),
(11, 'CRÂNIO', 'Vídeos - Cranioplastia', 'bi bi-camera-video'),
(12, 'COLUNA', 'Apresentação', 'bi bi-file-slides'),
(14, 'ORTOPEDIA', 'Apresentação', 'bi bi-file-slides'),
(15, 'RADIOFREQUÊNCIA', 'Apresentação', 'bi bi-file-slides'),
(16, 'RADIOFREQUÊNCIA', 'Vídeos - Radiofrequência', 'bi bi-camera-video'),
(17, 'DESCARTÁVEIS', 'Apresentação', 'bi bi-file-slides');

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores`
--

DROP TABLE IF EXISTS `setores`;
CREATE TABLE IF NOT EXISTS `setores` (
  `setId` int NOT NULL AUTO_INCREMENT,
  `setNome` varchar(100) NOT NULL,
  PRIMARY KEY (`setId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `setores`
--

INSERT INTO `setores` (`setId`, `setNome`) VALUES
(1, 'Desenvolvimento'),
(4, 'Marketing'),
(3, 'Diretoria'),
(5, 'Educação Continuada'),
(6, 'Planejamento'),
(7, 'Presidência'),
(8, 'Produção'),
(9, 'RH'),
(10, 'TI'),
(11, 'Qualidade'),
(12, 'Financeiro'),
(13, 'Estoque/Logística'),
(14, 'Central de Negócios'),
(15, 'Serviços Gerais');

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusadiantamento`
--

DROP TABLE IF EXISTS `statusadiantamento`;
CREATE TABLE IF NOT EXISTS `statusadiantamento` (
  `stadiantId` int NOT NULL AUTO_INCREMENT,
  `stadiantNome` varchar(30) NOT NULL,
  PRIMARY KEY (`stadiantId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `statusadiantamento`
--

INSERT INTO `statusadiantamento` (`stadiantId`, `stadiantNome`) VALUES
(1, 'Em Análise'),
(2, 'Aprovado'),
(3, 'Reprovado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusagenda`
--

DROP TABLE IF EXISTS `statusagenda`;
CREATE TABLE IF NOT EXISTS `statusagenda` (
  `statusagendaId` int NOT NULL AUTO_INCREMENT,
  `statusagendaNome` varchar(30) NOT NULL,
  PRIMARY KEY (`statusagendaId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `statusagenda`
--

INSERT INTO `statusagenda` (`statusagendaId`, `statusagendaNome`) VALUES
(8, 'A Fazer'),
(10, 'Feito'),
(11, 'Não Compareceu');

-- --------------------------------------------------------

--
-- Estrutura da tabela `statuscomercial`
--

DROP TABLE IF EXISTS `statuscomercial`;
CREATE TABLE IF NOT EXISTS `statuscomercial` (
  `stcomId` int NOT NULL AUTO_INCREMENT,
  `stcomNome` varchar(20) NOT NULL,
  `stcomIndiceFluxo` int NOT NULL,
  PRIMARY KEY (`stcomId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `statuscomercial`
--

INSERT INTO `statuscomercial` (`stcomId`, `stcomNome`, `stcomIndiceFluxo`) VALUES
(2, 'PENDENTE', 1),
(3, 'EM ANÁLISE', 2),
(8, 'PROP. ENVIADA', 3),
(5, 'APROVADO', 4),
(6, 'PEDIDO', 5),
(9, 'CANCELADO', 6),
(10, 'JÁ COTADO', 7),
(11, 'NÃO COTAR', 8),
(12, 'AGUARD. INFOS ADICIO', 9),
(13, 'COTADO OUTRO DIST', 10),
(14, 'DPS', 11),
(15, 'AGUARD. QUALIFICAÇÃO', 12),
(16, 'CLIENTE QUALIFICADO', 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusfinanceiro`
--

DROP TABLE IF EXISTS `statusfinanceiro`;
CREATE TABLE IF NOT EXISTS `statusfinanceiro` (
  `stfinId` int NOT NULL AUTO_INCREMENT,
  `stFinName` varchar(50) NOT NULL,
  PRIMARY KEY (`stfinId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `statusfinanceiro`
--

INSERT INTO `statusfinanceiro` (`stfinId`, `stFinName`) VALUES
(1, 'Em Análise'),
(2, 'Aprovado'),
(3, 'Reprovado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusplanejamento`
--

DROP TABLE IF EXISTS `statusplanejamento`;
CREATE TABLE IF NOT EXISTS `statusplanejamento` (
  `stplanId` int NOT NULL AUTO_INCREMENT,
  `stplanNome` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stplanIndiceFluxo` int NOT NULL,
  PRIMARY KEY (`stplanId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `statusplanejamento`
--

INSERT INTO `statusplanejamento` (`stplanId`, `stplanNome`, `stplanIndiceFluxo`) VALUES
(1, 'ANALISAR', 1),
(2, 'TC APROVADA', 2),
(4, 'TC REPROVADA SEM ARQUIVO', 3),
(5, 'TC REPROVADA COTAR', 4),
(6, 'TC REPROVADA NÃO COTAR', 5),
(7, 'REENVIADA', 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusqualificacao`
--

DROP TABLE IF EXISTS `statusqualificacao`;
CREATE TABLE IF NOT EXISTS `statusqualificacao` (
  `stquaId` int NOT NULL AUTO_INCREMENT,
  `stquaNome` varchar(20) NOT NULL,
  `stquaIndiceFluxo` int NOT NULL,
  PRIMARY KEY (`stquaId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `statusqualificacao`
--

INSERT INTO `statusqualificacao` (`stquaId`, `stquaNome`, `stquaIndiceFluxo`) VALUES
(1, 'Enviado', 1),
(2, 'Analisar', 2),
(3, 'Qualificado', 3),
(4, 'Recusado', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocadastroexterno`
--

DROP TABLE IF EXISTS `tipocadastroexterno`;
CREATE TABLE IF NOT EXISTS `tipocadastroexterno` (
  `tpcadexId` int NOT NULL AUTO_INCREMENT,
  `tpcadexCodCadastro` varchar(10) NOT NULL,
  `tpcadexNome` varchar(30) NOT NULL,
  PRIMARY KEY (`tpcadexId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `tipocadastroexterno`
--

INSERT INTO `tipocadastroexterno` (`tpcadexId`, `tpcadexCodCadastro`, `tpcadexNome`) VALUES
(1, '3DTR', 'Doutor(a)'),
(5, '4DTB', 'Distribuidor(a)'),
(3, '8PAC', 'Paciente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocadastrointerno`
--

DROP TABLE IF EXISTS `tipocadastrointerno`;
CREATE TABLE IF NOT EXISTS `tipocadastrointerno` (
  `tpcadinId` int NOT NULL AUTO_INCREMENT,
  `tpcadinCodCadastro` varchar(10) NOT NULL,
  `tpcadinNome` varchar(20) NOT NULL,
  PRIMARY KEY (`tpcadinId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `tipocadastrointerno`
--

INSERT INTO `tipocadastrointerno` (`tpcadinId`, `tpcadinCodCadastro`, `tpcadinNome`) VALUES
(1, '1ADM', 'Administrador'),
(2, '2PLJ', 'Planejador(a)'),
(3, '5CLN', 'Clínica'),
(4, '7VDN', 'Representante'),
(5, '10CPMH', 'Comercial'),
(6, '11QUA', 'Qualidade'),
(7, '6RSD', 'Residente '),
(8, '9DTC', 'Dist. Comercial'),
(9, '12FIN', 'Financeiro'),
(10, '13MKT', 'Marketing'),
(11, '14ACOM', 'Adm Comercial'),
(13, '15DATA', 'Analista Dados');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `usersId` int NOT NULL AUTO_INCREMENT,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPerm` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `usersAprov` varchar(20) NOT NULL,
  `usersFone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `usersUf` varchar(11) DEFAULT NULL,
  `usersCrm` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `usersEspec` varchar(128) DEFAULT NULL,
  `usersEmpr` varchar(128) DEFAULT NULL,
  `usersNmResp` varchar(128) DEFAULT NULL,
  `usersCnpj` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `usersCel` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `usersCpf` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `usersEmailEmpresa` varchar(50) DEFAULT NULL,
  `usersUfDr` varchar(30) DEFAULT NULL,
  `usersPaisCidade` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`usersId`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPerm`, `usersPwd`, `usersAprov`, `usersFone`, `usersUf`, `usersCrm`, `usersEspec`, `usersEmpr`, `usersNmResp`, `usersCnpj`, `usersCel`, `usersCpf`, `usersEmailEmpresa`, `usersUfDr`, `usersPaisCidade`) VALUES
(2, 'Maria Rosário', 'maria@teste.com', 'mariarosario', '8PAC', '$2y$10$u3lq2QShkAINxkz1/26w9O8mWYUGVpyC/be1XMel0U.yr/cOA/0W6', 'APROV', '00000000000', 'SP', NULL, NULL, NULL, ' SAads', NULL, '55619836528', '052.581.961-43', NULL, 'SP', NULL),
(3, 'Jose Jotform', 'jose@teste.com', 'josejotform', '4DTB', '$2y$10$NeulE0IDjpSlzoH4WmzDA.cGTHWXpgXBCIFQBGnLHsaUo2pZpP.Ce', 'APROV', '00000000000', 'DF', ' ', ' ', 'Empresa Fake', ' ', 'as684d', '0000000000', ' ', 'email@fake.com', ' ', ' '),
(4, 'Fulano de Tal', 'fulano@teste.com', 'fulanodetal', '3DTR', '$2y$10$fOfKCc2nFFhT.p.5sC5wfuDtNAMBSUgsTdhOyUuNEzDeNs1WZ7oRu', 'APROV', '(61)5698-8754', 'AC', '12145', 'Implantodontia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Paciente ABC', 'paciente@teste.com', 'paciente', '8PAC', '$2y$10$odVtoNZS6z2idTRyxLOQ/.PcTwS2Pexta/U6RNwNuc/24uoY8gjR6', 'APROV', '(00) 0000-0000', 'DF', ' ', ' ', ' ', 'Doutor Fulano', ' ', '(00) 00000-0000', '000.000.000-00', ' ', 'BA', ' '),
(6, 'Usuário Outro', 'userusers@teste.com', 'user', '3DTR', '$2y$10$Kg2E7kdV2MQXTRoHlWK4Nu1Hy0Hi4RHDFbkba7RBnWNf9TkQD6GfO', 'APROV', '(00) 0000-0000', 'DF', '000-00-0000', 'Implantodontia', ' ', ' ', ' ', '(00) 00000-0000', ' 00.000.000-00', ' ', ' ', ' '),
(8, 'International User', 'international@teste.com', 'internacional', '9INT', '$2y$10$mN2PY7zOjosVB7mCevYfMus/j3s6O88KaGDZL63fPJk4i945TgQn2', 'APROV', '(00) 0000-0000', 'AC', ' ', ' ', 'OSTEOFIX', ' ', ' ', '(00) 00000-0000', ' ', ' ', ' ', ' Chile'),
(9, 'Daiane Soares', 'daiane@teste.com', 'daianesoares', '10CPMH', '$2y$10$KSJP3Ad7MAUTJlbW88qZ/O7p1rHayXpYimqYIAObKE9Scf1GLBbR.', 'APROV', '687646948979', 'DF', ' ', ' ', ' ', ' ', ' ', '6546548647', ' ', ' ', ' ', ' '),
(13, 'PLAN4', 'plan4@teste.com', 'plan4', '2PLJ', '$2y$10$7HfFNB4JTwdd5aDbdXmMm.9fkTR7/cjitVxYc4ha9kj32bV64wK4e', 'APROV', '00000000000', 'DF', ' ', ' ', ' ', ' ', ' ', '000000000', ' ', ' ', ' ', ' '),
(12, 'Usuário Comercial', 'comercialteste@teste.com', 'comercial', '10CPMH', '$2y$10$9s59o23UrL.03FikRXKlv.q0kP/4Z/GMMp5qsb.m/n3i4D5cT3SuW', 'APROV', '(00) 0000-0000', 'RJ', ' ', ' ', ' ', ' ', ' ', '(00) 00000-0000', ' ', ' ', ' ', ' '),
(14, 'Usuário Distribuidor', 'distribuidor@teste.com', 'distribuidor', '4DTB', '$2y$10$oQkuL0pslrOfpqnrh4HrTelfmTl75uqHvwgfF95I3Don3XPv8ruYq', 'APROV', '(00) 0000-0000', 'AL', ' ', ' ', 'Empresa', ' ', '00.000.000/0000-00', '(00) 00000-0000', ' ', 'empresa@teste.com', ' ', ' '),
(15, 'PLAN1', 'plan@teste.com', 'plan1', '2PLJ', '$2y$10$nQIfnJF5l/m4kBgzHpl9Ue.iuJpBNHQUtJ7NVC/z29k.iA1ugMzem', 'APROV', '(00) 0000-0000', 'DF', ' ', ' ', ' ', ' ', ' ', '(00) 00000-0000', ' ', ' ', ' ', ' '),
(16, 'PLAN2', 'plan2@teste.com', 'plan2', '2PLJ', '$2y$10$F77Q5M.GzyJnpbAGeqn/xuRamqVMPlWpogKh00yn3kpVrORGvIhwG', 'APROV', '000000000', 'DF', ' ', ' ', ' ', ' ', ' ', '0000000000', ' ', ' ', ' ', ' '),
(17, 'PLAN3', 'plan3@teste.com', 'plan3', '2PLJ', '$2y$10$a.mQqHJpjaAx6CEpsK6OJOQO2rbGByNsd8XIbdkF5QA1fDJAdhox2', 'APROV', '000000000', 'DF', ' ', ' ', ' ', ' ', ' ', '0000000000', ' ', ' ', ' ', ' '),
(23, 'Luis Aragão', 'vanessa.paiva@fixgrupo.com.br', 'luisaragao', '7VDN', '$2y$10$SPGSsZyy8lo3qA5Pqgx/QOWTifQUr4sp3heOa7isIfXOnpmip1xce', 'APROV', '(61) 98365-2810', 'DF', ' ', ' ', ' ', ' ', ' ', '(61) 98365-2810', ' ', ' ', ' ', ' '),
(60, 'Saul Zapatta', 'testesaul@teste.com', 'saulzapatta', '7VDN', '$2y$10$d.AAVczAG0JV6Em3kHHVpuDRhAEMec8zPVt74OPnXh8.tBjwzttom', 'APROV', '000000000', 'DF', NULL, NULL, NULL, NULL, NULL, '0000000000', NULL, NULL, NULL, NULL),
(29, 'Vanessa Paiva', 'vanespaiva@gmail.com', 'vanessa', '1ADM', '$2y$10$PLCa47OOiQRPzNPdHSB.BuwMwBufI8y0PUoiQdQD3JETCTtE2UyBC', 'APROV', '(61) 98365-2810', 'DF', ' ', ' ', ' ', ' ', ' ', '(61) 98365-2810', ' 052.581.961-43', ' ', ' ', ' '),
(28, 'Joao Heitor', 'joaoheitor@teste.com', 'joaoheitor', '3DTR', '$2y$10$h5nQnjHUQwQVVANj.ktZgOF8ZKlvDNpquGrL.nSTHDE9pMIuzzVAi', 'APROV', '(61) 98365-2810', 'DF', '4654', 'Implantodontia', ' ', ' ', ' ', '(61) 98365-2810', '', ' ', ' ', ' '),
(30, 'Qualidade', 'qualidade@teste.com', 'qualidade', '11QUA', '$2y$10$04LwfLXnFlHf5MyKgmDhP.QFcUmUDtkJKwEMRXHn.Ue.IbF4LeTxu', 'APROV', '00000000', 'DF', NULL, NULL, NULL, NULL, NULL, '0000000000000', NULL, NULL, NULL, NULL),
(31, 'Heitor Jorge', 'heitorjorge@teste.com', 'heitorjorge', '3DTR', '$2y$10$6/RD9GZipCtqCA7VLBdfa.xTABhSaSf7iFDF/ARKZ2FuFaFhe.mM6', 'APROV', '(63) 2323-2323', 'DF', 'CRO-DF-55454', 'Implantodontia', ' ', ' ', ' ', '(45) 4547478445', '454.454.545-54', ' ', ' ', ' '),
(38, 'UFUAgsdgsg ush gsi', 'fulano@teste.com', 'dfjdl', '9DTC', '$2y$10$nlYxkYe/lTgXwh.QmfOuheU2Kf3M2wOAEEU6VCL7Zt0cTFL0LH7Fq', 'APROV', '000000000', 'AM', ' ', ' ', 'Empresa', ' ', '00.000.000/0000-00', '000000000', ' ', ' ', ' ', ' '),
(37, 'Vanessa Teste', 'vanessa@teste.com.br', 'vanessateste', '9DTC', '$2y$10$/AjA9DYyiUU/MULkuNDMHuNe3ELiPYp4r0g1XICmtvb5P2SMiw2iy', 'APROV', '646464', 'AL', ' ', ' ', 'Empresa', ' ', '00.000.000/0000-00', '54654798476', ' ', ' empresa@teste.com', ' ', ' '),
(39, 'Osires JDkjk jkj', 'vanespaiva@gmail.com', 'osires', '4DTB', '$2y$10$9wG78DQZK4gDpBZX8PhsZu3qSW47w2iwCeKj1NAbejKN4TkzemWUe', 'APROV', '(56) 5656-5656', 'AC', ' ', ' ', 'OSIRES', ' ', '39.896.712/0001-76', '(65) 65656-6565', ' ', 'vanespaiva@gmail.com', ' ', ' '),
(40, 'Iris', 'iris@teste.com', 'iris', '9DTC', '$2y$10$SzZnwI1U05cOy3gnHcicxOPkHXKcG.ZTfXrrDQUl7Ypgo8Sfjmw7C', 'APROV', '544) 4646-4446', 'DF', '--', NULL, 'OSIRES', NULL, '39.896.712/0001-76', '(04) 65464-5465', NULL, 'iris@comercial.com', NULL, NULL),
(45, 'safsdfasdf sdfsdf', 'uygdfu@teste.com', 'fdys', '4DTB', '$2y$10$DBLaDQUOIV7kL4Sg4IkYxe5DBrhKURIQfmUJxriwa2ww76sz7Zvtm', 'AGRDD', '(45) 5212-2212', 'GO', '--', NULL, 'uYGUSGI', NULL, '45.454.545/4545-48', '(66) 56565-6565', NULL, 'uygdfu@teste.com', NULL, NULL),
(48, 'Antonia Felix', 'antonia@teste.com', 'antonia', '12FIN', '$2y$10$ExeJk8t3fxjdyMAy12/22ewnyw47uGCIZSsoj/gqO6v/Xs4UElTiS', 'APROV', '564664646', 'DF', NULL, NULL, NULL, NULL, NULL, '564664646', NULL, NULL, NULL, NULL),
(50, 'Alan Vieira', 'alan@teste.com', 'alan', '13MKT', '$2y$10$WG.cVxkhKabmSRsqx.hut.OKyDgo/fDj3DtIaHrSwvEvM9z6rmqA.', 'APROV', '4545454', 'DF', NULL, NULL, NULL, NULL, NULL, '4545454', NULL, NULL, NULL, NULL),
(51, 'fsdfsd', 'sdfsdf@dgdf.com', 'sdfsdf', '9DTC', '$2y$10$3sNAlBtcVSvCGmUrCvUbpO0EIrDwnMeOLRPAM6a.f0N/GPGwkBso2', 'AGRDD', '(46) 4646-4646', 'AC', '--', NULL, 'uYGUSGI', NULL, NULL, '(45454446456464', NULL, 'uygdfu@teste.com', NULL, NULL),
(52, 'Neandro Barbosa', 'neandro@teste.com', 'neandro', '7VDN', '$2y$10$7oBWqfzzxZIMDHhN1ZuEQeyU..T1Z0GNbl/hHZyqIrpM016Io24X.', 'APROV', '0000000', 'DF', NULL, NULL, NULL, NULL, NULL, '00000000', NULL, NULL, NULL, NULL),
(53, 'Doutor Doutor', 'doutordoutor@teste.com', 'doutordoutor', '3DTR', '$2y$10$KmAUMDDIfOWy4I0G/xf6/uM5Ev4MBB1HW0rHMk/ntX8lKg53DZEza', 'APROV', '(61) 98365-2810', 'DF', 'CRO-PB-2154', 'Bucomaxilo', NULL, NULL, NULL, '(61) 98365-2810', '454.545.454-54', NULL, NULL, NULL),
(54, 'Distribuidor Distribuidor', 'osteofixnovo@teste.com', 'osteofixnovo', '4DTB', '$2y$10$JZxlaQeOdBZbzoXh8XL3/eN1zWHVqFU6j6PA2APXhKvv9Wsnm/fGS', 'APROV', '(54) 5454-5454', 'DF', '--', NULL, 'Osteofix Bom', NULL, '24.679.678/0001-00', '(54) 54545-4545', NULL, 'osteofixnovo@teste.com', NULL, NULL),
(55, 'Outro Osteofix', 'oesteonew@teste.com', 'oesteonew', '9DTC', '$2y$10$Sye4mzw6ghlxz0Z2AizOmezlZezhUmB9F6mFBRb.bnhH43gACO0Te', 'APROV', '(54) 5454-5454', 'DF', '--', NULL, 'Osteofix Bom', NULL, '24.679.678/0001-00', '(21) 21545-4545', NULL, 'osteofixnovo@teste.com', NULL, NULL),
(56, 'Paciente Paciente', 'pacientepaciente@teste.com', 'pacientepaciente', '8PAC', '$2y$10$WzsI6BJwR60268pD7UaTAe7xrDoEztNYPeRVhIZLrAYwt8zP/HHRC', 'AGRDD', '654) 644654646', 'DF', '--', NULL, NULL, 'Iguiy iu iyui', NULL, '(64) 54654-6545', '212.121.212-12', NULL, 'DF', NULL),
(57, 'Adm Comercial', 'teste@admcomercial.com', 'liberauser', '14ACOM', '$2y$10$qkr/mpm1XqfqaT6/qyJdWOEziwUFxanUzr.lazBI8dP9JlEcr3Poq', 'APROV', '(61)30288883', 'DF', NULL, NULL, NULL, NULL, NULL, '(61) 99946-8880', NULL, NULL, NULL, NULL),
(58, 'Andre Martins', 'testeandre@teste.com', 'andreamartins', '7VDN', '$2y$10$ijQ.pLtFk66xNY3iPEuJausLBUgJvFc4JzI40kdUVfutb6vQ3HhH2', 'APROV', '000000000', 'DF', NULL, NULL, NULL, NULL, NULL, '0000000000', NULL, NULL, NULL, NULL),
(59, 'Juliana Aguiar', 'testejuliana@teste.com', 'julianaaguiar', '15DATA', '$2y$10$Fp0nrmx0JQ/.dhtlMOi8leKYtBtX4KsQEgiCheSDBxr3OW4JcQb.C', 'APROV', '000000000', 'DF', ' ', ' ', ' ', ' ', ' ', '0000000000', ' ', ' ', ' ', ' ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `visualizador`
--

DROP TABLE IF EXISTS `visualizador`;
CREATE TABLE IF NOT EXISTS `visualizador` (
  `visId` int NOT NULL AUTO_INCREMENT,
  `visNumPed` varchar(20) NOT NULL,
  `visUrl3D` varchar(100) NOT NULL,
  `visUser` varchar(20) NOT NULL,
  `visStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`visId`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `visualizador`
--

INSERT INTO `visualizador` (`visId`, `visNumPed`, `visUrl3D`, `visUser`, `visStatus`) VALUES
(25, '3093', 'https://p3d.in/5OGLO', 'vanessapaiva', 'BLOQUEADO'),
(27, '3099', '', '', 'BLOQUEADO'),
(26, '3095', '', '', 'BLOQUEADO'),
(23, '3094', 'https://p3d.in/lUSd8', 'vanessapaiva', 'BLOQUEADO'),
(28, '123', '', '', 'BLOQUEADO'),
(29, '123', '', '', 'BLOQUEADO'),
(30, '2550', '', '', 'BLOQUEADO'),
(31, '6598', '', '', 'BLOQUEADO'),
(32, '6598', '', '', 'BLOQUEADO'),
(33, '2550', '', '', 'BLOQUEADO'),
(34, '2550', '', '', 'BLOQUEADO'),
(35, '2550', '', '', 'BLOQUEADO'),
(36, '2550', '', '', 'BLOQUEADO'),
(37, '2550', '', '', 'BLOQUEADO'),
(38, '2550', '', '', 'BLOQUEADO'),
(39, '2550', '', '', 'BLOQUEADO'),
(40, '2550', '', '', 'BLOQUEADO'),
(41, '2550', '', '', 'BLOQUEADO'),
(42, '2550', '', '', 'BLOQUEADO'),
(43, '2550', '', '', 'BLOQUEADO'),
(44, '2550', '', '', 'BLOQUEADO'),
(45, '2550', '', '', 'BLOQUEADO'),
(46, '2550', '', '', 'BLOQUEADO'),
(47, '2550', '', '', 'BLOQUEADO'),
(48, '2550', '', '', 'BLOQUEADO'),
(49, '2550', '', '', 'BLOQUEADO'),
(50, '2550', '', '', 'BLOQUEADO'),
(51, '2550', '', '', 'BLOQUEADO'),
(52, '2550', '', '', 'BLOQUEADO'),
(53, '45463', '', '', 'BLOQUEADO'),
(54, '45463', '', '', 'BLOQUEADO'),
(55, '45463', '', '', 'BLOQUEADO'),
(56, '45463', '', '', 'BLOQUEADO'),
(57, '45463', '', '', 'BLOQUEADO'),
(58, '45463', '', '', 'BLOQUEADO'),
(59, '45463', '', '', 'BLOQUEADO'),
(60, '45463', '', '', 'BLOQUEADO'),
(61, '45463', '', '', 'BLOQUEADO'),
(62, '45463', '', '', 'BLOQUEADO'),
(63, '8754', '', '', 'BLOQUEADO'),
(64, '8754', '', '', 'BLOQUEADO'),
(65, '8754', '', '', 'BLOQUEADO'),
(66, '8754', '', '', 'BLOQUEADO'),
(67, '4857', '', '', 'BLOQUEADO'),
(68, '6589', '', '', 'BLOQUEADO'),
(69, '123', '', '', 'BLOQUEADO'),
(70, '1684', '', '', 'BLOQUEADO'),
(71, '9876', '', '', 'BLOQUEADO'),
(72, '1111', ' https://p3d.in/5OGLO', 'vanessa', 'BLOQUEADO'),
(73, '1237', '', '', 'BLOQUEADO'),
(74, '8638', '', '', 'BLOQUEADO'),
(75, '991', '', '', 'BLOQUEADO'),
(76, '6598', '', '', 'BLOQUEADO'),
(77, '89565', '', '', 'BLOQUEADO'),
(78, '65487', '', '', 'BLOQUEADO'),
(79, '65487', '', '', 'BLOQUEADO'),
(80, '65487', '', '', 'BLOQUEADO'),
(81, '65487', '', '', 'BLOQUEADO'),
(82, '1234', '', '', 'BLOQUEADO'),
(83, '9685', 'https://p3d.in/5OGLO', 'vanessa', 'BLOQUEADO'),
(84, '98656', '', '', 'BLOQUEADO'),
(85, '1122', '', '', 'BLOQUEADO'),
(86, '1122', '', '', 'BLOQUEADO'),
(87, '1123', '', '', 'BLOQUEADO'),
(88, '5254', '', '', 'BLOQUEADO'),
(89, '5253', '', '', 'BLOQUEADO'),
(90, '5252', '', '', 'BLOQUEADO'),
(91, '5251', '', '', 'BLOQUEADO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
