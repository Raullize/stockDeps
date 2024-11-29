CREATE DATABASE IF NOT EXISTS `stockDeps`;
USE `stockDeps`;

-- Tabela de categorias
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(255) NOT NULL,
    `descricao` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de produtos
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idCategoria` int(11) NOT NULL,
    `nome` varchar(255) NOT NULL,
    `descricao` text NOT NULL,
    `preco` float NOT NULL,
    `quantidade` int(11) NOT NULL DEFAULT 0,
    `imagem` varchar(255) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `fk_produtos_categorias_idx` (`idCategoria`),
    CONSTRAINT `fk_produtos_categorias` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de clientes
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(255) NOT NULL,
    `cpf` varchar(14) NOT NULL,
    `celular` varchar(14) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de fornecedores
DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE `fornecedores` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(255) NOT NULL,
    `cnpj` varchar(18) NOT NULL,
    `email` varchar(255) NOT NULL,
    `telefone` varchar(15) NOT NULL,
    `endereco` varchar(255) NOT NULL,
    `municipio` varchar(50) NOT NULL,
    `cep` varchar(9) NOT NULL,
    `uf` varchar(2) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de entradas
DROP TABLE IF EXISTS `entradas`;
CREATE TABLE `entradas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idFornecedor` int(11) NOT NULL,
    `idProdutos` int(11) NOT NULL,
    `quantidade` int(11) NOT NULL,
    `preco` float NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `fk_entradas_fornecedor_idx` (`idFornecedor`),
    CONSTRAINT `fk_entradas_fornecedor` FOREIGN KEY (`idFornecedor`) REFERENCES `fornecedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    KEY `fk_entradas_produtos_idx` (`idProdutos`),
    CONSTRAINT `fk_entradas_produtos` FOREIGN KEY (`idProdutos`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de saídas
DROP TABLE IF EXISTS `saidas`;
CREATE TABLE `saidas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idClientes` int(11) DEFAULT NULL,  -- Permite NULL
    `idProdutos` int(11) NOT NULL,
    `quantidade` int(11) NOT NULL,
    `preco` float NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `fk_saidas_clientes_idx` (`idClientes`),
    CONSTRAINT `fk_saidas_clientes` FOREIGN KEY (`idClientes`) REFERENCES `clientes` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,  -- Ajuste para permitir NULL
    KEY `fk_saidas_produtos_idx` (`idProdutos`),
    CONSTRAINT `fk_saidas_produtos` FOREIGN KEY (`idProdutos`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
