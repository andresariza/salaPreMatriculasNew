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

    public function setId($id) {
        $this->id = $id;
    }

    public function setCarreraDto($carreraDto) {
        $this->carreraDto = $carreraDto;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function buscarPlanEstudio($codigoEstudiante) {
        $db = \Sala\lib\Factory::createDbo();
        $where = " codigoestudiante = ".$db->qstr($codigoEstudiante);
        $ePlanEstudioEstudiante = \Sala\entidad\PlanEstudioEstudiante::getList($where);
        
        if(!empty($ePlanEstudioEstudiante)){
            $ePlanEstudio = new \Sala\entidad\PlanEstudio();
            $ePlanEstudio->setDb();
            $ePlanEstudio->setIdplanestudio($ePlanEstudioEstudiante[0]->getIdplanestudio());
            $ePlanEstudio->getById();
            
            $this->id = $ePlanEstudio->getIdplanestudio();
            $this->nombre = $ePlanEstudio->getNombreplanestudio();
            $this->getListadoMaterias();
            d($this);
        }
    }

    public function validarMateriasDisponibles() {
        
    }
    
    private function getListadoMaterias(){
        $db = \Sala\lib\Factory::createDbo();
        $where = " idplanestudio = ".$db->qstr($this->id)
                . " ORDER BY  CONVERT(semestredetalleplanestudio,UNSIGNED INTEGER) ";
        $listadoMaterias = \Sala\entidad\DetallePlanEstudio::getList($where);
        d($listadoMaterias);
    }

}
