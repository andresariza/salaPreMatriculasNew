<?php
namespace Sala\components\misCarreras\control;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\lib\Servicios;
use \Sala\entidad\Carrera;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
class ControlMisCarreras   { 
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type stdObject
     * @access private
     */
    private $variables;
    
    public function __construct() {
        $this->db = Factory::createDbo();
    }
    
    public function setVariables($variables){
        $this->variables = $variables; 
    }
    
    public function seleccionarCarrera(){
        if(!empty($this->variables->codigoCarrera)){
            Factory::setSessionVar("codigofacultad", $this->variables->codigoCarrera);
            $Carrera = new \Sala\entidad\Carrera();
            $Carrera->setDb();
            $Carrera->setCodigocarrera($this->variables->codigoCarrera);
            $Carrera->getByCodigo();
            
            Factory::setSessionVar('carreraEstudiante', serialize($Carrera));
            Factory::setSessionVar("nombrefacultad", $Carrera->getNombrecarrera());
            
            $Periodo = Servicios::getPeriodoVigente();
            $PeriodoVirtual = Servicios::getPeriodoVirtualVigente($Carrera);
            
            Factory::setSessionVar('PeriodoSession', serialize($Periodo));
            Factory::setSessionVar('PeriodoVirtualSession', serialize($PeriodoVirtual));
            Factory::setSessionVar('codigoperiodosesion', $Periodo->getCodigoperiodo());
            
            Factory::inicializarPeridos();
            echo json_encode(array("s" => true));
        }else{
            echo json_encode(array("s" => false));
        }
        //d($_SESSION);
        exit();
    }
}