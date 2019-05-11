
var horariosSeleccionados = [null, new Array(), new Array(), new Array(), new Array(), new Array(), new Array()];
var gruposSeleccionadas = new Array();
function llevarGrupoAMateriaPadre(obj){
    var id = $(obj).attr("id");
    $( "#"+id).clone().appendTo("div#collapse"+$(obj).data("materiaid")+" div.panel-body div.sortable");
    $(obj).remove();
    removerPanelGrupoSeleccionado($( "#"+id));
}
function llevarGrupoASeleccionados(obj){
    var id = $(obj).attr("id");
    $( "#"+id).clone().appendTo("div.Destino");
    $(obj).remove();
    recibirPanelGrupoSeleccionado($( "#"+id));
}
function agregarGrupo(grupo) {
    var idMateria = $("#"+grupo.grupoId).data("materiaid");
    gruposSeleccionadas.push([parseInt(grupo.grupoId),idMateria]);
    reservarCupo(grupo.grupoId);
    grupo.horarios.forEach(function (item, index) {
        horariosSeleccionados[parseInt(item.dia)].push([item.ini, item.fin, item.iniReal, item.finReal, item.grupo, item.materia]);
    });
}
function removerGrupo(grupo) {
    gruposSeleccionadas = gruposSeleccionadas.filter(function (item) {
        return item[0] !== grupo.grupoId;
    });
    removerCupo(grupo.grupoId);
    grupo.horarios.forEach(function (item, index) {
        horariosSeleccionados[parseInt(item.dia)] = horariosSeleccionados[parseInt(item.dia)].filter(function (item2) {
            return (item2[0] !== item.ini && item2[1] !== item.fin);
        });
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