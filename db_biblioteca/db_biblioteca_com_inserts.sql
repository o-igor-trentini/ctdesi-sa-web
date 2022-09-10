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

INSERT INTO alunos (nome, nascimento, telefone, sexo) VALUES
	('Arthur da Silva', '2001/01/01', '(11) 11111-1111', 'M'),
    ('Bianca Galvão', '2002/02/02', '(22) 22222-2222', 'F'),
    ('Cristina Aparecida', '2003/03/03', '(33) 33333-3333', 'F'),
    ('Igor Trentini', '2004/10/11', '(44) 44444-4444', 'M'),
    ('Kaue Thums', '2003/09/06', '(55) 55555-5555', 'M')
;
    
INSERT INTO colaboradores (nome, cpf, nascimento, telefone, sexo, usuario, senha, tipo) VALUES
	('Administrador', '111.111.111-11', '2001/01/01', '(11) 11111-1111', 'M', 'admin', 'admin', 2),
    ('Isa Pedroso', '222.222.222-22', '2002/02/02', '(22) 22222-2222', 'F', 'isa', 'qwe', 1),
    ('Maria Salvador', '333.333.333-33', '2001/01/01', '(33) 33333-3333', 'F', 'maria', 'abc', 1),
    ('Igor Trentini', '444.444.444-44', '2004/04/04', '(22) 44444-4444', 'M', 'igor', '123', 1),
	('Kaue Thums', '555.555.555-55', '2003/03/03', '(55) 55555-5555', 'M', 'kaue', '123', 1)
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
    
INSERT INTO livros (titulo, resumo, editora, autor, qtd_paginas, isbn, id_genero) VALUES
	('Orgulho e Preconceito', 'Se você procura bons livros para ler, os romances de Jane Austen são sempre uma ótima escolha.', 'Martin Claret', 'Jane Austen', 277, '8572328750', 14),
	('1984', 'Em um país controlado por um regime totalitário, um homem vai se rebelar contra o sistema.', 'Capanhia das Letras', 'George Orwell', 300, '8572328750', 16),
    ('Dom Quixote de la Mancha', 'Um dos maiores clássicos da literatura espanhola, Dom Quixote conta a história de um cavaleiro que leu demasiados romances e enlouqueceu.', 'Monte Cristo', 'Miguel de Cervantes', 178, '8571062501', 2),
    ('O Pequeno Príncipe', 'Esse livro vale tanto pelas palavras quanto pelas ilustrações. Embora seja (oficialmente) um livro infantil, O Pequeno Príncipe analisa questões profundas sobre a vida humana.', 'Autentica', 'Antoine de Saint-Exupéry', 430, '8595081514', 3),
    ('Dom Casmurro', 'Existem muitos livros que exploram o ciúme no casamento, mas poucos o fazem tão bem como Dom Casmurro.', 'Penguin', 'Machado de Assis', 99, '8582850352', 16),
    ('O Bandolim do Capitão Corelli', 'Com um estilo e uma linguagem muito distintos, O Bandolim do Capitão Corelli conta a história do amor entre duas pessoas em lados opostos da 2ª Guerra Mundial.', 'Record', 'Louis de Bernières', 511, '8501048332', 16),
    ('O Conde de Monte Cristo', 'Amor, vingança, traição e tesouro! Edmond Dantès perde tudo quando é traído por um companheiro invejoso.', 'LeBooks', 'Alexandre Dumas', 120, '853229250X', 3),
    ('Um Estudo em Vermelho', 'A primeira história do famoso detetive Sherlock Holmes e seu fiel companheiro, John Watson.', 'Zahar', 'Arthur Conan Doyle', 493, '8537810878', 8),
    ('O Processo', 'Uma crítica à burocracia, O Processo conta a história de Joseph K., preso e julgado por um crime que desconhece.', 'Companhia de Bolso', 'Franz Kafka', 790, '8535907432', 5),
    ('Cem Anos de Solidão', 'Nessa obra-prima de Gabriel García Márquez encontramos o retrato de 7 gerações de uma família colombiana.', 'Record', 'Gabriel García Márquez', 392, '9788501012074', 17)
;

INSERT INTO emprestimos (data_retirada, hora_retirada, situacao, id_livro, id_aluno) VALUES
	(CURDATE(), CURTIME(), 1, 1, 1),
    (CURDATE(), CURTIME(), 1, 2, 2)
;

INSERT INTO emprestimos (data_retirada, hora_retirada, situacao, id_livro, id_colaborador) VALUES
	(CURDATE(), CURTIME(), 1, 3, 2),
    (CURDATE(), CURTIME(), 1, 4, 3)
;

INSERT INTO configuracoes (qtd_dias_devolucao, valor_multa) VALUES
	(14, 1.00)
;