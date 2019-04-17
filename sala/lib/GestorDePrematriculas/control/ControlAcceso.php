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
use \Sala\lib\Factory;
use \Sala\lib\Servicios;
class ControlAcceso {
    
    private $carreraDTO;
    private $periodoDTO;
    private $Estudiante;
    private $fechaAcademica;
    private $pazYSalvo;
    private $mensajeError = array();
    
    public function __construct(\Sala\lib\GestorDePrematriculas\impl\EstudianteImpl $Estudiante, 
            \Sala\lib\GestorDePrematriculas\dto\CarreraDTO $CarreraDTO) {
        $this->setEstudiante($Estudiante);
        $this->setCarreraDTO($CarreraDTO);
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
    
    public function setPeriodoDTO(){
        $periodoVigente = Servicios::getPeriodoVigente();
        $this->periodoDTO = new \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO(null,
                $periodoVigente->getCodigoperiodo(),
                $periodoVigente->getCodigoperiodo(),
                null,
                $periodoVigente->getFechainicioperiodo(),
                $periodoVigente->getFechavencimientoperiodo(),
                $periodoVigente->getNombreperiodo(),
                $periodoVigente->getNumeroperiodo());
        unset($periodoVigente);
    }
    
    public function setCarreraDTO(\Sala\lib\GestorDePrematriculas\dto\CarreraDTO $CarreraDTO){
        $this->carreraDTO = $CarreraDTO;
    }
    
    public function setEstudiante(\Sala\lib\GestorDePrematriculas\impl\EstudianteImpl $Estudiante){
        $this->Estudiante = $Estudiante;
    }
    
    private function setFechaAcademica(){
        $this->fechaAcademica = new \Sala\lib\GestorDePrematriculas\impl\FechaAcademicaImpl($this->carreraDTO, $this->periodoDTO);
    }
    
    private function setPazYSalvo(){
        $this->pazYSalvo = new \Sala\lib\GestorDePrematriculas\impl\PazYSalvoImpl($this->Estudiante->getEstudianteDTO());
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
