<?php
namespace Sala\components\dashBoard\modelo;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\lib\Servicios;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
class DashBoard implements \Sala\interfaces\Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct() {
        $this->db = Factory::createDbo();
    }
    
    public function getVariables($variables){
        /*
         * perfil 1 = Estudiante
         * perfil 2 = Profesor
         * perfil 3 = Administrativo
         * perfil 4 = Padre
         */
        require_once (PATH_SITE."/components/moduloCalendarioInstitucional/modelo/ModuloCalendarioInstitucional.php");
        $modeloRender = Factory::getRenderInstance();
        
        $array = array();
        
        $ModuloHistoricoNotas = new \Sala\components\moduloGraficaNotas\modelo\ModuloGraficaNotas($this->db);
        $variablesHistorico = clone $variables;
        $variablesHistorico->layout = "historico";
        unset($variablesHistorico->option);
        $arrayHistoricoNotas = $ModuloHistoricoNotas->getVariables($variablesHistorico);
        $moduloName = "moduloGraficaNotas"; 
        $historicoNotas = $modeloRender->render('historicoDeNotas',"/components/".$moduloName,$arrayHistoricoNotas, true);
        $array["historicoNotas"] = $historicoNotas; 

        
        $Usuario = new \Sala\entidad\Usuario();
        $Usuario->setIdusuario(Factory::getSessionVar('idusuario'));
        $Usuario->getUsuarioByIdUsuario();
        
        $idPerfil = Factory::getSessionVar('idPerfil');
        $codigo = Factory::getSessionVar('codigo');
        $documento = $Usuario->getNumerodocumento();
        //d($idPerfil);
        if((($idPerfil == 1 || $idPerfil == 4) && ($codigo == $documento)) || (@$variables->layout=="carrerasEstudiante" )){
            $variables->layout = "carrerasEstudiante";
            $array["carrerasEstudiante"] = $this->getCarrerasEstudiante();
        }
        $tipoHorario = "";
        if($idPerfil == 1){
            $tipoHorario = 'estudiante';
            $array["encuestadocente"] = $this->getEncuestasDocente($Usuario);
        }elseif($idPerfil == 2){                            
            $tipoHorario = 'Docente';
            $array["banner"]=  $this->getFechaBanner();              
        }
        $array["horario"] = $this->getHorario($tipoHorario,$Usuario,$variables);

        $moduloCalendarioInstitucional = new \Sala\components\moduloCalendarioInstitucional\modelo\ModuloCalendarioInstitucional($this->db);
        $arrayCaledario = $moduloCalendarioInstitucional->getVariables($variables);
        
        $moduloName = "moduloCalendarioInstitucional"; 
        //ddd($fecha); 

        $calendario = $modeloRender->render('default',"/components/".$moduloName,$arrayCaledario, true);
        
        $array["calendario"] = $calendario;
        
        //d($idPerfil);
        /*if($idPerfil){
            $Votacion = $this->getVotacionDocente();
            $array["Votacion"] = $Votacion;
        }/**/
        //$Modelo = new Menu($this->db);
        //$array = $Modelo->getVariables($variables);  
        //d($array);
        /*$controlRender = new ControlRender();
        $menu = $controlRender->render("menu",$array, true);
        $array["menu"] = $menu;/**/

        return $array;
    }
    
    private function getVotacionDocente(){
        
        //'codigodocente';
        $codigodocente = Factory::getSessionVar('codigodocente');
        $Votacion = new \Sala\entidad\Votacion();
        $DocentesVoto = new \Sala\entidad\DocentesVoto();
        $Votacion->setDb();
        $Votacion->getVotacionVigente();
        
        $idVotacion = $Votacion->getIdvotacion();
        if(!empty($idVotacion)){
            $DocentesVoto->setDb();
            $DocentesVoto->setNumerodocumento($codigodocente);
            $DocentesVoto->getByDocumento();
            $codigoCarrera = $DocentesVoto->getCodigocarrera();
            if(empty($codigoCarrera)){
                //$Votacion = null;
            }
            
            if(!empty($numerodocumento)){
                $query_votacion_vigente="SELECT COUNT(vv.numerodocumentovotantesvotacion) AS votos "
                        . "FROM votacion v "
                        . "INNER JOIN votantesvotacion vv ON (v.idvotacion = vv.idvotacion) "
                        . "WHERE v.codigoestado = '100' "
                        . " AND vv.codigoestado = '100' "
                        . " AND now() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion "
                        . " AND v.idvotacion = ".$this->db->qstr($idVotacion)." "
                        . " AND vv.numerodocumentovotantesvotacion = ".$this->db->qstr($codigodocente)." ";
                
		$operacion_votacion_vigente = $this->db->Execute($query_votacion_vigente);
		$row_operacion_votacion_vigente = $operacion_votacion_vigente->fetchRow();
		$cantVotos = $row_operacion_votacion_vigente['votos'];
		if($cantVotos==0){
                    $datosvotante = array('codigoestudiante'=> Factory::getSessionVar('codigo'),'numerodocumento'=>$codigodocente,'codigocarrera'=>$codigoCarrera,'tipovotante'=>'docente','cantVotos'=>$cantVotos,'idvotacion'=>$idVotacion,'modalidadacademica'=>null);
                    Factory::setSessionVar('datosvotante', $datosvotante);
		}
            }
            
        }
        return $Votacion;
    }
    
    private function getCarrerasEstudiante(){
        $codigoestudiante = Factory::getSessionVar('codigo');
        
        $Usuario = new \Sala\entidad\Usuario();
        $Usuario->setIdusuario(Factory::getSessionVar('idusuario'));
        $Usuario->getUsuarioByIdUsuario();
         
        $documento = $Usuario->getNumerodocumento();
        unset($Usuario);
        
        if($documento!=$codigoestudiante){
            $codigoestudiante = $documento;
        }
        //d($codigoestudiante);
        $query = "SELECT DISTINCT c.nombrecarrera, c.codigocarrera, eg.apellidosestudiantegeneral, "
                . " eg.nombresestudiantegeneral, d.nombredocumento, d.tipodocumento, "
                . " e.codigoestudiante, eg.numerodocumento, eg.fechanacimientoestudiantegeneral, "
                . " eg.expedidodocumento, eg.idestudiantegeneral, gr.nombregenero, "
                . " e.codigoperiodo, eg.celularestudiantegeneral, eg.emailestudiantegeneral, "
                . " eg.codigogenero,s.nombresituacioncarreraestudiante, eg.direccionresidenciaestudiantegeneral, "
                . " eg.telefonoresidenciaestudiantegeneral, eg.ciudadresidenciaestudiantegeneral, eg.direccioncorrespondenciaestudiantegeneral, "
                . " eg.telefonocorrespondenciaestudiantegeneral, eg.ciudadcorrespondenciaestudiantegeneral, e.codigocarrera "
                . "FROM estudiante e "
                . "INNER JOIN estudiantegeneral eg ON (e.idestudiantegeneral = eg.idestudiantegeneral) "
                . "INNER JOIN estudiantedocumento ed ON (e.idestudiantegeneral = ed.idestudiantegeneral AND ed.idestudiantegeneral = eg.idestudiantegeneral) "
                . "INNER JOIN carrera c ON (e.codigocarrera = c.codigocarrera) "
                . "INNER JOIN documento d ON (eg.tipodocumento = d.tipodocumento) "
                . "INNER JOIN situacioncarreraestudiante s ON (e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante) "
                . "INNER JOIN genero gr ON (gr.codigogenero = eg.codigogenero) "
                . "WHERE ed.numerodocumento = ".$this->db->qstr($codigoestudiante)." "
                . "ORDER BY e.codigosituacioncarreraestudiante DESC";
        //d($query);
        $datos = $this->db->Execute($query);
        
        $data = $datos->GetArray();
        
        return $data;
    }
    
    private function getHorario($tipo,$Usuario,$variables){
        require_once (PATH_SITE."/components/horario/modelo/Horario.php");
        $horario = null;
        $modeloRender = Factory::getRenderInstance();
        $variables->Usuario = $Usuario;
        $variables->periodo = Factory::getSessionVar('codigoperiodosesion');
        $variables->FechaFutura_1 = date("Y-m-d");
        $variables->FechaFutura_2 = date("Y-m-d");
        $variables->diaDeLaSemana = date('N');
        $variables->tipo = $tipo;
        //d($variables);
        
        $Horario = new \Sala\components\horario\modelo\Horario($this->db);
        $array = $Horario->getVariables($variables);
        
        $moduloName = "horario"; 
        if(!empty($tipo)){
            $horario = $modeloRender->render('default',"/components/".$moduloName,$array, true);
        }
        return $horario;
    }
    
    /*Funcion creada para la definición de la fecha inicio y la fecha fin en las que se va a mostrar el Banner de la Autoevalución de Asignaturas por parte de los docentes.*/
    private function getFechaBanner(){ 
        $query = "SELECT imagen, UrlEncuesta "
                . " FROM AutoevaluacionesDocente "
                . " WHERE FechaInicial <= NOW() "
                . " AND Fechafinal >= NOW() "
                . " AND CodigoEstado=100";
        $datos = $this->db->GetRow($query);                   
        
        $arrayautoevaluacion = array();
        
        if(!empty($datos)){
            $arrayautoevaluacion['imagen'] = $datos['imagen'];
            $arrayautoevaluacion['UrlEncuesta']= $datos['UrlEncuesta'];
        }
         
        return $arrayautoevaluacion;
     }
    
    /*
     * Ivan Dario Quintero Rios
     * Abril 30 del 2018     
     * Defincion de funcion para evaluacion docentes activas
     */
      
    private function getEncuestasDocente($Usuario){
        $codigoestudiante = Factory::getSessionVar('codigo');
        $idCarrera = Factory::getSessionVar('idCarrera');
        $idusuario = $Usuario->getIdusuario();                               
        $valorreturn = 0;
        
        if($idCarrera){
            //validar la lista de encuestas activas
            require_once (PATH_SITE."/entidad/Encuesta.php");
            require_once (PATH_SITE."/entidad/EncuestaMateria.php");
            require_once (PATH_SITE."/entidad/EncuestaCarreras.php");
            $Encuesta = new \Sala\entidad\Encuesta();        
            $EncuestaMateria = new \Sala\entidad\EncuestaMateria();
            $EncuestaMateria->setDb();
            $EncuestaCarreras = new \Sala\entidad\EncuestaCarreras();    
            $codigoperiodo = Factory::getSessionVar('codigoperiodosesion');

            //consulta de las encuestas activas para fecha actual
            $dia = date("Y-m-d");
            $where = " fechainicioencuesta <= ".$this->db->qstr($dia)." AND fechafinalencuesta >= ".$this->db->qstr($dia)." AND codigoestado=100 ";        
            $lista = $Encuesta->getList($where);                                                
            
            if(!empty($lista[0])){
                //ingresa a la lista de encuestas activas        
                foreach($lista as $datos){            
                    $idencuesta = $datos->getIdencuesta();
                    
                    //Valida la encuesta para el proceso
                    if($idencuesta <> '' || $idencuesta <> null){                        
                        //consulta si extsite para el periodo y para la carrera la encuesta activa, para la fecha actual
                        $where = " codigoperiodo = ".$this->db->qstr($codigoperiodo)." AND CodigoCarrera = ".$this->db->qstr($idCarrera)." AND CodigoEstado = 100 AND FechaFinal > now()";
                        $carreras = $EncuestaCarreras->getList($where);                          
                        
                        if($carreras <> null){
                            $valor = $carreras[0]->getCodigocarrera();  
                            if($valor == $idCarrera){
                                //se consulta el listado de materias matriculas para el estudiante
                                $materiasestudiante = $EncuestaMateria->getEncuestamateriaEstudiante($codigoperiodo,$idCarrera,$codigoestudiante);    
                                foreach($materiasestudiante as $materias){
                                    //Se valida si las materias matriculadas ya fueron evaluadas                                             
                                    $contadorRespuestas = $EncuestaMateria->getRespuestaencuestamateria($codigoestudiante, $codigoperiodo, $materias['codigomateria']);                                                                                                                                   

                                    if($contadorRespuestas == 0){
                                        //Se debe realizar la evaluacion
                                        $valorreturn = 1;                                    
                                    }
                                }//foreach                            
                            }//if
                        }//if
                    }//if
                }//foreach
            }else{                
                //validacion de instrumentos creados.
                //verifica que existan evaluaciones activas para estudiantes
                $query = "SELECT idsiq_Ainstrumentoconfiguracion "
                        . "FROM siq_Ainstrumentoconfiguracion "
                        . "WHERE fecha_inicio <= NOW() "
                        . " AND fecha_fin > NOW() "
                        . " AND codigoestado = 100 "
                        . " AND cat_ins LIKE '%EDOCENTES%'";
                $datos = $this->db->GetRow($query);        

                //sí es la encuesta 321 se verifican los grupos y las materias matriculas por los estudiantes
                if(!empty($datos['idsiq_Ainstrumentoconfiguracion']) && $datos['idsiq_Ainstrumentoconfiguracion'] == '321'){
                    $sql ="SELECT d.idprematricula, p.codigoestudiante , e.codigocarrera, d.idgrupo "
                            . "FROM detalleprematricula d "
                            . "INNER JOIN prematricula p ON (d.idprematricula = p.idprematricula) "
                            . "INNER JOIN estudiante e ON (p.codigoestudiante = e.codigoestudiante) "
                            . "WHERE d.idgrupo IN (124594, "
                            . " 124656,        124657,            124692,         124693, "
                            . " 124717,         125365,            125366,            125367, "
                            . " 125368,            125369,            125370,            125371, "
                            . " 125373,            125067,            130003,            129113, "
                            . " 129114,            129115,            129110,            129111, "
                            . " 129112,            129781,            129438,            129439, "
                            . " 129440,            129615,            129616,            125176, "
                            . " 130580,            130745,            125621,            125622, "
                            . " 125668,            125669,            125686,            125705, "
                            . " 125721,            125764,            125097,            125128, "
                            . " 124525,            124457,            129002,            124419, "
                            . " 124493,            125957,            125958,           125959, "
                            . " 125960,            125961,            126113,            126114, "
                            . " 128633,            130483,            127165,            127166, "
                            . " 127197,            127429,            127430,            127490, "
                            . " 127491,            127347,            128184,            128185, "
                            . " 128186,            127012,            127014,            127236, "
                            . " 127237,            127263,            127274,            127289, "
                            . " 127290,            127012,            127014,            127036, "
                            . " 127932,            127933,            128092,            126384, "
                            . " 126392,            128530,            126719,            126727, "
                            . " 128818,            126769,            126831,            128010, "
                            . " 128235,            128236,            128237,            128238 "
                            . " ) "
                            . " AND d.codigoestadodetalleprematricula = 30 "
                            . " AND e.codigoestudiante = ".$this->db->qstr($codigoestudiante)." ";
                    
                    $matriculado = $this->db->GetAll($sql);        

                    foreach($matriculado as $grupos){
                        $idgrupo = $grupos['idgrupo'];             

                        if($idgrupo != null || $idgrupo  != ''){
                            //Valida la cantidad de respuestas que tiene registardas el estudainte para la encuesta
                            $sqlrespuestas ="SELECT COUNT(*) AS contador "
                                    . "FROM siq_Arespuestainstrumento r "
                                    . "WHERE r.idsiq_Ainstrumentoconfiguracion = ".$this->db->qstr($encuestadocente)." "
                                    . " AND r.usuariocreacion = ".$this->db->qstr($idusuario)." "
                                    . " AND r.codigoestado = 100 "
                                    . " AND r.idgrupo = ".$this->db->qstr($idgrupo)." ";
                            $respuesta = $this->db->GetRow($sqlrespuestas);       

                            //Valida la cantidad de presguntas que tiene el instrumento
                            $sqltotalpreguntas = "SELECT COUNT(*) AS total "
                                    . "FROM siq_Ainstrumento a "
                                    . "WHERE a.idsiq_Ainstrumentoconfiguracion = ".$this->db->qstr($encuestadocente)." "
                                    . " AND a.codigoestado = '100'";
                            $total = $this->db->GetRow($sqltotalpreguntas);

                            if($respuesta['contador'] < $total['total']){
                                $valorreturn = 2;
                            }
                        }   
                    }
                // encuesta 321*/    
                }else{
                    //complemento de instrumentos pendientes
                }
            }
            return $valorreturn;
        }
    }
}