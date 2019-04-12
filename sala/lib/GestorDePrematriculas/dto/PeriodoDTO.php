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
    private $id;
    private $agno;
    private $codigoPeriodo;
    private $estado;
    private $fechaFin;
    private $fechaInicio;
    private $nombre;
    private $numeroPeriodo;
    public function __construct($id, $agno, $codigoPeriodo, $estado, $fechaFin, $fechaInicio, $nombre, $numeroPeriodo) {
        $this->id = $id;
        $this->agno = $agno;
        $this->codigoPeriodo = $codigoPeriodo;
        $this->estado = $estado;
        $this->fechaFin = $fechaFin;
        $this->fechaInicio = $fechaInicio;
        $this->nombre = $nombre;
        $this->numeroPeriodo = $numeroPeriodo;
    }
    public function getId() {
        return $this->id;
    }

    public function getAgno() {
        return $this->agno;
    }

    public function getCodigoPeriodo() {
        return $this->codigoPeriodo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNumeroPeriodo() {
        return $this->numeroPeriodo;
    }
}
