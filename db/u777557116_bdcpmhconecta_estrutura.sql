-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 14-Jan-2023 às 12:32
-- Versão do servidor: 5.7.36
-- versão do PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdcpmhconecta`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `abasmidias`
--

DROP TABLE IF EXISTS `abasmidias`;
CREATE TABLE IF NOT EXISTS `abasmidias` (
  `abmId` int(11) NOT NULL AUTO_INCREMENT,
  `abmNome` varchar(100) NOT NULL,
  PRIMARY KEY (`abmId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aceite`
--

DROP TABLE IF EXISTS `aceite`;
CREATE TABLE IF NOT EXISTS `aceite` (
  `aceiteId` int(11) NOT NULL AUTO_INCREMENT,
  `aceiteNumPed` varchar(20) NOT NULL,
  `aceiteDeAcordo` varchar(10) DEFAULT NULL,
  `aceiteObs` varchar(300) DEFAULT NULL,
  `aceiteStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`aceiteId`)
  -- UNIQUE KEY `aceiteNumPed` (`aceiteNumPed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aceiteproposta`
--

DROP TABLE IF EXISTS `aceiteproposta`;
CREATE TABLE IF NOT EXISTS `aceiteproposta` (
  `apropId` int(11) NOT NULL AUTO_INCREMENT,
  `apropNumProp` varchar(10) NOT NULL,
  `apropNomeUsuario` varchar(100) NOT NULL,
  `apropData` varchar(30) NOT NULL,
  `apropIp` varchar(20) NOT NULL,
  `apropCPFCNPJ` varchar(30) NOT NULL,
  `apropFormaPgto` varchar(50) NOT NULL,
  `apropCaminhoArquivo` text,
  `apropStatus` varchar(30) NOT NULL,
  `apropExtensionFile` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`apropId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `adiantamentos`
--

DROP TABLE IF EXISTS `adiantamentos`;
CREATE TABLE IF NOT EXISTS `adiantamentos` (
  `adiantId` int(11) NOT NULL AUTO_INCREMENT,
  `adiantUser` varchar(50) NOT NULL,
  `adiantNPed` varchar(10) NOT NULL,
  `adiantProduto` varchar(20) NOT NULL,
  `adiantDataSolicitacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `adiantStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`adiantId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda`
--

DROP TABLE IF EXISTS `agenda`;
CREATE TABLE IF NOT EXISTS `agenda` (
  `agdId` int(11) NOT NULL AUTO_INCREMENT,
  `agdUserCriador` varchar(100) DEFAULT NULL,
  `agdNumPedRef` varchar(10) NOT NULL,
  `agdNomeDr` varchar(30) NOT NULL,
  `agdNomPac` varchar(100) NOT NULL,
  `agdProd` varchar(30) NOT NULL,
  `agdStatus` varchar(20) NOT NULL,
  `agdStatusVideo` varchar(30) DEFAULT NULL,
  `agdTipo` varchar(30) DEFAULT NULL,
  `agdData` varchar(10) DEFAULT NULL,
  `agdHora` varchar(20) DEFAULT NULL,
  `agdCodHora` varchar(10) DEFAULT NULL,
  `agdResponsavel` varchar(30) DEFAULT NULL,
  `agdFeedback` varchar(30) DEFAULT NULL,
  `agdObs` text,
  PRIMARY KEY (`agdId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunoteste`
--

DROP TABLE IF EXISTS `alunoteste`;
CREATE TABLE IF NOT EXISTS `alunoteste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `tel` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivoproposta`
--

DROP TABLE IF EXISTS `arquivoproposta`;
CREATE TABLE IF NOT EXISTS `arquivoproposta` (
  `arqId` int(11) NOT NULL AUTO_INCREMENT,
  `arqNumProp` int(11) NOT NULL,
  `arqTC` varchar(10) NOT NULL,
  `arqLaudo` varchar(10) NOT NULL,
  `arqModelo` varchar(10) NOT NULL,
  `arqImagem` varchar(10) NOT NULL,
  PRIMARY KEY (`arqId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bancosdadosnotificacoes`
--

DROP TABLE IF EXISTS `bancosdadosnotificacoes`;
CREATE TABLE IF NOT EXISTS `bancosdadosnotificacoes` (
  `bdntfId` int(11) NOT NULL AUTO_INCREMENT,
  `bdntfNome` varchar(200) NOT NULL,
  PRIMARY KEY (`bdntfId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `caddoutoresdistribuidores`
--

DROP TABLE IF EXISTS `caddoutoresdistribuidores`;
CREATE TABLE IF NOT EXISTS `caddoutoresdistribuidores` (
  `drId` int(11) NOT NULL AUTO_INCREMENT,
  `drUidDr` varchar(200) NOT NULL,
  `drUidDistribuidor` varchar(200) NOT NULL,
  `drDistCNPJ` varchar(30) NOT NULL,
  PRIMARY KEY (`drId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chartcolor`
--

DROP TABLE IF EXISTS `chartcolor`;
CREATE TABLE IF NOT EXISTS `chartcolor` (
  `chartId` int(11) NOT NULL AUTO_INCREMENT,
  `chartColor` varchar(7) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`chartId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentariosforum`
--

DROP TABLE IF EXISTS `comentariosforum`;
CREATE TABLE IF NOT EXISTS `comentariosforum` (
  `faqcomentId` int(11) NOT NULL AUTO_INCREMENT,
  `faqcomentUserCriador` varchar(200) NOT NULL,
  `faqcomentFaqId` varchar(100) NOT NULL,
  `faqcomentDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `faqcomentTexto` text NOT NULL,
  PRIMARY KEY (`faqcomentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentariosproposta`
--

DROP TABLE IF EXISTS `comentariosproposta`;
CREATE TABLE IF NOT EXISTS `comentariosproposta` (
  `comentVisId` int(11) NOT NULL AUTO_INCREMENT,
  `comentVisUser` varchar(20) NOT NULL,
  `comentVisNumProp` varchar(20) NOT NULL,
  `comentVisText` varchar(300) NOT NULL,
  `comentVisHorario` varchar(20) NOT NULL,
  `comentVisTipoUser` varchar(200) NOT NULL,
  PRIMARY KEY (`comentVisId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentariosvisualizador`
--

DROP TABLE IF EXISTS `comentariosvisualizador`;
CREATE TABLE IF NOT EXISTS `comentariosvisualizador` (
  `comentVisId` int(11) NOT NULL AUTO_INCREMENT,
  `comentVisUser` varchar(20) NOT NULL,
  `comentVisNumPed` varchar(20) NOT NULL,
  `comentVisText` varchar(300) NOT NULL,
  `comentVisHorario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comentVisId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conselhosprofissionais`
--

DROP TABLE IF EXISTS `conselhosprofissionais`;
CREATE TABLE IF NOT EXISTS `conselhosprofissionais` (
  `consId` int(11) NOT NULL AUTO_INCREMENT,
  `consNomeExtenso` varchar(100) NOT NULL,
  `consAbreviacao` varchar(5) NOT NULL,
  PRIMARY KEY (`consId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `convenios`
--

DROP TABLE IF EXISTS `convenios`;
CREATE TABLE IF NOT EXISTS `convenios` (
  `convId` int(11) NOT NULL AUTO_INCREMENT,
  `convName` varchar(200) NOT NULL,
  PRIMARY KEY (`convId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `especialidades`
--

DROP TABLE IF EXISTS `especialidades`;
CREATE TABLE IF NOT EXISTS `especialidades` (
  `especId` int(11) NOT NULL AUTO_INCREMENT,
  `especNome` varchar(100) NOT NULL,
  PRIMARY KEY (`especId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE IF NOT EXISTS `estados` (
  `ufId` int(11) NOT NULL AUTO_INCREMENT,
  `ufNomeExtenso` varchar(100) NOT NULL,
  `ufAbreviacao` varchar(2) NOT NULL,
  `ufRegiao` varchar(100) NOT NULL,
  PRIMARY KEY (`ufId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapasanaliseplanejamento`
--

DROP TABLE IF EXISTS `etapasanaliseplanejamento`;
CREATE TABLE IF NOT EXISTS `etapasanaliseplanejamento` (
  `etpId` int(11) NOT NULL AUTO_INCREMENT,
  `etpNumProp` int(11) NOT NULL,
  `etpFluxo` int(11) NOT NULL,
  PRIMARY KEY (`etpId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fasesproduto`
--

DROP TABLE IF EXISTS `fasesproduto`;
CREATE TABLE IF NOT EXISTS `fasesproduto` (
  `faseId` int(11) NOT NULL AUTO_INCREMENT,
  `faseOrdem` int(11) NOT NULL,
  `faseNome` varchar(100) NOT NULL,
  `faseTempo` int(11) NOT NULL,
  PRIMARY KEY (`faseId`),
  UNIQUE KEY `faseOrdem` (`faseOrdem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedbackaceite`
--

DROP TABLE IF EXISTS `feedbackaceite`;
CREATE TABLE IF NOT EXISTS `feedbackaceite` (
  `fdaceiteId` int(11) NOT NULL AUTO_INCREMENT,
  `fdaceiteNumPed` varchar(20) NOT NULL,
  `fdaceiteResposta` varchar(15) DEFAULT NULL,
  `fdaceiteComentario` varchar(300) DEFAULT NULL,
  `fdaceiteStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`fdaceiteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedbackagenda`
--

DROP TABLE IF EXISTS `feedbackagenda`;
CREATE TABLE IF NOT EXISTS `feedbackagenda` (
  `feedbackagendaId` int(11) NOT NULL AUTO_INCREMENT,
  `feedbackagendaNome` varchar(30) NOT NULL,
  PRIMARY KEY (`feedbackagendaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `filedownload`
--

DROP TABLE IF EXISTS `filedownload`;
CREATE TABLE IF NOT EXISTS `filedownload` (
  `fileId` int(11) NOT NULL AUTO_INCREMENT,
  `fileNumPropRef` int(11) NOT NULL,
  `fileUuid` text,
  `fileRealName` text,
  `fileIsStored` varchar(5) DEFAULT NULL,
  `fileSize` varchar(200) DEFAULT NULL,
  `fileCdnUrl` varchar(200) DEFAULT NULL,
  `fileDownloadAtivo` int(11) DEFAULT NULL,
  PRIMARY KEY (`fileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `filedownloadlaudo`
--

DROP TABLE IF EXISTS `filedownloadlaudo`;
CREATE TABLE IF NOT EXISTS `filedownloadlaudo` (
  `fileId` int(11) NOT NULL AUTO_INCREMENT,
  `fileNumPropRef` int(11) NOT NULL,
  `fileUuid` text NOT NULL,
  `fileRealName` text NOT NULL,
  `fileIsStored` varchar(5) NOT NULL,
  `fileSize` varchar(200) NOT NULL,
  `fileCdnUrl` text NOT NULL,
  `fileDownloadAtivo` int(11) NOT NULL,
  PRIMARY KEY (`fileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `filefinanceiro`
--

DROP TABLE IF EXISTS `filefinanceiro`;
CREATE TABLE IF NOT EXISTS `filefinanceiro` (
  `filefinId` int(11) NOT NULL AUTO_INCREMENT,
  `filefinRealName` text NOT NULL,
  `filefinPropId` varchar(20) NOT NULL,
  `filefinPath` text NOT NULL,
  PRIMARY KEY (`filefinId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formapagamento`
--

DROP TABLE IF EXISTS `formapagamento`;
CREATE TABLE IF NOT EXISTS `formapagamento` (
  `pgtoId` int(11) NOT NULL AUTO_INCREMENT,
  `pgtoNome` varchar(100) NOT NULL,
  PRIMARY KEY (`pgtoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `forum`
--

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `faqId` int(11) NOT NULL AUTO_INCREMENT,
  `faqUserCriador` varchar(200) NOT NULL,
  `faqTipoConta` varchar(200) NOT NULL,
  `faqSetor` varchar(200) NOT NULL,
  `faqDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `faqStatus` varchar(15) NOT NULL,
  `faqAssuntoPrincipal` varchar(300) NOT NULL,
  `faqTipoTexto` varchar(10) NOT NULL,
  `faqTexto` text NOT NULL,
  PRIMARY KEY (`faqId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horasdisponiveisagenda`
--

DROP TABLE IF EXISTS `horasdisponiveisagenda`;
CREATE TABLE IF NOT EXISTS `horasdisponiveisagenda` (
  `hrId` int(11) NOT NULL AUTO_INCREMENT,
  `hrCodigo` varchar(10) NOT NULL,
  `hrHorario` varchar(20) NOT NULL,
  PRIMARY KEY (`hrId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagemreferenciaplana`
--

DROP TABLE IF EXISTS `imagemreferenciaplana`;
CREATE TABLE IF NOT EXISTS `imagemreferenciaplana` (
  `imgplanId` int(11) NOT NULL AUTO_INCREMENT,
  `imgplanNomeImg` text,
  `imgplanPathImg` text,
  `imgplanNumProp` int(11) NOT NULL,
  PRIMARY KEY (`imgplanId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagemreferenciaplanb`
--

DROP TABLE IF EXISTS `imagemreferenciaplanb`;
CREATE TABLE IF NOT EXISTS `imagemreferenciaplanb` (
  `imgplanId` int(11) NOT NULL AUTO_INCREMENT,
  `imgplanNomeImg` text,
  `imgplanPathImg` text,
  `imgplanNumProp` int(11) NOT NULL,
  PRIMARY KEY (`imgplanId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagensprodutos`
--

DROP TABLE IF EXISTS `imagensprodutos`;
CREATE TABLE IF NOT EXISTS `imagensprodutos` (
  `imgprodId` int(11) NOT NULL AUTO_INCREMENT,
  `imgprodCategoria` varchar(20) NOT NULL,
  `imgprodNome` varchar(30) NOT NULL,
  `imgprodCodCallisto` varchar(20) NOT NULL,
  `imgprodLink` varchar(600) NOT NULL,
  `imgprodDataEnvio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`imgprodId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itensproposta`
--

DROP TABLE IF EXISTS `itensproposta`;
CREATE TABLE IF NOT EXISTS `itensproposta` (
  `itemId` int(11) NOT NULL AUTO_INCREMENT,
  `itemCdg` varchar(128) NOT NULL,
  `itemNome` varchar(200) NOT NULL,
  `itemAnvisa` varchar(200) NOT NULL,
  `itemQtd` int(11) NOT NULL,
  `itemValor` float NOT NULL,
  `itemValorBase` float NOT NULL,
  `itemPropRef` varchar(128) NOT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `laudostomograficos`
--

DROP TABLE IF EXISTS `laudostomograficos`;
CREATE TABLE IF NOT EXISTS `laudostomograficos` (
  `laudoId` int(11) NOT NULL AUTO_INCREMENT,
  `laudoNumProp` int(11) NOT NULL,
  `laudoStatus` varchar(100) NOT NULL,
  `laudoDataDocumento` varchar(10) NOT NULL,
  `laudoDataExame` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`laudoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logdeatividades`
--

DROP TABLE IF EXISTS `logdeatividades`;
CREATE TABLE IF NOT EXISTS `logdeatividades` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `logDtHora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logUser` varchar(200) NOT NULL,
  `logAtividade` text NOT NULL,
  PRIMARY KEY (`logId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logstatus`
--

DROP TABLE IF EXISTS `logstatus`;
CREATE TABLE IF NOT EXISTS `logstatus` (
  `logstId` int(11) NOT NULL AUTO_INCREMENT,
  `logstPropRef` int(11) NOT NULL,
  `logstData` varchar(30) NOT NULL,
  `logstUsuario` varchar(200) NOT NULL,
  `logstDescricao` text NOT NULL,
  `logstOrigem` varchar(50) NOT NULL,
  PRIMARY KEY (`logstId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `materiaismidias`
--

DROP TABLE IF EXISTS `materiaismidias`;
CREATE TABLE IF NOT EXISTS `materiaismidias` (
  `mtmId` int(11) NOT NULL AUTO_INCREMENT,
  `mtmAba` varchar(100) NOT NULL,
  `mtmSessao` varchar(100) NOT NULL,
  `mtmTitulo` varchar(100) NOT NULL,
  `mtmDescricao` varchar(100) NOT NULL,
  `mtmLink` text NOT NULL,
  `mtmDtCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mtmDtAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mtmRelevancia` int(11) NOT NULL,
  PRIMARY KEY (`mtmId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesesano`
--

DROP TABLE IF EXISTS `mesesano`;
CREATE TABLE IF NOT EXISTS `mesesano` (
  `mesId` int(11) NOT NULL AUTO_INCREMENT,
  `mesNum` int(11) NOT NULL,
  `mesNome` varchar(20) NOT NULL,
  `mesAbrv` varchar(3) NOT NULL,
  PRIMARY KEY (`mesId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoesexternasemail`
--

DROP TABLE IF EXISTS `notificacoesexternasemail`;
CREATE TABLE IF NOT EXISTS `notificacoesexternasemail` (
  `ntfEmailId` int(11) NOT NULL AUTO_INCREMENT,
  `ntfEmailBDRef` varchar(100) NOT NULL,
  `ntfEmailNomeTemplate` varchar(200) NOT NULL,
  `ntfEmailAssuntoEmail` varchar(200) NOT NULL,
  `ntfEmailTexto` text NOT NULL,
  `ntfEmailDestinatario` varchar(100) NOT NULL,
  `ntfEmailDtCriacao` varchar(100) NOT NULL,
  `ntfEmailUserCriacao` varchar(100) NOT NULL,
  `ntfEmailDtUpdate` varchar(100) DEFAULT NULL,
  `ntfEmailUserUpdate` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ntfEmailId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacoesexternaswpp`
--

DROP TABLE IF EXISTS `notificacoesexternaswpp`;
CREATE TABLE IF NOT EXISTS `notificacoesexternaswpp` (
  `ntfWppId` int(11) NOT NULL AUTO_INCREMENT,
  `ntfWppBDRef` varchar(100) NOT NULL,
  `ntfWppNomeTemplate` varchar(200) NOT NULL,
  `ntfWppTitulo` varchar(200) NOT NULL,
  `ntfWppTexto` text NOT NULL,
  `ntfWppDestinatario` varchar(100) NOT NULL,
  `ntfWppDtCriacao` varchar(100) NOT NULL,
  `ntfWppUserCriacao` varchar(100) NOT NULL,
  `ntfWppDtUpdate` varchar(100) DEFAULT NULL,
  `ntfWppUserUpdate` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ntfWppId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `pedId` int(11) NOT NULL AUTO_INCREMENT,
  `pedNumPedido` varchar(20) NOT NULL,
  `pedPropRef` varchar(20) NOT NULL,
  `pedUserCriador` varchar(50) NOT NULL,
  `pedRep` varchar(50) NOT NULL,
  `pedSharedUsers` text,
  `pedNomeDr` varchar(100) NOT NULL,
  `pedNomePac` varchar(100) NOT NULL,
  `pedCrmDr` varchar(20) NOT NULL,
  `pedProduto` text NOT NULL,
  `pedTipoProduto` varchar(20) NOT NULL,
  `pedStatus` varchar(20) NOT NULL,
  `pedPosicaoFluxo` int(11) NOT NULL,
  `pedDtCriacaoPed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pedAbaAgenda` varchar(8) NOT NULL,
  `pedAbaVisualizacao` varchar(8) NOT NULL,
  `pedAbaAceite` varchar(8) NOT NULL,
  `pedAbaRelatorio` varchar(8) NOT NULL,
  `pedAbaDocumentos` varchar(8) NOT NULL,
  `pedAndamento` varchar(10) NOT NULL,
  `pedCpfCnpj` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`pedId`),
  UNIQUE KEY `pedNumPedido` (`pedNumPedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `placeholdersnotificacao`
--

DROP TABLE IF EXISTS `placeholdersnotificacao`;
CREATE TABLE IF NOT EXISTS `placeholdersnotificacao` (
  `plntfId` int(11) NOT NULL AUTO_INCREMENT,
  `plntfBd` varchar(200) NOT NULL,
  `plntfNome` varchar(200) NOT NULL,
  `plntfVariavel` varchar(200) NOT NULL,
  PRIMARY KEY (`plntfId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `planosfinanceiros`
--

DROP TABLE IF EXISTS `planosfinanceiros`;
CREATE TABLE IF NOT EXISTS `planosfinanceiros` (
  `finId` int(11) NOT NULL AUTO_INCREMENT,
  `finModalidade` varchar(256) NOT NULL,
  PRIMARY KEY (`finId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prazoproposta`
--

DROP TABLE IF EXISTS `prazoproposta`;
CREATE TABLE IF NOT EXISTS `prazoproposta` (
  `przId` int(11) NOT NULL AUTO_INCREMENT,
  `przNumProposta` varchar(100) NOT NULL,
  `przData` date NOT NULL,
  `przStatus` varchar(100) NOT NULL,
  PRIMARY KEY (`przId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtoagenda`
--

DROP TABLE IF EXISTS `produtoagenda`;
CREATE TABLE IF NOT EXISTS `produtoagenda` (
  `produtoagendaId` int(11) NOT NULL AUTO_INCREMENT,
  `produtoagendaNome` varchar(30) NOT NULL,
  PRIMARY KEY (`produtoagendaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `prodId` int(11) NOT NULL AUTO_INCREMENT,
  `prodCodCallisto` varchar(48) NOT NULL,
  `prodDescricao` varchar(128) NOT NULL,
  `prodAnvisa` varchar(128) NOT NULL,
  `prodPreco` varchar(128) NOT NULL,
  `prodParafuso` int(11) NOT NULL,
  `prodKitDr` text NOT NULL,
  `prodTxtCotacao` text NOT NULL,
  `prodTxtAcompanha` text NOT NULL,
  `prodCodPropPadrao` varchar(48) NOT NULL,
  `prodCategoria` varchar(48) NOT NULL,
  `prodImposto` int(11) DEFAULT NULL,
  `prodNCM` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`prodId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtosproposta`
--

DROP TABLE IF EXISTS `produtosproposta`;
CREATE TABLE IF NOT EXISTS `produtosproposta` (
  `prodpropId` int(11) NOT NULL AUTO_INCREMENT,
  `prodpropNome` varchar(100) NOT NULL,
  PRIMARY KEY (`prodpropId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `propostas`
--

DROP TABLE IF EXISTS `propostas`;
CREATE TABLE IF NOT EXISTS `propostas` (
  `propId` int(11) NOT NULL AUTO_INCREMENT,
  `propUserCriacao` varchar(128) NOT NULL,
  `propEmailCriacao` varchar(128) NOT NULL,
  `propDataCriacao` varchar(30) NOT NULL,
  `propData` date DEFAULT NULL,
  `propHora` time DEFAULT NULL,
  `propStatus` varchar(100) NOT NULL,
  `propStatusTC` varchar(100) DEFAULT NULL,
  `propEmpresa` varchar(200) DEFAULT NULL,
  `propNomeDr` varchar(128) NOT NULL,
  `propNConselhoDr` varchar(20) NOT NULL,
  `propEmailDr` varchar(128) NOT NULL,
  `propTelefoneDr` varchar(20) NOT NULL,
  `propNomePac` varchar(128) NOT NULL,
  `propConvenio` varchar(128) NOT NULL,
  `propEmailEnvio` varchar(128) NOT NULL,
  `propTipoProd` varchar(128) NOT NULL,
  `propLongListaItens` text NOT NULL,
  `propListaItens` varchar(100) NOT NULL,
  `propEspessura` varchar(100) DEFAULT NULL,
  `propUf` varchar(200) NOT NULL,
  `propRepresentante` varchar(200) NOT NULL,
  `propValidade` varchar(200) NOT NULL,
  `propValorSomaItens` float DEFAULT NULL,
  `propValorSomaTotal` float DEFAULT NULL,
  `propDesconto` int(11) DEFAULT NULL,
  `propoValorDesconto` float NOT NULL,
  `propValorPosDesconto` float DEFAULT NULL,
  `propListaItensBD` varchar(200) DEFAULT NULL,
  `propTxtReprov` varchar(200) DEFAULT NULL,
  `propProjetistas` varchar(30) DEFAULT NULL,
  `propPedido` varchar(10) DEFAULT NULL,
  `propTaxaExtra` varchar(10) NOT NULL,
  `propPlanoVenda` varchar(300) DEFAULT NULL,
  `propBdDtCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `propDrUid` varchar(200) DEFAULT NULL,
  `propCnpjCpf` varchar(30) NOT NULL,
  `propTxtLaudo` text,
  `propNomeEnvio` varchar(200) DEFAULT NULL,
  `propTelEnvio` varchar(15) DEFAULT NULL,
  `propTxtComercial` text,
  `propTxtRepresentante` text,
  PRIMARY KEY (`propId`)
  -- KEY `propUserCriacao` (`propUserCriacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoidr`
--

DROP TABLE IF EXISTS `qualianexoidr`;
CREATE TABLE IF NOT EXISTS `qualianexoidr` (
  `xidrId` int(11) NOT NULL AUTO_INCREMENT,
  `xidrIdProjeto` varchar(30) NOT NULL,
  `xidrUserCriador` varchar(30) NOT NULL,
  `xidrTipoContaCriador` varchar(30) NOT NULL,
  `xidrDataCriacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xidrDataUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `xidrStatusEnvio` varchar(30) NOT NULL,
  `xidrStatusQualidade` varchar(30) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoii`
--

DROP TABLE IF EXISTS `qualianexoii`;
CREATE TABLE IF NOT EXISTS `qualianexoii` (
  `xiiId` int(11) NOT NULL AUTO_INCREMENT,
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
  `xiiEspecialidade` varchar(30) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoiiidr`
--

DROP TABLE IF EXISTS `qualianexoiiidr`;
CREATE TABLE IF NOT EXISTS `qualianexoiiidr` (
  `xiiidrId` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoiiipac`
--

DROP TABLE IF EXISTS `qualianexoiiipac`;
CREATE TABLE IF NOT EXISTS `qualianexoiiipac` (
  `xiiipacId` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualianexoipac`
--

DROP TABLE IF EXISTS `qualianexoipac`;
CREATE TABLE IF NOT EXISTS `qualianexoipac` (
  `xipacId` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `qualificacaocliente`
--

DROP TABLE IF EXISTS `qualificacaocliente`;
CREATE TABLE IF NOT EXISTS `qualificacaocliente` (
  `qualiId` int(11) NOT NULL AUTO_INCREMENT,
  `qualiDtChegada` text NOT NULL,
  `qualiUsuario` text NOT NULL,
  `qualiStatus` text NOT NULL,
  `qualiResultado` int(11) NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registroenvioqualificacao`
--

DROP TABLE IF EXISTS `registroenvioqualificacao`;
CREATE TABLE IF NOT EXISTS `registroenvioqualificacao` (
  `regEnvId` int(11) NOT NULL AUTO_INCREMENT,
  `regEnvUsuario` text NOT NULL,
  `regEnvData` text NOT NULL,
  PRIMARY KEY (`regEnvId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registropreenchimentoqualificacao`
--

DROP TABLE IF EXISTS `registropreenchimentoqualificacao`;
CREATE TABLE IF NOT EXISTS `registropreenchimentoqualificacao` (
  `regPreId` int(11) NOT NULL AUTO_INCREMENT,
  `regPreUsuario` text NOT NULL,
  `regPreData` text NOT NULL,
  `regPreIdForm` text NOT NULL,
  `regPreNome` text NOT NULL,
  PRIMARY KEY (`regPreId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registrostatusproposta`
--

DROP TABLE IF EXISTS `registrostatusproposta`;
CREATE TABLE IF NOT EXISTS `registrostatusproposta` (
  `regId` int(11) NOT NULL AUTO_INCREMENT,
  `regStatus` varchar(20) NOT NULL,
  `regNumProp` int(11) NOT NULL,
  `regUser` varchar(200) NOT NULL,
  `regDate` datetime NOT NULL,
  PRIMARY KEY (`regId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorios`
--

DROP TABLE IF EXISTS `relatorios`;
CREATE TABLE IF NOT EXISTS `relatorios` (
  `relId` int(11) NOT NULL AUTO_INCREMENT,
  `relNumPedRef` varchar(20) NOT NULL,
  `relPath` varchar(300) NOT NULL,
  `relFileName` varchar(100) NOT NULL,
  `relUserCriacao` varchar(30) NOT NULL,
  `relDataEnvio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `relDataUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `relStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`relId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorioupload`
--

DROP TABLE IF EXISTS `relatorioupload`;
CREATE TABLE IF NOT EXISTS `relatorioupload` (
  `fileId` int(11) NOT NULL AUTO_INCREMENT,
  `fileNumPed` varchar(30) NOT NULL,
  `filePath` varchar(300) NOT NULL,
  `fileRealName` varchar(300) NOT NULL,
  PRIMARY KEY (`fileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `representantes`
--

DROP TABLE IF EXISTS `representantes`;
CREATE TABLE IF NOT EXISTS `representantes` (
  `repID` int(11) NOT NULL AUTO_INCREMENT,
  `repNome` varchar(100) NOT NULL,
  `repUid` varchar(100) NOT NULL,
  `repFone` varchar(20) NOT NULL,
  `repEmail` varchar(100) NOT NULL,
  `repUF` varchar(2) NOT NULL,
  `repNomeUF` varchar(100) NOT NULL,
  `repRegiao` varchar(100) NOT NULL,
  PRIMARY KEY (`repID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `responsavelagenda`
--

DROP TABLE IF EXISTS `responsavelagenda`;
CREATE TABLE IF NOT EXISTS `responsavelagenda` (
  `responsavelagendaId` int(11) NOT NULL AUTO_INCREMENT,
  `responsavelagendaNome` varchar(30) NOT NULL,
  PRIMARY KEY (`responsavelagendaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessaomidias`
--

DROP TABLE IF EXISTS `sessaomidias`;
CREATE TABLE IF NOT EXISTS `sessaomidias` (
  `ssmId` int(11) NOT NULL AUTO_INCREMENT,
  `ssmAba` varchar(100) NOT NULL,
  `ssmNome` varchar(100) NOT NULL,
  `ssmIcon` text NOT NULL,
  PRIMARY KEY (`ssmId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `setores`
--

DROP TABLE IF EXISTS `setores`;
CREATE TABLE IF NOT EXISTS `setores` (
  `setId` int(11) NOT NULL AUTO_INCREMENT,
  `setNome` varchar(100) NOT NULL,
  PRIMARY KEY (`setId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacaotrocaproduto`
--

DROP TABLE IF EXISTS `solicitacaotrocaproduto`;
CREATE TABLE IF NOT EXISTS `solicitacaotrocaproduto` (
  `solId` int(11) NOT NULL AUTO_INCREMENT,
  `solProd` varchar(100) CHARACTER SET utf8 NOT NULL,
  `solNumProp` int(11) NOT NULL,
  `solStatus` varchar(100) NOT NULL,
  `solUserSolicitante` varchar(100) NOT NULL,
  PRIMARY KEY (`solId`),
  UNIQUE KEY `solNumProp` (`solNumProp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusadiantamento`
--

DROP TABLE IF EXISTS `statusadiantamento`;
CREATE TABLE IF NOT EXISTS `statusadiantamento` (
  `stadiantId` int(11) NOT NULL AUTO_INCREMENT,
  `stadiantNome` varchar(30) NOT NULL,
  PRIMARY KEY (`stadiantId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusagenda`
--

DROP TABLE IF EXISTS `statusagenda`;
CREATE TABLE IF NOT EXISTS `statusagenda` (
  `statusagendaId` int(11) NOT NULL AUTO_INCREMENT,
  `statusagendaNome` varchar(30) NOT NULL,
  PRIMARY KEY (`statusagendaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statuscomercial`
--

DROP TABLE IF EXISTS `statuscomercial`;
CREATE TABLE IF NOT EXISTS `statuscomercial` (
  `stcomId` int(11) NOT NULL AUTO_INCREMENT,
  `stcomNome` varchar(20) NOT NULL,
  `stcomIndiceFluxo` int(11) NOT NULL,
  PRIMARY KEY (`stcomId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusfinanceiro`
--

DROP TABLE IF EXISTS `statusfinanceiro`;
CREATE TABLE IF NOT EXISTS `statusfinanceiro` (
  `stfinId` int(11) NOT NULL AUTO_INCREMENT,
  `stFinName` varchar(50) NOT NULL,
  PRIMARY KEY (`stfinId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusplanejamento`
--

DROP TABLE IF EXISTS `statusplanejamento`;
CREATE TABLE IF NOT EXISTS `statusplanejamento` (
  `stplanId` int(11) NOT NULL AUTO_INCREMENT,
  `stplanNome` varchar(50) NOT NULL,
  `stplanIndiceFluxo` int(11) NOT NULL,
  PRIMARY KEY (`stplanId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusqualificacao`
--

DROP TABLE IF EXISTS `statusqualificacao`;
CREATE TABLE IF NOT EXISTS `statusqualificacao` (
  `stquaId` int(11) NOT NULL AUTO_INCREMENT,
  `stquaNome` varchar(20) NOT NULL,
  `stquaIndiceFluxo` int(11) NOT NULL,
  PRIMARY KEY (`stquaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocadastroexterno`
--

DROP TABLE IF EXISTS `tipocadastroexterno`;
CREATE TABLE IF NOT EXISTS `tipocadastroexterno` (
  `tpcadexId` int(11) NOT NULL AUTO_INCREMENT,
  `tpcadexCodCadastro` varchar(10) NOT NULL,
  `tpcadexNome` varchar(30) NOT NULL,
  PRIMARY KEY (`tpcadexId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipocadastrointerno`
--

DROP TABLE IF EXISTS `tipocadastrointerno`;
CREATE TABLE IF NOT EXISTS `tipocadastrointerno` (
  `tpcadinId` int(11) NOT NULL AUTO_INCREMENT,
  `tpcadinCodCadastro` varchar(10) NOT NULL,
  `tpcadinNome` varchar(20) NOT NULL,
  PRIMARY KEY (`tpcadinId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `usersId` int(11) NOT NULL AUTO_INCREMENT,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPerm` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `usersAprov` varchar(20) NOT NULL,
  `usersFone` varchar(20) DEFAULT NULL,
  `usersUf` varchar(11) DEFAULT NULL,
  `usersCrm` varchar(20) DEFAULT NULL,
  `usersEspec` varchar(128) DEFAULT NULL,
  `usersEmpr` varchar(128) DEFAULT NULL,
  `usersNmResp` varchar(128) DEFAULT NULL,
  `usersCnpj` varchar(35) DEFAULT NULL,
  `usersCel` varchar(20) DEFAULT NULL,
  `usersCpf` varchar(25) DEFAULT NULL,
  `usersEmailEmpresa` varchar(50) DEFAULT NULL,
  `usersUfDr` varchar(30) DEFAULT NULL,
  `usersPaisCidade` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`usersId`),
  UNIQUE KEY `usersEmail` (`usersEmail`),
  UNIQUE KEY `usersUid` (`usersUid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `visualizador`
--

DROP TABLE IF EXISTS `visualizador`;
CREATE TABLE IF NOT EXISTS `visualizador` (
  `visId` int(11) NOT NULL AUTO_INCREMENT,
  `visNumPed` varchar(20) NOT NULL,
  `visUrl3D` varchar(100) NOT NULL,
  `visUser` varchar(20) NOT NULL,
  `visStatus` varchar(20) NOT NULL,
  PRIMARY KEY (`visId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aceite`
--
-- ALTER TABLE `aceite`
--   ADD CONSTRAINT `aceiteNumPed` FOREIGN KEY (`aceiteNumPed`) REFERENCES `pedido` (`pedNumPedido`) ON DELETE NO ACTION;

--
-- Limitadores para a tabela `propostas`
--
-- ALTER TABLE `propostas`
--   ADD CONSTRAINT `propUserCriacao` FOREIGN KEY (`propUserCriacao`) REFERENCES `users` (`usersUid`) ON UPDATE CASCADE;
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE IF NOT EXISTS `midias_comentarios_plan` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idProduto INT,
    idComentario INT,
    nome VARCHAR(255),
    tipo VARCHAR(50),
    dados LONGBLOB,
    FOREIGN KEY (idProduto) REFERENCES comentariosproposta(comentVisNumProp),
    FOREIGN KEY (idComentario) REFERENCES comentariosproposta(comentVisId)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
