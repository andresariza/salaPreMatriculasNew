
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
                    success: function( data ){
                        if(data.s){
                            var titulo = "Prematricula finalizada";
                            abrirModal(titulo,data.msj);
                            setTimeout(function(){
                                $(".modal-dialog .bootbox-close-button.close").trigger("click");
                                $("#mainnav-menu #menuId_0").trigger("click");
                                
                                contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                                contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                
                                showAlert(dataAlert[2].type,contentHTML,true);
                            }, 2000);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {}
                }).always(function() {
                    hideLoader();
                });
            }
        }); 
    });
}