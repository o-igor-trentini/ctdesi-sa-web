
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
            $sql = 'SELECT * FROM generos WHERE id_genero=?';
            $param = [$idAlt];
            $dados = $conexao->pegarRegistro($sql, $param);
            
            echo "
            <script type='text/javascript'>
                document.getElementById('tipoEnvio').value = 'alt';

                document.getElementById('txtIdGenero').value = '".(!empty($dados['id_genero']) ? $dados['id_genero'] : "")."';
                document.getElementById('txtGenero').value = '".(!empty($dados['genero']) ? $dados['genero'] : "")."';

                document.getElementById('tituloModalForm').innerText = 'ALTEARAR GÊNERO';
                document.getElementById('btnEnviar').innerText = 'ALTERAR';
            </script>";          
    }   
?>