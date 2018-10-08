<?php
namespace Sala\components\cambioPeriodo\control;
defined('_EXEC') or die;
use \Sala\lib\Factory;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
class ControlCambioPeriodo{ 
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
    
    public function seleccionarPeriodo(){
        //d($_SESSION);
        //d($this->variables);
        if(!empty($this->variables->codigoPeriodo)){
            Factory::setSessionVar('codigoperiodosesion', $this->variables->codigoPeriodo);
            $Periodo = new \Sala\entidad\Periodo();
            $Periodo->setDb();
            $Periodo->setCodigoperiodo($this->variables->codigoPeriodo);
            $Periodo->getById();
            
            Factory::setSessionVar('PeriodoSession', serialize($Periodo));
            
            $nombrePeriodo = $Periodo->getNombreperiodo();
            
            if(!empty($this->variables->idPeriodoVirtual)){
                $PeriodoVirtualCarrera = new \Sala\entidad\PeriodoVirtualCarrera();
                $PeriodoVirtualCarrera->setDb();
                $PeriodoVirtualCarrera->setId($this->variables->idPeriodoVirtual);
                $PeriodoVirtualCarrera->getById();
                
                $nombrePeriodo = $PeriodoVirtualCarrera->getPeriodoVirtual()->getNombrePeriodo();
                Factory::setSessionVar('PeriodoVirtualSession', serialize($PeriodoVirtualCarrera));
            }
            // 'PeriodoVirtualSession'
            echo json_encode(array("s" => true, "nombrePeriodo" => $nombrePeriodo));
        }else{
            echo json_encode(array("s" => false));
        }
        exit();
    }
}