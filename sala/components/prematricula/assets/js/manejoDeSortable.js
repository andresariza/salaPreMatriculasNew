
function extenderPanelDestino(obj) {
    var newheight = (145 * $(obj).parent().find(".collapse .sortable .arrastrable").length) + 50;
    if ($(obj).find("a").attr("aria-expanded") === "false") {
        $(".Destino").css("min-height", height + newheight);
    } else {
        $(".Destino").css("min-height", height);
    }
    setTimeout(function(){
        $('html,body').animate({
            scrollTop: $(obj).offset().top
        }, 1000);
    }, 500);
}
function iniciarSortable() {
    $('div.sortable').sortable({
        connectWith: 'div.sortable',
        items: "div.arrastrable",
        placeholder: "portlet-placeholder",
        cancel: ".unsortable",
        receive: function (event, ui) {
            if ($(ui.item).parent().hasClass("Destino")) {
                recibirPanelGrupoSeleccionado(ui.item);
            } else {
                removerPanelGrupoSeleccionado(ui.item);
            }
        }
    });
}
function recibirPanelGrupoSeleccionado(obj){
    var grupo = $(obj).data("grupo");
    agregarMateria($(obj).data("materiaid"));
    agregarGrupo(grupo);
    agregarCreditos($(obj).data("creditos"), obj);
    $("div#collapse" + $(obj).data("materiaid") + " div.sortable .arrastrable .mensajeMateriaSeleccionada").html('<div class=\"alert alert-warning fade in\"><button class=\"close\" data-dismiss=\"alert\"><span>×</span></button><strong><i class=\"fa fa-info-circle\"></i> </strong> Esta materia ya fue seleccionada. </div>');
    $("div#collapse" + $(obj).data("materiaid") + " div.sortable").sortable('disable');
    $("div#collapse" + $(obj).data("materiaid") + " div.sortable div.arrastrable").addClass("bg-trans-dark text-muted unsortable");
    prepareToReactiveSortable();
    prepareToRemove();
    activarBotonFinanizar();
}
function removerPanelGrupoSeleccionado(obj){
    var grupo = $(obj).data("grupo");
    if("collapse" + $(obj).data("materiaid") === $(obj).parent().parent().parent().attr("id")){
        $("div#collapse" + $(obj).data("materiaid") + " div.sortable .arrastrable .mensajeMateriaSeleccionada").html('');
        removerMateria($(obj).data("materiaid"));
        removerGrupo(grupo);
        removerCreditos($(obj).data("creditos"));
        $("div#collapse" + $(obj).data("materiaid") + " div.sortable div.arrastrable").removeClass("bg-trans-dark text-muted  unsortable");
        $("div#collapse" + $(obj).data("materiaid") + " div.sortable").sortable('enable');
        $(obj).unbind('mouseenter');
        $(obj).unbind('mouseleave');
        validarCruceDeHorarios();
        prepareToSelect();
    }else{
        llevarGrupoAMateriaPadre(obj);
    }
    activarBotonFinanizar();
}

function prepareToReactiveSortable() {
    $(".Destino .arrastrable").unbind('mouseenter');
    $(".Destino .arrastrable").mouseenter(function () {
        $("div#collapse" + $(this).data("materiaid") + " div.sortable").sortable('enable');
    });
    $(".Destino .arrastrable").unbind('mouseleave');
    $(".Destino .arrastrable").mouseleave(function () {
        $("div#collapse" + $(this).data("materiaid") + " div.sortable").sortable('disable');
    });
}
function desactivarItem(obj, mensaje) {
    $(obj).addClass("bg-trans-dark");
    $(obj).addClass("ui-state-disabled");
    $(obj).addClass("unsortable");
    $(obj).find("div.mensajeError").html("<div class=\"alert alert-warning fade in\"><button class=\"close\" data-dismiss=\"alert\"><span>×</span></button><strong><i class=\"fa fa-info-circle\"></i> </strong> "+mensaje+" </div>");
}
function activarItem(obj) {
    $(obj).removeClass("bg-trans-dark");
    $(obj).removeClass("ui-state-disabled");
    $(obj).removeClass("unsortable");
    $(obj).find("div.mensajeError").html("");
}
function prepareToRemove(){
    $(".remover button").unbind('click');
    $(".remover button").click(function(){
        llevarGrupoAMateriaPadre($(this).parent().parent().parent());
    });
}
function prepareToSelect(){
    $(".seleccionarGrupo button").unbind('click');
    $(".seleccionarGrupo button").click(function(){
        llevarGrupoASeleccionados($(this).parent().parent().parent());
    });
}
function activarBotonFinanizar(){
    if(gruposSeleccionadas.length > 0){
        $("#finalizarPrematricula").removeAttr("disabled");
    }else{
        $("#finalizarPrematricula").attr("disabled","disabled");
    }
}