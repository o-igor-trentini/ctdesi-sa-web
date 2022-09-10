<?php
    session_start();

    if (empty($_SESSION['id_pessoa'])) {
        header ("LOCATION: identificarPessoa.php");
        exit;
    } else if (empty($_SESSION['id_livro'])) {
        header ("LOCATION: identificarLivro.php");
        exit;
    }

    if ($_SESSION['acao'] == 'devolver') {
        $caminho = 'application/emprestimo_atualizar.php';
    } else {
        $caminho = 'application/emprestimo_inserir.php';
    }

    $primeiroNome = '';
    for ($i = 0; $i < strlen($_SESSION['nome']); $i++) {
        if (substr($_SESSION['nome'], $i, 1) != ' ') {
            $primeiroNome = $primeiroNome . substr($_SESSION['nome'], $i, 1);
        } else {
            break;
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br" style="width: 100%;height: 100%;background: rgb(24,188,156) !important;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo ucfirst("{$_SESSION['acao']}"); ?> - Biblioteca</title>

    <?php 
        include_once 'application/links/icones/icone_pagina.php';
        include_once 'application/links/css-js-pagina/index_emprestimo_devolucao/index_emprestimo_devolucao.php';  
    ?>  
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="72" style="width: 100%;height: 100%;">
    <header class="text-center text-white bg-primary masthead" style="background: rgb(232,237,236);padding: 170px 0px 96px;height: 100%;width: 100%;">
        <div class="container" data-aos="zoom-in-down" data-aos-duration="550" style="height: 550px;">

            <?php
                require_once 'application/class/BancoDeDados.php';
                $conexao = new BancoDeDados;
                $sql = 'SELECT multa FROM emprestimos WHERE situacao = 1 AND id_'. $_SESSION['tipo_pessoa'][0] .' = ?';
                $params = [$_SESSION['id_pessoa']];
                $dados = $conexao->pegarRegistro($sql, $params);

                if ($_SESSION['acao'] == 'devolver' && $dados['multa'] > 0) {
                    $valor_multa = number_format($dados['multa'], 2, "," ,".");
                    echo "<h1 style='font-size: 60px;'>{$primeiroNome}, você precisa pagar a multa para devolver o livro!</h1>
                          <h2 style='font-size: 60px;'>R\$ {$valor_multa}<br><br></h2>
                          <h1 style='font-size: 40px;'>Consulte um responsável pela biblioteca.</h1>";
                    echo "<div style='height: 4px;background: #ffffff;width: 25%;margin-right: 37.5%;margin-left: 37.5%;margin-top: 20px;margin-bottom: 12px;'></div>
                    <h2 class='font-weight-light mb-0'></h2><a class='btn btn-outline-light btn-xl' href='index.php' style='margin: 10px;width: 300px;'>
                    <i class='fa fa-arrow-circle-left me-2' style='font-size: 21px;'></i><span>Voltar</span></a>
                    <div style='height: 4px;background: #ffffff;width: 25%;margin-right: 37.5%;margin-left: 37.5%;margin-top: 20px;margin-bottom: 12px;'></div>";
                } else {
                    echo "<h1 style='font-size: 40px;'>{$primeiroNome}, você realmente deseja {$_SESSION['acao']} &nbsp;o livro \"{$_SESSION['titulo']}\"?</h1>";

                    date_default_timezone_set('America/Sao_Paulo');

                    $sql = 'SELECT qtd_dias_devolucao AS qtd_dias FROM configuracoes';
                    $dados = $conexao->pegarRegistro($sql);
                    $dataDevolucao = date('d/m/Y', strtotime("+{$dados['qtd_dias']} days"));
                    
                    echo "<h1 style='font-size: 22px;'>Data estimada para devolução: {$dataDevolucao}</h1>";

                    echo "<div style='height: 4px;background: #ffffff;width: 25%;margin-right: 37.5%;margin-left: 37.5%;margin-top: 20px;margin-bottom: 12px;'></div>
                          <a class='btn btn-outline-light btn-xl' id='confirmar' href={$caminho} style='margin: 10px;width: 300px;background: #ffffff;color: rgb(34,34,34);'><i class='far fa-check-square me-2'></i><span>Confirmar</span></a>";
                        if ($_SESSION['acao'] == 'devolver') {
                            echo "<h2 class=font-weight-light mb-0'></h2><a class='btn btn-outline-light btn-xl' id='confirmar' href='{$caminho}?renovar=1' style='margin: 10px;width: 300px;background: #ffffff;color: rgb(34,34,34);'><i class='far fa-share-square me-2'></i><span>Renovar</span></a>";
                        }
                        
                    echo "<h2 class='font-weight-light mb-0' onclick='cancelar()'></h2>
                    <a class='btn btn-outline-light btn-xl' href='#' style='margin: 10px;width: 300px;' onclick='cancelar()'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 24 24' fill='none' class='me-2' style='font-size: 21px;'>
                    <path d='M10 14L12 12M12 12L14 10M12 12L10 10M12 12L14 14M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'></path>
                    </svg><span>Cancelar</span></a>";
                }
            ?>
        </div>
    </header>

    <script src="vendor/jquery-3.6.0/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="assetsEmprestimo/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="assetsEmprestimo/js/script.min.js"></script>
    
    <div class="modal fade" id="modal-cancelar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="background: #ffffff;color: rgb(50,50,50);">Alerta</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="background: #ffffff;color: rgb(50,50,50);">Realmente deseja cancelar?</p>
                </div>
                <div class="modal-footer"><a class="btn btn-light" id="cancelar" role="button" data-bs-dismiss="modal" style="color: rgb(51,51,51);background: rgb(187,187,187);border-width: 0px;width: 30%;">Cancelar</a><a class="btn btn-primary" role="button" style="border-width: 0px;width: 30%;" data-bs-dismiss="modal" onclick="voltar()">Confirmar</a></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function cancelar() {
            $(document).ready(function(){
                $('#modal-cancelar').modal('show');
            });
        }
        
        function voltar() {
            window.location.href = "index.php";
        }
    </script>
</body>
</html>