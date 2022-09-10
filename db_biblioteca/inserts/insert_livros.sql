USE db_biblioteca;

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

SELECT * FROM livros;