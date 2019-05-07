var creditosSeleccionados = 0;
var materiasSeleccionadas = new Array();
var gruposSeleccionadas = new Array();
var horariosSeleccionados = [null, new Array(), new Array(), new Array(), new Array(), new Array(), new Array()];
$(document).ready(function () {
    $(".Destino").css("min-height", height);
    $('.accordion .panel-heading').click(function () {
        extenderPanelDestino(this);
    });
    prepareToSelect();
    prepareToRemove();
    validarCruceDeHorarios();
    iniciarSortable();
});
function extenderPanelDestino(obj) {
    var newheight = (121 * $(obj).parent().find(".collapse .sortable .arrastrable").length) + 50;
    if ($(obj).find("a").attr("aria-expanded") === "false") {
        $(".Destino").css("min-height", height + newheight);
    } else {
        $(".Destino").css("min-height", height);
    }
}
function iniciarSortable() {
    $('div.sortable').sortable({
        connectWith: 'div.sortable',
        items: "div.arrastrable",
        placeholder: "portlet-placeholder",
        cancel: ".unsortable",
        receive: function (event, ui) {
            if ($(ui.item).parent().hasClass("Destino")) {
                recibePanelGrupoSeleccionado(ui.item);
            } else {
                remuevePanelGrupoSeleccionado(ui.item);
            }
        }
    });
}
function recibePanelGrupoSeleccionado(obj){
    var grupo = $(obj).data("grupo");
    agregarMateria($(obj).data("materiaid"));
    agregarGrupo(grupo);
    agregarCreditos($(obj).data("creditos"));
    $("div#collapse" + $(obj).data("materiaid") + " div.sortable .arrastrable .mensajeMateriaSeleccionada").html('<div class=\"alert alert-warning fade in\"><button class=\"close\" data-dismiss=\"alert\"><span>×</span></button><strong><i class=\"fa fa-info-circle\"></i> </strong> Esta materia ya fue seleccionada. </div>');
    $("div#collapse" + $(obj).data("materiaid") + " div.sortable").sortable('disable');
    $("div#collapse" + $(obj).data("materiaid") + " div.sortable div.arrastrable").addClass("bg-trans-dark text-muted unsortable");
    prepareToReactiveSortable();
    prepareToRemove();
}
function remuevePanelGrupoSeleccionado(obj){
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
}
function agregarCreditos(creditos){
    creditosSeleccionados += creditos;
    $("#creditosSeleccionados").html(creditosSeleccionados);
}
function removerCreditos(creditos){
    creditosSeleccionados -= creditos;
    $("#creditosSeleccionados").html(creditosSeleccionados);
}
function llevarGrupoAMateriaPadre(obj){
    var id = $(obj).attr("id");
    $( "#"+id).clone().appendTo("div#collapse"+$(obj).data("materiaid")+" div.panel-body div.sortable");
    $(obj).remove();
    remuevePanelGrupoSeleccionado($( "#"+id));
}
function llevarGrupoADestino(obj){
    console.log(obj);
    var id = $(obj).attr("id");
    $( "#"+id).clone().appendTo("div.Destino");
    $(obj).remove();
    recibePanelGrupoSeleccionado($( "#"+id));
}
function agregarMateria(materiaId) {
    materiasSeleccionadas.push(materiaId);
}
function removerMateria(materiaId) {
    materiasSeleccionadas = materiasSeleccionadas.filter(function (item) {
        return item !== materiaId;
    });
}
function agregarGrupo(grupo) {
    gruposSeleccionadas.push(grupo.grupoId);
    reservarCupo(grupo.grupoId);
    grupo.horarios.forEach(function (item, index) {
        horariosSeleccionados[parseInt(item.dia)].push([item.ini, item.fin, item.iniReal, item.finReal, item.grupo, item.materia]);
    });
}
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
function removerGrupo(grupo) {
    gruposSeleccionadas = gruposSeleccionadas.filter(function (item) {
        return item !== grupo.grupoId;
    });
    grupo.horarios.forEach(function (item, index) {
        horariosSeleccionados[parseInt(item.dia)] = horariosSeleccionados[parseInt(item.dia)].filter(function (item2) {
            return (item2[0] !== item.ini && item2[1] !== item.fin);
        });
    });
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
function validarHorarioDisponible(horariospreviamenteseleccionados, horarios) {
    var retorna = true;
    if (horarios.length > 0) {
        horarios.forEach(function (item, index) {
            var dia = parseInt(item.dia);
            var inicio = parseInt(item.ini);
            var final = parseInt(item.fin);
            var horariosDia = horariospreviamenteseleccionados[dia];
            if (horariosDia.length > 0) {
                horariosDia.forEach(function (item2, index2) {
                    if (item2[0] <= inicio && inicio <= item2[1]) {
                        retorna = false;
                    }
                    if (item2[0] <= final && final <= item2[1]) {
                        retorna = false;
                    }
                });
            }
        });
    }
    return retorna;
}
function validarCruceDeHorarios() {
    $("div.list-group.sortable div.arrastrable").unbind('mouseenter');
    $("div.list-group.sortable div.arrastrable").mouseenter(function () {
        var grupo = $(this).data("grupo");
        puedeAgregar = validarHorarioDisponible(horariosSeleccionados, grupo.horarios);
        if (!puedeAgregar) {
            desactivarItem(this);
        } else {
            if (!$(this).parent().hasClass("ui-sortable-disabled")) {
                activarItem(this);
            }
        }
    });
}
function desactivarItem(obj) {
    $(obj).addClass("bg-trans-dark");
    $(obj).addClass("ui-state-disabled");
    $(obj).addClass("unsortable");
    $(obj).find("div.mensajeError").html("<div class=\"alert alert-warning fade in\"><button class=\"close\" data-dismiss=\"alert\"><span>×</span></button><strong><i class=\"fa fa-info-circle\"></i> </strong> Horarios cruzados, este grupo no se puede agregar. </div>");
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
        llevarGrupoADestino($(this).parent().parent().parent());
    });
}