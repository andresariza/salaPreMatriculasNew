var creditosSeleccionados = 0;
var mostrarAlertaSobrecupo = true;
function agregarCreditos(creditos, obj){
    creditosSeleccionados += creditos;
    $("#creditosSeleccionados").html(creditosSeleccionados);
    
    creditosRestantes -= creditos;
    $("#creditosRestantes").html(creditosRestantes);
    if(creditosRestantes<0 && mostrarAlertaSobrecupo){
        alertaSobrepasoCreditos((creditosRestantes * -1) , obj);
    }
}

function removerCreditos(creditos){
    creditosSeleccionados -= creditos;
    $("#creditosSeleccionados").html(creditosSeleccionados);
    
    creditosRestantes += creditos;
    $("#creditosRestantes").html(creditosRestantes);
}
function alertaSobrepasoCreditos(creditosSobre, obj){
    var confirma = '<div class="text-2x alert alert-warning fade in"><strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></strong> Al elegir este grupo usted tiene un sobrecupo de '+creditosSobre+' créditos, cada crédito extra tendá un sobrecosto en el valor de su matricula, desea agregar la materia?</div>';
    bootbox.setDefaults({
        locale: "es"
    });
    bootbox.confirm(confirma, function(result) {
        if (!result) {
            removerPanelGrupoSeleccionado(obj);
        }
    });
}