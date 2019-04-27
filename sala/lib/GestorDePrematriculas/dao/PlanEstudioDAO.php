<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dao;
defined('_EXEC') or die;

/**
 * Description of PlanEstudioDAO
 *
 * @author Andres
 */
class PlanEstudioDAO implements \Sala\lib\GestorDePrematriculas\interfaces\IPlanEstudioDAO {
    private $PlanEstudioDTO;
    
    public function __construct() {
        $this->PlanEstudioDTO = new \Sala\lib\GestorDePrematriculas\dto\PlanEstudioDTO();
    }
    
    public function getId() {
        return $this->PlanEstudioDTO->getId();
    }

    public function getCarreraDto() {
        return $this->PlanEstudioDTO->getCarreraDto();
    }

    public function getNombre() {
        return $this->PlanEstudioDTO->getNombre();
    }
    
    public function getCodigoEstudiante() {
        return $this->PlanEstudioDTO->getCodigoEstudiante();
    }

    public function getListadoMaterias() {
        return $this->PlanEstudioDTO->getListadoMaterias();
    }

    public function getPlanEstudioDTO() {
        return $this->PlanEstudioDTO;
    }

    public function setId($id) {
        $this->PlanEstudioDTO->setId($id);
    }

    public function setCarreraDto($carreraDto) {
        $this->PlanEstudioDTO->setCarrera($carreraDto);
    }

    public function setNombre($nombre) {
        $this->PlanEstudioDTO->setNombre($nombre);
    }
    
    public function setCodigoEstudiante($codigoEstudiante) {
        $this->PlanEstudioDTO->setCodigoEstudiante($codigoEstudiante);
    }

    public function setListadoMaterias($listadoMaterias) {
        $this->PlanEstudioDTO->setListadoMaterias($listadoMaterias);
    }

    public function buscarPlanEstudio() {
        $db = \Sala\lib\Factory::createDbo();
        $where = " codigoestudiante = ".$db->qstr($this->getCodigoEstudiante());
        $ePlanEstudioEstudiante = \Sala\entidad\PlanEstudioEstudiante::getList($where);
        
        if(!empty($ePlanEstudioEstudiante)){
            $ePlanEstudio = new \Sala\entidad\PlanEstudio();
            $ePlanEstudio->setDb();
            $ePlanEstudio->setIdplanestudio($ePlanEstudioEstudiante[0]->getIdplanestudio());
            $ePlanEstudio->getById();
            
            $this->setId($ePlanEstudio->getIdplanestudio());
            $this->setNombre($ePlanEstudio->getNombreplanestudio());
            $this->setListadoMaterias($this->getMateriasPlanEstudio());
        }
    }

    public function validarMateriasDisponibles(\Sala\lib\GestorDePrematriculas\dto\PeriodoDTO $periodoDTO) {
        $i = 0;
        foreach($this->getListadoMaterias() as $m){
            $m->setAprovado($this->validarMateriaAprovada($m->getId()));
            if(!$m->getAprovado()){
                $preRequisito = $m->getPreRequisito();
                if(!empty($preRequisito)){
                    $disponible = $this->validarMateriaAprovada($preRequisito);
                    $m->setDisponibleMatricula($disponible);
                }else{
                    $m->setDisponibleMatricula(true);
                }
            }
            if($m->getDisponibleMatricula()){
                $m->setListadoGrupos($this->getGruposMateria($m,$periodoDTO));
            }
            $i++;
        }
    }
    
    private function validarMateriaAprovada($idMateria){
        $aprovado = false;
        $db = \Sala\lib\Factory::createDbo();
        $where = " idplanestudio = ".$db->qstr($this->getId())
                . " AND codigoestudiante = ".$db->qstr($this->getCodigoEstudiante())
                . " AND codigomateria = ".$db->qstr($idMateria);
        $eNotaHistorico = \Sala\entidad\NotaHistorico::getList($where);
        if(!empty($eNotaHistorico)){ 
            if( (int)$eNotaHistorico[0]->getNotadefinitiva() > 3){
                $aprovado = true;
            }
        }
        /*/if($idMateria == 15040){
            d($where);
            d($eNotaHistorico);
            d($aprovado);
        }/**/
        return $aprovado;
    }
    
    private function getGruposMateria(\Sala\lib\GestorDePrematriculas\dto\MateriaDTO $materia, \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO $periodoDTO){
        return \Sala\lib\GestorDePrematriculas\impl\GrupoImpl::getGruposMateria($materia, $periodoDTO);
    }
    
    private function getMateriasPlanEstudio(){
        $return = array();
        $db = \Sala\lib\Factory::createDbo();
        $where = " idplanestudio = ".$db->qstr($this->getId())
                . " ORDER BY  CONVERT(semestredetalleplanestudio,UNSIGNED INTEGER) ";
        $listadoMaterias = \Sala\entidad\DetallePlanEstudio::getList($where);
        foreach($listadoMaterias as $m){
            $return[] = $this->getMateria($m);
        }
        
        return $return;
    }
    
    private function getMateria(\Sala\entidad\DetallePlanEstudio $m){        
        $materia = new \Sala\entidad\Materia();
        $materia->setDb();
        $materia->setCodigomateria($m->getCodigomateria());
        $materia->getById();

        $MateriaImpl = new \Sala\lib\GestorDePrematriculas\impl\MateriaImpl();
        $MateriaImpl->setId($materia->getCodigomateria());
        $MateriaImpl->setModalidad($materia->getCodigomodalidadmateria());
        $MateriaImpl->setNombreCorto($materia->getNombrecortomateria());
        $MateriaImpl->setNombreLargo($materia->getNombremateria());
        $MateriaImpl->setNumeroCreditos($m->getNumerocreditosdetalleplanestudio());
        $MateriaImpl->setPreRequisito($this->getId());
        $MateriaImpl->setSemestre($m->getSemestredetalleplanestudio());
        $MateriaImpl->setTipoCalificacion($materia->getCodigotipocalificacionmateria());
         
        unset($materia);
        return $MateriaImpl->getMateriaDTO();
    }

}
