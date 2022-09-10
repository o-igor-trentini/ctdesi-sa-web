<!DOCTYPE html>
<html lang="pt-br" style="width: 100%;height: 100%;background: rgb(24,188,156) !important;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Escanear QRCode - Biblioteca</title>

    <?php 
        include_once 'application/links/icones/icone_pagina.php';
        include_once 'application/links/css-js-pagina/index_emprestimo_devolucao/index_emprestimo_devolucao.php';  
    ?>   
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="72" style="width: 100%;height: 100%;">
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-secondary text-uppercase" id="mainNav" style="background: rgb(40, 45, 50) !important;">
        <div class="container"><a class="navbar-brand" id="voltar" href="index.php" style="font-size: 19px;"><i class="fas fa-arrow-left me-2"></i>Voltar</a>
        </div>
    </nav>
    <header class="text-center text-white bg-primary masthead" style="background: rgb(232,237,236);padding: 170px 0px 96px;height: 100%;width: 100%;">
        <div class="container" data-aos="zoom-in-down" data-aos-duration="550" style="height: 550px;">
            <h1 style="font-size: 40px;">Escaneie o seu QRCode</h1>
            <div style="height: 4px;background: #ffffff;width: 25%;margin-right: 37.5%;margin-left: 37.5%;margin-top: 12px;margin-bottom: 20px;"></div>
            <img src="assetsEmprestimo/img/qrcode.gif" style="width: 300px;box-shadow: 0px 0px 20px rgb(65,65,65);border-radius: 10px;">
            <div style="height: 4px;background: #ffffff;width: 25%;margin-right: 37.5%;margin-left: 37.5%;margin-top: 20px;margin-bottom: 12px;"></div>
            <form id="formulario" style="background: rgba(255,255,255,0);border-color: rgba(33,37,41,0);color: rgba(249,249,249,0); opacity: 0;" method="POST" action="application/pessoa_verificar.php"><input class="form-control" type="text" style="background: rgba(255,255,255,0);border-color: rgba(33,37,41,0);color: rgba(255,255,255,0);" name="txtIdPessoa" id="txtIdPessoa" onBlur="foco()" onkeypress="return somenteN(event)" autocomplete="off"></form>
        </div>
    </header>

    <div class="modal fade" id="modal-alerta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color: rgb(61,61,61);">Alerta</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body" style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 18px;'>

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery-3.6.0/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="assetsEmprestimo/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="assetsEmprestimo/js/script.min.js"></script>

    <script type="text/javascript">
        // Modal
        $(document).ready(function(){
            <?php
                If (isset($_GET['erro']) && $_GET['erro'] == '1') {
                    echo "$('#modal-body').html('<p>Ops... <br><br>Escaneie o QRCode novamente!</p>');";
                    echo "$('#modal-alerta').modal('show');";
                    echo "var fecharModal = setTimeout(function() {
                        $('#modal-alerta').modal('hide');
                        $('#txtIdPessoa').focus();
                    }, 3500);";
                } elseIf (isset($_GET['erro']) && $_GET['erro'] == '2') {
                    echo "$('#modal-body').html('<p>Nenhum indivíduo foi encontrado!</p>');";
                    echo "$('#modal-alerta').modal('show');";
                    echo "var fecharModal = setTimeout(function() {
                        $('#modal-alerta').modal('hide');
                        $('#txtIdPessoa').focus();
                    }, 3500);";
                }
            ?>
        });

        // Sempre dar foco no campo
        window.onload = document.getElementById("txtIdPessoa").focus();
        function foco() {
            document.getElementById("txtIdPessoa").focus();
        }

        // Digitar apenas n° | Enviar Form
        function somenteN(e) {
			var charCode = e.charCode ? e.charCode : e.keyCode;
				if (charCode != 8 && charCode != 9 && charCode != 13 && charCode != 32) {
					if (charCode < 48 || charCode > 57) {
						return false;
					}
				}
                var timerEnter = setTimeout(function() {
                
                    document.getElementById("formulario").submit();
                }, 1000);
        }
    </script>
</body>
</html>