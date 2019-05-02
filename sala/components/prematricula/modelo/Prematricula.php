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
        $return = array();
        //$DAOFacadeImpl = new \Sala\lib\GestorDePrematriculas\impl\DAOFacadeImpl();
        $DAOBridgeImpl = new \Sala\lib\GestorDePrematriculas\impl\DAOBridgeImpl();
        
        //$ControllerAcceso = new \Sala\lib\GestorDePrematriculas\control\ControllerAcceso($DAOFacadeImpl->getEstudiante(), $DAOFacadeImpl->getCarrera());
        $ControllerAcceso = new \Sala\lib\GestorDePrematriculas\control\ControllerAcceso($DAOBridgeImpl->getEstudiante(), $DAOBridgeImpl->getCarrera());
        //$return['Estudiante'] = $DAOFacadeImpl->getEstudiante()->getEstudianteDTO();
        $return['Estudiante'] = $DAOBridgeImpl->getEstudiante()->getEstudianteDTO();
        $return['acceso'] = $ControllerAcceso->validarDatosAccesoPrematricula();
        if ( $return['acceso'] ) {
            //$DAOFacadeImpl->getPlanEstudio();
            //$return['PlanEstudio'] = $DAOFacadeImpl->getMateriasDisponibles($ControllerAcceso->getPeriodoDTO());
            $return['PlanEstudio'] = $DAOBridgeImpl->getPlanEstudio($ControllerAcceso->getPeriodoDTO());
        } else {
            $return['mensajeError'] = $ControllerAcceso->getMensajeError();
        }
        //d($return);
        return $return;
    }

}
