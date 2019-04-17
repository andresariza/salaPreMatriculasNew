<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dto;
defined('_EXEC') or die;

/**
 * Description of MateriaDTO
 *
 * @author Andres
 */
class MateriaDTO {
    
    private $id;
    private $estado;
    private $modalidad;
    private $nombreCorto;
    private $nombreLargo;
    private $tipoCalificacion;
    private $numeroCreditos;
    private $semestre;
    private $preRequisito;
    private $aprovado;
    private $listadoGrupos;
    private $disponibleMatricula = false;
    
    public function __construct($id, $estado, $modalidad, $nombreCorto, $nombreLargo, $tipoCalificacion, $numeroCreditos, $semestre, $preRequisito) {
        $this->id = $id;
        $this->estado = $estado;
        $this->modalidad = $modalidad;
        $this->nombreCorto = $nombreCorto;
        $this->nombreLargo = $nombreLargo;
        $this->tipoCalificacion = $tipoCalificacion;
        $this->numeroCreditos = $numeroCreditos;
        $this->semestre = $semestre;
        $this->preRequisito = $preRequisito;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getModalidad() {
        return $this->modalidad;
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

    public function getPreRequisito() {
        return $this->preRequisito;
    }
    
    public function getAprovado() {
        return $this->aprovado;
    }
    
    public function getListadoGrupos() {
        return $this->listadoGrupos;
    }
    
    public function setAprovado($aprovado) {
        $this->aprovado = $aprovado;
    }
    
    public function getDisponibleMatricula() {
        return $this->disponibleMatricula;
    }
    
    public function setListadoGrupos($listadoGrupos){
        $this->listadoGrupos = $listadoGrupos;
    }

    public function setDisponibleMatricula($disponibleMatricula) {
        $this->disponibleMatricula = $disponibleMatricula;
    }
}
