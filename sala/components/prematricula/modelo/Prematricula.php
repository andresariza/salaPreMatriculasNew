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
        $DAOFacadeImpl = new \Sala\lib\GestorDePrematriculas\impl\DAOFacadeImpl();
        
        $ControlAcceso = new \Sala\lib\GestorDePrematriculas\control\ControlAcceso($DAOFacadeImpl->getEstudiante(), $DAOFacadeImpl->getCarrera());
        $return['Estudiante'] = $DAOFacadeImpl->getEstudiante()->getEstudianteDTO();
        $return['acceso'] = $ControlAcceso->validarDatosAccesoPrematricula();
        if ( $return['acceso'] ) {
            $DAOFacadeImpl->getPlanEstudio();
            $return['PlanEstudio'] = $DAOFacadeImpl->getMateriasDisponibles($ControlAcceso->getPeriodoDTO());
        } else {
            $return['mensajeError'] = $ControlAcceso->getMensajeError();
        }
        //d($return);
        return $return;
    }

}
