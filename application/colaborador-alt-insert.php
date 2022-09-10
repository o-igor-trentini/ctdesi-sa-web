<?php
    require_once 'class/BancoDeDados.php';

    $envio = isset($_POST['tipoEnvio']) ? $_POST['tipoEnvio'] : '';


    //_______________________________________________________ 
    //             ######## CADASTRAR #############
    //_______________________________________________________ 
    if($envio == 'insert'){
        $form['nome'] = isset($_POST['txtNome']) ? $_POST['txtNome'] : '';
        $form['cpf'] = isset($_POST['txtCpf']) ? $_POST['txtCpf'] : '';
        $form['nasc'] = isset($_POST['dtpNasc']) ? $_POST['dtpNasc'] : '';
        $form['tel'] = isset($_POST['txtTel']) ? $_POST['txtTel'] : '';
        $form['sexo'] = isset($_POST['slctGenero']) ? $_POST['slctGenero'] : '';
        $usuario = isset($_POST['txtUsuario']) ? $_POST['txtUsuario'] : '';
        $form['senha'] = isset($_POST['txtSenha']) ? $_POST['txtSenha'] : '';
        $form['tipo'] = isset($_POST['slctTipo']) ? $_POST['slctTipo'] : '';

        if (in_array('', $form) || strlen($form['tel']) < 14 || strlen($form['cpf']) < 14 || empty($usuario)) {
            $resultado = '2';
            echo "<script>window.location.href='../colaboradores.php?resultado={$resultado}'</script>";
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'SELECT COUNT(*) AS encontrou FROM colaboradores WHERE usuario=?';
        $params = [$usuario];
        $resultadoUsuario = $conexao->pegarRegistro($sql,$params);

        if($resultadoUsuario['encontrou'] > 0){
            $resultado = '8';
            echo "<script>window.location.href='../colaboradores.php?resultado={$resultado}'</script>";
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'SELECT COUNT(*) AS encontrou FROM colaboradores WHERE cpf=?';
        $params = [$form['cpf']];
        $resultadoCPF = $conexao->pegarRegistro($sql,$params);

        if($resultadoCPF['encontrou'] > 0){
            $resultado = '9';
            echo "<script>window.location.href='../colaboradores.php?resultado={$resultado}'</script>";
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'INSERT INTO colaboradores (nome, cpf, nascimento, telefone, sexo, usuario, senha, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $params = [$form['nome'], $form['cpf'], $form['nasc'], $form['tel'], $form['sexo'], $usuario, $form['senha'], $form['tipo']];
        
        if ($conexao->inserirRegistro($sql, $params)) {
            $conexao = new BancoDeDados;
            $sql = 'SELECT MAX(id_colaborador) AS ultimo FROM colaboradores';
            $dados = $conexao->pegarRegistro($sql);
            $id = $dados['ultimo'];
            $cadastro = '1';
            echo "<script>window.location.href = '../identificador.php?id=$id&cad=$cadastro&tipo=2';</script>";
            
        } else {
            $resultado = '0';
        }
        echo "<script>window.location.href='../colaboradores.php?resultado={$resultado}'</script>";
    }elseif($envio == 'alt'){

    //_______________________________________________________ 
    //             ######## ALTERAR #############
    //_______________________________________________________
        $form['id'] = isset($_POST['txtIdColaborador']) ? $_POST['txtIdColaborador'] : '';
        $form['nome'] = isset($_POST['txtNome']) ? $_POST['txtNome'] : '';
        $form['cpf'] = isset($_POST['txtCpf']) ? $_POST['txtCpf'] : '';
        $form['nasc'] = isset($_POST['dtpNasc']) ? $_POST['dtpNasc'] : '';
        $form['tel'] = isset($_POST['txtTel']) ? $_POST['txtTel'] : '';
        $form['sexo'] = isset($_POST['slctGenero']) ? $_POST['slctGenero'] : '';
        $usuario = isset($_POST['txtUsuario']) ? $_POST['txtUsuario'] : '';
        $form['senha'] = isset($_POST['txtSenha']) ? $_POST['txtSenha'] : '';
        $form['tipo'] = isset($_POST['slctTipo']) ? $_POST['slctTipo'] : '';

        if (in_array('', $form) || strlen($form['tel']) < 14 || strlen($form['cpf']) < 14 || empty($usuario)) {
            $resultado = 2;
            echo "<script>window.location.href='../colaboradores.php?resultado={$resultado}'</script>";
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'SELECT COUNT(*) AS encontrou FROM colaboradores WHERE usuario=? AND id_colaborador != ?';
        $params = [$usuario, $form['id']];
        $resultadoUsuario = $conexao->pegarRegistro($sql,$params);

        if($resultadoUsuario['encontrou'] > 0){
            $resultado = '8';
            echo "<script>window.location.href='../colaboradores.php?resultado={$resultado}'</script>";
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'SELECT COUNT(*) AS encontrou FROM colaboradores WHERE cpf=? AND id_colaborador != ?';
        $params = [$form['cpf'], $form['id']];
        $resultadoCPF = $conexao->pegarRegistro($sql,$params);

        if($resultadoCPF['encontrou'] > 0){
            $resultado = '9';
            echo "<script>window.location.href='../colaboradores.php?resultado={$resultado}'</script>";
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'UPDATE colaboradores SET nome = ?, cpf = ?, nascimento = ?, telefone = ?, sexo = ?, usuario = ?, senha = ?, tipo = ? WHERE id_colaborador=?';
        $params = [$form['nome'], $form['cpf'], $form['nasc'], $form['tel'], $form['sexo'], $usuario, $form['senha'], $form['tipo'], $form['id']];

        if ($conexao->atualizarRegistro($sql, $params)) {
            $resultado = 3;
        } else {
            $resultado = 4;
        }

        echo "<script>window.location.href='../colaboradores.php?resultado={$resultado}'</script>";
     }


?>