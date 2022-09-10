<?php
    $imprimir = isset($_GET['valor']) ? $_GET['valor'] : '';
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

    <!-- ------------------------------------------------------------------- -->
       <!--             ######## QRCODE ########## -->
    <!-- ------------------------------------------------------------------- -->
    <div id="dados">
        <div class="col-sm-6" style="height: 190px;margin: 30px;width: 190px;padding: 0;" id="qrcode"></div>
    </div>
    

    <script src='vendor/qrcode.min.js'></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.8/swiper-bundle.min.js"></script>
    <script src="assets/js/script.min.js"></script>
    
    <!-- ------------------------------------------------------------------- -->
       <!--             ######## IMPRIMINDO QRCODE ########## -->
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

    <script type="text/javascript">
        window.onload = window.print();
    </script>
</body>

</html>