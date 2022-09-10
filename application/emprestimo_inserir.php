<?php
        date_default_timezone_set('America/Sao_Paulo');

        require_once 'class/BancoDeDados.php';
        $conexao = new BancoDeDados;
        session_start();
        $sql = 'INSERT INTO emprestimos (data_retirada, hora_retirada, situacao, id_'. $_SESSION['tipo_pessoa'][0] .', id_livro) VALUES (?, ?, 1, ?, ?)';
        $params = [date('Y/m/d'), date('H:i:s'), $_SESSION['id_pessoa'], $_SESSION['id_livro']];
        if ($conexao->inserirRegistro($sql, $params)) {
            if ($_SESSION['acao'] == 'devolver') {
                $sql = 'SELECT qtd_dias_devolucao AS qtd_dias FROM configuracoes';
                $dados = $conexao->pegarRegistro($sql);
                $dataDevolucao = date('d/m/Y', strtotime("+{$dados['qtd_dias']} days"));
                header ("LOCATION: ../index.php?sucesso=2&data={$dataDevolucao}");
                exit;
            }

            header ("LOCATION: ../index.php?sucesso=1");
            exit;
        } else {
            header ("LOCATION: ../emprestimo-devolucao.php?erro=1");
            exit;
        }

        header ("LOCATION: ../index.php");
?>