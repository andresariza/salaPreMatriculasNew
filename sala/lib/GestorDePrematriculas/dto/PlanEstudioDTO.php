<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dto;
defined('_EXEC') or die;

/**
 * Description of PlanEstudioDTO
 *
 * @author Andres
 */
class PlanEstudioDTO {
    private $carrera;
    private $id;
    private $nombre;
    public function __construct($carrera, $id, $nombre) {
        $this->carrera = $carrera;
        $this->id = $id;
        $this->nombre = $nombre;
    }
    public function getCarrera() {
        return $this->carrera;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }
}
