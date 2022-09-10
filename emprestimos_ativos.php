<?php

    //-------------------------------------------------------------------
    //   ######## VALIDANDO E RECEBENDO OS DADOS DA SESSÃO ##########
    //-------------------------------------------------------------------
    session_start();
    if(!isset($_SESSION['logado'])){
        header('LOCATION: index.php');
        exit;
    }

    $id_colaborador = isset($_SESSION['id_colaborador']) ? $_SESSION['id_colaborador'] : '';
    $nome_colaboradorInteiro = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
    $tipo_colaboradorNumero = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : '';
    //-------------------------------------------------------------------

    //-------------------------------------------------------------------
    //   ######## VERIFICANDO O TIPO DE USUÁRIO ##########
    //-------------------------------------------------------------------
    if($tipo_colaboradorNumero == 1){
        $tipo_colaboradorNome = 'Comum';
    }else if ($tipo_colaboradorNumero == 2){
        $tipo_colaboradorNome = 'Administrador';
    }
    $nome_colaborador = '';
    for ($i = 0; $i < strlen($nome_colaboradorInteiro); $i++) {
        if (substr($nome_colaboradorInteiro, $i, 1) != ' ') {
            $nome_colaborador = $nome_colaborador . substr($nome_colaboradorInteiro, $i, 1);
        } else {
            break;
        }
    }
    //-------------------------------------------------------------------

    ######## ID-FINALIZAR REGISTRO ##########
    $id = isset($_POST['idFinalizar']) ? $_POST['idFinalizar'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sistema - Biblioteca</title>

    <!-- ------------------------------------------------------------------- -->
       <!-- ######## IMPORTANDO OS DADOS(CSS, ICONE, JS) ########## -->
    <!-- ------------------------------------------------------------------- -->
    <?php 
        include_once 'application/links/icones/icone_pagina.php';
        include_once 'application/links/css-js-pagina/forms/forms.php';
    ?> 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- ------------------------------------------------------------------- -->

</head>

<body id="page-top" >
    <!-- ------------------------------------------------------------------- -->
        <!-- ################# MENU #################### -->
    <!-- ------------------------------------------------------------------- -->
    <div class="botao">
        <span class="fas fa-bars"></span>
    </div>
    <nav class="barra">
        <div class="text">
            MENU
        </div>
        <ul>
            <li class=""><a id='menu' href="livros.php"><i class="fas fa-book"></i>LIVROS</a></li>
            <li class=""><a id='menu' href="alunos.php"><i class="fas fa-graduation-cap"></i>ALUNOS</a></li>
            <li class=""><a id='menu' href="colaboradores.php"><i class="fas fa-user-cog"></i></i>COLABORADORES</a></li>
            <li class='ativo'>
                <a href="#" class="feat-btn ativo"><i class="fas fa-qrcode"></i>EMPRÉSTIMOS
                    <span class="fas fa-caret-up first"></span>
                </a>
                <ul class="feat-show">
                    <li class='ativo'><a href="emprestimos_ativos.php">ATIVOS</a></li>
                    <li class=''><a href="emprestimos_atrasados.php">ATRASADOS</a></li>
                </ul>
            </li>
            <?php
                if($tipo_colaboradorNumero == 2){
                    echo "<li class=''><a id='menu' href='configuracoes.php'><i class='fas fa-cogs'></i></i></i>CONFIGURAÇÕES</a></li>";
                }
            ?>
        </ul>
    </nav>

    <div class="content">
        <div id="wrapper">
            <nav class='navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0' style='color: rgb(24,188,156);width: 100px!important;background: rgb(31, 31, 31) !important;'>
            </nav>
            <div class="d-flex flex-column" id="content-wrapper">
                <div id="content" style="background: #f9f9f9;width: 100%;">
                    <!-- ------------------------------------------------------------------- -->
                            <!-- ################# NAVBAR #################### -->
                    <!-- ------------------------------------------------------------------- -->
                    <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                        <div class="container-fluid">
                            
                            <span style="font-size: 25px;width: 100%;font-family: Allerta, sans-serif;color: rgb(53,53,54);">SISTEMA BIBLIOTECA</span>
                                    
                            <?php
                                echo "<div class='container' style='width: 21em !important; text-align: right; padding: 0px !important;'>
                                            <i class='fas fa-user' style='font-size: 23px;margin-right: 9px;color: rgb(89,89,89);'></i><span style='color: rgb(89,89,89);'>{$nome_colaborador}</span>
                                        </div>";
                            ?>

                            <div class="d-none d-sm-block topbar-divider"></div>
                            
                            <a href="application/logout.php" style="color: rgb(89,89,89);">Sair</a>
                        </div>
                    </nav>

                    <section class="register-photo" style="color: rgb(255,255,255);background: #f9f9f9;padding: 25px;padding-top: 25px;width: 100%;">
                        <!-- ------------------------------------------------------------------- -->
                            <!-- ################# TÍTULO DA PÁGINA #################### -->
                        <!-- ------------------------------------------------------------------- -->
                        <section data-aos="zoom-in" data-aos-duration="500" class="register-photo" style="color: rgb(133, 135, 150);background: rgb(255,255,255);margin: 0px;box-shadow: 0px 0px 4px rgb(114,114,125);border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom-right-radius: 3px;border-bottom-left-radius: 3px;margin-top: 0px;width: 100%;padding-top: 10px;padding-bottom: 10px;padding-right: 2%;padding-left: 2%;">
                            <div class="container" style="width: 100%;padding: 0;margin-top: 0;">
                                <div class="intro">
                                    <h2 class="text-center" style="color: rgb(50,50,50);font-family: Nunito, sans-serif;border-color: rgb(0,0,0);"><strong>EMPRÉSTIMOS ATIVOS</strong></h2>
                                </div>
                            </div>
                        </section>
                        
                        <!-- ------------------------------------------------------------------- -->
                        <!-- ################# LISTAGEM DE EMPRÉSTIMOS ATRASADOS #################### -->
                        <!-- ------------------------------------------------------------------- -->
                        <section data-aos="zoom-in-down" data-aos-duration="500" class="register-photo" style="min-height:700px; color: rgb(133, 135, 150);background: rgb(255,255,255);margin: 0px;box-shadow: 0px 0px 4px rgb(114,114,125);border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom-right-radius: 3px;border-bottom-left-radius: 3px;margin-top: 30px;width: 100%;padding-top: 20px;padding-bottom: 20px;">
                            <div class="form-container"></div>
                            <section class="article-list">
                                <div class="container">
                                    <div style='position:relative; width:100%; height:80px;'>
                                        <div class="intro" style='position:absolute;left:0;right:0;margin:auto;'>
                                            <h2 class="text-center" style="color: rgb(50,50,50);font-family: Nunito, sans-serif;padding: 5px;margin-bottom: 20px;">LISTAGEM</h2>
                                        </div>
                                    </div>    
                                    
                                    <div style='width: 100%;height: 1px;border-width: 2px;border-color: rgb(17,17,17);border-top-width: 1px;border-top-color: rgb(0,0,0);box-shadow: 0px 0px 0px;background: #929292;margin-bottom: 2%;'></div>

                                    <div class="row articles" style="margin: 0!important;padding:0!important;padding-bottom: 40px;">
                                        <div class="col" style="margin: 0!important;padding:0!important;">
                                            <div class="table-responsive tabelaEmprestimos">
                                                <table 
                                                    class='table listar-emprestimos' 
                                                    id='listar-emprestimos'
                                                    style='width: 100%; min-width: 900px; overflow: auto;'
                                                >
                                                    <thead style='font-size:18px; color: #fff !important;'>
                                                        <tr>
                                                            <th style='width: 5% !important;'>#</th>
                                                            <th style='width: 15% !important;'>Data Retirada</th>
                                                            <th style='width: 15% !important;'>Hora Ret.</th>
                                                            <th style='width: 30% !important;'>Livro</th>
                                                            <th style='width: 25% !important;'>Pessoa</th>
                                                            <th style='width: 10% !important;'></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </section>

                        <!-- Botão voltar ao topo -->
                        <a class='border rounded d-inline scroll-to-top' href='#page-top'><i class='fas fa-angle-up'></i></a>
                    </section>
                </div>

                <!-- DADOS DESENVOLVIMENTO -->
                <footer class="footer-dark" style="height: 0;width: 100%;">
                    <p style="text-align: center;color: rgb(172,180,186);">Igor Trentini | Kaue Thums © 2021<br></p>
                </footer>
            </div>
        </div>
    </div>
    <!-- ################# RETORNO AJAX ##################### -->
    <div id='voltaDados'></div>
    <!-- ------------------------------------------------------------------- -->

    <!-- ------------------------------------------------------------------- -->
         <!-- ################# INCLUINDO FUNÇÕES ##################### -->
    <!-- ------------------------------------------------------------------- -->
    <script src='application/funcoes/funcoes.js' type='text/javascript'></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> 
    <?php include 'application/modais.php';?>
    <!-- ------------------------------------------------------------------- -->
    

    <!-- ------------------------------------------------------------------- -->
         <!-- ################# CSS TABELA ##################### -->
    <!-- ------------------------------------------------------------------- -->
    <style>
        table thead tr{
            background-color:#696969;
        }
        
        #formFinalizar{
            background-color: transparent;
        }

        tbody tr:nth-child(even) {
            background-color: #DCDCDC;
        }
      
    </style>
    <!-- ------------------------------------------------------------------- -->

        
    <script type='text/javascript'>
         $(document).ready(function() {
            $('#listar-emprestimos').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "application/listar_emprestimos_ativos.php",
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
                }
            });
        });
        //-------------------------------------------------------------------
        //     ################# MENU #####################
        //-------------------------------------------------------------------
        $('.botao').click(function(){
           $(this).toggleClass("click");
           $('.barra').toggleClass("show");
        });
        $('.feat-btn').click(function(){
             $('nav ul .feat-show').toggleClass("show");
             $('nav ul .first').toggleClass("rotate");
        });
        $('.serv-btn').click(function(){
             $('nav ul .serv-show').toggleClass("show1");
             $('nav ul .second').toggleClass("rotate");
        });
        //-------------------------------------------------------------------

        //-------------------------------------------------------------------
        //     ################# LIMITADOR TABLEA #####################
        //-------------------------------------------------------------------
        function tableLimit(){
            var val = document.getElementById('slctFiltro').value;
            $('.listar-emprestimos tbody > tr').show();
            if(val != 'todos'){
                $('.listar-emprestimos tbody > tr').slice(val).hide();
            }
        }
        window.onload = tableLimit;
        // ------------------------------------------------------------------


        //-------------------------------------------------------------------
        // ################# CAHAMANDO MODAL RESULTADO #####################
        //-------------------------------------------------------------------
        <?php
            $resultado = isset($_GET['resultado']) ? $_GET['resultado'] : '';
            if(!empty($resultado)){
                echo "chamarModalResult(".$resultado.")";
            }
        ?>
        //-------------------------------------------------------------------


        //-------------------------------------------------------------------
        // ################# EXCLUIR REGISTRO #####################
        //-------------------------------------------------------------------
        function finalizar(id){
            document.getElementById('idFinalizar').value = id
            $('#modal-finalizar').modal('show');
        }
        function finalizarRegistro() {
            $('#formFinalizar').submit();
        }
        //-------------------------------------------------------------------

    </script>
    <!-- ------------------------------------------------------------------- -->
    <!-- ################# FINALIZANDO EMPRÉSTIMO ##################### -->
    <!-- ------------------------------------------------------------------- -->
    <?php
         // FINALIZANDO EMPRESTIMO
         if(!empty($id)){
            date_default_timezone_set('America/Sao_Paulo');
            require_once 'application/class/BancoDeDados.php';
            $conexao = new BancoDeDados;
            $sql = 'UPDATE emprestimos SET situacao=0,data_devolucao=?,hora_devolucao=? WHERE id_emprestimo=?';
            $param = [date('Y/m/d'), date('H:i:s'), $id];

            if ($conexao->atualizarRegistro($sql, $param)){
                echo "<script>window.location.href = 'emprestimos_ativos.php?resultado=10';</script>";
            }else {
                echo "<script>window.location.href = 'emprestimos_ativos.php?resultado=11';</script>";
            }
        } 
    ?>
</body>
</html>