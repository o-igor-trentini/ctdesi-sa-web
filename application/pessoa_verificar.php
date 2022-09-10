<?php
        $txtId = isset($_POST['txtIdPessoa']) ? $_POST['txtIdPessoa'] : '';

        // Em branco
        if (empty($txtId)) {
                header ("LOCATION: ../identificarPessoa.php?erro=1");
                exit;
        }

        $tipo = substr($txtId, 0, 1);
        $id = substr($txtId, 2);

        if ($tipo == 1) {
                $pessoa = 'aluno';
                $pessoas = 'alunos';
        } elseif ($tipo == 2){
                $pessoa = 'colaborador';
                $pessoas = 'colaboradores';
        } else {
                header ("LOCATION: ../identificarPessoa.php?erro=1");
                exit;
        }

        require_once 'class/BancoDeDados.php';
        $conexao = new BancoDeDados;
        $sql = 'SELECT COUNT(*) AS encontrou, nome FROM '. $pessoas .' WHERE id_'. $pessoa .' = ?';
        $params = [$id];
        $dadosP = $conexao->pegarRegistro($sql, $params);

        if ($dadosP['encontrou'] > 0) {
                session_start();
                $_SESSION['id_pessoa'] = $id;
                $_SESSION['nome'] = $dadosP['nome'];
                $_SESSION['tipo_pessoa'] = [$pessoa, $pessoas];

                $sql = 'SELECT COUNT(*) AS ativo, situacao FROM emprestimos WHERE id_'. $pessoa .' = ? AND situacao = 1';
                $params = [$id];
                $dados = $conexao->pegarRegistro($sql, $params);
                if ($dados['ativo'] > 0 && $dados['situacao'] == 1) {
                        $_SESSION['acao'] = 'devolver';

                        header ("LOCATION: ../identificarLivro.php");
                        exit;
                } else {
                        $_SESSION['acao'] = 'retirar';

                        header ("LOCATION: ../identificarLivro.php");
                        exit;  
                }
        } else {
                // Usuário não encontrado
                header ("LOCATION: ../identificarLivro.php?erro=1");
        }
?>