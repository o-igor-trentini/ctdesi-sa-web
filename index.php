<?php
    date_default_timezone_set('America/Sao_Paulo');
    
    require_once 'application/class/BancoDeDados.php';
    $conexao = new BancoDeDados;

    $sql = 'SELECT 
                id_emprestimo,
                DATEDIFF (
                    now(), 
                    DATE_ADD(data_retirada, INTERVAL (SELECT qtd_dias_devolucao FROM configuracoes WHERE id_configuracao = 1) DAY)
                ) AS dias_atrasados 
            FROM emprestimos 
            WHERE 
                DATEDIFF (
                    now(), 
                    DATE_ADD(data_retirada, INTERVAL (SELECT qtd_dias_devolucao FROM configuracoes WHERE id_configuracao = 1) DAY)
                    ) > 0
            ';

        $dados = $conexao->pegarRegistros($sql);
        if (!empty($dados)) {
            foreach ($dados as $dado) {
                $sql = 'UPDATE emprestimos 
                        SET multa = ? * (SELECT valor_multa FROM configuracoes WHERE id_configuracao = 1) 
                        WHERE 
                            situacao = 1 
                            AND id_emprestimo = ?
                        ';

                $params = [$dado['dias_atrasados'], $dado['id_emprestimo']];
                $conexao->atualizarRegistro($sql, $params);
            }
        }

    session_start();
	session_destroy();
	unset($_SESSION);
?>

<!DOCTYPE html>
<html lang="pt-br" style="background: rgb(40, 45, 50) !important;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Início - Biblioteca</title>

    <?php 
        include_once 'application/links/icones/icone_pagina.php';
        include_once 'application/links/css-js-pagina/index_emprestimo_devolucao/index_emprestimo_devolucao.php';  
    ?>    
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="72">
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-secondary text-uppercase" id="mainNav" style="background: rgb(40, 45, 50) !important;">
        <div class="container"><a class="navbar-brand" href="#page-top">E.E.B.N. Rosina nardi</a><button data-bs-toggle="collapse" data-bs-target="#navbarResponsive" class="navbar-toggler text-white bg-primary navbar-toggler-right text-uppercase rounded" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#login" style="font-size: 24px;">login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="text-center text-white bg-primary masthead" style="background: rgb(232,237,236);padding: 170px 0px 96px;height: 1000px;width: 100%;">
        <div class="container" data-aos="zoom-in-down" data-aos-duration="550" style="height: 550px;"><img class="img-fluid d-block mx-auto mb-5" src="assetsEmprestimo/img/portfolio/open-book%20(2).png" style="width: 200px;height: 200px;">
            <h1 style="font-size: 40px;">Biblioteca</h1>
            <div style="height: 4px;background: #ffffff;width: 25%;margin-right: 37.5%;margin-left: 37.5%;margin-top: 12px;margin-bottom: 12px;"></div>
                <a class="btn btn-outline-light btn-xl" role="button" href="identificarPessoa.php" style="margin: 10px;width: 300px;"><i class="fas fa-book me-2"></i><span>Retirar / Devolver</span></a>
            <div style="height: 4px;background: #ffffff;width: 25%;margin-right: 37.5%;margin-left: 37.5%;margin-top: 12px;margin-bottom: 12px;"></div>
        </div>
    </header>
    <section id="login" style="background: rgb(241,247,252);height: 850px;width: 100%;padding: 140px 0px;">
        <div class="container" data-aos="zoom-in-down" data-aos-duration="550">
            <h2 class="text-uppercase text-center text-secondary mb-0">login</h2>
            <div style="height: 4px;background: rgb(44,62,80);width: 25%;margin-right: 37.5%;margin-left: 37.5%;margin-top: 40px;margin-bottom: 48px;color: rgb(44,62,80);"></div>
        </div>
        <section class="login-clean" style="background: rgb(241, 247, 252);height: 600;width: 100%;padding: 10px 0px 140px 0px;">
            <form data-aos="zoom-in-down" data-aos-duration="550" method="post" ACTION="application/login.php">
                <div class="illustration"><i class="icon ion-ios-navigate" style="color: rgb(24,188,156);background: #ffffff;border-color: rgb(24,188,156);"></i></div>
                <div class="mb-3"><input class="form-control" type="text" name="txtUsuario" id="txtUsuario" placeholder="Usuário" style="border-bottom-width: 2px;" autocomplete="off"></div>
                <div class="mb-3"><input class="form-control" type="password" name="txtSenha" id="txtSenha" placeholder="Senha" style="border-bottom-width: 2px;"></div>
                <div class="mb-3"><button class="btn btn-primary" type="submit" style="width: 100%;margin: 0;background: rgb(24,188,156);font-family: Allerta, sans-serif;">ENTRAR</button></div>
            </form>
        </section>
        <footer class="footer-dark" style="background: rgb(40, 45, 50);height: 250px;width: 100%;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 item text" style="width: 100%;">
                        <h3 style="text-align: center;">SENAI - CONCÓRDIA/SC</h3>
                        <p style="text-align: center;color: rgb(172,180,186);opacity: 1;">Site desenvolvido pela turma de Desenvolvimento de Sistemas do SENAI de Concórdia/SC no ano de 2021.</p>
                    </div>
                </div>
            </div>
            <p style="text-align: center;color: rgb(240, 249, 255);"></p>
            <p style="text-align: center;color: rgb(172,180,186);width: 90%;margin: 0px 5% 5%;">Igor Trentini | Kaue Thums © 2021<br></p>
        </footer>
    </section>

    <div class="modal fade" id="modal-alerta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color: rgb(61,61,61);">Alerta</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body" style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 18px;'>

                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Modal
        $(document).ready(function(){
            <?php
                If (isset($_GET['erro']) && $_GET['erro'] == '1') {
                    echo "$('#modal-body').html('<p>Existem campos em branco.<br><br>Verifique!</p>');";
                    echo "$('#modal-alerta').modal('show');";
                    echo "var fecharModal = setTimeout(function() {
                        $('#modal-alerta').modal('hide');
                        $('#txtUsuario').focus();
                    }, 2500);";
                } elseIf (isset($_GET['erro']) && $_GET['erro'] == '2') {
                    echo "$('#modal-body').html('<p>Usuário não encontrado!</p>');";
                    echo "$('#modal-alerta').modal('show');";
                    echo "var fecharModal = setTimeout(function() {
                        $('#modal-alerta').modal('hide');
                        $('#txtUsuario').focus();
                    }, 2500);";
                } elseIf (isset($_GET['erro']) && $_GET['erro'] == '3' && isset($_GET['usuario'])) {
                    echo "document.getElementById('txtUsuario').value = '{$_GET['usuario']}';";
                    echo "$('#modal-body').html('<p>Senha incorreta!</p>');";
                    echo "$('#modal-alerta').modal('show');";
                    echo "var fecharModal = setTimeout(function() {
                        $('#modal-alerta').modal('hide');
                        $('#txtSenha').focus();
                    }, 2500);";

                    $foco = 'senha';
                } elseIf (isset($_GET['sucesso']) && $_GET['sucesso'] == '1') {
                    echo "$('#modal-body').html('<p>Livro retirado com sucesso!</p>');";
                    echo "$('#modal-alerta').modal('show');";
                    echo "var fecharModal = setTimeout(function() {
                        $('#modal-alerta').modal('hide');
                        $('#btnAcao').focus();
                    }, 3500);";
                } elseIf (isset($_GET['sucesso']) && $_GET['sucesso'] == '2') {
                    echo "$('#modal-body').html('<p>Livro renovado com sucesso!<br><br>Data estimada para devolução: {$_GET['data']}</p>');";
                    echo "$('#modal-alerta').modal('show');";
                    echo "var fecharModal = setTimeout(function() {
                        $('#modal-alerta').modal('hide');
                        $('#btnAcao').focus();
                    }, 5000);";
                } elseIf (isset($_GET['sucesso']) && $_GET['sucesso'] == '3') {
                    echo "$('#modal-body').html('<p>Livro devolvido com sucesso!</p>');";
                    echo "$('#modal-alerta').modal('show');";
                    echo "var fecharModal = setTimeout(function() {
                        $('#modal-alerta').modal('hide');
                        $('#btnAcao').focus();
                    }, 3500);";
                }
            ?>
        });
    </script>
</body>
</html>