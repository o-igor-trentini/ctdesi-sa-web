<?php
    $txtId = isset($_POST['txtIdLivro']) ? $_POST['txtIdLivro'] : '';

    // Em branco
    if (empty($txtId)) {
            header ("LOCATION: ../identificarLivro.php?erro=1");
            exit;
    }

    $tipo = substr($txtId, 0, 1);
    $id = substr($txtId, 2);

    // Não é livro
    if ($tipo != 3) {
        header ("LOCATION: ../identificarLivro.php?erro=1");
            exit;
    }

    require_once 'class/BancoDeDados.php';
    $conexao = new BancoDeDados;
    $sql = 'SELECT COUNT(*) AS encontrou, titulo FROM livros WHERE id_livro = ?';
    $params = [$id];
    $dadosL = $conexao->pegarRegistro($sql, $params);

    if ($dadosL['encontrou'] > 0) {
        session_start();
        $_SESSION['id_livro'] = $id;
        $_SESSION['titulo'] = $dadosL['titulo'];
        
        if ($_SESSION['acao'] == 'devolver') {
            $sql = 'SELECT id_livro FROM emprestimos WHERE (id_'. $_SESSION['tipo_pessoa'][0] .' = ? AND id_livro = ?) AND situacao = 1';
            $params = [$_SESSION['id_pessoa'], $id];
            $dados = $conexao->pegarRegistro($sql, $params);
            
            // Livro errado
            if ($dados['id_livro'] != $id) {
                header ("LOCATION: ../identificarLivro.php?erro=2");
                exit;
            } else {
                header ("LOCATION: ../emprestimo-devolucao.php");
                exit;
            }
        } else {
            // Verificar disponibilidade
            $sql = 'SELECT COUNT(*) AS encontrou FROM emprestimos WHERE id_livro = ? AND situacao = 1';
            $params = [$id];
            $dados = $conexao->pegarRegistro($sql, $params);
            
            if ($dados['encontrou'] > 0) {
                // Livro indisponível
                header ("LOCATION: ../identificarLivro.php?erro=3");
                exit;
            } else {
                header ("LOCATION: ../emprestimo-devolucao.php");
                exit;
            }
        }
    } else {
        // Não existe
        header ("LOCATION: ../identificarLivro.php?erro=1");
        exit;
    }
?>