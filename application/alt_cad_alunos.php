
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
            $sql = 'SELECT * FROM alunos WHERE id_aluno=?';
            $param = [$idAlt];
            $dados = $conexao->pegarRegistro($sql, $param);
            
            echo "
            <script type='text/javascript'>
                document.getElementById('tipoEnvio').value = 'alt';

                document.getElementById('txtIdAluno').value = '".(!empty($dados['id_aluno']) ? $dados['id_aluno'] : "")."';
                document.getElementById('txtNome').value = '".(!empty($dados['nome']) ? $dados['nome'] : "")."';
                document.getElementById('dtpNasc').value = '".(!empty($dados['nascimento']) ? $dados['nascimento'] : "")."';
                document.getElementById('txtTel').value = '".(!empty($dados['telefone']) ? $dados['telefone'] : "")."';
                
                document.getElementById('slctGenero').value = '".(!empty($dados['sexo']) ? $dados['sexo'] : "")."';

                document.getElementById('tituloModalForm').innerText = 'ALTEARAR ALUNO';
                document.getElementById('btnEnviar').innerText = 'ALTERAR';
            </script>";          
    }   
?>