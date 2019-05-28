<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sala\lib\GestorDePrematriculas\service;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
use \Sala\lib\GestorDePrematriculas\dto\CarreraDTO;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\dto\PlanEstudioDTO;
use \Sala\lib\GestorDePrematriculas\impl\estudiante\EstudianteImpl;
use \Sala\lib\GestorDePrematriculas\impl\validaAcceso\FechaAcademicaImpl;
use \Sala\lib\GestorDePrematriculas\impl\validaAcceso\PazYSalvoImpl;
use \Sala\lib\GestorDePrematriculas\impl\auxiliaresPlanEstudio\CreditosDisponiblesImpl;

/**
 * Description of servicio
 *
 * @author Andres
 */
class Servicio {
    private $creditosDisponiblesImpl;
    private $estudianteImpl;
    private $fechaAcademicaImpl;
    private $pazYSalvoImpl;
    private $periodoDTO;
    private $estudianteDTO;
    
    public function __construct(EstudianteDTO $estudianteDTO, CarreraDTO $carreraDTO, 
            PeriodoDTO $periodoDTO) {
        $this->periodoDTO = $periodoDTO;
        $this->estudianteDTO = $estudianteDTO;
        $this->estudianteImpl = new EstudianteImpl($estudianteDTO);
        $this->fechaAcademicaImpl = new FechaAcademicaImpl($carreraDTO, $periodoDTO);
        $this->pazYSalvoImpl = new PazYSalvoImpl($estudianteDTO);
        $this->creditosDisponiblesImpl = new CreditosDisponiblesImpl();
    }
    
    public function consultarCreditos(PlanEstudioDTO $planEstudioDTO, EstudianteDTO $estudianteDTO){
        return $this->creditosDisponiblesImpl->consultarCreditos($planEstudioDTO, $estudianteDTO);
    }
    
    public function validarDatosAccesoPrematricula(){
        $permiso = true;
        
        if($this->fechaAcademicaImpl->validarFechaAcademica()===false){
            $permiso = false;
            $this->mensajeError[] = "No se encuentra dentro de las fechas permitidas para prematricula";
        }
        
        if($this->estudianteImpl->validarEstado()===false){
            $permiso = false;
            $this->mensajeError[] = "No se encuentra como estudiante activo";
        }
        if($this->estudianteDTO->getEstadoPrematricula()===true){
            $permiso = false;
            $this->mensajeError[] = "El estudiante ya realizo la prematricula";
        }
        if($this->pazYSalvoImpl->validarPazYSalvoEstudiante($this->estudianteDTO, $this->periodoDTO)===false){
            $permiso = false;
            $this->mensajeError[] = "No se encuentra a paz y salvo";
        }
        
        return $permiso;
    }
}
