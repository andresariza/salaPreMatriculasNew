<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\interfaces\validaAcceso;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;

/**
 *
 * @author Andres
 */
interface IPazYSalvo {
    public function validarPazYSalvoEstudiante(EstudianteDTO $Estudiante, PeriodoDTO $PeriodoDTO);
}
