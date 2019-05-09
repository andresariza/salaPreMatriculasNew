<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\abstracts\DAOBridge;
/**
 * Description of DAOFacadeImpl
 *
 * @author Andres
 */
class DAOBridgeImpl extends DAOBridge {
    
    public function __construct(){
        parent::__construct();
    }

    
    public function buscarPlanEstudio(PeriodoDTO $periodo, EstudianteDTO $EstudianteDTO) {
        $this->getPlanEstudioDAO()->setCarreraDto($this->getCarrera());
        $this->getPlanEstudioDAO()->setCodigoEstudiante($EstudianteDTO->getCodigo());
        return $this->getPlanEstudioDAO()->buscarPlanEstudio($periodo);
    }

    public function getCarrera() {
        $carreraEstudiante = unserialize(Factory::getSessionVar("carreraEstudiante"));
        return $this->getCarreraDAO()->consultarCarrera($carreraEstudiante->getCodigocarrera());
    }

    public function consultarEstudiante($codigo,$idEstudiante){
        return $this->getEstudianteDAO()->consultarEstudiante($codigo,$idEstudiante);
    }

    public function borrarReserva(EstudianteDTO $estudianteDTO, $grupoid) {
        return $this->getReservaCupoDAO()->borrarReserva($estudianteDTO, $grupoid);
    }

    public function consultarReservas(EstudianteDTO $estudianteDTO) {
        return $this->getReservaCupoDAO()->consultarReservas($estudianteDTO);
    }

    public function reservarCupo(EstudianteDTO $estudianteDTO, $grupoid) {
        return $this->getReservaCupoDAO()->reservarCupo($estudianteDTO, $grupoid);
    }

}
