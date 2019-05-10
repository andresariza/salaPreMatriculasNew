<?php

namespace Sala\components\prematricula\modelo;

defined('_EXEC') or die;

/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
use \Sala\lib\Factory;
use \Sala\lib\GestorDePrematriculas\control\Controller;
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
        
        $Controller = new Controller();
        
        $estudianteImpl = $Controller->getEstudiante();
        
        $return['Estudiante'] = $estudianteImpl->getEstudianteDTO();
        $return['acceso'] = $Controller->validarDatosAccesoPrematricula();
        if ( $return['acceso'] ) {
            $return['PlanEstudio'] = $Controller->buscarPlanEstudio($estudianteImpl->getEstudianteDTO());
            $return['reservas'] = $Controller->consultarReservasEstudiante($estudianteImpl->getEstudianteDTO());
            $return['creditosDisponibles'] = $Controller->consultarCreditos($return['PlanEstudio'], $estudianteImpl->getEstudianteDTO());
        } else {
            $return['mensajeError'] = $Controller->getMensajeError();
        }
        return $return;
    }

}
