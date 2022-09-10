<?php
    require_once 'class/BancoDeDados.php';

    // Conexão 
    $conexao = new BancoDeDados;

    $dados_requisicao = $_REQUEST;

    $colunas = [
        0 => 'id_genero',
        1 => 'genero',
        2 => 'id_genero'
    ];
    
    $query_qnt_generos = "SELECT COUNT(id_genero) AS qnt_generos FROM generos";

    // Acessa o IF quando ha paramentros de pesquisa   
    if(!empty($dados_requisicao['search']['value'])) {
        $query_qnt_generos .= " WHERE id_genero LIKE ? ";
        $query_qnt_generos .= " OR genero LIKE ? ";
    }

    $valor_pesq = "";
    $param = [];
    // Acessa o IF quando ha paramentros de pesquisa   
    if(!empty($dados_requisicao['search']['value'])) {
        $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";

        $param = [$valor_pesq, $valor_pesq];
    }

    $result_qnt_generos = $conexao->pegarRegistro($query_qnt_generos,$param);

    $query_generos = "SELECT id_genero, genero FROM generos ";

    if(!empty($dados_requisicao['search']['value'])) {
        $query_generos .= " WHERE id_genero LIKE ? ";
        $query_generos .= " OR genero LIKE ? ";
    }

    $query_generos .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT ".$dados_requisicao['start'].",".$dados_requisicao['length'];

    if(!empty($dados_requisicao['search']['value'])) {
        $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";

        $param = [$valor_pesq, $valor_pesq];
    }else{
        $param = [];
    }

    $result_generos = $conexao->pegarRegistros($query_generos,$param);

    $dados = [];
    // Ler os registros retornado do banco de dados e atribuir no array 
    foreach($result_generos as $row_generos) {
        $registro = [];

        $registro[] = $row_generos['id_genero'];
        $registro[] = $row_generos['genero'];
        $registro[] = 
        "<form method='post' id='formExcluir' action='' style='padding:0;'>
            <input type='hidden' id='idExcluir' name='idExcluir' value=''>
            <a class='btn btn-info btn-circle ms-1' role='button' data-bs-toggle='tooltip' data-bss-tooltip='' id='alterar' style='margin: 2px !important; background: #4e98eb;border-color: #4e98eb;width: 35px;height: 35px;font-size: 14px;' title='Editar Registro' onclick='alterar({$row_generos['id_genero']})'><i class='fas fa-pencil-alt text-white'></i></a>
            <a class='btn btn-danger btn-circle ms-1' role='button' data-bs-toggle='tooltip' data-bss-tooltip='' id='excluir' style='margin: 2px !important; background: rgb(215,93,82);border-color: rgb(215,93,82);width: 35px;height: 35px;' title='Excluir Registro' onclick='excluir({$row_generos['id_genero']})'><i class='fas fa-trash text-white' style='font-size: 14px;'></i></a>
        </form>";
                                                                     

        $dados[] = $registro;
    }

    //Cria o array de informações a serem retornadas para o Javascript
    $resultado = [
        "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
        "recordsTotal" => intval($result_qnt_generos['qnt_generos']), // Quantidade de registros que há no banco de dados
        "recordsFiltered" => intval($result_qnt_generos['qnt_generos']), // Total de registros quando houver pesquisa
        "data" => $dados // Array de dados com os registros retornados da tabela usuarios
    ];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);
