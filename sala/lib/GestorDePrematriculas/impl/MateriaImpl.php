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
    private $modalidad;
    private $nombreCorto;
    private $nombreLargo;
    private $tipoCalificacion;
    private $numeroCreditos;
    private $semestre;
    private $preRequisito;
    private $aprovado;
    
    public function __construct() {
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
    
    public function getPreRequisito(){
        return $this->preRequisito;
    }
    
    public function getAprovado() {
        return $this->aprovado;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setModalidad($modalidad) {
        $this->modalidad = $modalidad;
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

    public function setPreRequisito($idPlanEstudio,$codigoMateria = null) {
        if(!empty($this->id)){
            $idMateria = $this->id;
        }else{
            $idMateria = $codigoMateria;
        }
        $db = \Sala\lib\Factory::createDbo();
        $where = " codigotiporeferenciaplanestudio = 100 "
                . " AND codigomateria = ".$db->qstr($idMateria)
                . " AND idplanestudio = ".$db->qstr($idPlanEstudio);
        
        $preRequisito = \Sala\entidad\ReferenciaPlanEstudio::getList($where);
        if(!empty($preRequisito)){
            $this->preRequisito = $preRequisito[0]->getCodigomateriareferenciaplanestudio();
        }
    }

    public function setAprovado($aprovado) {
        $this->aprovado = $aprovado;
    }
        
    public function quitarMateria() {
        
    }

    public function seleccionarMateria() {
        
    }
    
    public function getMateriaDTO(){
        return new \Sala\lib\GestorDePrematriculas\dto\MateriaDTO($this->id, 
                $this->estado, $this->modalidad, $this->nombreCorto, 
                $this->nombreLargo, $this->tipoCalificacion, $this->numeroCreditos, 
                $this->semestre, $this->preRequisito);
    }

}
