<!-- _______________________________________ -->
    <!-- ########### MODAIS ############# -->
<!-- _______________________________________ -->

<!-- MODAL EXCLUIR -->
<div class='modal fade modais' role='dialog' tabindex='-1' id='modal-excluir'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title' style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 26px;'>Alerta!</h4><button type='button' class='btn-close' data-bs-dismiss='modal' href='#' onclick='fecharModal()'></button>
            </div>
            <div class='modal-body'>
                <p style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 18px;'>Realmente deseja excluir este registro?</p>
            </div>
            <div class='modal-footer'>
                <button class='btn btn-light' id='fechar' type='button' data-bs-dismiss='modal' style='width: 25%;font-family: Allerta, sans-serif;color: rgb(252,252,252);background: rgb(137,137,137);' onclick='fecharModal()'>Cancelar</button>
                <button class='btn btn-primary' type='button' style='width: 25%;background: rgb(24,188,156);font-family: Allerta, sans-serif;border:none !important' onclick='excluirRegistro()'>Sim</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FINALIZAR -->
<div class='modal fade modais' role='dialog' tabindex='-1' id='modal-finalizar'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title' style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 26px;'>Alerta!</h4><button type='button' class='btn-close' data-bs-dismiss='modal' href='#' onclick='fecharModal()'></button>
            </div>
            <div class='modal-body'>
                <p style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 18px;'>Realmente deseja finalizar este empréstimo?</p>
            </div>
            <div class='modal-footer'>
                <button class='btn btn-light' id='fechar' type='button' data-bs-dismiss='modal' style='width: 25%;font-family: Allerta, sans-serif;color: rgb(252,252,252);background: rgb(137,137,137);' onclick='fecharModal()'>Cancelar</button>
                <button class='btn btn-primary' type='button' style='width: 25%;background: rgb(24,188,156);font-family: Allerta, sans-serif;border:none !important' onclick='finalizarRegistro()'>Sim</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL QUITAR -->
<div class='modal fade modais' role='dialog' tabindex='-1' id='modal-quitar'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title' style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 26px;'>Alerta!</h4><button type='button' class='btn-close' data-bs-dismiss='modal' href='#' onclick='fecharModal()'></button>
            </div>
            <div class='modal-body'>
                <p style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 18px;'>Realmente deseja quitar multa e finalizar este empréstimo?</p>
            </div>
            <div class='modal-footer'>
                <button class='btn btn-light' id='fechar' type='button' data-bs-dismiss='modal' style='width: 25%;font-family: Allerta, sans-serif;color: rgb(252,252,252);background: rgb(137,137,137);' onclick='fecharModal()'>Cancelar</button>
                <button class='btn btn-primary' type='button' style='width: 25%;background: rgb(24,188,156);font-family: Allerta, sans-serif;border:none !important' onclick='quitarRegistro()'>Sim</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL RESULTADO -->
<div class='modal fade modais' id='modal-result' role='dialog' tabindex='-1'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title' style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 26px;'>Alerta!</h4><button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' href='#' onclick='fecharModal()'></button>
            </div>
            <div class='modal-body' id='modal-result-body' style='color: rgb(82,82,82);font-family: Nunito, sans-serif;font-size: 18px;'>
                <p>...</p>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>



$('#modal-result-body').html('<p>Há campos em branco. Verifique!</p>');

    function chamarModalResult(result){

        // INSERT
        if(result == 0){
            $('#modal-result-body').html('<p>>Ops! Houve um problema ao tentar cadastrar.</p>');

        }else if(result == 1){
            $('#modal-result-body').html('<p>Registro inserido com sucesso!</p>');

        }else if(result == 2){
            $('#modal-result-body').html('<p>Há campos em branco. Verifique!</p>');
        }

        // ALTER
        else if(result == 3){
            $('#modal-result-body').html('<p>Registro alterado com sucesso!</p>');

        }else if(result == 4){
            $('#modal-result-body').html('<p>>Ops! Houve um problema ao tentar alterar.</p>');

        }

        // DELETE
        else if(result == 5){
            $('#modal-result-body').html('<p>Ops! Não foi possivel excluir. Este registro possuí situação ativa!</p>');

        }else if(result == 6){
            $('#modal-result-body').html('<p>Registro excluido com sucesso!</p>');

        }else if(result == 7){
            $('#modal-result-body').html('<p>Ops! Houve um problema ao tentar excluir.</p>');

        }

        // COLABORADOR VALIDAÇÃO - USUÁRIO/CPF
        else if(result == 8){
            $('#modal-result-body').html('<p>Usuário escolhido indisponível!</p>');
        }else if(result == 9){
            $('#modal-result-body').html('<p>O CPF digitado ja possuí registro!</p>');
        }

        // FINALIZAR EMPRÉSTIMO
        else if(result == 10){
            $('#modal-result-body').html('<p>Empréstimo finalizado com sucesso!</p>');
        }else if(result == 11){
            $('#modal-result-body').html('<p>Ops! Houve um problema ao tentar finalizar.</p>');
        }

        // QUITAR DÍVIDA
        else if(result == 12){
            $('#modal-result-body').html('<p>Multa quitada com sucesso!</p>');
        }else if(result == 13){
            $('#modal-result-body').html('<p>Ops! Houve um problema ao tentar quitar a multa.</p>');
        }

        $(document).ready(function(){
            $('#modal-result').modal('show');
            var fecharModal = setTimeout(function() {
                $('#modal-result').modal('hide');
            }, 3000);
        });
        
    }   

</script>