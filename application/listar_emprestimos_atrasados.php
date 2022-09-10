<?php
    require_once 'class/BancoDeDados.php';

    // Conexão 
    $conexao = new BancoDeDados;

    $dados_requisicao = $_REQUEST;

    $colunas = [
        0 => 'id_emprestimo',
        1 => 'data_retirada',
        2 => 'hora_retirada',
        3 => 'livro',
        4 => 'multa',
        5 => 'pessoa',
        6 => 'id_emprestimo'
    ];
    
    $query_qnt_emprestimos = "
        SELECT 
            COUNT(a.id_emprestimo) AS qnt_emprestimos 
        FROM 
            emprestimos AS a
        LEFT JOIN
            livros AS b ON a.id_livro = b.id_livro
        LEFT JOIN
            colaboradores AS c ON a.id_colaborador = c.id_colaborador
        LEFT JOIN
            alunos AS d ON a.id_aluno = d.id_aluno
        WHERE 
            (a.situacao=1 AND a.multa>0)";

    // Acessa o IF quando ha paramentros de pesquisa   
    if(!empty($dados_requisicao['search']['value'])) {
        $query_qnt_emprestimos .= " AND (a.id_emprestimo LIKE ? OR a.data_retirada LIKE ? OR a.multa LIKE ? OR a.hora_retirada LIKE ? OR b.titulo LIKE ? OR c.nome LIKE ? OR d.nome LIKE ?)";
    }

    $valor_pesq = "";
    $param = [];
    // Acessa o IF quando ha paramentros de pesquisa   
    if(!empty($dados_requisicao['search']['value'])) {
        $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";

        $param = [$valor_pesq, $valor_pesq, $valor_pesq, $valor_pesq, $valor_pesq, $valor_pesq, $valor_pesq];
    }

    $result_qnt_emprestimos = $conexao->pegarRegistro($query_qnt_emprestimos,$param);

    $query_emprestimos = "
    SELECT 
        a.id_emprestimo AS id_emprestimo,
        a.data_retirada AS data_retirada,
        a.hora_retirada AS hora_retirada,
        b.titulo AS livro,
        a.multa,
        CASE WHEN c.nome != NULL THEN c.nome ELSE d.nome END AS pessoa
    FROM 
        emprestimos AS a
    LEFT JOIN
        livros AS b ON a.id_livro = b.id_livro
    LEFT JOIN
        colaboradores AS c ON a.id_colaborador = c.id_colaborador
    LEFT JOIN
        alunos AS d ON a.id_aluno = d.id_aluno
    WHERE 
        (a.situacao=1 AND a.multa>0)";

    if(!empty($dados_requisicao['search']['value'])) {
        $query_emprestimos .= " AND (a.id_emprestimo LIKE ? OR a.data_retirada LIKE ? OR a.multa LIKE ? OR a.hora_retirada LIKE ? OR b.titulo LIKE ? OR c.nome LIKE ? OR d.nome LIKE ?)";
    }

    $query_emprestimos .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT ".$dados_requisicao['start'].",".$dados_requisicao['length'];

    if(!empty($dados_requisicao['search']['value'])) {
        $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";

        $param = [$valor_pesq, $valor_pesq, $valor_pesq, $valor_pesq, $valor_pesq, $valor_pesq, $valor_pesq];
    }else{
        $param = [];
    }

    $result_emprestimos = $conexao->pegarRegistros($query_emprestimos,$param);

    $dados = [];
    // Ler os registros retornado do banco de dados e atribuir no array 
    foreach($result_emprestimos as $row_emprestimos) {
        $registro = [];

        $registro[] = $row_emprestimos['id_emprestimo'];
        $registro[] = $row_emprestimos['data_retirada'];
        $registro[] = $row_emprestimos['hora_retirada'];
        $registro[] = $row_emprestimos['livro'];
        $registro[] = $row_emprestimos['multa'];
        $registro[] = $row_emprestimos['pessoa'];
        $registro[] = 
        "<form method='post' id='formFinalizar' action='' style='padding:0;'>
            <input type='hidden' id='idFinalizar' name='idFinalizar' value=''>
            <a class='btn btn-success btn-circle ms-1' role='button' data-bs-toggle='tooltip' data-bss-tooltip='' id='detalhes' style='margin: 2px !important; background: rgb(24,188,156);width: 35px;height: 35px;font-size: 14px;border-color: rgb(24,188,156);' title='Quitar Multa' onclick='quitar({$row_emprestimos['id_emprestimo']})'><i class='fas fa-dollar-sign text-white'></i></a>
        </form>";
                                                                     
        $dados[] = $registro;
    }

    //Cria o array de informações a serem retornadas para o Javascript
    $resultado = [
        "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
        "recordsTotal" => intval($result_qnt_emprestimos['qnt_emprestimos']), // Quantidade de registros que há no banco de dados
        "recordsFiltered" => intval($result_qnt_emprestimos['qnt_emprestimos']), // Total de registros quando houver pesquisa
        "data" => $dados // Array de dados com os registros retornados da tabela usuarios
    ];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);
