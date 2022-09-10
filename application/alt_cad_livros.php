
<!-- ------------------------------------------------------------------- -->
        <!-- ######### PASSAR DADOS PARA O FORM ########## -->
<!-- ------------------------------------------------------------------- -->
<?php
        if(isset($_POST['idAlt'])){
            $idAlt = $_POST['idAlt'];
        }else{
            $idAlt = '';
        };

        if(!empty($idAlt)){
            require_once 'class/BancoDeDados.php';
            $conexao = new BancoDeDados;
            $sql = 'SELECT * FROM livros WHERE id_livro=?';
            $param = [$idAlt];
            $dados = $conexao->pegarRegistro($sql, $param);

            $resumo = str_replace(array("\n", "\r"), ' ', (!empty($dados['resumo']) ? $dados['resumo'] : ""));

            echo "
            <script type/javascript>
                document.getElementById('tipoEnvio').value = 'alt';

                document.getElementById('txtIdLivro').value = '".(!empty($dados['id_livro']) ? $dados['id_livro'] : "")."';
                document.getElementById('txtTitulo').value = '".(!empty($dados['titulo']) ? $dados['titulo'] : "")."';
                document.getElementById('txtResumo').value = '$resumo';
                document.getElementById('txtEditora').value = '".(!empty($dados['editora']) ? $dados['editora'] : "")."';
                document.getElementById('txtAutor').value = '".(!empty($dados['autor']) ? $dados['autor'] : "")."';
                document.getElementById('txtQtdPaginas').value = '".(!empty($dados['qtd_paginas']) ? $dados['qtd_paginas'] : "")."';
                document.getElementById('txtIsbn').value = '".(!empty($dados['isbn']) ? $dados['isbn'] : "")."';
                document.getElementById('slctGenero').value = '".(!empty($dados['id_genero']) ? $dados['id_genero'] : "")."';

                document.getElementById('tituloModalForm').innerText = 'ALTEARAR LIVRO';
                document.getElementById('btnEnviar').innerText = 'ALTERAR';
            </script>";
    }   
?>