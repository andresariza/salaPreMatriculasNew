<?php
defined('_EXEC') or die;

echo Sala\lib\Factory::printImportJsCss("js",HTTP_SITE."/assets/js/jquery-ui.min.js");
$listadoMateriasDisponibles = \Sala\components\prematricula\control\ControlPrematricula::getListadoMateriasDisponibles($PlanEstudio->getListadoMaterias());

echo Sala\lib\Factory::printImportJsCss("css",HTTP_SITE."/components/prematricula/assets/css/default.css");
echo Sala\lib\Factory::printImportJsCss("js",HTTP_SITE."/components/prematricula/assets/js/default.js");
echo Sala\lib\Factory::printImportJsCss("js",HTTP_SITE."/components/prematricula/assets/js/previsualizarHorarios.js");
?>
<script type="text/javascript">
    var height = <?php echo count($listadoMateriasDisponibles)*45;?>;
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
        <div class="panel-body">
            <div class="row">
                <div class="alert alert-info  fa-2x fade in">
                    <button class="close" data-dismiss="alert"><span>×</span></button>
                    <strong><i class="fa fa-info-circle"></i></strong> Para agregar un grupo, haga clic sobre nombre de la materia y arrastre el grupo deseado al panel de grupos seleccionados, ó haga clic en el boton selecionar.
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="panel-heading">
                        <h3 class="panel-title">Materias y Grupos Disponibles</h3>
                    </div>
                    <div class="panel-group accordion" id="accordion">
                        <?php
                        foreach ($listadoMateriasDisponibles as $materia) {
                            ?>
                            <div class="panel" style="margin-bottom: 15px;">
                                <div class="panel-heading">
                                    <h5 class="panel-title" style="line-height: 15px;">
                                        <a data-parent="#accordion" data-toggle="collapse" href="#collapse<?php echo $materia->getId(); ?>" aria-expanded="false" class="collapsed">
                                            <span class="text-normal">
                                                <?php echo $materia->getNombreLargo(); ?> 
                                            </span><br>
                                            <span class="text-xs text-light">
                                                <strong>Semestre:</strong> <?php echo $materia->getSemestre(); ?> - 
                                            </span>
                                            <span class="text-xs text-light">
                                                <strong>Creditos:</strong> <?php echo $materia->getNumeroCreditos(); ?>
                                            </span>
                                            <div class="arrowAlignRight">
                                                <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-down"></i>
                                            </div>
                                        </a>
                                    </h5>
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
                                                     data-grupo='<?php echo json_encode(array("grupoId"=>$grupo->getId(),"horarios"=>$arrayHorario));?>' 
                                                     >
                                                    <p class="list-group-item-text">
                                                        <span class="nombreMateria">
                                                            <strong>Materia: 
                                                            <?php echo $materia->getNombreLargo(); ?></strong></br> 
                                                        </span>
                                                        <span class="nombreGrupo">
                                                            <strong>Grupo: </strong> 
                                                            <?php echo utf8_decode($grupo->getNombre()); ?></br> 
                                                        </span>
                                                        <span class="numeroSemestre">
                                                            <strong>Semestre:</strong> 
                                                            <?php echo $materia->getSemestre(); ?></br> 
                                                        </span>
                                                        <span class="numeroCreditos">
                                                            <strong>Creditos:</strong> 
                                                            <?php echo $materia->getNumeroCreditos(); ?></br> 
                                                        </span>
                                                        <span class="cuposDisponibles">
                                                            <strong>Cupo disponible:</strong> 
                                                            <?php echo $grupo->getCupoMaximo(); ?></br> 
                                                        </span>
                                                        <span class="horarios">
                                                            <strong>Horarios</strong></br>
                                                            <?php
                                                            foreach($grupo->getHorariosGrupo() as $horario){
                                                                echo $horario->getDia()." de ". $horario->getHorainicial()." a ".$horario->getHorafinal() ."</br>";
                                                            }
                                                            ?>
                                                        </span>
                                                    </p>
                                                    <div class="row pad-all">
                                                        <div class="col-md-6 col-sm-12 previsualizar">
                                                            <button class="btn btn-info btn-labeled fa fa-eye"  data-target="#preview-lg-modal" data-toggle="modal" >
                                                                Previsualizar este horario
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 seleccionarGrupo">
                                                            <button class="btn btn-success btn-labeled fa fa-share-square-o">Seleccionar</button>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 remover">
                                                            <button class="btn btn-warning btn-labeled fa fa-trash">Remover</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mensajeError"></div>
                                                        <div class="mensajeMateriaSeleccionada"></div>
                                                    </div>
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
                    <div class="panel-heading">
                        <div class="panel-control">
                            <button class="btn btn-success btn-labeled fa fa-eye previsualizarFinal" data-target="#preview-lg-modal" data-toggle="modal">Ver Horarios Seleccionados</button>
                        </div>
                        <h3 class="panel-title">Grupos Seleccionados</h3>
                    </div>
                    <div class="panel-body bg-gray-light sortable Destino" >
                        
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
                                <th class="bg-info">Horas</th>
                                <th class="bg-info">LUNES</th>
                                <th class="bg-info">MARTES</th>
                                <th class="bg-info">MIERCOLES</th>
                                <th class="bg-info">JUEVES</th>
                                <th class="bg-info">VIERNES</th>
                                <th class="bg-info">SABADO</th>
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
