<?php
    require_once 'class/BancoDeDados.php';

    $campo = isset($_POST['qtd_dias']) ? $_POST['qtd_dias'] : $_POST['multa'];
    
    if ($campo == 'qtd_dias_devolucao') {
        $form['valor'] = isset($_POST['txtDevolucao']) ? $_POST['txtDevolucao'] : '';
    } else {
        $form['valor'] = isset($_POST['txtMulta']) ? $_POST['txtMulta'] : '';
    }

    if (in_array('', $form)) {
        header ("LOCATION: ../configuracoes.php?resultado=2#parametros");
        exit;
    }

    $conexao = new BancoDeDados;
    $sql = 'UPDATE configuracoes SET '. $campo .' = ?';
    $params = [str_replace(',', '.', $form['valor'])];
    if ($conexao->atualizarRegistro($sql, $params)) {
        if ($campo == 'qtd_dias_devolucao') {
            header ("LOCATION: ../configuracoes.php?resultado=3#parametros");
            exit;
        } else {
            header ("LOCATION: ../configuracoes.php?resultado=3#parametros");
            exit;
        }
        
    } else {
        header ("LOCATION: ../configuracoes.php?resultado=4#parametros");
        exit;
    }
?>