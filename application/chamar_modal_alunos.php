<!-- ------------------------------------------------------------------- -->
        <!-- ######### PASSAR DADOS PARA O MODAL ########## -->
<!-- ------------------------------------------------------------------- -->
    <?php
        if(isset($_POST['idModal'])){
            $idModal = $_POST['idModal'];
        }else{
            $idModal = '';
        };

        if(isset($_POST['campos'])){
            $campos = $_POST['campos'];
        }else{
            $campos = '';
        };
    ?>
    
<script>
    <?php
    if(!empty($idModal)){

        if ($campos != '0') {
            $qtdRegistros = " LIMIT $campos";
        } else {
            $qtdRegistros = '';
        }
        
        require_once 'class/BancoDeDados.php';
        $conexao = new BancoDeDados;
        $sql = 'SELECT * FROM alunos WHERE id_aluno=?';
        $param = [$idModal];
        $dados = $conexao->pegarRegistro($sql,$param);

        if(!empty($dados['sexo'])){
            if($dados['sexo'] == 'F'){
                $sexo = 'Feminino';
            }elseif($dados['sexo']){
                $sexo = 'Masculino';
            }
        }else{
            $sexo = 'Sem registro';
        }

        echo "
        document.getElementById('idModal').value                 = '".(!empty($dados['id_aluno']) ? $dados['id_aluno'] : "Sem Registro")."';
        document.getElementById('tituloModal').innerHTML         = '".(!empty($dados['nome']) ? $dados['nome'] : "Sem Registro")."';
        document.getElementById('nascimentoModal').innerHTML     = '".(!empty($dados['nascimento']) ? date('d/m/Y', strtotime($dados['nascimento'])) : "Sem Registro")."';

        document.getElementById('telefoneModal').innerHTML       = '".(!empty($dados['telefone']) ? $dados['telefone'] : "Sem Registro")."';
        document.getElementById('sexoModal').innerHTML           = '$sexo';";

        $conexao = new BancoDeDados;
        $sql = 'SELECT COUNT(*) AS disponivel FROM emprestimos WHERE id_aluno=? AND situacao=1';
        $param = [$idModal];
        $dadosSituacao = $conexao->pegarRegistro($sql,$param);

        if($dadosSituacao['disponivel'] > 0){
            $situacao = 'Locação Ativa';
        }else{
            $situacao = 'Sem locações ativas';
        }

        echo "document.getElementById('situacaoModal').innerHTML = '$situacao';";

        // TABELA LOCAÇÕES
        $conexao = new BancoDeDados;
        $sql = 'SELECT a.*,b.titulo as titulo FROM emprestimos as a INNER JOIN livros as b on a.id_livro=b.id_livro WHERE a.id_aluno=? order by a.id_emprestimo DESC'.$qtdRegistros;
        $param = [$idModal];
        $dadosLocacao = $conexao->pegarRegistros($sql,$param);

        foreach($dadosLocacao as $linha){
            // PREPARANDO OS DADOS
            $id           = $linha['id_emprestimo'];
            $dataRet      = date('d/m/Y', strtotime($linha['data_retirada']));
            $horaRet      = $linha['hora_retirada'];

            if($linha['situacao'] == 0){
                $dataDev      = date('d/m/Y', strtotime($linha['data_devolucao']));
                $horaDev      = $linha['hora_devolucao'];
                $situacao     = 'Inativo';
            }else{
                $dataDev      = '-';
                $horaDev      = '-';
                $situacao     = 'Ativo';
            }

            $livro = $linha['titulo'];
           
            echo "$('#tabelaModal > tbody:last-child').append('<tr><td>$id</td><td>$dataRet</td><td>$horaRet</td><td>$dataDev</td><td>$horaDev</td><td>$situacao</td><td>$livro</td></tr>');";  
        }
    }
    ?>
</script>