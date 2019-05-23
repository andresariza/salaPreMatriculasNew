
function reservarCupo(grupoId){
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "GET",
        dataType: "json",
        data: {
            tmpl : 'json',
            option : "prematricula",
            action : "reservarCupo",
            grupoId : grupoId
        },
        success: function( data ){},
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function() {
        hideLoader();
    });
}

function removerCupo(grupoId){
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "GET",
        dataType: "json",
        data: {
            tmpl : 'json',
            option : "prematricula",
            action : "removerCupo",
            grupoId : grupoId
        },
        success: function( data ){},
        error: function (xhr, ajaxOptions, thrownError) {}
    }).always(function() {
        hideLoader();
    });
}

function validarCuposDisponibles(obj){
    var puedeAgregar = true;
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "GET",
        dataType: "json",
        data: {
            tmpl : 'json',
            option : "prematricula",
            action : "validarCuposDisponibles",
            grupoId : $(obj).attr("id")
        },
        success: function( data ){ 
            var cupo =  parseInt(data.cuposDisponibles);
            
            if(cupo<=0){
                puedeAgregar = false;
                cupo = 0;
            }else{
                puedeAgregar = true ;
            }
            
            if(puedeAgregar){
                activarItem(obj);
            }else{
                desactivarItem(obj,"Este grupo no tiene cupos disponibles.");
            }
            $(obj).data("cupodisponible", cupo);
            $("#cuposDisponibles_"+$(obj).attr("id")).html(cupo);
        },
        error: function (xhr, ajaxOptions, thrownError) {}
    });
}

function continuarReservas(reservas){
    var confirma = '<div class="text-2x alert alert-success fade in"><strong><i class="fa fa-info-circle" aria-hidden="true"></i></strong> En el momento cuenta con reservas de cupo, desea continuar con ese proceso?<br>Recuerde que su reserva de cupo tiene una duración de 2 horas antes de ser liberado, si no desea continuar con el proceso perderá la reserva de cupo.</div>';
    bootbox.setDefaults({
        locale: "es"
    });
    bootbox.confirm(confirma, function(result) {
        mostrarAlertaSobrecupo = false;
        if (result) {
            showLoader();
            reservas.forEach(function(entry) {
                llevarGrupoASeleccionados($("#"+entry));
            });
            hideLoader();
        }else{
            reservas.forEach(function(entry) {
                llevarGrupoAMateriaPadre($("#"+entry));
            });
        }
        mostrarAlertaSobrecupo = true;
    });
}