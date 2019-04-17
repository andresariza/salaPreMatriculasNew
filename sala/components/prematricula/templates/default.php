<?php
defined('_EXEC') or die;
$listadoMateriasDisponibles = \Sala\components\prematricula\control\ControlPrematricula::getListadoMateriasDisponibles($PlanEstudio->getListadoMaterias());
d($listadoMateriasDisponibles);
?>
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
                                        <div class="list-group">
                                            <?php
                                            foreach($materia->getListadoGrupos() as $grupo){
                                                ?>
                                                <a class="list-group-item" id="<?php echo $grupo->getId(); ?>" href="#">
                                                    <h4 class="list-group-item-heading text-thin"><?php echo $grupo->getNombre(); ?></h4>
                                                    <p class="list-group-item-text">
                                                        <strong>Cupo disponible:</strong> 
                                                            <?php echo $grupo->getCupoMaximo(); ?>
                                                    </p>
                                                    <p class="list-group-item-text">
                                                        <strong>Horarios</strong></br>
                                                        <?php
                                                        foreach($grupo->getHorariosGrupo() as $horario){
                                                            echo $horario->getDia()." de ". $horario->getHorainicial()." a ".$horario->getHorafinal() ."</br>";
                                                        }
                                                        ?>
                                                    </p>
                                                </a>
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
            </div>
        </div>
        <?php
    }
    ?>
</div>