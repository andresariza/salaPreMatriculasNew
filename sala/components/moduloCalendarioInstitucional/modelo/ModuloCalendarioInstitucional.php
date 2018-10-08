<?php
namespace Sala\components\moduloCalendarioInstitucional\modelo;
defined('_EXEC') or die;
use \Sala\lib\Factory;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
class moduloCalendarioInstitucional implements \Sala\interfaces\Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct() {
        $this->db = Factory::createDbo();
    }
    
    public function getVariables($variables){
        $array = array();
        
        $eventos = \Sala\entidad\CalendarioInstitucional::getByCodigoCarrera();
        $array["eventos"] = $eventos;
        
        //d($array);
        return $array;
    }
}
