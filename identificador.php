<?php
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $cadastro = isset($_GET['cad']) ? $_GET['cad'] : '';
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
    require_once 'application/class/BancoDeDados.php';

    //  ------------------------------------------------------------------- 
        //  ################# VALIDANDO USUÁRIO #################### 
    //  -------------------------------------------------------------------
    if($tipo == '1'){
        
        $conexao = new BancoDeDados;
        $sql = 'SELECT nome FROM alunos WHERE id_aluno=?';
        $params = [$id];
        $dados = $conexao->pegarRegistro($sql,$params);
        $nome = $dados['nome'];                                                     
    }else{
        $conexao = new BancoDeDados;
        $sql = 'SELECT nome FROM colaboradores WHERE id_colaborador=?';
        $params = [$id];
        $dados = $conexao->pegarRegistro($sql,$params);
        $nome = $dados['nome'];      
    }
    //  -------------------------------------------------------------------
    

    //  ------------------------------------------------------------------- 
        //  ################# PREPARANDO VALORES QRCODE #################### 
    //  -------------------------------------------------------------------
    $imprimir = $tipo . ' ' . $id;

    if($cadastro == 1){
        $resultado = 1;
    }else{
        $resultado = '';
    }

    //  ------------------------------------------------------------------- 
        //  ################# VALIDANDO RETORNO #################### 
    //  -------------------------------------------------------------------
    if($tipo == 1 && $cadastro == 1){
        $action = "href='alunos.php?resultado=1'";
    }else if ($tipo == 1 && $cadastro == ''){
        $action = "href='alunos.php'";
    }else if ($tipo == 2 && $cadastro == 1){
        $action = "href='colaboradores.php?resultado=1'";
    }else if ($tipo == 2 && $cadastro == ''){
        $action = "href='colaboradores.php'";
    }
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
    <!-- ------------------------------------------------------------------- --> 
</head>

<!-- ------------------------------------------------------------------- -->
    <!-- ######## MODAL CARTEIRA QRCODE ########## -->
<!-- ------------------------------------------------------------------- -->
<body class="bg-gradient-primary" style="background: rgb(24,188,156);height: 100%;">
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 100px;">
            <div class="col-md-9 col-lg-12 col-xl-10" data-aos="zoom-in-down" data-aos-duration="550">
                <div class="card shadow-lg o-hidden border-0 my-5" style="margin-top: 100px;">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex" style="box-shadow: 0px 0px 2px;"  id='dados'>
                                <section style="height: 190px !important; width: 390px;margin: 20px;border-width: 1px;box-shadow: 0px 0px 0px 2px rgb(0,0,0);">
                                    <div style="height: 150px; width: 190px; margin-right: 5px; display: inline-block !important;position: absolute;">
                                        <div style="width: 100%;height: 50%;padding: 10px;color: rgb(0,0,0);"><span style="font-size: 19px;">E.E.B.N. ROSINA NARDI</span></div>
                                        <div style="width: 100%;height: 50%;padding: 10px;"><span style="font-size: 16px;color: rgb(0,0,0);"><?php echo "$nome"; ?></span></div>
                                    </div>
                                    <div style="height: 180px;margin: 5px;width: 190px;padding: 10px !important;display: inline-block !important; margin-left: 50%;" id="qrcode"></div>
                                </section>
                            </div>
                            <div class="col-lg-6" style="box-shadow: 0px 0px 8px;border-left-color: rgb(0,0,0);">
                                <div class="p-5" style="padding-top: 20px !important;">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4" style="font-family: Nunito, sans-serif;color: rgb(62,62,65);">Identificador Biblioteca</h4>
                                    </div>
                                    <form class="user" style="height: 100px;">
                                        <hr>
                                            <a onclick="funcao_pdf()" class="btn btn-primary d-block btn-facebook btn-user w-100" role="button" style="border-radius: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;background: rgb(24,188,156);font-family: Allerta, sans-serif;font-size: 16px;">Imprimir | Baixar</a>
                                            <a class="btn btn-primary d-block btn-facebook btn-user w-100" role="button" id="voltar" style="border-radius: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;background: rgb(149,149,149);font-family: Allerta, sans-serif;font-size: 16px;margin-top: 10px;" <?php echo "{$action}";?>>Voltar</a>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------------------- -->


    <!-- ------------------------------------------------------------------- -->
    <!--          ######## GERANDO QRCODE ########## -->
    <!-- ------------------------------------------------------------------- -->
    <?php
        echo "<script type='text/javascript'>
                    new QRCode(document.getElementById('qrcode'), 
                    {text:'{$imprimir}',
                        width: 170,
                        height: 160
                    });
              </script>";
    ?>

    <!-- ------------------------------------------------------------------- -->
    <!--          ######## IMPRESSÃO ########## -->
    <!-- ------------------------------------------------------------------- -->
    <script type="text/javascript">
            function funcao_pdf(){
                <?php
                    echo "window.open('imprimirPessoa.php?valor={$imprimir}&nome={$nome}')";
                ?>  
            }
    </script>
</body>

</html>