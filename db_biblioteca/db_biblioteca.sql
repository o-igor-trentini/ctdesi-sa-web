SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_biblioteca
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_biblioteca` DEFAULT CHARACTER SET utf8 ;
USE `db_biblioteca` ;

-- -----------------------------------------------------
-- Table `db_biblioteca`.`alunos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_biblioteca`.`alunos` (
  `id_aluno` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `nascimento` DATE NOT NULL,
  `telefone` VARCHAR(255) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  PRIMARY KEY (`id_aluno`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_biblioteca`.`generos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_biblioteca`.`generos` (
  `id_genero` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `genero` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_genero`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_biblioteca`.`livros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_biblioteca`.`livros` (
  `id_livro` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `resumo` TEXT NOT NULL,
  `editora` VARCHAR(255) NOT NULL,
  `autor` VARCHAR(255) NOT NULL,
  `qtd_paginas` INT UNSIGNED NOT NULL,
  `isbn` VARCHAR(255) NULL,
  `id_genero` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_livro`),
  CONSTRAINT `fk_livros_generos1`
    FOREIGN KEY (`id_genero`)
    REFERENCES `db_biblioteca`.`generos` (`id_genero`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_biblioteca`.`colaboradores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_biblioteca`.`colaboradores` (
  `id_colaborador` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(20) NOT NULL,
  `nascimento` DATE NOT NULL,
  `telefone` VARCHAR(255) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `usuario` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `tipo` TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_colaborador`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_biblioteca`.`emprestimos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_biblioteca`.`emprestimos` (
  `id_emprestimo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `data_retirada` DATE NOT NULL,
  `hora_retirada` TIME NOT NULL,
  `data_devolucao` DATE NULL,
  `hora_devolucao` TIME NULL,
  `situacao` TINYINT NOT NULL,
  `multa` FLOAT UNSIGNED NOT NULL DEFAULT 0,
  `id_livro` INT UNSIGNED NOT NULL,
  `id_aluno` INT UNSIGNED NULL,
  `id_colaborador` INT UNSIGNED NULL,
  PRIMARY KEY (`id_emprestimo`),
  CONSTRAINT `fk_emprestimos_alunos`
    FOREIGN KEY (`id_aluno`)
    REFERENCES `db_biblioteca`.`alunos` (`id_aluno`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_emprestimos_livros1`
    FOREIGN KEY (`id_livro`)
    REFERENCES `db_biblioteca`.`livros` (`id_livro`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_emprestimos_colaboradores1`
    FOREIGN KEY (`id_colaborador`)
    REFERENCES `db_biblioteca`.`colaboradores` (`id_colaborador`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_biblioteca`.`configuracoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_biblioteca`.`configuracoes` (
  `id_configuracao` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `qtd_dias_devolucao` INT UNSIGNED NOT NULL DEFAULT 1,
  `valor_multa` FLOAT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_configuracao`))
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO colaboradores (nome, cpf, nascimento, telefone, sexo, usuario, senha, tipo) VALUES ('Administrador', '111.111.111-11', '2001/01/01', '(11) 11111-1111', 'M', 'admin', 'admin', 2);

INSERT INTO configuracoes (qtd_dias_devolucao, valor_multa) VALUES
	(14, 1.00)
;

INSERT INTO generos (genero) VALUES
	('Auto'),
    ('Comédia'),
	('Conto'),
	('Crônica'),
    ('Écloga'),
    ('Elegia'),
	('Ensaio'),
	('Épico'),
	('Epopéia'),
	('Fábula'),
	('Farsa'),
	('Novela'),
	('Ode'),
	('Romance'),
	('Soneto'),
	('Tragédia'),
	('Tragicomédia')
;