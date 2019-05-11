<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dto;
defined('_EXEC') or die;

/**
 * Description of PeriodoDTO
 *
 * @author Andres
 */
class PeriodoDTO {
    private $codigoPeriodo;
    private $fechaFin;
    private $fechaInicio;
    private $numeroPeriodo;
    public function __construct( $codigoPeriodo, $fechaInicio, $fechaFin, $numeroPeriodo) {
        $this->codigoPeriodo = $codigoPeriodo;
        $this->fechaFin = $fechaFin;
        $this->fechaInicio = $fechaInicio;
        $this->numeroPeriodo = $numeroPeriodo;
    }

    public function getCodigoPeriodo() {
        return $this->codigoPeriodo;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function getNumeroPeriodo() {
        return $this->numeroPeriodo;
    }
}
