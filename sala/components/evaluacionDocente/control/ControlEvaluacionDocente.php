<?php
namespace Sala\components\evaluacionDocente\control;
/**
 * @author 
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
class ControlEvaluacionDocente{ 
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
        $this->db = \Sala\lib\Factory::createDbo();
    }
    
    public function setVariables($variables){
        $this->variables = $variables; 
    }
    
    public function seleccionarMateria(){
        if(!empty($this->variables->codigoPeriodo)){
            Factory::setSessionVar('codigoperiodosesion', $this->variables->codigoPeriodo);
            $Periodo = new \Sala\entidad\Periodo();
            $Periodo->setDb();
            $Periodo->setCodigoperiodo($this->variables->codigoPeriodo);
            $Periodo->getById(); 
            echo json_encode(array("s" => true, "nombrePeriodo" => $Periodo->getNombreperiodo()));
        }else{
            echo json_encode(array("s" => false));
        }
        exit();
    }
}