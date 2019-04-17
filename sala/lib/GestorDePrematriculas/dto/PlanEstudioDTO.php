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
    private $id;
    private $nombre;
    private $carrera;
    private $codigoEstudiante;
    private $listadoMaterias;
    
    
    public function __construct($id, $nombre, $carrera, $codigoEstudiante, $listadoMaterias) {
        $this->carrera = $carrera;
        $this->id = $id;
        $this->nombre = $nombre;
        $this->codigoEstudiante = $codigoEstudiante;
        $this->listadoMaterias = $listadoMaterias;
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
    public function getCodigoEstudiante() {
        return $this->codigoEstudiante;
    }

    public function getListadoMaterias() {
        return $this->listadoMaterias;
    }
}
