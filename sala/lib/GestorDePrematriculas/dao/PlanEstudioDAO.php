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
    private $id;
    private $carreraDto;
    private $nombre;
    private $codigoEstudiante;
    private $listadoMaterias;
    
    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getCarreraDto() {
        return $this->carreraDto;
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

    public function getPlanEstudioDTO() {
        return new \Sala\lib\GestorDePrematriculas\dto\PlanEstudioDTO($this->id, $this->nombre, $this->carreraDto, $this->codigoEstudiante, $this->listadoMaterias);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCarreraDto($carreraDto) {
        $this->carreraDto = $carreraDto;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setCodigoEstudiante($codigoEstudiante) {
        $this->codigoEstudiante = $codigoEstudiante;
    }

    public function setListadoMaterias($listadoMaterias) {
        $this->listadoMaterias = $listadoMaterias;
    }

    public function buscarPlanEstudio() {
        $db = \Sala\lib\Factory::createDbo();
        $where = " codigoestudiante = ".$db->qstr($this->codigoEstudiante);
        $ePlanEstudioEstudiante = \Sala\entidad\PlanEstudioEstudiante::getList($where);
        
        if(!empty($ePlanEstudioEstudiante)){
            $ePlanEstudio = new \Sala\entidad\PlanEstudio();
            $ePlanEstudio->setDb();
            $ePlanEstudio->setIdplanestudio($ePlanEstudioEstudiante[0]->getIdplanestudio());
            $ePlanEstudio->getById();
            
            $this->id = $ePlanEstudio->getIdplanestudio();
            $this->nombre = $ePlanEstudio->getNombreplanestudio();
            $this->setListadoMaterias($this->getMateriasPlanEstudio());
        }
    }

    public function validarMateriasDisponibles(\Sala\lib\GestorDePrematriculas\dto\PeriodoDTO $periodoDTO) {
        $i = 0;
        foreach($this->listadoMaterias as $m){
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
        $where = " idplanestudio = ".$db->qstr($this->id)
                . " AND codigoestudiante = ".$db->qstr($this->codigoEstudiante)
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
        $return = array();
        $db = \Sala\lib\Factory::createDbo();
        $where = " codigomateria = ".$db->qstr($materia->getId())
                . " AND codigoperiodo = ".$db->qstr($periodoDTO->getCodigoPeriodo());
        $eGrupo = \Sala\entidad\Grupo::getList($where);
        if(!empty($eGrupo)){
            foreach($eGrupo as $g){
                $GrupoIMP = new \Sala\lib\GestorDePrematriculas\impl\GrupoImpl();
                $GrupoIMP->setId($g->getIdgrupo());
                $GrupoIMP->setDocente($g->getNumerodocumento());
                $GrupoIMP->setEstado($g->getCodigoestadogrupo());
                $GrupoIMP->setMateria($materia->getId());
                $GrupoIMP->setNombre($g->getNombregrupo());
                $GrupoIMP->setCodigoGrupo($g->getCodigogrupo());
                $GrupoIMP->setCupoMaximo($g->getMaximogrupo());
                $GrupoIMP->setCupoOcupado($g->getMatriculadosgrupo());
                $GrupoIMP->setCupoElectiva($g->getMaximogrupoelectiva());
                $GrupoIMP->setMatriculadosElectiva($g->getMatriculadosgrupoelectiva());
                $GrupoIMP->setPeriodoDTO($periodoDTO);
                $GrupoIMP->setHorariosGrupo();
                $return[] = $GrupoIMP;
            }
        }
        return $return;
    }
    
    private function getMateriasPlanEstudio(){
        $return = array();
        $db = \Sala\lib\Factory::createDbo();
        $where = " idplanestudio = ".$db->qstr($this->id)
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
        $MateriaImpl->setPreRequisito($this->id);
        $MateriaImpl->setSemestre($m->getSemestredetalleplanestudio());
        $MateriaImpl->setTipoCalificacion($materia->getCodigotipocalificacionmateria());
        
        unset($materia);
        return $MateriaImpl->getMateriaDTO();
    }

}
