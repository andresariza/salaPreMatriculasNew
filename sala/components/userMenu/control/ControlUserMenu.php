<?php
namespace Sala\components\userMenu\control;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
class ControlUserMenu{ 
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
    
    public function desactivarMenuPulsante(){
        $idUsuario = \Sala\lib\Factory::getSessionVar('idusuario');
        
        \Sala\lib\Factory::setCookieVar("disablePulsar_".$idUsuario, true, time() + (86400 * 30 * 5), "/");
        
        echo json_encode(array("s"=>true, "mensaje" => "Pulsar Deshabilitado"));
        exit();
    }
    
}