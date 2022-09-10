<?php
    date_default_timezone_set('America/Sao_Paulo');

    require_once 'class/BancoDeDados.php';
    $conexao = new BancoDeDados;
    session_start();
    $sql = 'SELECT id_emprestimo FROM emprestimos WHERE id_'. $_SESSION['tipo_pessoa'][0] .' = ? AND situacao = 1';
    $params =[$_SESSION['id_pessoa']];
    $dados = $conexao->pegarRegistro($sql, $params);

    $sql = 'UPDATE emprestimos SET data_devolucao = ?, hora_devolucao = ?, situacao = 0 WHERE id_emprestimo = ? AND id_'. $_SESSION['tipo_pessoa'][0] .' = ?';
    $params = [date('Y/m/d'), date('H:i:s'), $dados['id_emprestimo'], $_SESSION['id_pessoa']];
    if ($conexao->atualizarRegistro($sql, $params)) {
        $renovar = isset($_GET['renovar']) ? true : false;
        if ($renovar) {
            header ("LOCATION: emprestimo_inserir.php");
            exit;
        }

        header ("LOCATION: ../index.php?sucesso=3");
        exit;
    } else {
        header ("LOCATION: ../emprestimo-devolucao.php?erro=1");
        exit;
    }

    header ("LOCATION: ../index.php");
?>