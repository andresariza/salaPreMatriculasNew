<?php

namespace Sala\components\prematricula\modelo;

defined('_EXEC') or die;

/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
use \Sala\lib\Factory;

class Prematricula implements \Sala\interfaces\Model {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    public function __construct() {
        $this->db = Factory::createDbo();
    }

    public function getVariables($variables) {
        $EstudianteDAO = new \Sala\lib\GestorDePrematriculas\dao\EstudianteDAO(Factory::getSessionVar('codigo'), Factory::getSessionVar("sesion_idestudiantegeneral"));
        $Estudiante = $EstudianteDAO->getEstudiante();
        
        $carreraEstudiante = unserialize(Factory::getSessionVar("carreraEstudiante")); 
        $CarreraDAO = new \Sala\lib\GestorDePrematriculas\dao\CarreraDAO();
        $CarreraDAO->consultarCarrera($carreraEstudiante->getCodigocarrera());

        $ControlAcceso = new \Sala\lib\GestorDePrematriculas\control\ControlAcceso($Estudiante, $CarreraDAO->getCarreraDTO());

        if ($ControlAcceso->validarDatosAccesoPrematricula()) { 
            $estudianteDTO = $Estudiante->getEstudianteDTO();
            $PlanEstudioDAO = new \Sala\lib\GestorDePrematriculas\dao\PlanEstudioDAO();
            $PlanEstudioDAO->setCarreraDto($ControlAcceso->getCarreraDTO());
            $PlanEstudioDAO->setCodigoEstudiante($estudianteDTO->getCodigo());
            $PlanEstudioDAO->buscarPlanEstudio();
            $PlanEstudioDAO->validarMateriasDisponibles($ControlAcceso->getPeriodoDTO());  
        }
        return array();
    }

}
