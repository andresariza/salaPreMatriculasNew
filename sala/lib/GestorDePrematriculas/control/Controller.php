<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sala\lib\GestorDePrematriculas\control;
defined('_EXEC') or die;

/**
 * Description of Controller
 *
 * @author Andres
 */
use \Sala\lib\Servicios;
use \Sala\lib\Factory;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
use \Sala\lib\GestorDePrematriculas\dto\CarreraDTO;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\dto\PlanEstudioDTO;
use \Sala\lib\GestorDePrematriculas\impl\daoBridge\DAOBridgeImpl;
use \Sala\lib\GestorDePrematriculas\service\Servicio;

class Controller {
    
    private $Servicio;
    private $periodoDTO;
    private $Estudiante;
    private $DAOBridgeImpl;
    private $mensajeError = array();
    
    public function __construct() {
        $this->DAOBridgeImpl = new DAOBridgeImpl();
        $this->setEstudiante($this->DAOBridgeImpl->consultarEstudiante(Factory::getSessionVar('codigo'), Factory::getSessionVar("sesion_idestudiantegeneral")));
        $this->setCarreraDTO($this->DAOBridgeImpl->consultarCarrera()); 
        $this->setPeriodoDTO();
        
        $this->Servicio = new Servicio($this->Estudiante, $this->carreraDTO, $this->periodoDTO); 
    }
    
    public function validarDatosAccesoPrematricula(){
        return $this->Servicio->validarDatosAccesoPrematricula();
    }
    
    public function buscarPlanEstudio(EstudianteDTO $EstudianteDTO){
        return $this->DAOBridgeImpl->buscarPlanEstudio($this->periodoDTO, $EstudianteDTO);
    }
    
    public function setPeriodoDTO(){
        $periodoVigente = Servicios::getPeriodoVigente();
        $this->periodoDTO = new PeriodoDTO(
                $periodoVigente->getCodigoperiodo(),
                $periodoVigente->getFechainicioperiodo(),
                $periodoVigente->getFechavencimientoperiodo(),
                $periodoVigente->getNumeroperiodo());
        unset($periodoVigente);
    }
    
    public function setCarreraDTO(CarreraDTO $CarreraDTO){
        $this->carreraDTO = $CarreraDTO;
    }
    
    public function setEstudiante($Estudiante){
        $this->Estudiante = $Estudiante;
    }
    
    public function getCarreraDTO() {
        return $this->carreraDTO;
    }

    public function getPeriodoDTO() {
        return $this->periodoDTO;
    }

    public function getEstudiante() {
        return $this->Estudiante;
    }
    
    public function getMensajeError() {
        return $this->mensajeError;
    }
    
    public function borrarReserva(EstudianteDTO $estudianteDTO, $grupoid) {
        return $this->DAOBridgeImpl->borrarReserva($estudianteDTO, $grupoid);
    }

    public function consultarReservasEstudiante(EstudianteDTO $estudianteDTO) {
        return $this->DAOBridgeImpl->consultarReservasEstudiante($estudianteDTO);
    }
    
    public function consultarReservasGrupo($idGrupo) {
        return $this->DAOBridgeImpl->consultarReservasGrupo($idGrupo);
    }

    public function reservarCupo(EstudianteDTO $estudianteDTO,$grupoid) {
        return $this->DAOBridgeImpl->reservarCupo($estudianteDTO, $grupoid);
    }
    
    public function consultarCreditos(PlanEstudioDTO $planEstudioDTO, EstudianteDTO $estudianteDTO){
        return $this->Servicio->consultarCreditos($planEstudioDTO, $estudianteDTO);
    }
}
