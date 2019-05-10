var creditosSeleccionados = 0;
var mostrarAlertaSobrecupo = true;
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
    //$(obj).focus();
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
    agregarCreditos($(obj).data("creditos"), obj);
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
function agregarCreditos(creditos, obj){
    creditosSeleccionados += creditos;
    $("#creditosSeleccionados").html(creditosSeleccionados);
    
    creditosRestantes -= creditos;
    $("#creditosRestantes").html(creditosRestantes);
    if(creditosRestantes<0 && mostrarAlertaSobrecupo){
        alertaSobreCupo((creditosRestantes * -1) , obj);
    }
}

function alertaSobreCupo(creditosSobre, obj){
    var confirma = '<div class="text-2x alert alert-warning fade in"><strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></strong> Al elegir este grupo usted tiene un sobrecupo de '+creditosSobre+' créditos, cada crédito extra tendá un sobrecosto en el valor de su matricula, desea agregar la materia?</div>';
    bootbox.setDefaults({
        locale: "es"
    });
    bootbox.confirm(confirma, function(result) {
        if (!result) {
            remuevePanelGrupoSeleccionado(obj);
        }
    });
}
function removerCreditos(creditos){
    creditosSeleccionados -= creditos;
    $("#creditosSeleccionados").html(creditosSeleccionados);
    
    creditosRestantes += creditos;
    $("#creditosRestantes").html(creditosRestantes);
}
function llevarGrupoAMateriaPadre(obj){
    var id = $(obj).attr("id");
    $( "#"+id).clone().appendTo("div#collapse"+$(obj).data("materiaid")+" div.panel-body div.sortable");
    $(obj).remove();
    remuevePanelGrupoSeleccionado($( "#"+id));
}
function llevarGrupoASeleccionados(obj){
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
function removerGrupo(grupo) {
    gruposSeleccionadas = gruposSeleccionadas.filter(function (item) {
        return item !== grupo.grupoId;
    });
    removerCupo(grupo.grupoId);
    grupo.horarios.forEach(function (item, index) {
        horariosSeleccionados[parseInt(item.dia)] = horariosSeleccionados[parseInt(item.dia)].filter(function (item2) {
            return (item2[0] !== item.ini && item2[1] !== item.fin);
        });
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
function removerCupo(grupoId){
    console.log("remover "+grupoId);
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
            desactivarItem(this,"Horarios cruzados, este grupo no se puede agregar.");
        } else {
            if (!$(this).parent().hasClass("ui-sortable-disabled")) {
                activarItem(this);
                validarCuposDisponibles(this);
            }
        }
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
function continuarReservas(reservas){
    var confirma = '<div class="text-2x alert alert-success fade in"><strong><i class="fa fa-info-circle" aria-hidden="true"></i></strong> En el momento cuenta con reservas de cupo, desea continuar con ese proceso?<br>Recuerde que su reserva de cupo tiene una duración de 2 horas antes de ser liberado, si no desea continuar con el proceso perderá la reserva de cupo.</div>';
    bootbox.setDefaults({
        locale: "es"
    });
    bootbox.confirm(confirma, function(result) {
        if (result) {
            showLoader();
            mostrarAlertaSobrecupo = false;
            reservas.forEach(function(entry) {
                llevarGrupoASeleccionados($("#"+entry));
            });
            mostrarAlertaSobrecupo = true;
            hideLoader();
        }else{
            reservas.forEach(function(entry) {
                llevarGrupoAMateriaPadre($("#"+entry));
            });
        }
    });
}