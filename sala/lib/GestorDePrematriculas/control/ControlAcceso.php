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
    
    public function __construct() {
        $this->setPeriodoDTO();
        $this->setCarreraDTO();
        
        #toDo tratar de implementar un Builder para la creacion de estudiante
        $this->setEstudiante();
        $this->setFechaAcademica();
        $this->setPazYSalvo();
    }
    
    public function validarDatosAccesoPrematricula(){
        return ( $this->fechaAcademica->validarFechaAcademica() &&
                $this->Estudiante->validarEstado() && 
                $this->pazYSalvo->validarPazYSalvoEstudiante());
    }
    
    private function setPeriodoDTO(){
        $periodoVigente = Servicios::getPeriodoVigente();
        $this->periodoDTO = new \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO();
        $this->periodoDTO->codigoPeriodo = $periodoVigente->getCodigoperiodo();
        $this->periodoDTO->agno = $periodoVigente->getCodigoperiodo();
        $this->periodoDTO->fechaFin = $periodoVigente->getFechainicioperiodo();
        $this->periodoDTO->fechaInicio = $periodoVigente->getFechavencimientoperiodo();
        $this->periodoDTO->nombre = $periodoVigente->getNombreperiodo();
        $this->periodoDTO->numeroPeriodo = $periodoVigente->getNumeroperiodo();
        unset($periodoVigente);
    }
    
    private function setCarreraDTO(){
        $carreraEstudiante = unserialize(Factory::getSessionVar("carreraEstudiante"));        
        $this->carreraDTO = new \Sala\lib\GestorDePrematriculas\dto\CarreraDTO();
        $this->carreraDTO->id = $carreraEstudiante->getCodigocarrera();
        $this->carreraDTO->nombre = $carreraEstudiante->getNombrecarrera();
        $this->carreraDTO->titulo = $carreraEstudiante->getNombrecarrera();
        unset($carreraEstudiante);
    }
    
    private function setEstudiante(){        
        $eEstudiante = new \Sala\entidad\Estudiante();
        $eEstudiante->setCodigoEstudiante(Factory::getSessionVar('codigo'));
        $eEstudiante->setDb();
        $eEstudiante->getById();
        //d($eEstudiante);
        
        $eEstudianteGeneral = new \Sala\entidad\EstudianteGeneral();
        $eEstudianteGeneral->setIdestudiantegeneral(Factory::getSessionVar("sesion_idestudiantegeneral"));
        $eEstudianteGeneral->setDb();
        $eEstudianteGeneral->getById();
        //d($eEstudianteGeneral);
        
        $this->Estudiante = new \Sala\lib\GestorDePrematriculas\impl\EstudianteImpl($eEstudiante->getCodigoesEstudiante(), 
                $eEstudiante->getCodigoesEstudiante(), $eEstudiante->getCodigosituacioncarreraestudiante(),
                $eEstudianteGeneral->getNombresestudiantegeneral(), $eEstudianteGeneral->getApellidosestudiantegeneral());
    }
    
    private function setFechaAcademica(){
        $this->fechaAcademica = new \Sala\lib\GestorDePrematriculas\impl\FechaAcademicaImpl($this->carreraDTO, $this->periodoDTO);
    }
    
    private function setPazYSalvo(){
        $this->pazYSalvo = new \Sala\lib\GestorDePrematriculas\impl\PazYSalvoImpl($this->Estudiante);
    }
}
