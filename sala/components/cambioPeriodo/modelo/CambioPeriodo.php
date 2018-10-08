<?php
namespace Sala\components\cambioPeriodo\modelo;
defined('_EXEC') or die;
use \Sala\lib\Factory;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
class CambioPeriodo implements \Sala\interfaces\Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    public function __construct() {
        $this->db = \Sala\lib\Factory::createDbo();
    }
    
    public function getVariables($variables){
        $array = array();
        
        $codigofacultad = Factory::getSessionVar('codigofacultad'); 
        
        //d($_SESSION );
        
        $carreraSession = unserialize(Factory::getSessionVar('carreraEstudiante'));
        
        if( $codigofacultad != $carreraSession->getCodigocarrera()){        
            $Carrera = new \Sala\entidad\Carrera();
            $Carrera->setDb();
            $Carrera->setCodigocarrera($codigofacultad);
            $Carrera->getByCodigo();
        }else{
            $Carrera = $carreraSession;
            $Carrera->setDb();
        }
        
        $modalidadAcademica = $Carrera->getCodigomodalidadacademica();
        $codigocarrera = $Carrera->getCodigocarrera();
        //d($codigocarrera);
        $array['Carrera'] = $Carrera;
        
        $listaPeriodosVirtuales = \Sala\entidad\PeriodoVirtualCarrera::getList(" codigoCarrera = ".$this->db->qstr($codigocarrera));
        
        if(empty($listaPeriodosVirtuales)){
            $listaPeriodosVirtuales = \Sala\entidad\PeriodoVirtualCarrera::getList(" codigoModalidadAcademica = ".$this->db->qstr($modalidadAcademica));
        }
        $array['listaPeriodosVirtuales'] = $listaPeriodosVirtuales;
        
        $query = "SELECT p.codigoperiodo "
                ." FROM periodo p "
                ." INNER JOIN estadoperiodo e ON (p.codigoestadoperiodo = e.codigoestadoperiodo) "
                ." INNER JOIN carreraperiodo cp ON (cp.codigoperiodo = p.codigoperiodo) "
                ." WHERE  cp.codigocarrera = '".$codigofacultad."' "
                ." ORDER BY p.codigoperiodo DESC ";
        //d($query);
        /*$datos = $this->db->Execute($query);
        $data = $datos->GetArray();
        $listaPeriodos = array();
        
        foreach($data as $l){
            $listaPeriodos[] = $l['codigoperiodo'];
        }/**/
        $listaPeriodos = array();
        $listaPeriodos = \Sala\entidad\Periodo::getList(" codigoperiodo IN (".$query.")  ORDER BY codigoperiodo DESC ");
        $array['listaPeriodos'] = $listaPeriodos; 
        
        $Periodo = unserialize(Factory::getSessionVar("PeriodoSession"));
        $codigoperiodosesion = Factory::getSessionVar('codigoperiodosesion');
        //d($codigoperiodosesion);
        if($Periodo->getCodigoperiodo()!=$codigoperiodosesion){
            $Periodo = new \Sala\entidad\Periodo();
            $Periodo->setDb();
            $Periodo->setCodigoperiodo($codigoperiodosesion);
            $Periodo->getById();
        }
        
        $array['periodoActual'] = $Periodo;
        
        $PeriodoVirtualActual = Factory::getSessionVar('PeriodoVirtualSession');
        $array['periodoVirtualActual'] = $PeriodoVirtualActual;
        
        $array['rol'] = Factory::getSessionVar('rol');
        
        return $array;
    } 
}