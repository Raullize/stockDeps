CREATE DATABASE IF NOT EXISTS `stock-deps` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `stock-deps`;

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

INSERT INTO `categorias` (`id`, `nome`, `descricao`) VALUES 
    (10, 'Lava Roupas', 'Produtos para lavagem de roupas e tecidos.'),
    (20, 'Lava Louças', 'Produtos para lavagem de louças e utensílios de cozinha.'),
    (30, 'Lava Carro', 'Produtos para lavagem de veículos.'),
    (40, 'Limpeza de Ambiente', 'Produtos para limpeza e aromatização de ambientes.'),
    (50, 'Outros', 'Outros produtos de limpeza.');

-- Tabela de produtos
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idCategoria` int(11) NOT NULL,
    `nome` varchar(255) NOT NULL,
    `preco` varchar(11) NOT NULL,
    `descricao` text NOT NULL,
    `quantidade` int(11) NOT NULL DEFAULT 0,
    `status` tinyint(1) NOT NULL DEFAULT 1,
    `imagem` varchar(255) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `fk_produtos_categorias_idx` (`idCategoria`),
    CONSTRAINT `fk_produtos_categorias` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de endereços
DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE `enderecos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `logradouro` varchar(255) NOT NULL,
    `numero` varchar(10) NOT NULL,
    `complemento` varchar(255) DEFAULT NULL,
    `bairro` varchar(50) NOT NULL,
    `cidade` varchar(50) NOT NULL,
    `uf` varchar(2) NOT NULL,
    `cep` varchar(9) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de clientes
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(255) NOT NULL,
    `cpf` varchar(14) NOT NULL,
    `email` varchar(255) NOT NULL,
    `celular` varchar(14) NOT NULL,
    `idEndereco` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `fk_clientes_endereco_idx` (`idEndereco`),
    CONSTRAINT `fk_clientes_endereco` FOREIGN KEY (`idEndereco`) REFERENCES `enderecos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de fornecedores
DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE `fornecedores` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(255) NOT NULL,
    `cnpj` varchar(18) NOT NULL,
    `email` varchar(255) NOT NULL,
    `telefone` varchar(15) NOT NULL,
    `idEndereco` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `fk_fornecedores_endereco_idx` (`idEndereco`),
    CONSTRAINT `fk_fornecedores_endereco` FOREIGN KEY (`idEndereco`) REFERENCES `enderecos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de entradas
DROP TABLE IF EXISTS `entradas`;
CREATE TABLE `entradas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idCategoria` int(11) NOT NULL,
    `idProdutos` int(11) NOT NULL,
    `idFornecedor` int(11) NOT NULL,
    `quantidade` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `fk_entradas_categoria_idx` (`idCategoria`),
    CONSTRAINT `fk_entradas_categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    KEY `fk_entradas_produtos_idx` (`idProdutos`),
    CONSTRAINT `fk_entradas_produtos` FOREIGN KEY (`idProdutos`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    KEY `fk_entradas_fornecedor_idx` (`idFornecedor`),
    CONSTRAINT `fk_entradas_fornecedor` FOREIGN KEY (`idFornecedor`) REFERENCES `fornecedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabela de saídas
DROP TABLE IF EXISTS `saidas`;
CREATE TABLE `saidas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idCategoria` int(11) NOT NULL,
    `idClientes` int(11) NOT NULL,
    `idProdutos` int(11) NOT NULL,
    `quantidade` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `fk_saidas_categorias_idx` (`idCategoria`),
    CONSTRAINT `fk_saidas_categorias` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    KEY `fk_saidas_clientes_idx` (`idClientes`),
    CONSTRAINT `fk_saidas_clientes` FOREIGN KEY (`idClientes`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    KEY `fk_saidas_produtos_idx` (`idProdutos`),
    CONSTRAINT `fk_saidas_produtos` FOREIGN KEY (`idProdutos`) REFERENCES `produtos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;