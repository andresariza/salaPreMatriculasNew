
var materiasSeleccionadas = new Array();
function agregarMateria(materiaId) {
    materiasSeleccionadas.push(materiaId);
}
function removerMateria(materiaId) {
    materiasSeleccionadas = materiasSeleccionadas.filter(function (item) {
        return item !== materiaId;
    });
}