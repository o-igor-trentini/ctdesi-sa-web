USE db_biblioteca;

INSERT INTO alunos (nome, nascimento, telefone, sexo) VALUES
	('Arthur da Silva', '2001/01/01', '(11) 11111-1111', 'M'),
    ('Bianca Galvão', '2002/02/02', '(22) 22222-2222', 'F'),
    ('Cristina Aparecida', '2003/03/03', '(33) 33333-3333', 'F'),
    ('Igor Trentini', '2004/10/11', '(44) 44444-4444', 'M'),
    ('Kaue Thums', '2003/09/06', '(55) 55555-5555', 'M')
    ;
    
    SELECT * FROM alunos;