<?php
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $cadastro = isset($_GET['cad']) ? $_GET['cad'] : '';
    
    //  ------------------------------------------------------------------- 
    //  ################# PREPARANDO VALORES QRCODE #################### 
    //  -------------------------------------------------------------------
    $imprimir = '3 ' . $id;


    //  ------------------------------------------------------------------- 
        //  ################# VALIDANDO RETORNO #################### 
    //  -------------------------------------------------------------------
    if($cadastro == 1){
        $resultado = 1;
    }else{
        $resultado = '';
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
                            <div class="col-lg-6 d-none d-lg-flex" style="box-shadow: 0px 0px 2px;" id="dados">
                                <div class="col-sm-6" style="height: 190px;margin: 30px;width: 190px;padding: 0;" id="qrcode"></div>
                            </div>
                            <div class="col-lg-6" style="box-shadow: 0px 0px 8px;border-left-color: rgb(0,0,0);">
                                <div class="p-5" style="height: 240px;padding-top: 20px !important;">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4" style="font-family: Nunito, sans-serif;color: rgb(62,62,65);">Identificador Livro</h4>
                                    </div>
                                    <form class="user">
                                        <hr><a onclick="funcao_pdf()" class="btn btn-primary d-block btn-facebook btn-user w-100" role="button" style="border-radius: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;background: rgb(24,188,156);font-family: Allerta, sans-serif;font-size: 16px;">Imprimir | Baixar</a>
                                        <a class="btn btn-primary d-block btn-facebook btn-user w-100" role="button" id="voltar" style="border-radius: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;background: rgb(149,149,149);font-family: Allerta, sans-serif;font-size: 16px;margin-top: 10px;" <?php echo "href='livros.php?resultado={$resultado}'";?>>Voltar</a>
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
                        width: 190,
                        height: 190,
                        colorDark: '#000000',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.H
                    });
              </script>";
    ?>

    <!-- ------------------------------------------------------------------- -->
    <!--          ######## IMPRESSÃO ########## -->
    <!-- ------------------------------------------------------------------- -->
    <script type="text/javascript">
            function funcao_pdf(){
                <?php
                    echo "window.open('imprimir.php?valor={$imprimir}')";
                ?>  
            }
    </script>
</body>

</html>