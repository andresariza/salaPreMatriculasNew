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
        
        $ControllerAcceso = new \Sala\lib\GestorDePrematriculas\control\ControllerAcceso();
        
        $DAOBridgeImpl = new \Sala\lib\GestorDePrematriculas\impl\DAOBridgeImpl();
        
        $estudianteImpl = $DAOBridgeImpl->getEstudiante(Factory::getSessionVar('codigo'), Factory::getSessionVar("sesion_idestudiantegeneral"));
        
        $return['Estudiante'] = $estudianteImpl->getEstudianteDTO();
        $return['acceso'] = $ControllerAcceso->validarDatosAccesoPrematricula();
        if ( $return['acceso'] ) {
            $return['PlanEstudio'] = $DAOBridgeImpl->getPlanEstudio($ControllerAcceso->getPeriodoDTO(), $estudianteImpl->getEstudianteDTO());
        } else {
            $return['mensajeError'] = $ControllerAcceso->getMensajeError();
        }
        return $return;
    }

}
