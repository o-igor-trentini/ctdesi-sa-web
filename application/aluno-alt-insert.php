<?php
    require_once 'class/BancoDeDados.php';

    $envio = isset($_POST['tipoEnvio']) ? $_POST['tipoEnvio'] : '';

    //_______________________________________________________ 
    //             ######## CADASTRAR #############
    //_______________________________________________________ 
    if($envio == 'insert'){
        $form['nome'] = isset($_POST['txtNome']) ? $_POST['txtNome'] : '';
        $form['nasc'] = isset($_POST['dtpNasc']) ? $_POST['dtpNasc'] : '';
        $form['tel'] = isset($_POST['txtTel']) ? $_POST['txtTel'] : '';
        $form['sexo'] = isset($_POST['slctGenero']) ? $_POST['slctGenero'] : '';

        if (in_array('', $form) && strlen($form['tel']) < 14) {
            $resultado = '2';
            echo "<script>window.location.href='../alunos.php?resultado={$resultado}'</script>";
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'INSERT INTO alunos (nome, nascimento, telefone, sexo) VALUES (?, ?, ?, ?)';
        $params = [$form['nome'], $form['nasc'], $form['tel'], $form['sexo']];
        
        if ($conexao->inserirRegistro($sql, $params)) {

            $conexao = new BancoDeDados;
            $sql = 'SELECT MAX(id_aluno) AS ultimo FROM alunos';
            $dados = $conexao->pegarRegistro($sql);
            $id = $dados['ultimo'];
            $cadastro = '1';
            echo "<script>window.location.href = '../identificador.php?id=$id&cad=$cadastro&tipo=1';</script>";
            exit;
        } else {
            $resultado = '0';
        }
        echo "<script>window.location.href='../alunos.php?resultado={$resultado}'</script>";

    }elseif($envio == 'alt'){ 

        
    //_______________________________________________________ 
    //             ######## ALTERAR #############
    //_______________________________________________________
        $form['id'] = isset($_POST['txtIdAluno']) ? $_POST['txtIdAluno'] : '';
        $form['nome'] = isset($_POST['txtNome']) ? $_POST['txtNome'] : '';
        $form['nasc'] = isset($_POST['dtpNasc']) ? $_POST['dtpNasc'] : '';
        $form['tel'] = isset($_POST['txtTel']) ? $_POST['txtTel'] : '';
        $form['sexo'] = isset($_POST['slctGenero']) ? $_POST['slctGenero'] : '';
        

        if (in_array('', $form) && strlen($form['tel']) < 14) {
            $atual = 2;
            echo "<script>window.location.href='../alunos.php?resultado={$atual}'</script>";
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'UPDATE alunos SET nome = ?, nascimento = ?, telefone =?, sexo = ? WHERE id_aluno = ?';
        $params = [$form['nome'], $form['nasc'], $form['tel'], $form['sexo'], $form['id']];
        
        if ($conexao->atualizarRegistro($sql, $params)) {
            $resultado = 3;
        } else {
            $resultado = 4;
        }

        echo "<script>window.location.href='../alunos.php?resultado={$resultado}'</script>";
    }else{
        echo "<script>window.location.href='../alunos.php'</script>";
    }
    
?>