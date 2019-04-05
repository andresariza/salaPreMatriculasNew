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
    
    public function __construct() {
        $this->db = Factory::createDbo();
    }
    //put your code here
    public function getVariables($variables) {
        $carreraEstudiante = unserialize(Factory::getSessionVar("carreraEstudiante"));
        $periodoSesion = unserialize(Factory::getSessionVar("PeriodoSession"));
        $periodoVigente = Servicios::getPeriodoVigente();
        
        $carreraDTO = new \Sala\lib\GestorDePrematriculas\dto\CarreraDTO();
        $carreraDTO->id = $carreraEstudiante->getCodigocarrera();
        $carreraDTO->nombre = $carreraEstudiante->getNombrecarrera();
        $carreraDTO->titulo = $carreraEstudiante->getNombrecarrera();
        d($carreraEstudiante);
        
        $periodoDTO = new \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO();
        $periodoDTO->codigoPeriodo = $periodoVigente->getCodigoperiodo();
        $periodoDTO->agno = $periodoVigente->getCodigoperiodo();
        $periodoDTO->fechaFin = $periodoVigente->getFechainicioperiodo();
        $periodoDTO->fechaInicio = $periodoVigente->getFechavencimientoperiodo();
        $periodoDTO->nombre = $periodoVigente->getNombreperiodo();
        $periodoDTO->numeroPeriodo = $periodoVigente->getNumeroperiodo();
        //$periodoDTO->id = $periodoVigente->get
        
        //d($carreraEstudiante);
        $fechaAcademica = new \Sala\lib\GestorDePrematriculas\impl\FechaAcademica($carreraDTO, $periodoDTO);
        //d($periodoVigente);
        //d($periodoDTO);
        d($fechaAcademica);
        return array();
    }

}
