USE db_biblioteca;

INSERT INTO colaboradores (nome, cpf, nascimento, telefone, sexo, usuario, senha, tipo) VALUES
	('Administrador', '111.111.111-11', '2001/01/01', '(11) 11111-1111', 'M', 'admin', 'admin', 2),
    ('Isa Pedroso', '222.222.222-22', '2002/02/02', '(22) 22222-2222', 'F', 'isa', 'qwe', 1),
    ('Maria Salvador', '333.333.333-33', '2001/01/01', '(33) 33333-3333', 'F', 'maria', 'abc', 1),
    ('Igor Trentini', '444.444.444-44', '2004/04/04', '(22) 44444-4444', 'M', 'igor', '123', 1),
	('Kaue Thums', '555.555.555-55', '2003/03/03', '(55) 55555-5555', 'M', 'kaue', '123', 1)
;

SELECT * FROM colaboradores;