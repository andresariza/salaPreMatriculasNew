<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\components\prematricula\control;
defined('_EXEC') or die;
use \Sala\lib\Factory;

/**
 * Description of ControlPrematricula
 *
 * @author Andres
 */
class ControlPrematricula {
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
    
    public static function getListadoMateriasDisponibles($listadoMaterias){
        $listadoDisponibles = $listadoMaterias;
        $i = 0;
        foreach($listadoDisponibles as $l){
            if(empty($l->getListadoGrupos()) || !$l->getDisponibleMatricula()){
                unset($listadoDisponibles[$i]);
            }
            $i++;
        }
        return $listadoDisponibles;
    }
}
