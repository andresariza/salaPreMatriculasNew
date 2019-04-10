<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;

/**
 * Description of GrupoImpl
 *
 * @author Andres
 */
class GrupoImpl implements \Sala\lib\GestorDePrematriculas\interfaces\IGrupo {
    private $id;
    private $docente;
    private $estado;
    private $materia;
    private $nombre;
    private $periodoDTO;
    
    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDocente() {
        return $this->docente;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getMateria() {
        return $this->materia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPeriodoDTO() {
        return $this->periodoDTO;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDocente($docente) {
        $this->docente = $docente;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setMateria($materia) {
        $this->materia = $materia;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPeriodoDTO($periodoDTO) {
        $this->periodoDTO = $periodoDTO;
    }

    
    //put your code here
    public function quitar() {
        
    }

    public function seleccionar() {
        
    }

}
