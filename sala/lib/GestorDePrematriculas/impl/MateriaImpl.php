<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\impl;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\entidad\ReferenciaPlanEstudio;
use \Sala\lib\GestorDePrematriculas\dto\MateriaDTO;
/**
 * Description of MateriaImpl
 *
 * @author Andres
 */
class MateriaImpl {
    private $MateriaDTO; 
    
    public function __construct() {
        $this->MateriaDTO = new MateriaDTO();
    }
    
    public function getId() {
        return $this->MateriaDTO->getId();
    }

    public function getEstado() {
        return $this->MateriaDTO->getEstado();
    }

    public function getModalidad() {
        return $this->MateriaDTO->getModalidad();
    }

    public function getNombreCorto() {
        return $this->MateriaDTO->getNombreCorto();
    }

    public function getNombreLargo() {
        return $this->MateriaDTO->getNombreLargo();
    }

    public function getTipoCalificacion() {
        return $this->MateriaDTO->getTipoCalificacion();
    }
    
    public function getNumeroCreditos() {
        return $this->MateriaDTO->getNumeroCreditos();
    }

    public function getSemestre() {
        return $this->MateriaDTO->getSemestre();
    }
    
    public function getPreRequisito(){
        return $this->MateriaDTO->getPreRequisito();
    }
    
    public function getAprovado() {
        return $this->MateriaDTO->getAprovado();
    }
    
    public function getDisponibleMatricula() {
        return $this->MateriaDTO->getDisponibleMatricula();
    }

    public function setId($id) {
        $this->MateriaDTO->setId($id);
    }

    public function setEstado($estado) {
        $this->MateriaDTO->setEstado($estado);
    }

    public function setModalidad($modalidad) {
        $this->MateriaDTO->setModalidad($modalidad);
    }

    public function setNombreCorto($nombreCorto) {
        $this->MateriaDTO->setNombreCorto($nombreCorto);
    }

    public function setNombreLargo($nombreLargo) {
        $this->MateriaDTO->setNombreLargo($nombreLargo);
    }

    public function setTipoCalificacion($tipoCalificacion) {
        $this->MateriaDTO->setTipoCalificacion($tipoCalificacion);
    }

    public function setNumeroCreditos($numeroCreditos) {
        $this->MateriaDTO->setNumeroCreditos($numeroCreditos);
    }

    public function setSemestre($semestre) {
        $this->MateriaDTO->setSemestre($semestre);
    }

    public function setPreRequisito($idPlanEstudio,$codigoMateria = null) {
        if(!empty($this->id)){
            $idMateria = $this->id;
        }else{
            $idMateria = $codigoMateria;
        }
        $db = Factory::createDbo();
        $where = " codigotiporeferenciaplanestudio = 100 "
                . " AND codigomateria = ".$db->qstr($idMateria)
                . " AND idplanestudio = ".$db->qstr($idPlanEstudio);
        
        $preRequisito = ReferenciaPlanEstudio::getList($where);
        if(!empty($preRequisito)){
            $this->MateriaDTO->setPreRequisito($preRequisito[0]->getCodigomateriareferenciaplanestudio());
        }
    }

    public function setAprovado($aprovado) {
        $this->MateriaDTO->setAprovado($aprovado);
    }
    
    public function setDisponibleMatricula($disponibleMatricula) {
        $this->MateriaDTO->setDisponibleMatricula( $disponibleMatricula );
    }
    
    public function getMateriaDTO(){
        return $this->MateriaDTO;
    }

}
