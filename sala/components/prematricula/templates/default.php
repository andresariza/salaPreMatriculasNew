<?php
defined('_EXEC') or die;

echo Sala\lib\Factory::printImportJsCss("js",HTTP_SITE."/assets/js/jquery-ui.min.js");

$listadoMateriasDisponibles = \Sala\components\prematricula\control\ControlPrematricula::getListadoMateriasDisponibles($PlanEstudio->getListadoMaterias());
//d($listadoMateriasDisponibles);
?>
<style>
    .portlet-placeholder {
        border: 1px dotted black;
        margin: 0 1em 1em 0;
        height: 50px;
    }
    .panel-collapse .remover{
        display: none;
    }
    .Destino .previsualizar{
        display: none;
    }
</style>
<script type="text/javascript">
    var materiasSeleccionadas = new Array();
    var gruposSeleccionadas = new Array();
    var horariosSeleccionados = [null,new Array(),new Array(),new Array(),new Array(),new Array(),new Array()];
    $(document).ready(function () {
        validarCruceDeHorarios();
        $(".previsualizar").click(function(){
            previsualizar($(this).parent().parent());
        });
        iniciarSortable();
    });
    function iniciarSortable(){
        $('div.sortable').sortable({
            connectWith: 'div.sortable',
            items: "div.arrastrable",
            placeholder: "portlet-placeholder",
            cancel: ".unsortable",
            receive: function( event, ui ) {
                var grupo  = $(ui.item).data("grupo");
                if($(ui.item).parent().hasClass("Destino")){
                    agregarMateria($(ui.item).data("materiaid"));
                    agregarGrupo(grupo);
                    $("div#collapse"+$(ui.item).data("materiaid")+" div.sortable").sortable('disable');
                    $("div#collapse"+$(ui.item).data("materiaid")+" div.sortable div.arrastrable").addClass("bg-trans-dark text-muted unsortable");
                    prepareToReactiveSortable();
                }else{
                    removerMateria($(ui.item).data("materiaid"));
                    removerGrupo(grupo);
                    $("div#collapse"+$(ui.item).data("materiaid")+" div.sortable div.arrastrable").removeClass("bg-trans-dark text-muted  unsortable");
                    $("div#collapse"+$(ui.item).data("materiaid")+" div.sortable").sortable('enable');
                    $(ui.item).unbind('mouseenter');
                    $(ui.item).unbind('mouseleave');
                    validarCruceDeHorarios();
                }
            }
        });
    }
    function agregarMateria(materiaId){
        materiasSeleccionadas.push(materiaId);
    }
    function removerMateria(materiaId){
        materiasSeleccionadas = materiasSeleccionadas.filter(function(item) { 
            return item !== materiaId;
        });
    }
    function agregarGrupo(grupo){
        gruposSeleccionadas.push(grupo.grupoId);
        grupo.horarios.forEach(function(item, index){
            horariosSeleccionados[parseInt(item.dia)].push([item.ini,item.fin,item.iniReal,item.finReal,item.grupo,item.materia]);
        });
    }
    function removerGrupo(grupo){
        gruposSeleccionadas = gruposSeleccionadas.filter(function(item) { 
            return item !== grupo.grupoId;
        });
        grupo.horarios.forEach(function(item, index){
            horariosSeleccionados[parseInt(item.dia)] = horariosSeleccionados[parseInt(item.dia)].filter(function(item2) { 
                return (item2[0]!==item.ini && item2[1]!==item.fin);
            });
        });
    }
    function prepareToReactiveSortable(){
        $(".Destino .arrastrable").unbind('mouseenter');
        $(".Destino .arrastrable").mouseenter(function(){
            $("div#collapse"+$(this).data("materiaid")+" div.sortable").sortable('enable');
        });
        $(".Destino .arrastrable").unbind('mouseleave');
        $(".Destino .arrastrable").mouseleave(function(){
            $("div#collapse"+$(this).data("materiaid")+" div.sortable").sortable('disable');
        });
    }
    function validarHorarioDisponible(horariospreviamenteseleccionados, horarios){
        var retorna = true; 
        if(horarios.length>0){
            horarios.forEach(function(item, index){
                var dia = parseInt(item.dia);
                var inicio = parseInt(item.ini);
                var final = parseInt(item.fin);
                var horariosDia = horariospreviamenteseleccionados[dia];
                if(horariosDia.length >0 ){
                    horariosDia.forEach(function(item2, index2){
                        if(item2[0]<=inicio  && inicio<=item2[1]){
                            retorna = false;
                        }
                        if(item2[0]<=final  && final<=item2[1]){
                            retorna = false;
                        }
                    });
                }
            });
        }
        return retorna;
    }
    function validarCruceDeHorarios(){
        $("div.list-group.sortable div.arrastrable").unbind('mouseenter');
        $("div.list-group.sortable div.arrastrable").mouseenter(function(){
            var grupo = $(this).data("grupo");
            puedeAgregar = validarHorarioDisponible(horariosSeleccionados, grupo.horarios);
            if(!puedeAgregar){
                desactivarItem(this);
            }else{
                if(!$(this).parent().hasClass("ui-sortable-disabled")){
                    activarItem(this);
                }
            }
        });
    }
    function desactivarItem(obj){
        $(obj).addClass("bg-trans-dark");
        $(obj).addClass("ui-state-disabled");
        $(obj).addClass("unsortable");
        $(obj).find("div.mensajeError").html("<div class=\"alert alert-warning fade in\"><button class=\"close\" data-dismiss=\"alert\"><span>×</span></button><strong>Error: </strong> Horarios cruzados, este grupo no se puede agregar. </div>");
    }
    function activarItem(obj){
        $(obj).removeClass("bg-trans-dark");
        $(obj).removeClass("ui-state-disabled");
        $(obj).removeClass("unsortable");
        $(obj).find("div.mensajeError").html("");
    }
    function previsualizar(obj){
        var grupo  = $(obj).data("grupo");
        mostrarHorariosSeleccionados();
        grupo.horarios.forEach(function(item, index){
            var dia = ".d_"+parseInt(item.dia);
            var horaIni = parseInt(item.iniReal);
            var horaFin = parseInt(item.finReal);
            var nombreGrupo = item.grupo;
            var nombreMateria = item.materia;
            htmlHorarioGrupoDia(dia, horaIni, horaFin, nombreMateria, nombreGrupo, "bg-info");
            //horariosSeleccionados[parseInt(item.dia)].push([item.ini,item.fin,item.iniReal,item.finReal,item.grupo,item.materia]);
        });
    }
    function mostrarHorariosSeleccionados(){
        limpiarPreviewHorario();
        for(i = 1; i < horariosSeleccionados.length; i++) {
            var dia = ".d_"+i;
            if(horariosSeleccionados[i].length > 0){
                for(j = 0; j < horariosSeleccionados[i].length; j++) { 
                    var horaIni = parseInt(horariosSeleccionados[i][j][2]);
                    var horaFin = parseInt(horariosSeleccionados[i][j][3]);
                    var nombreGrupo = horariosSeleccionados[i][j][4];
                    var nombreMateria = horariosSeleccionados[i][j][5];
                    htmlHorarioGrupoDia(dia, horaIni, horaFin, nombreMateria, nombreGrupo);
                }
            }
        } 
    }
    function limpiarPreviewHorario(){
        $(".dia").html("");
    }
    function htmlHorarioGrupoDia(dia, horaIni, horaFin, nombreMateria, nombreGrupo, bg = 'bg-success'){
        for(z=horaIni; z<horaFin; z++){
            var htmlPrevio = $("#h_"+z+" "+dia).html();
            if(htmlPrevio!==""){
                bg = "bg-danger ";
            }
            $("#h_"+z+" "+dia).html(htmlPrevio + htmlGrupoCelda(bg, nombreMateria, nombreGrupo));
        }
    }
    function htmlGrupoCelda(bg, nombreMateria, nombreGrupo){
        return "<div class=\""+bg+" text-sm\"><strong>Materia: </strong>"+nombreMateria+"<strong><br>Grupo: </strong>"+nombreGrupo+"<\div>"
    }
    function unixTimestamp(t){
        var dt = new Date(t*2000);
        var hr = dt.getHours();
        var m = "0" + dt.getMinutes();
        var s = "0" + dt.getSeconds();
        return hr+ ':' + m.substr(-2) + ':' + s.substr(-2);
    }
</script>
<div class="panel">
    
    <?php
    if (!$acceso) {
        ?>
        <div class="alert alert-danger fade in fa-2x"> 
            <strong><i class="fa fa-exclamation-triangle "></i></strong> No puede ingresar a prematriculas.
        </div>
        <?php
        foreach ($mensajeError as $error) {
            ?>
            <div class="alert alert-warning fade in">
                <button class="close" data-dismiss="alert"><span>×</span></button>
                <strong><i class="fa fa-exclamation-triangle"></i></strong> <?php echo $error; ?>.
            </div>
            <?php
        }
    } else {
        ?>
        <div class="panel-heading">
            <h3 class="panel-title">Materias disponibles</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="panel-group accordion" id="accordion">
                        <?php
                        foreach ($listadoMateriasDisponibles as $materia) {
                            ?>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-parent="#accordion" data-toggle="collapse" href="#collapse<?php echo $materia->getId(); ?>" aria-expanded="false" class="collapsed"><?php echo $materia->getNombreLargo(); ?></a>
                                    </h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapse<?php echo $materia->getId(); ?>" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        <div class="list-group sortable">
                                            <?php
                                            foreach($materia->getListadoGrupos() as $grupo){
                                                $arrayHorario = array();
                                                $i=0;
                                                foreach($grupo->getHorariosGrupo() as $horario){
                                                    $arrayHorario[$i]["dia"] = $horario->getCodigodia();
                                                    $arrayHorario[$i]["ini"] = strtotime($horario->getHorainicial())+1;
                                                    $arrayHorario[$i]["fin"] = strtotime($horario->getHorafinal());
                                                    $arrayHorario[$i]["iniReal"] = $horario->getHorainicial();
                                                    $arrayHorario[$i]["finReal"] = $horario->getHorafinal();
                                                    $arrayHorario[$i]["grupo"] = addslashes($grupo->getNombre());
                                                    $arrayHorario[$i]["materia"] = addslashes($materia->getNombreLargo());
                                                    $i++;
                                                }
                                                ?>
                                                <div class="list-group-item arrastrable" id="<?php echo $grupo->getId(); ?>" 
                                                     data-materiaid="<?php echo $materia->getId(); ?>"
                                                     data-grupo='<?php echo json_encode(array("grupoId"=>$grupo->getId(),"horarios"=>$arrayHorario));?>'  >
                                                    <h4 class="list-group-item-heading text-thin"><?php echo utf8_decode($grupo->getNombre()); ?></h4>
                                                    <p class="list-group-item-text">
                                                        <strong>Materia</strong></br>
                                                        <?php echo $materia->getNombreLargo(); ?></br> 
                                                        <strong>Cupo disponible:</strong> 
                                                            <?php echo $grupo->getCupoMaximo(); ?></br> 
                                                        <strong>Horarios</strong></br>
                                                        <?php
                                                        foreach($grupo->getHorariosGrupo() as $horario){
                                                            echo $horario->getDia()." de ". $horario->getHorainicial()." a ".$horario->getHorafinal() ."</br>";
                                                        }
                                                        ?>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12 previsualizar">
                                                            <button class="btn btn-info btn-rounded btn-labeled fa fa-eye"  data-target="#preview-lg-modal" data-toggle="modal" >Previsualizar</button>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 remover">
                                                            <button class="btn btn-warning btn-rounded btn-labeled fa fa-trash">Remover</button>
                                                        </div>
                                                    </div>
                                                    <div class="mensajeError"></div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-12">
                    panel dragable
                    <div class="panel-body sortable Destino" style="width:100%; min-height: 300px; background-color: threedface; ">
                        
                    </div>
                    
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    
    <div id="preview-lg-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">Horario - Vista previa</h4>
                </div>
                <div class="modal-body">
                    <table id="calendario" width="700px" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="background:#57A639;">Horas</th>
                                <th style="background:#57A639;">LUNES</th>
                                <th style="background:#57A639;">MARTES</th>
                                <th style="background:#57A639;">MIERCOLES</th>
                                <th style="background:#57A639;">JUEVES</th>
                                <th style="background:#57A639;">VIERNES</th>
                                <th style="background:#57A639;">SABADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="h_6" style="">
                                <td><strong>6:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_7" style="">
                                <td><strong>7:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_8" style="">
                                <td><strong>8:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_9" style="">
                                <td><strong>9:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_10" style="">
                                <td><strong>10:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_11" style="">
                                <td><strong>11:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_12" style="">
                                <td><strong>12:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_13" style="">
                                <td><strong>13:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_14" style="">
                                <td><strong>14:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_15" style="">
                                <td><strong>15:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_16" style="">
                                <td><stron>16:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_17" style="">
                                <td><strong>17:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_18" style="">
                                <td><strong>18:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_19" style="">
                                <td><strong>19:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_20" style="">
                                <td><strong>20:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                            <tr id="h_21" style="">
                                <td><strong>21:00</strong></td>
                                <td class="dia d_1"></td>
                                <td class="dia d_2"></td>
                                <td class="dia d_3"></td>
                                <td class="dia d_4"></td>
                                <td class="dia d_5"></td>
                                <td class="dia d_6"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>