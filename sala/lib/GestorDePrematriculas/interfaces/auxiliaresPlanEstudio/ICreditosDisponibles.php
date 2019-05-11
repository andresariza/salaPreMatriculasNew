<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\interfaces\auxiliaresPlanEstudio;
defined('_EXEC') or die;
use Sala\lib\GestorDePrematriculas\dto\PlanEstudioDTO;
use Sala\lib\GestorDePrematriculas\dto\EstudianteDTO;
/**
 *
 * @author arizaandres
 */
interface ICreditosDisponibles {
    public function consultarCreditos(PlanEstudioDTO $planEstudioDTO, EstudianteDTO $estudianteDTO);
}
