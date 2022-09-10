<?php
    require_once 'class/BancoDeDados.php';

    // Conexão 
    $conexao = new BancoDeDados;

    $dados_requisicao = $_REQUEST;

    $colunas = [
        0 => 'id_aluno',
        1 => 'nome',
        2 => 'nascimento',
        3 => 'id_aluno'
    ];
    
    $query_qnt_alunos = "SELECT COUNT(id_aluno) AS qnt_alunos FROM alunos";

    // Acessa o IF quando ha paramentros de pesquisa   
    if(!empty($dados_requisicao['search']['value'])) {
        $query_qnt_alunos .= " WHERE id_aluno LIKE ? ";
        $query_qnt_alunos .= " OR nome LIKE ? ";
        $query_qnt_alunos .= " OR nascimento LIKE ? ";
    }

    $valor_pesq = "";
    $param = [];
    // Acessa o IF quando ha paramentros de pesquisa   
    if(!empty($dados_requisicao['search']['value'])) {
        $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";

        $param = [$valor_pesq, $valor_pesq, $valor_pesq];
    }

    $result_qnt_alunos = $conexao->pegarRegistro($query_qnt_alunos,$param);

    $query_alunos = "SELECT id_aluno, nome, nascimento FROM alunos ";

    if(!empty($dados_requisicao['search']['value'])) {
        $query_alunos .= " WHERE id_aluno LIKE ? ";
        $query_alunos .= " OR nome LIKE ? ";
        $query_alunos .= " OR nascimento LIKE ? ";
    }

    $query_alunos .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT ".$dados_requisicao['start'].",".$dados_requisicao['length'];

    if(!empty($dados_requisicao['search']['value'])) {
        $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";

        $param = [$valor_pesq, $valor_pesq, $valor_pesq];
    }else{
        $param = [];
    }

    $result_alunos = $conexao->pegarRegistros($query_alunos,$param);

    $dados = [];
    // Ler os registros retornado do banco de dados e atribuir no array 
    foreach($result_alunos as $row_alunos) {
        $registro = [];

        $registro[] = $row_alunos['id_aluno'];
        $registro[] = $row_alunos['nome'];
        $registro[] = $row_alunos['nascimento'];
        $registro[] = 
        "<form method='post' id='formExcluir' action='' style='padding:0;'>
            <input type='hidden' id='idExcluir' name='idExcluir' value=''>
            <a class='btn btn-success btn-circle ms-1' role='button' data-bs-toggle='tooltip' data-bss-tooltip='' id='detalhes' style='margin: 2px !important; background: rgb(24,188,156);width: 35px;height: 35px;font-size: 14px;border-color: rgb(24,188,156);' title='Ver Detalhes' onclick='detalhes({$row_alunos['id_aluno']}, 10)'><i class='fas fa-ellipsis-h text-white'></i></a>
            <a class='btn btn-warning btn-circle ms-1' role='button' data-bs-toggle='tooltip' data-bss-tooltip='' id='qrcode' style='margin: 2px !important; background: rgb(72,72,72);border-color: rgb(72,72,72);width: 35px;height: 35px;font-size: 14px;' title='Gerar QRCode' href=identificador.php?id={$row_alunos['id_aluno']}&tipo=1><i class='fas fa-qrcode text-white'></i></a>
            <a class='btn btn-info btn-circle ms-1' role='button' data-bs-toggle='tooltip' data-bss-tooltip='' id='alterar' style='margin: 2px !important; background: #4e98eb;border-color: #4e98eb;width: 35px;height: 35px;font-size: 14px;' title='Editar Registro' onclick='alterar({$row_alunos['id_aluno']})'><i class='fas fa-pencil-alt text-white'></i></a>
            <a class='btn btn-danger btn-circle ms-1' role='button' data-bs-toggle='tooltip' data-bss-tooltip='' id='excluir' style='margin: 2px !important; background: rgb(215,93,82);border-color: rgb(215,93,82);width: 35px;height: 35px;' title='Excluir Registro' onclick='excluir({$row_alunos['id_aluno']})'><i class='fas fa-trash text-white' style='font-size: 14px;'></i></a>
        </form>";
                                                                     

        $dados[] = $registro;
    }

    //Cria o array de informações a serem retornadas para o Javascript
    $resultado = [
        "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
        "recordsTotal" => intval($result_qnt_alunos['qnt_alunos']), // Quantidade de registros que há no banco de dados
        "recordsFiltered" => intval($result_qnt_alunos['qnt_alunos']), // Total de registros quando houver pesquisa
        "data" => $dados // Array de dados com os registros retornados da tabela usuarios
    ];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);
