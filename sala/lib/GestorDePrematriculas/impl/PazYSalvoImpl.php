<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\interfaces\IPazYSalvo;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;

/**
 * Description of PazYSalvoImpl
 *
 * @author Andres
 */
class PazYSalvoImpl implements IPazYSalvo {
    private $Estudiante;
    
    function __construct(EstudianteDTO $Estudiante) {
        $this->Estudiante = $Estudiante;
    }
    
    public function validarPazYSalvoEstudiante() {
        //toDo por el alcance del proyecto, no es posible validar el paz y salvo
        // razon por la cual se asume que todos los estudiantes estan a paz y salvo
        return true;
    }

}

