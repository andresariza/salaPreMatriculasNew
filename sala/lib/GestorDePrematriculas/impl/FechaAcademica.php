<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;

/**
 * Description of newPHPClass
 *
 * @author Andres
 */
class FechaAcademica implements \Sala\lib\GestorDePrematriculas\interfaces\IFechaAcademica{
    private $carrera;
    private $fechaInicioPrematricula;
    private $fechaFinPrematricula;
    private $periodo;
    
    public function __construct(\Sala\lib\GestorDePrematriculas\dto\CarreraDTO $carrera, \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO $periodo) {
        $this->carrera = $carrera;
        $this->periodo = $periodo;
    }

    public function validarFechaAcademica() {
        //ToDo hacer la implemantacion de la validacion de la fecha academica   
    }

}
