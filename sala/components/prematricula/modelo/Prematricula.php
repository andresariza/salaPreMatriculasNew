<?php

namespace Sala\components\prematricula\modelo;

defined('_EXEC') or die;

/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
use \Sala\lib\Factory;
use \Sala\lib\GestorDePrematriculas\control\ControllerAcceso;
use \Sala\interfaces\Model;

class Prematricula implements Model {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    public function __construct() {
        $this->db = Factory::createDbo();
    }

    public function getVariables($variables) {
        $return = array("variables" => $variables);
        
        $ControllerAcceso = new ControllerAcceso();
        
        $estudianteImpl = $ControllerAcceso->getEstudiante();
        
        $return['Estudiante'] = $estudianteImpl->getEstudianteDTO();
        $return['acceso'] = $ControllerAcceso->validarDatosAccesoPrematricula();
        if ( $return['acceso'] ) {
            $return['PlanEstudio'] = $ControllerAcceso->buscarPlanEstudio($estudianteImpl->getEstudianteDTO());
        } else {
            $return['mensajeError'] = $ControllerAcceso->getMensajeError();
        }
        return $return;
    }

}
