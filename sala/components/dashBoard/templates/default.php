<?php 
defined('_EXEC') or die;
//d($horarioEstudiante);
//d($_SESSION);
?>

<div class="row">
    <div class="col-lg-8"> 
        <!--Banner para la Autoevalucion de asignaturas por parte de los docentes -->
        <?php         
        if(!empty($banner)){
        ?>
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">Auto Evaluacion Docente</h3>
            </div>
            <div class="panel-body">                                       
                <div class="row">
                    <a href="<?php echo $banner['UrlEncuesta']; ?>" target="_blank">
                        <img class="img-responsive" src="<?php echo HTTP_ROOT."/".$banner['imagen'];?>"/>
                    </a> 
                </div>               
            </div>
        </div>
        <?php 
        }
        ?>
        
        
        <?php                   
        if(!empty($encuestadocente)){
        ?>
        <?php echo Factory::printImportJsCss("js",HTTP_SITE."/components/dashBoard/assets/js/encuesta.js"); ?>
        <div class="panel panel-bordered panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Evaluacion Docente</h3>
            </div>
            <div class="panel-body">
                <div style="height:122px">                    
                    <h3>Para que usted pueda acceder a las opciones del sistema debe realizar la evaluación docente.</h3>                    
                    <div class="row">
                        <div class="col-md-3">
                            <h3>Aqui <i class="fa fa-arrow-right fa-2x"></i></h3>
                        </div>
                        <div class="col-md-1">
                            <input type="hidden" id="url" name="url" value="<?php echo $encuestadocente;?>">
                            <button id="evaluacionDocente" class="btn btn-warning btn-rounded"><i class="fa fa-group fa-3x"></i></button> 
                        </div>
                    </div>                        
                </div>                
            </div>
        </div>
        <?php 
        }
        ?>
        <?php
        $idPerfil = Sala\lib\Factory::getSessionVar('idPerfil');
        //$idVotacion = @$Votacion->getIdvotacion();
        if(!empty($horario)){
            ?>
            <div class="panel">
                <!--<div class="panel-media">
                    <img src="../../../assets/img/av1.png" class="panel-media-img img-circle img-border-light" alt="Profile Picture">
                    <div class="row">
                        <div class="col-lg-7">
                            <h3 class="panel-media-heading">Stephen Tran</h3>
                            <a href="#" class="btn-link">@stephen_doe</a>
                            <p class="text-muted mar-btm">Web and Graphic designer</p>
                        </div>
                        <div class="col-lg-5 text-lg-right">
                            <button class="btn btn-sm btn-primary">Add Friend</button>
                            <button class="btn btn-sm btn-mint btn-icon fa fa-envelope icon-lg"></button>
                        </div>
                    </div>
                </div>-->
            <?php
                echo $horario;
            ?>
            </div> 
            <?php
        }
        ?>
        <?php
        if(!empty($historicoNotas)){
            echo $historicoNotas;
        }
        ?>
        
        <!-- Calendar placeholder-->
        <!-- ============================================ -->
        <?php echo $calendario?>
        <!-- ============================================ --> 
</div>
    <div class="col-lg-4">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Eventos</h3>
            </div>
            <div class="panel-body" id="EventoDinamico">
                <i class="fa fa-spinner fa-pulse fa-3x"></i> Cargando...
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Conéctate con la UEB</h3>
            </div>
            <div class="panel-body bs-dashDoard-btn">
                <a title="" href="https://www.facebook.com/universidadelbosque" target="_blank" class="btn btn-labeled btn-primary btn-hover-primary fa fa-facebook icon-lg add-tooltip" data-original-title="Facebook" data-container="body">
                    <span class="hidden-xs">Facebook</span>
                </a>
                <a title="" href="https://www.linkedin.com/edu/universidad-el-bosque-11599" target="_blank" class="btn btn-labeled btn-info btn-hover-info fa fa-linkedin icon-lg add-tooltip" data-original-title="Linkedin" data-container="body">
                    <span class="hidden-xs">Linkedin</span>
                </a>
                <a title="" href="https://www.instagram.com/uelbosque" target="_blank" class="btn btn-labeled btn-warning btn-hover-warning fa fa-instagram icon-lg add-tooltip" data-original-title="Instagram" data-container="body">
                    <span class="hidden-xs">Instagram</span>
                </a>
                <a title="" href="https://twitter.com/UElBosque" target="_blank" class="btn btn-labeled btn-info btn-hover-info fa fa-twitter icon-lg add-tooltip" data-original-title="Twitter" data-container="body">
                    <span class="hidden-xs">Twitter</span>
                </a>
            </div>
        </div>
    </div>
</div>
    <!--===================================================-->
    <!--===================================================-->
 

<?php echo \Sala\lib\Factory::printImportJsCss("js",HTTP_SITE."/components/dashBoard/assets/js/dashBoard.js"); ?>