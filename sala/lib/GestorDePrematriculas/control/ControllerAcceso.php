<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sala\lib\GestorDePrematriculas\control;
defined('_EXEC') or die;

/**
 * Description of ControlAcceso
 *
 * @author Andres
 */
use \Sala\lib\Servicios;
use \Sala\lib\Factory;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
use \Sala\lib\GestorDePrematriculas\dto\CarreraDTO;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\interfaces\IEstudiante;
use \Sala\lib\GestorDePrematriculas\impl\DAOBridgeImpl;
use \Sala\lib\GestorDePrematriculas\impl\FechaAcademicaImpl;
use \Sala\lib\GestorDePrematriculas\impl\PazYSalvoImpl;

class ControllerAcceso {
    
    private $CarreraDTO;
    private $periodoDTO;
    private $Estudiante;
    private $fechaAcademica;
    private $pazYSalvo;
    private $DAOBridgeImpl;
    private $mensajeError = array();
    
    public function __construct() {
        $this->DAOBridgeImpl = new DAOBridgeImpl();
        $this->Estudiante = $this->DAOBridgeImpl->consultarEstudiante(Factory::getSessionVar('codigo'), Factory::getSessionVar("sesion_idestudiantegeneral"));
        $this->CarreraDTO = $this->DAOBridgeImpl->getCarrera();
        $this->setEstudiante($this->Estudiante);
        $this->setCarreraDTO($this->CarreraDTO);
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
        if($this->Estudiante->validarEstado()===false){
            $permiso = false;
            $this->mensajeError[] = "No se encuentra como estudiante activo";
        }
        if($this->pazYSalvo->validarPazYSalvoEstudiante()===false){
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
        $this->periodoDTO = new PeriodoDTO(null,
                $periodoVigente->getCodigoperiodo(),
                $periodoVigente->getCodigoperiodo(),
                null,
                $periodoVigente->getFechainicioperiodo(),
                $periodoVigente->getFechavencimientoperiodo(),
                $periodoVigente->getNombreperiodo(),
                $periodoVigente->getNumeroperiodo());
        unset($periodoVigente);
    }
    
    public function setCarreraDTO(CarreraDTO $CarreraDTO){
        $this->carreraDTO = $CarreraDTO;
    }
    
    public function setEstudiante(IEstudiante $Estudiante){
        $this->Estudiante = $Estudiante;
    }
    
    private function setFechaAcademica(){
        $this->fechaAcademica = new FechaAcademicaImpl($this->carreraDTO, $this->periodoDTO);
    }
    
    private function setPazYSalvo(){
        $this->pazYSalvo = new PazYSalvoImpl($this->Estudiante->getEstudianteDTO());
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
}
