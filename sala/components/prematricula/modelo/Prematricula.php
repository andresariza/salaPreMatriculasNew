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
        $return['acceso'] = $Controller->validarDatosAccesoPrematricula();
        if ( $return['acceso'] ) {
            $return['PlanEstudio'] = $Controller->buscarPlanEstudio($Controller->getEstudiante());
            $return['reservas'] = $Controller->consultarReservasEstudiante($Controller->getEstudiante());
            $return['creditosDisponibles'] = $Controller->consultarCreditos($return['PlanEstudio'], $Controller->getEstudiante());
            $return['Estudiante'] = $Controller->getEstudiante();
        } else {
            $variables->layout = "accesoRestringido";
            $return['mensajeError'] = $Controller->getMensajeError();
        }
        return $return;
    }

}
