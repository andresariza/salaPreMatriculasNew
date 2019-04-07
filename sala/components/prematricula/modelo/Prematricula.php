<?php

namespace Sala\components\prematricula\modelo;
defined('_EXEC') or die; 
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
use \Sala\lib\Factory;
use \Sala\lib\Servicios;
class Prematricula implements \Sala\interfaces\Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    private $carreraDTO;
    private $periodoDTO;
    private $Estudiante;
    
    public function __construct() {
        $this->db = Factory::createDbo();
        $this->setPeriodoDTO();
        $this->setCarreraDTO();
        
        #toDo tratar de implementar un Builder para la creacion de estudiante
        $this->setEstudiante();
    }
    //put your code here
    public function getVariables($variables) {
        
        $fechaAcademicaImpl = new \Sala\lib\GestorDePrematriculas\impl\FechaAcademicaImpl($this->carreraDTO, $this->periodoDTO);
        $fechaValida = $fechaAcademicaImpl->validarFechaAcademica();
        $situacionEstudiantevalido = $this->Estudiante->validarEstado(); 
        
        $pazYSalvo = new \Sala\lib\GestorDePrematriculas\impl\PazYSalvoImpl($this->Estudiante);
       d($this->Estudiante);
        
        if($fechaValida && $situacionEstudiantevalido && $pazYSalvo->validarPazYSalvoEstudiante()){
            echo $fechaValida;
        }
        
        return array();
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

}
