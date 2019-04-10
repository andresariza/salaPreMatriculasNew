<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;

/**
 * Description of MateriaImpl
 *
 * @author Andres
 */
class MateriaImpl implements \Sala\lib\GestorDePrematriculas\interfaces\IMateria {
    private $id;
    private $estado;
    private $modalidadMaestra;
    private $nombreCorto;
    private $nombreLargo;
    private $tipoCalificacion;
    
    public function __construct() {
    }
    
    public function getId() {
        return $this->id;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getModalidadMaestra() {
        return $this->modalidadMaestra;
    }

    public function getNombreCorto() {
        return $this->nombreCorto;
    }

    public function getNombreLargo() {
        return $this->nombreLargo;
    }

    public function getTipoCalificacion() {
        return $this->tipoCalificacion;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setModalidadMaestra($modalidadMaestra) {
        $this->modalidadMaestra = $modalidadMaestra;
    }

    public function setNombreCorto($nombreCorto) {
        $this->nombreCorto = $nombreCorto;
    }

    public function setNombreLargo($nombreLargo) {
        $this->nombreLargo = $nombreLargo;
    }

    public function setTipoCalificacion($tipoCalificacion) {
        $this->tipoCalificacion = $tipoCalificacion;
    }
    
    public function quitarMateria() {
        
    }

    public function seleccionarMateria() {
        
    }

}
