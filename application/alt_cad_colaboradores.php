
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
            $sql = 'SELECT * FROM colaboradores WHERE id_colaborador=?';
            $param = [$idAlt];
            $dados = $conexao->pegarRegistro($sql, $param);

            echo "
            <script type/javascript>
                document.getElementById('tipoEnvio').value = 'alt';

                document.getElementById('txtIdColaborador').value = '".(!empty($dados['id_colaborador']) ? $dados['id_colaborador'] : "")."';
                document.getElementById('txtNome').value = '".(!empty($dados['nome']) ? $dados['nome'] : "")."';
                document.getElementById('txtCpf').value = '".(!empty($dados['cpf']) ? $dados['cpf'] : "")."';
                document.getElementById('dtpNasc').value = '".(!empty($dados['nascimento']) ? $dados['nascimento'] : "")."';
                document.getElementById('txtTel').value = '".(!empty($dados['telefone']) ? $dados['telefone'] : "")."';
                document.getElementById('txtUsuario').value = '".(!empty($dados['usuario']) ? $dados['usuario'] : "")."';
                document.getElementById('txtSenha').value = '".(!empty($dados['senha']) ? $dados['senha'] : "")."';
                document.getElementById('slctTipo').value = '".(!empty($dados['tipo']) ? $dados['tipo'] : "")."';
                document.getElementById('slctGenero').value = '".(!empty($dados['sexo']) ? $dados['sexo'] : "")."';

                document.getElementById('tituloModalForm').innerText = 'ALTEARAR COLABORADOR';
                document.getElementById('btnEnviar').innerText = 'ALTERAR';
            </script>";
    }   
?>