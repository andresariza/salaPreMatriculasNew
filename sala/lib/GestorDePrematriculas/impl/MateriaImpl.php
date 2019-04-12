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
    private $numeroCreditos;
    private $semestre;
    private $preRequisito;
    
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
    
    public function getNumeroCreditos() {
        return $this->numeroCreditos;
    }

    public function getSemestre() {
        return $this->semestre;
    }
    
    public function getPreRequisito(){
        return $this->preRequisito;
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

    public function setNumeroCreditos($numeroCreditos) {
        $this->numeroCreditos = $numeroCreditos;
    }

    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }

    public function setPreRequisito($preRequisito) {
        $this->preRequisito = $preRequisito;
    }
        
    public function quitarMateria() {
        
    }

    public function seleccionarMateria() {
        
    }
    
    public function getMateriaDTO(){
        return new \Sala\lib\GestorDePrematriculas\dto\MateriaDTO($this->id, 
                $this->estado, $this->modalidadMaestra, $this->nombreCorto, 
                $this->nombreLargo, $this->tipoCalificacion, $this->numeroCreditos, 
                $this->semestre, $this->preRequisito);
    }

}
