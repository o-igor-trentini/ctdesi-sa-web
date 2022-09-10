//-------------------------------------------------------------------
//          ######## MÁSCARA DE CELULAR/TELEFONE ##########
//-------------------------------------------------------------------
var behavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {
onKeyPress: function (val, e, field, options) {
    field.mask(behavior.apply({}, arguments), options);
}
};
$('.telefone').mask(behavior, options);

$(document).ready(function()
{
$(".telefone").attr('minlength','14');
});
//-------------------------------------------------------------------


//-------------------------------------------------------------------
//          ######## FECHAR MODAIS ##########
//-------------------------------------------------------------------
function fecharModal(){
    $('.modais').modal('hide'); 
}
//-------------------------------------------------------------------


//-------------------------------------------------------------------
//          ######## PESQUISA EM TEMPO REAL ##########
//-------------------------------------------------------------------
$(function(){
    $('.pesquisar').keyup(function(){
        //pega o css da tabela 
        var tabela = $(this).attr('alt');
        if( $(this).val() != ""){
            $("."+tabela+" tbody>tr").hide();
            $("."+tabela+" td:contains-ci('" + $(this).val() + "')").parent("tr").show();
        } else{
            $("."+tabela+" tbody>tr").show();
        }
    }); 
});
$.extend($.expr[":"], {
    "contains-ci": function(elem, i, match, array) {
        return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
});
//-------------------------------------------------------------------