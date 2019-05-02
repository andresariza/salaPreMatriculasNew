<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;
use \Sala\lib\Factory;

/**
 * Description of DAOFacadeImpl
 *
 * @author Andres
 */
class DAOBridgeImpl extends \Sala\lib\GestorDePrematriculas\abstracts\DAOBridge {
    
    public function __construct(){
        parent::__construct();
    }

    
    public function getPlanEstudio(\Sala\lib\GestorDePrematriculas\dto\PeriodoDTO $periodo) {
        $this->getPlanEstudioDAO()->setCarreraDto($this->getCarrera());
        $this->getPlanEstudioDAO()->setCodigoEstudiante($this->getEstudianteDAO()->getEstudianteDTO()->getCodigo());
        $this->getPlanEstudioDAO()->buscarPlanEstudio();
        return $this->getMateriasDisponibles($periodo);
    }

    private function getMateriasDisponibles(\Sala\lib\GestorDePrematriculas\dto\PeriodoDTO $periodo) {
        $this->getPlanEstudioDAO()->validarMateriasDisponibles($periodo); 
        return $this->getPlanEstudioDAO()->getPlanEstudioDTO();
    }

    public function getCarrera() {
        $carreraEstudiante = unserialize(Factory::getSessionVar("carreraEstudiante"));
        return $this->getCarreraDAO()->consultarCarrera($carreraEstudiante->getCodigocarrera());
    }

    public function getEstudiante(){
        return $this->getEstudianteDAO()->getEstudiante();
    }

}
