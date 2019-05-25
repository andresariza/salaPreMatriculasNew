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
use \Sala\lib\GestorDePrematriculas\impl\estudiante\EstudianteImpl;
use \Sala\lib\GestorDePrematriculas\impl\daoBridge\DAOBridgeImpl;
use \Sala\lib\GestorDePrematriculas\impl\validaAcceso\FechaAcademicaImpl;
use \Sala\lib\GestorDePrematriculas\impl\validaAcceso\PazYSalvoImpl;
use \Sala\lib\GestorDePrematriculas\impl\auxiliaresPlanEstudio\CreditosDisponiblesImpl;

class Controller {
    
    private $CarreraDTO;
    private $periodoDTO;
    private $Estudiante;
    private $fechaAcademica;
    private $pazYSalvo;
    private $DAOBridgeImpl;
    private $mensajeError = array();
    
    public function __construct() {
        $this->DAOBridgeImpl = new DAOBridgeImpl();
        $this->setEstudiante($this->DAOBridgeImpl->consultarEstudiante(Factory::getSessionVar('codigo'), Factory::getSessionVar("sesion_idestudiantegeneral")));
        $this->setCarreraDTO($this->DAOBridgeImpl->consultarCarrera()); 
        $this->setPeriodoDTO();
        
        $this->setFechaAcademica();
        $this->setPazYSalvo();
    }
    
    public function validarDatosAccesoPrematricula(){
        $permiso = true;
        
        if($this->fechaAcademica->validarFechaAcademica()===false){
            $permiso = false;
            $this->mensajeError[] = "No se encuentra dentro de las fechas permitidas para prematricula";
        }
        $estudiante = new EstudianteImpl($this->Estudiante);
        if($estudiante->validarEstado()===false){
            $permiso = false;
            $this->mensajeError[] = "No se encuentra como estudiante activo";
        }
        if($this->Estudiante->getEstadoPrematricula()===true){
            $permiso = false;
            $this->mensajeError[] = "El estudiante ya realizo la prematricula";
        }
        if($this->pazYSalvo->validarPazYSalvoEstudiante($this->Estudiante, $this->periodoDTO)===false){
            $permiso = false;
            $this->mensajeError[] = "No se encuentra a paz y salvo";
        }
        
        return $permiso;
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
    
    private function setFechaAcademica(){
        $this->fechaAcademica = new FechaAcademicaImpl($this->carreraDTO, $this->periodoDTO);
    }
    
    private function setPazYSalvo(){
        $this->pazYSalvo = new PazYSalvoImpl($this->Estudiante);
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

    public function getFechaAcademica() {
        return $this->fechaAcademica;
    }

    public function getPazYSalvo() {
        return $this->pazYSalvo;
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
        $CreditosDisponiblesImpl = new CreditosDisponiblesImpl();
        return $CreditosDisponiblesImpl->consultarCreditos($planEstudioDTO, $estudianteDTO);
    }
}
