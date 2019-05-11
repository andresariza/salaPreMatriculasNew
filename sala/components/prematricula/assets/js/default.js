
$(document).ready(function () {
    $(".Destino").css("min-height", height);
    $('.accordion .panel-heading').click(function () {
        extenderPanelDestino(this);
    });
    prepareToSelect();
    prepareToRemove();
    validarCruceDeHorarios();
    iniciarSortable();
    finalizarYGuardar();
});

function finalizarYGuardar(){
    $("#finalizarPrematricula").click(function(){
        var confirma = '<div class="text-2x alert alert-success fade in"><strong><i class="fa fa-info-circle" aria-hidden="true"></i></strong> Está seguro de finalizar y guardar su prematrícula?</div>';
        bootbox.setDefaults({
            locale: "es"
        });
        bootbox.confirm(confirma, function(result) {
            if (result) {
                showLoader();
                $.ajax({
                    url: HTTP_SITE+"/index.php",
                    type: "GET",
                    dataType: "json",
                    data: {
                        tmpl : 'json',
                        option : "prematricula",
                        action : "finalizarPrematricula",
                        grupoId : JSON.stringify(gruposSeleccionadas)
                    },
                    success: function( data ){},
                    error: function (xhr, ajaxOptions, thrownError) {}
                }).always(function() {
                    hideLoader();
                });
            }
        }); 
    });
}