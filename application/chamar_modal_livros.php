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
    
<script type='text/javascript'>
    <?php
    if(!empty($idModal)){
        if ($campos != '0') {
            $qtdRegistros = " LIMIT $campos";
        } else {
            $qtdRegistros = '';
        }
        require_once 'class/BancoDeDados.php';
        $conexao = new BancoDeDados;
        $sql = 'SELECT * FROM livros WHERE id_livro=?';
        $param = [$idModal];
        $dados = $conexao->pegarRegistro($sql,$param);
        
        $resumo = str_replace(array("\n", "\r"), ' ', (!empty($dados['resumo']) ? $dados['resumo'] : "Sem registro"));

        echo "
        document.getElementById('idModal').value                 = '".(!empty($dados['id_livro']) ? $dados['id_livro'] : "Sem registro")."';
        document.getElementById('tituloModal').innerHTML         = '".(!empty($dados['titulo']) ? $dados['titulo'] : "Sem registro")."';
        document.getElementById('editoraModal').innerHTML        = '".(!empty($dados['editora']) ? $dados['editora'] : "Sem registro")."';
        document.getElementById('autorModal').innerHTML          = '".(!empty($dados['autor']) ? $dados['autor'] : "Sem registro")."';
        document.getElementById('qtdPagModal').innerHTML         = '".(!empty($dados['qtd_paginas']) ? $dados['qtd_paginas'] : "Sem registro")."';
        document.getElementById('resumoModal').innerHTML         = '$resumo';";

        if($dados['isbn'] == ''){
            $isbn = 'Sem registro';
        }else{
            $isbn = $dados['isbn'];
        }
        
        $conexao = new BancoDeDados;
        $sql = 'SELECT genero FROM generos WHERE id_genero=?';
        $param = [$dados['id_genero']];
        $genero = $conexao->pegarRegistro($sql,$param);

        $conexao = new BancoDeDados;
        $sql = 'SELECT COUNT(*) AS disponivel FROM emprestimos WHERE id_livro=? AND situacao=1';
        $param = [$idModal];
        $dadosSituacao = $conexao->pegarRegistro($sql,$param);

        if($dadosSituacao['disponivel'] > 0){
            $situacao = 'Locação Ativa';
        }else{
            $situacao = 'Sem locações ativas';
        }

        echo "document.getElementById('situacaoModal').innerHTML = '$situacao';
              document.getElementById('isbnModal').innerHTML     = '$isbn';
              document.getElementById('generoModal').innerHTML   = '".(!empty($dados['genero']) ? $dados['genero'] : "Sem registro")."';
        ";

        // TABELA LOCAÇÕES
        $conexao = new BancoDeDados;
        $sql = 'SELECT * FROM emprestimos WHERE id_livro=? order by id_emprestimo DESC'.$qtdRegistros;
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

            // VERIFICANDO SE É COLABORADOR OU ALUNO
            if($linha['id_colaborador'] == ''){
                $sql = 'SELECT (SELECT nome FROM alunos a WHERE e.id_aluno = a.id_aluno) AS nome FROM emprestimos e WHERE id_aluno = ?';
                $param = [$linha['id_aluno']];
                $pessoa = $conexao->pegarRegistro($sql,$param);
                $nome = $pessoa['nome'];
            }else{
                $sql = 'SELECT (SELECT nome FROM colaboradores c WHERE e.id_colaborador = c.id_colaborador) AS nome FROM emprestimos e WHERE id_colaborador = ?';
                $param = [$linha['id_colaborador']];
                $pessoa = $conexao->pegarRegistro($sql,$param);
                $nome = $pessoa['nome'];
            }
                
           
            echo "$('#tabelaModal > tbody:last-child').append('<tr><td>$id</td><td>$dataRet</td><td>$horaRet</td><td>$dataDev</td><td>$horaDev</td><td>$situacao</td><td>$nome</td></tr>');";  
        
        }
    }
    ?>
</script>