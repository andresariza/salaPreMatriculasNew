<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\components\prematricula\control;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\lib\GestorDePrematriculas\control\Controller;   
use \Sala\entidad\Grupo;

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
    
    private $Controller;
    
    public function __construct() {
        $this->db = Factory::createDbo();
        
        $this->Controller = new Controller();
    }
    
    public function setVariables($variables){
        $this->variables = $variables; 
    }
    
    public function reservarCupo(){
        $estudianteDTO = $this->Controller->getEstudiante()->getEstudianteDTO();
        
        $result= $this->Controller->reservarCupo($estudianteDTO, $this->variables->grupoId);
        
        echo json_encode(array("s"=>$result));
    }
    
    public function removerCupo(){
        $estudianteDTO = $this->Controller->getEstudiante()->getEstudianteDTO();
        
        $result = $this->Controller->borrarReserva($estudianteDTO, $this->variables->grupoId);
        echo json_encode(array("s"=>$result));
    }
    
    public function validarCuposDisponibles(){
        $result = $this->Controller->consultarReservasGrupo($this->variables->grupoId);
        
        $entGrupo = new Grupo();
        $entGrupo->setIdgrupo($this->variables->grupoId);
        $entGrupo->getById();
        
        echo json_encode(array( "cuposDisponibles" => ($entGrupo->getMaximogrupo() - $entGrupo->getMatriculadosgrupo()) - count($result)));
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
