<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\lib\GestorDePrematriculas\interfaces\IDAOFacade;
use \Sala\lib\GestorDePrematriculas\dao\EstudianteDAO;
use \Sala\lib\GestorDePrematriculas\dao\CarreraDAO;
use \Sala\lib\GestorDePrematriculas\dao\PlanEstudioDAO;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;

/**
 * Description of DAOFacadeImpl
 *
 * @author Andres
 */
class DAOFacadeImpl implements IDAOFacade {
    
    private $CarreraDAO;
    private $EstudianteDAO;
    private $PlanEstudioDAO;
    
    public function __construct() {
        $this->EstudianteDAO = new EstudianteDAO(Factory::getSessionVar('codigo'), Factory::getSessionVar("sesion_idestudiantegeneral"));
        $this->CarreraDAO = new CarreraDAO();
    }

    
    public function getPlanEstudio() {
        $this->PlanEstudioDAO = new PlanEstudioDAO();
        $this->PlanEstudioDAO->setCarreraDto($this->CarreraDAO->getCarreraDTO());
        $this->PlanEstudioDAO->setCodigoEstudiante($this->EstudianteDAO->getEstudianteDTO()->getCodigo());
        $this->PlanEstudioDAO->buscarPlanEstudio();
    }

    public function getMateriasDisponibles(PeriodoDTO $periodo) {
        $this->PlanEstudioDAO->validarMateriasDisponibles($periodo); 
        return $this->PlanEstudioDAO->getPlanEstudioDTO();
    }

    public function getCarrera() {
        $carreraEstudiante = unserialize(Factory::getSessionVar("carreraEstudiante"));
        $this->CarreraDAO->consultarCarrera($carreraEstudiante->getCodigocarrera());
        return $this->CarreraDAO->getCarreraDTO();
    }

    public function getEstudiante() {
        return $this->EstudianteDAO->getEstudiante();
    }

}
