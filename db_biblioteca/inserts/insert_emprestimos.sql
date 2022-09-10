USE db_biblioteca;

INSERT INTO emprestimos (data_retirada, hora_retirada, situacao, id_livro, id_aluno) VALUES
	(CURDATE(), CURTIME(), 1, 1, 1),
    (CURDATE(), CURTIME(), 1, 2, 2)
;

INSERT INTO emprestimos (data_retirada, hora_retirada, situacao, id_livro, id_colaborador) VALUES
	(CURDATE(), CURTIME(), 1, 3, 2),
    (CURDATE(), CURTIME(), 1, 4, 3)
;

SELECT * FROM emprestimos;