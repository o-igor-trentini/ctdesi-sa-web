<?php
    $imprimir = isset($_GET['valor']) ? $_GET['valor'] : '';
    $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sistema - Biblioteca</title>

    <!-- ------------------------------------------------------------------- -->
       <!-- ######## IMPORTANDO OS DADOS(ICONE) ########## -->
    <!-- ------------------------------------------------------------------- -->
    <?php 
        include_once 'application/links/icones/icone_pagina.php';
    ?> 
    <!-- ------------------------------------------------------------------- --> 
</head>

<body class="bg-gradient-primary">

    <div id='dados'>
        <section style="height: 190px !important; width: 390px;margin: 20px;border-width: 1px;box-shadow: 0px 0px 0px 2px rgb(0,0,0);">
            <div style="height: 150px; width: 190px; margin-right: 5px; display: inline-block !important;position: absolute;">
                <div style="width: 100%;height: 50%;padding: 10px;color: rgb(0,0,0);"><span style="font-size: 19px;">E.E.B.N. ROSINA NARDI</span></div>
                <div style="width: 100%;height: 50%;padding: 10px;"><span style="font-size: 16px;color: rgb(0,0,0);"><?php echo "$nome"; ?></span></div>
            </div>
            <div style="height: 180px;margin: 5px;width: 190px;padding: 10px !important;display: inline-block !important; margin-left: 50%;" id="qrcode"></div>
        </section>
    </div>
                           
    <script src='vendor/qrcode.min.js'></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/script.min.js"></script>
    <?php
        echo "<script type='text/javascript'>
                    new QRCode(document.getElementById('qrcode'), 
                    {text:'{$imprimir}',
                        width: 160,
                        height: 160,
                        colorDark: '#000000',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.H
                    });
              </script>";
    ?>

    <script type="text/javascript">
        window.onload = window.print();
    </script>
</body>

</html>