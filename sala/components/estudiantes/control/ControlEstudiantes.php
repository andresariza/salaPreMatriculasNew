<?php
namespace Sala\components\estudiantes\control;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
class ControlEstudiantes{ 
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
}