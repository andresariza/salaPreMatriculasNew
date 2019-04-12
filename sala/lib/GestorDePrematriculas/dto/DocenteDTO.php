<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dto;
defined('_EXEC') or die;

/**
 * Description of DocenteDTO
 *
 * @author Andres
 */
class DocenteDTO {
    private $codigo;
    private $nombreCompleto;
    private $tipoDocente;
    public function __construct($codigo, $nombreCompleto, $tipoDocente) {
        $this->codigo = $codigo;
        $this->nombreCompleto = $nombreCompleto;
        $this->tipoDocente = $tipoDocente;
    }
    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombreCompleto() {
        return $this->nombreCompleto;
    }

    public function getTipoDocente() {
        return $this->tipoDocente;
    }
}
