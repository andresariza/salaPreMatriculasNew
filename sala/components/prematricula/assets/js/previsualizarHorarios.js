$(document).ready(function () {
    $(".previsualizar").click(function () {
        previsualizar($(this).parent().parent());
    });
    $(".previsualizarFinal").click(function () {
        mostrarHorariosSeleccionados();
    });
});
function previsualizar(obj) {
    var grupo = $(obj).data("grupo");
    mostrarHorariosSeleccionados();
    grupo.horarios.forEach(function (item, index) {
        var dia = ".d_" + parseInt(item.dia);
        var horaIni = parseInt(item.iniReal);
        var horaFin = parseInt(item.finReal);
        var nombreGrupo = item.grupo;
        var nombreMateria = item.materia;
        htmlHorarioGrupoDia(dia, horaIni, horaFin, nombreMateria, nombreGrupo, "bg-info");
        //horariosSeleccionados[parseInt(item.dia)].push([item.ini,item.fin,item.iniReal,item.finReal,item.grupo,item.materia]);
    });
}
function mostrarHorariosSeleccionados() {
    limpiarPreviewHorario();
    for (i = 1; i < horariosSeleccionados.length; i++) {
        var dia = ".d_" + i;
        if (horariosSeleccionados[i].length > 0) {
            for (j = 0; j < horariosSeleccionados[i].length; j++) {
                var horaIni = parseInt(horariosSeleccionados[i][j][2]);
                var horaFin = parseInt(horariosSeleccionados[i][j][3]);
                var nombreGrupo = horariosSeleccionados[i][j][4];
                var nombreMateria = horariosSeleccionados[i][j][5];
                htmlHorarioGrupoDia(dia, horaIni, horaFin, nombreMateria, nombreGrupo);
            }
        }
    }
}
function limpiarPreviewHorario() {
    $(".dia").html("");
}
function htmlHorarioGrupoDia(dia, horaIni, horaFin, nombreMateria, nombreGrupo, bg = 'bg-success') {
    for (z = horaIni; z < horaFin; z++) {
        var htmlPrevio = $("#h_" + z + " " + dia).html();
        if (htmlPrevio !== "") {
            bg = "bg-danger ";
        }
        $("#h_" + z + " " + dia).html(htmlPrevio + htmlGrupoCelda(bg, nombreMateria, nombreGrupo));
}
}
function htmlGrupoCelda(bg, nombreMateria, nombreGrupo) {
    return "<div class=\"" + bg + " text-sm\"><strong>Materia: </strong>" + nombreMateria + "<strong><br>Grupo: </strong>" + nombreGrupo + "<\div>"
}
function unixTimestamp(t) {
    var dt = new Date(t * 2000);
    var hr = dt.getHours();
    var m = "0" + dt.getMinutes();
    var s = "0" + dt.getSeconds();
    return hr + ':' + m.substr(-2) + ':' + s.substr(-2);
}