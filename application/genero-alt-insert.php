<?php
    require_once 'class/BancoDeDados.php';

    $envio = isset($_POST['tipoEnvio']) ? $_POST['tipoEnvio'] : '';

    //_______________________________________________________ 
    //             ######## CADASTRAR #############
    //_______________________________________________________ 
    if($envio == 'insert'){
        $form['genero'] = isset($_POST['txtGenero']) ? $_POST['txtGenero'] : '';

        if (in_array('', $form)) {
            header ("LOCATION: ../configuracoes.php?resultado=2#genero");
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'INSERT INTO generos (genero) VALUES (?)';
        $params = [$form['genero']];
        if ($conexao->inserirRegistro($sql, $params)) {
            header ("LOCATION: ../configuracoes.php?resultado=1#listagem");
            exit;
        } else {
            header ("LOCATION: ../configuracoes.php?resultado=0#listagem");
            exit;
        }
    }else if($envio == 'alt'){

        //_______________________________________________________ 
        //             ######## ALTERAR #############
        //_______________________________________________________
        $form['id'] = isset($_POST['txtIdGenero']) ? $_POST['txtIdGenero'] : '';
        $form['genero'] = isset($_POST['txtGenero']) ? $_POST['txtGenero'] : '';

        if (in_array('', $form)) {
            header ("LOCATION: ../configuracoes.php?resultado=2#genero");
            exit;
        }
        require_once 'class/BancoDeDados.php';
        $conexao = new BancoDeDados;
        $sql = 'UPDATE generos SET genero = ? WHERE id_genero = ?';
        $params = [$form['genero'], $form['id']];
        if ($conexao->atualizarRegistro($sql, $params)) {
            header ("LOCATION: ../configuracoes.php?resultado=3#listagem");
            exit;
        } else {
            header ("LOCATION: ../configuracoes.php?resultado=4#listagem");
            exit;
        }
    }

?>