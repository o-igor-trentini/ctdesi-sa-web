<?php
    $usuario = isset($_POST['txtUsuario']) ? $_POST['txtUsuario'] : '';
    $senha = isset($_POST['txtSenha']) ? $_POST['txtSenha'] : '';

    // Em branco
    if (empty($usuario) || empty($senha)) {
        header ("LOCATION: ../index.php?erro=1#login");
        exit;
    }

    require_once 'class/BancoDeDados.php';
    $conexao = new BancoDeDados;
    $sql = 'SELECT COUNT(*) AS encontrou, usuario, senha, id_colaborador, nome, tipo FROM colaboradores WHERE usuario=?';
    $params = [$usuario];
    $dados = $conexao->pegarRegistro($sql, $params);

    // Usuário não encontrado
    if ($dados['encontrou'] <= 0) {
        header ("LOCATION: ../index.php?erro=2#login");
        exit;
    }

    // Senha incorreta
    if ($senha != $dados['senha']) {
        header ("LOCATION: ../index.php?erro=3&usuario={$usuario}#login");
        exit;
    }
    
    if (is_array($dados)) {
            session_start();
            $_SESSION['logado'] = TRUE;
            $_SESSION['id_colaborador'] = $dados['id_colaborador'];
            $_SESSION['nome'] = $dados['nome'];
            $_SESSION['tipo'] = $dados['tipo'];

            header("LOCATION: ../livros.php");
        }
?>