<?php
    require_once 'class/BancoDeDados.php';

    $envio = isset($_POST['tipoEnvio']) ? $_POST['tipoEnvio'] : '';

    //_______________________________________________________ 
    //             ######## CADASTRAR #############
    //_______________________________________________________ 
    if($envio == 'insert'){
        $form['titulo'] = isset($_POST['txtTitulo']) ? $_POST['txtTitulo'] : '';
        $form['resumo'] = isset($_POST['txtResumo']) ? $_POST['txtResumo'] : '';
        $form['editora'] = isset($_POST['txtEditora']) ? $_POST['txtEditora'] : '';
        $form['autor'] = isset($_POST['txtAutor']) ? $_POST['txtAutor'] : '';
        $form['qtdPaginas'] = isset($_POST['txtQtdPaginas']) ? $_POST['txtQtdPaginas'] : '';
        $isbn = isset($_POST['txtIsbn']) ? $_POST['txtIsbn'] : 'Sem Registro';
        $form['idGenero'] = isset($_POST['slctGenero']) ? $_POST['slctGenero'] : '';

        if (in_array('', $form)) {
            $resultado = '2';
            echo "<script>window.location.href='../livros.php?resultado={$resultado}'</script>";
            exit;
        }

        $conexao = new BancoDeDados;
        $sql = 'INSERT INTO livros (titulo, resumo, editora, autor, qtd_paginas, isbn, id_genero) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = [$form['titulo'], $form['resumo'], $form['editora'], $form['autor'], $form['qtdPaginas'], $isbn, $form['idGenero']];
        
        if ($conexao->inserirRegistro($sql, $params)) {

            $conexao = new BancoDeDados;
            $sql = 'SELECT MAX(id_livro) AS ultimo FROM livros';
            $dados = $conexao->pegarRegistro($sql);
            $id = $dados['ultimo'];
            $cadastro = '1';

            echo "<script>window.location.href = '../identificadorLivro.php?id=$id&cad=$cadastro';</script>";
            exit;
        } else {
            $resultado = '0';
        }
        
        echo "<script>window.location.href='../livros.php?resultado={$resultado}'</script>";
    }else if($envio == 'alt'){
    //_______________________________________________________ 
    //             ######## ALTERAR #############
    //_______________________________________________________
        $form['id'] = isset($_POST['txtIdLivro']) ? $_POST['txtIdLivro'] : '';
        $form['titulo'] = isset($_POST['txtTitulo']) ? $_POST['txtTitulo'] : '';
        $form['resumo'] = isset($_POST['txtResumo']) ? $_POST['txtResumo'] : '';
        $form['editora'] = isset($_POST['txtEditora']) ? $_POST['txtEditora'] : '';
        $form['autor'] = isset($_POST['txtAutor']) ? $_POST['txtAutor'] : '';
        $form['qtdPaginas'] = isset($_POST['txtQtdPaginas']) ? $_POST['txtQtdPaginas'] : '';
        $isbn = isset($_POST['txtIsbn']) ? $_POST['txtIsbn'] : '';
        $form['idGenero'] = isset($_POST['slctGenero']) ? $_POST['slctGenero'] : '';
    
        if (in_array('', $form)) {
            $resultado = 2;
            echo "<script>window.location.href='../livros.php?resultado={$resultado}'</script>";
            exit;
        }
    
        $conexao = new BancoDeDados;
        $sql = 'UPDATE livros SET titulo = ?, resumo = ?, editora = ?, autor = ?, qtd_paginas = ?, isbn = ?, id_genero = ? WHERE id_livro = ?';
        $params = [$form['titulo'], $form['resumo'], $form['editora'], $form['autor'], $form['qtdPaginas'], $isbn, $form['idGenero'], $form['id']];
        
        if ($conexao->atualizarRegistro($sql, $params)) {
            $resultado = 3;
        } else {
            $resultado = 4;
        }
    
        echo "<script>window.location.href='../livros.php?resultado={$resultado}'</script>";
    }
?>