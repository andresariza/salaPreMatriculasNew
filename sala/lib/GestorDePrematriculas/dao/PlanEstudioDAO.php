<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\lib\GestorDePrematriculas\dao;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\entidad\PlanEstudioEstudiante;
use \Sala\entidad\PlanEstudio;
use \Sala\entidad\NotaHistorico;
use \Sala\entidad\DetallePlanEstudio;
use \Sala\entidad\Materia;
use \Sala\lib\GestorDePrematriculas\interfaces\IPlanEstudioDAO;
use \Sala\lib\GestorDePrematriculas\dto\PlanEstudioDTO;
use \Sala\lib\GestorDePrematriculas\dto\PeriodoDTO;
use \Sala\lib\GestorDePrematriculas\dto\MateriaDTO;
use \Sala\lib\GestorDePrematriculas\impl\GrupoImpl;
use \Sala\lib\GestorDePrematriculas\impl\MateriaImpl;

/**
 * Description of PlanEstudioDAO
 *
 * @author Andres
 */
class PlanEstudioDAO implements IPlanEstudioDAO {
    private $PlanEstudioDTO;
    
    public function __construct() {
        $this->PlanEstudioDTO = new PlanEstudioDTO();
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

    public function buscarPlanEstudio(PeriodoDTO $periodo) {
        $db = Factory::createDbo();
        $where = " codigoestudiante = ".$db->qstr($this->getCodigoEstudiante());
        $ePlanEstudioEstudiante = PlanEstudioEstudiante::getList($where);
        
        if(!empty($ePlanEstudioEstudiante)){
            $ePlanEstudio = new PlanEstudio();
            $ePlanEstudio->setIdplanestudio($ePlanEstudioEstudiante[0]->getIdplanestudio());
            $ePlanEstudio->getById();
            
            $this->setId($ePlanEstudio->getIdplanestudio());
            $this->setNombre($ePlanEstudio->getNombreplanestudio());
            $this->setListadoMaterias($this->getMateriasPlanEstudio());
        }
        
        $this->validarMateriasDisponibles($periodo);
        return $this->getPlanEstudioDTO();
    }

    private function validarMateriasDisponibles(PeriodoDTO $periodoDTO) {
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
        $db = Factory::createDbo();
        $where = " idplanestudio = ".$db->qstr($this->getId())
                . " AND codigoestudiante = ".$db->qstr($this->getCodigoEstudiante())
                . " AND codigomateria = ".$db->qstr($idMateria);
        $eNotaHistorico = NotaHistorico::getList($where);
        if(!empty($eNotaHistorico)){ 
            if( (int)$eNotaHistorico[0]->getNotadefinitiva() > 3){
                $aprovado = true;
            }
        }
        return $aprovado;
    }
    
    private function getGruposMateria(MateriaDTO $materia, PeriodoDTO $periodoDTO){
        $grupo = new GrupoImpl();
        return $grupo->getGruposMateria($materia, $periodoDTO);
    }
    
    private function getMateriasPlanEstudio(){
        $return = array();
        $db = Factory::createDbo();
        $where = " idplanestudio = ".$db->qstr($this->getId());
        $listadoMaterias = DetallePlanEstudio::getList($where);
        foreach($listadoMaterias as $m){
            $return[] = $this->getMateria($m);
        }
        
        return $return;
    }
    
    private function getMateria(DetallePlanEstudio $m){        
        $materia = new Materia();
        $materia->setCodigomateria($m->getCodigomateria());
        $materia->getById();

        $MateriaImpl = new MateriaImpl();
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
