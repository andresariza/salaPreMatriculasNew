<?php

namespace Sala\components\prematricula\modelo;
defined('_EXEC') or die; 
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
use \Sala\lib\Factory;
class Prematricula implements \Sala\interfaces\Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct() {
        $this->db = Factory::createDbo();
    }
    //put your code here
    public function getVariables($variables) {
        $ControlAcceso = new \Sala\lib\GestorDePrematriculas\control\ControlAcceso();
        if($ControlAcceso->validarDatosAccesoPrematricula()){
            ddd($ControlAcceso); 
        }
        return array();
    }

}
