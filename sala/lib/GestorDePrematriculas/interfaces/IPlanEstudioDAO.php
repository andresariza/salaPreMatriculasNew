<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\interfaces;
defined('_EXEC') or die;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
/**
 *
 * @author Andres
 */
interface IPlanEstudioDAO {
    public function buscarPlanEstudio();
    public function validarMateriasDisponibles(PeriodoDTO $periodoDTO);
}
