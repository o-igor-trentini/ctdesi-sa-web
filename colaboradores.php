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
    if($tipo_colaboradorNumero != 2){
        header('LOCATION: livros.php');
        exit;
    }

    $nome_colaborador = '';
    for ($i = 0; $i < strlen($nome_colaboradorInteiro); $i++) {
        if (substr($nome_colaboradorInteiro, $i, 1) != ' ') {
            $nome_colaborador = $nome_colaborador . substr($nome_colaboradorInteiro, $i, 1);
        } else {
            break;
        }
    }

    if($tipo_colaboradorNumero == 1){
        $tipo_colaboradorNome = 'Comum';
    }else if ($tipo_colaboradorNumero == 2){
        $tipo_colaboradorNome = 'Administrador';
    }
    //-------------------------------------------------------------------

    ######## ID-EXCLUIR REGISTRO ##########
    $id = isset($_POST['idExcluir']) ? $_POST['idExcluir'] : ''; 
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
            <li class="ativo"><a id='menu' href="colaboradores.php"><i class="fas fa-user-cog"></i></i>COLABORADORES</a></li>
            <li class=''>
                <a href="#" class="feat-btn ativo"><i class="fas fa-qrcode"></i>EMPRÉSTIMOS
                    <span class="fas fa-caret-up first"></span>
                </a>
                <ul class="feat-show">
                    <li class=''><a href="emprestimos_ativos.php">ATIVOS</a></li>
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
                                <h2 class="text-center" style="color: rgb(50,50,50);font-family: Nunito, sans-serif;"><strong>COLABORADORES</strong></h2>
                            </div>
                        </div>
                    </section>
                    
                    <!-- ------------------------------------------------------------------- -->
                    <!-- ################# LISTAGEM DE COLABORADORES #################### -->
                    <!-- ------------------------------------------------------------------- -->
                    <section data-aos="zoom-in-down" data-aos-duration="500" class="register-photo" style="min-height:700px;color: rgb(133, 135, 150);background: rgb(255,255,255);margin: 0px;box-shadow: 0px 0px 4px rgb(114,114,125);border-top-left-radius: 3px;border-top-right-radius: 3px;border-bottom-right-radius: 3px;border-bottom-left-radius: 3px;margin-top: 30px;width: 100%;padding-top: 20px;padding-bottom: 20px;">
                        <div class="form-container"></div>
                        <section class="article-list">
                            <div class="container">
                                <div style='position:relative; width:100%; height:80px;'>
                                    <div class="intro" style='position:absolute;left:0;right:0;margin:auto;'>
                                        <h2 class="text-center" style="color: rgb(50,50,50);font-family: Nunito, sans-serif;padding: 5px;margin-bottom: 20px;">LISTAGEM</h2>
                                    </div>
                                    <a class='btn btn-success btn-circle ms-1' role='button' data-bs-toggle='tooltip' data-bss-tooltip='' id='novo' style='right:0;margin:auto;margin: 2px !important; background: rgb(24,188,156);width: 50px;height: 50px;font-size: 14px;border-color: rgb(24,188,156);position:absolute;' title='Novo Colaborador' onclick="abrirForm()"><i class='fa fa-plus' style='color: #fff;'></i></a>
                                </div>    
                                
                                <div style='width: 100%;height: 1px;border-width: 2px;border-color: rgb(17,17,17);border-top-width: 1px;border-top-color: rgb(0,0,0);box-shadow: 0px 0px 0px;background: #929292;margin-bottom: 2%;'></div>

                                <div class="row articles" style="margin: 0;padding:0!important;padding-bottom: 40px;">
                                    <div class="col" style="margin: 0!important;padding:0!important">
                                        <div class="table-responsive">
                                            <table 
                                                class='table listar-colaboradores'
                                                id='listar-colaboradores'
                                                style='width: 100%; min-width: 900px; overflow: auto;'
                                            >
                                                <thead>
                                                    <tr>
                                                        <th style='width: 5% !important'>#</th>
                                                        <th style='width: 30% !important'>Nome</th>
                                                        <th style='width: 20% !important'>Nascimento</th>
                                                        <th style='width: 20% !important'>Usuário</th>
                                                        <th style='width: 25% !important'></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </section>

                    <!-- ------------------------------------------------------------------- -->
                        <!-- ################# MODAL DETALHES #################### -->
                    <!-- ------------------------------------------------------------------- -->
                    <div class='modal fade modais' role='dialog' tabindex='-1' id='modal-detalhes'>
                        <div class='modal-dialog modal-xl' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h2 class='modal-title' id='tituloModal' style='color: rgb(40,40,40);font-family: Basic, sans-serif;'></h2>
                                    
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' href='#' onclick='fecharModal()'></button>
                                </div>

                                <div class='modal-body' id='modal-detalhes-body'>

                                <input type='hidden' id='idModal'>

                                <h5 class='modal-title' style='color: rgb(40,40,40); text-align: justify;'><u><b>CPF:</b></u> <p id='cpfModal' style='display:inline-block;'>...</p></h5><br>

                                <h5 class='modal-title' style='color: rgb(40,40,40); text-align: justify;'><u><b>Data de Nascimento:</b></u> <p id='nascimentoModal' style='display:inline-block;'>...</p></h5><br>
                            
                                <h5 class='modal-title' style='color: rgb(40,40,40); text-align: justify;'><u><b>Telefone:</b></u> <p id='telefoneModal' style='display:inline-block;'>...</p></h5><br>
                                
                                <h5 class='modal-title' style='color: rgb(40,40,40); text-align: justify;'><u><b>Sexo:</b></u> <p id='sexoModal' style='display:inline-block;'>...</p></h5><br>

                                <h5 class='modal-title' style='color: rgb(40,40,40); text-align: justify;'><u><b>Usuário:</b></u> <p id='usuarioModal' style='display:inline-block;'>...</p></h5><br>

                                <h5 class='modal-title' style='color: rgb(40,40,40); text-align: justify;'><u><b>Tipo:</b></u> <p id='tipoModal' style='display:inline-block;'>...</p></h5><br>
                                
                                <h5 class='modal-title' style='color: rgb(40,40,40); text-align: justify;'><u><b>Situação:</b></u> <p id='situacaoModal' style='display:inline-block;'>...</p></h5><br>

                                <!-- Linha -->
                                <div style="width: 100%; height: 1px; border-width: 2px; border-color: rgb(17,17,17); border-top-width: 1px;border-top-color: rgb(0,0,0);box-shadow: 0px 0px 0px;background: #929292;margin-bottom: 2%;"></div>
                                    
                                <h2 class='modal-title text-center' style='color: rgb(40,40,40);font-family: Basic, sans-serif;margin-bottom: 30px;'>Histórico de Locações</h2>
                                 
                                <div class="d-flex justify-content-center flex-wrap">
                                    <div class="col-sm-6" style="height: 95%;display:inline">
                                        <select autocomplete="off" class="bg-light form-select col-sm-3" name="slctFiltroModal" id="slctFiltroModal" onchange="detalhes(0, 0)" data-bs-toggle='tooltip' data-bss-tooltip='' title='Filtro' style="border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 0;border-bottom-left-radius: 0;height: 100%;width: 20%;margin-right: 79%;margin-left: 1%;border-top-width: 0px;border-right-width: 0px;border-bottom-width: 2px;border-left-width: 0;margin-left: 0px!important;" required>
                                            <option value="10">10x</option>
                                            <option value="50">50x</option>
                                            <option value="100">100x</option>
                                            <option value="0">Todos</option>
                                        </select>
                                    </div>
                                    <div class='col-sm-6'>
                                        <form class="d-flex justify-content-center flex-wrap" method="post" style="width: 100%;border-color: rgba(80,94,108,0);border-top-left-radius: 5px;border-top-right-radius: 5px;padding-bottom: 5px;padding-top: 5px;padding-right: 150px;padding-left: 150px;padding:0 !important;">
                                            <div class="col-sm-10" style="margin-bottom: 2%;height: 42px;">
                                                <input class="form-control pesquisar" type="text" style="border-bottom-width: 2px;border-top-left-radius: 5px;border-top-right-radius: 0px; border-bottom-left-radius: 0px !important; border-bottom-right-radius: 0px !important;width: 100%;" name="txtPesquisarModal" id='txtPesquisarModal' placeholder="Pesquisar..."  alt="listar-colaboradores-modal" autocomplete="off">
                                            </div>
                                            <div class="col-sm-2" style="height: 42px;">
                                                <button class="btn btn-primary py-0" type="button" style="border: none; width: 100%;margin: 0;height: 40px;border-top-left-radius: 0;border-bottom-left-radius: 0;background: rgb(24,188,156);" disabled><i class="fas fa-search" ></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class='table-responsive'>
                                    <table id='tabelaModal' class='table listar-colaboradores-modal'>
                                        <thead style='color: rgb(55,55,55);'>
                                            <tr style='background-color:#696969;color:#fff;'>
                                                <th>#</th>
                                                <th>Data Retirada</th>
                                                <th>Hora Ret.</th>
                                                <th>Data Devolução</th>
                                                <th>Hora Dev.</th>
                                                <th>Situação</th>
                                                <th>Livro</th>
                                            </tr>
                                        </thead>
                                        <tbody id='corpoTabelaModal' style='color: rgb(51,51,51);'>
                                            <!-- CONTEÚDO PREENCHIDO VIA AJAX -->
                                        </tbody>
                                    </table>
                                    
                                </div> 
                                    <h2 class='modal-title' id='tituloModal' style='color: rgb(40,40,40);font-family: Basic, sans-serif;'></h2>
                                </div>
                                <div class='modal-footer'><button class='btn btn-light' id='fechar' type='button' data-bs-dismiss='modal' style='background: rgb(179,179,179);width: 30%;' onclick = fecharModal()>Fechar</button></div>
                            </div>
                        </div>
                    </div>

                    <!-- ------------------------------------------------------------------- -->
                        <!-- ################# MODAL FORMULÁRIO #################### -->
                    <!-- ------------------------------------------------------------------- -->
                    <div class='modal fade modais' role='dialog' tabindex='-1' id='modal-form'>
                        <div class='modal-dialog modal-xl' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>

                                    <h2 class='modal-title' id='tituloModalForm' style='color: rgb(40,40,40);font-family: Basic, sans-serif; font-size: 1.6em;'></h2>
                                    
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' href='#' onclick='fecharModal()'></button>
                                </div>

                                <div class='modal-body' id='modal-detalhes-body'>

                                    <form class="d-flex justify-content-center flex-wrap formColaboradores" id='formColaboradores' method="post" style="width: 100%;border-color: rgba(80,94,108,0);border-top-left-radius: 5px;border-top-right-radius: 5px;" action='application/colaborador-alt-insert.php'>
                                        <!-- CAMPOS -->
                                        
                                        <input type="hidden" name="txtIdColaborador" placeholder="ID" id="txtIdColaborador">
                                        <input class="form-control" type="hidden" name="tipoEnvio" id="tipoEnvio" value='insert'>
                                        
                                        <div class="col-sm-12" style="margin-bottom: 2%;">
                                            <input autocomplete="off" class="form-control" type="text" data-bs-toggle='tooltip' data-bss-tooltip='' title='Nome*' style="width: 100%;border-bottom-width: 2px;border-top-left-radius: 5px;border-top-right-radius: 5px;" name="txtNome" placeholder="Nome" id="txtNome" required>
                                        </div>
                                        <div class="col-sm-6" style="height: 40px;margin-bottom: 2%;">
                                            <input autocomplete="off" class="form-control maskCPF" type="text" minlength="14" data-bs-toggle='tooltip' data-bss-tooltip='' title='CPF*' style="width: 99%;margin-right: 1%;margin-left: 0;background: rgb(247, 249, 252);border-bottom-width: 2px;border-top-left-radius: 5px;border-top-right-radius: 5px;" name="txtCpf" placeholder="CPF" id="txtCpf" required>
                                        </div>
                                        <div class="col-sm-6" style="height: 40px;margin-bottom: 2%;">
                                            <input autocomplete="off" class="form-control telefone" type="text" minlength="14" data-bs-toggle='tooltip' data-bss-tooltip='' title='Telefone*' style="width: 99%;padding: 0;margin-left: 1%;border-bottom-width: 2px;border-top-left-radius: 5px;border-top-right-radius: 5px;" placeholder="Telefone" name="txtTel" id="txtTel" required>
                                        </div>
                                        <div class="col-sm-6" style="height: 40px;margin-bottom: 2%;border-bottom-width: 2px;">
                                            <input autocomplete="off" class="form-control" type="date" data-bs-toggle='tooltip' data-bss-tooltip='' title='Data de Nascimento*' style="border-bottom-width: 2px;width: 99%;margin-right: 1%;border-top-left-radius: 5px;border-top-right-radius: 5px;" name="dtpNasc" id="dtpNasc" required>
                                        </div>
                                        <div class="col-sm-6" style="height: 40px;margin-bottom: 2%;">
                                            <select autocomplete="off" class="bg-light form-select" name="slctGenero" id="slctGenero" data-bs-toggle='tooltip' data-bss-tooltip='' title='Sexo*' style="border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 0;border-bottom-left-radius: 0;height: 100%;width: 99%;margin-left: 1%;border-top-width: 0px;border-right-width: 0px;border-bottom-width: 2px;border-left-width: 0;" required>
                                                <option value="M">Masculino</option>
                                                <option value="F">Feminino</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4" style="height: 40px;margin-bottom: 2%;">
                                            <input autocomplete="off" class="form-control" type="text" data-bs-toggle='tooltip' data-bss-tooltip='' title='Usuario*' style="width: 99%;padding: 0;border-bottom-width: 2px;border-top-left-radius: 5px;border-top-right-radius: 5px;margin-right: 1%;" placeholder="Usuário" name="txtUsuario" id="txtUsuario" required>
                                        </div>
                                        <div class="col-sm-4" style="height: 40px;margin-bottom: 2%;">
                                            <input autocomplete="off" class="form-control" type="text" data-bs-toggle='tooltip' data-bss-tooltip='' title='Senha*' style="width: 98%;padding: 0;margin-left: 1%;border-bottom-width: 2px;border-top-left-radius: 5px;border-top-right-radius: 5px;margin-right: 1%;" placeholder="Senha" name="txtSenha" id="txtSenha" required>
                                        </div>
                                        <div class="col-sm-4" style="height: 40px;margin-bottom: 2%;">
                                            <select autocomplete="off" class="bg-light form-select" name="slctTipo" id="slctTipo" data-bs-toggle='tooltip' data-bss-tooltip='' title='Tipo de Colaborador*' style="border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 0;border-bottom-left-radius: 0;height: 100%;width: 99%;margin-left: 1%;border-top-width: 0px;border-right-width: 0px;border-bottom-width: 2px;border-left-width: 0;" required>
                                                <option value="1">Comum</option>
                                                <option value="2">Administrador</option>
                                            </select>
                                        </div>
                                        <!-- Linha -->
                                        <div style="width: 100%;height: 1px;border-width: 2px;border-color: rgb(17,17,17);border-top-width: 1px;border-top-color: rgb(0,0,0);box-shadow: 0px 0px 0px;background: #929292;margin-bottom: 2%;"></div>
                                        
                                        <!-- Botões -->
                                        <div class='col-sm-6' style='height: 50px;margin-bottom: 2%;'>
                                            <button class='btn btn-secondary' type='reset' style='width: 99%;margin: 0;margin-right: 1%;height: 100%;font-family: Allerta, sans-serif;'>CANCELAR</button>
                                        </div>
                                        <div class='col-sm-6' style='height: 50px;margin-bottom: 2%;'>
                                            <button class='btn btn-primary' id='btnEnviar' name='btnEnviar' type='submit' style='width: 99%;margin: 0;margin-left: 1%;height: 100%;background: rgb(24,188,156);font-family: Allerta, sans-serif;'>CADASTRAR</button>
                                        </div>
                                    </form>

                                    <h2 class='modal-title' id='tituloModal' style='color: rgb(40,40,40);font-family: Basic, sans-serif;'></h2>
                                </div>
                                <div class='modal-footer'><button class='btn btn-light' id='fechar' type='button' data-bs-dismiss='modal' style='background: rgb(179,179,179);width: 30%;' onclick = fecharModal()>Fechar</button></div>
                            </div>
                        </div>
                    </div>

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
        .table thead{
            font-size:18px; 
        }
        #formExcluir{
            background-color: transparent;
        }

        tbody tr:nth-child(even) {
            background-color: #DCDCDC;
        }
        table thead tr{
            background-color:#696969;
            color: #fff !important;
        }
    </style>
    <!-- ------------------------------------------------------------------- -->

    <script type='text/javascript'>
        $(document).ready(function() {
            $('#listar-colaboradores').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "application/listar_colaboradores.php",
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
        //     ################# LIMITADOR TABLEA #####################
        //-------------------------------------------------------------------
        function tableLimit(){
            var val = document.getElementById('slctFiltro').value;
            
            $('.listar-colaboradores tbody > tr').show();
            if(val != 'todos'){
                $('.listar-colaboradores tbody > tr').slice(val).hide();
            }
        }
        window.onload = tableLimit;
        // ------------------------------------------------------------------
        
        //-------------------------------------------------------------------
        //          ######## MÁSCARA DE CPF ##########
        //-------------------------------------------------------------------
        $('.maskCPF').mask('000.000.000-00');
        $('.maskCPF').attr('minlength','14');
        //-------------------------------------------------------------------

        //-------------------------------------------------------------------
        // ################# ABRIR MODAL FORM #####################
        //-------------------------------------------------------------------
        function abrirForm(){
            $('#modal-form').modal('show');
            document.getElementById('formColaboradores').reset();
            document.getElementById('tipoEnvio').value = 'insert';
            document.getElementById('tituloModalForm').innerText = 'NOVO COLABORADOR';
            document.getElementById('btnEnviar').innerText = 'CADASTRAR';
        }
        //-------------------------------------------------------------------

        //-------------------------------------------------------------------
        // ################# EXCLUIR REGISTRO #####################
        //-------------------------------------------------------------------
        function excluir(id){
            document.getElementById('idExcluir').value = id
            $('#modal-excluir').modal('show');
        }
        function excluirRegistro() {
            $('#formExcluir').submit();
        }
        //-------------------------------------------------------------------

        //-------------------------------------------------------------------
        // ########## PASSANDO OS DADOS PARA O FORM VIA AJAX #############
        //-------------------------------------------------------------------
        function alterar(id){
            $(document).ready(function () {
                    $('#modal-form').modal('show');
                    $.ajax({
                    type: "POST",
                    url: 'application/alt_cad_colaboradores.php',   
                    data: {
                        idAlt: id
                    },
                    success: function (result) {
                        $('#voltaDados').html(result);
                    },
                    error: function (result) {
                        $('#voltaDados').html(result);
                    }
                    });
            });
        }

        //-------------------------------------------------------------------
        // ########## PASSANDO OS DADOS PARA O MODAL VIA AJAX #############
        //-------------------------------------------------------------------
        function detalhes(id, campos){
            if(id == 0){
                id = document.getElementById('idModal').value;
            }

            if(campos == 0){
                campos = document.getElementById('slctFiltroModal').value;
            }
            $(document).ready(function () {
                        $.ajax({
                        type: "POST",
                        url: 'application/chamar_modal_colaboradores.php',   
                        data: {
                            idModal: id,
                            campos: campos
                        },
                        success: function (result) {
                            $('#voltaDados').html(result);
                        },
                        error: function (result) {
                            $('#voltaDados').html(result);
                        }
                        });  
                        $("#corpoTabelaModal tr").remove(); 
                        $('#modal-detalhes').modal('show');
            });
        
        }

    </script>

    <!-- ------------------------------------------------------------------- -->
    <!-- ################# EXCLUINDO REGISTRO ##################### -->
    <!-- ------------------------------------------------------------------- -->
    <?php
        if(!empty($id)){
            require_once 'application/class/BancoDeDados.php';
            $conexao = new BancoDeDados;
            
            $sql = 'SELECT count(*) AS encontrou FROM emprestimos WHERE id_colaborador=? AND situacao=1';
            $param = [$id];
            $dado = $conexao->pegarRegistro($sql, $param);

            if($dado['encontrou'] > 0){
                echo "<script>window.location.href = 'colaboradores.php?resultado=5';</script>";
            }else{
                $sql = 'DELETE FROM colaboradores WHERE id_colaborador=?';
                $param = [$id];
                if ($conexao->excluirRegistro($sql, $param)){
                    echo "<script>window.location.href = 'colaboradores.php?resultado=6';</script>";
                }else {
                    echo "<script>window.location.href = 'colaboradores.php?resultado=7';</script>";
                }
            }
        }
    ?>
    <!-- ------------------------------------------------------------------- -->
</body>
</html>