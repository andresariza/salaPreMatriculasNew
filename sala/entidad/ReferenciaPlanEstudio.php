<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\entidad;
defined('_EXEC') or die;
use \Sala\lib\Factory;

/**
 * Description of ReferenciaPlanEstudio
 *
 * @author Andres
 */
class ReferenciaPlanEstudio  implements \Sala\interfaces\Entidad {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    private $idplanestudio;
    
    private $idlineaenfasisplanestudio;
    
    private $codigomateria;
    
    private $codigomateriareferenciaplanestudio;
    
    private $codigotiporeferenciaplanestudio;
    
    private $fechacreacionreferenciaplanestudio;
    
    private $fechainicioreferenciaplanestudio;
    
    private $fechavencimientoreferenciaplanestudio;
    
    private $codigoestadoreferenciaplanestudio;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdplanestudio() {
        return $this->idplanestudio;
    }

    public function getIdlineaenfasisplanestudio() {
        return $this->idlineaenfasisplanestudio;
    }

    public function getCodigomateria() {
        return $this->codigomateria;
    }

    public function getCodigomateriareferenciaplanestudio() {
        return $this->codigomateriareferenciaplanestudio;
    }

    public function getCodigotiporeferenciaplanestudio() {
        return $this->codigotiporeferenciaplanestudio;
    }

    public function getFechacreacionreferenciaplanestudio() {
        return $this->fechacreacionreferenciaplanestudio;
    }

    public function getFechainicioreferenciaplanestudio() {
        return $this->fechainicioreferenciaplanestudio;
    }

    public function getFechavencimientoreferenciaplanestudio() {
        return $this->fechavencimientoreferenciaplanestudio;
    }

    public function getCodigoestadoreferenciaplanestudio() {
        return $this->codigoestadoreferenciaplanestudio;
    }

    public function setIdplanestudio($idplanestudio) {
        $this->idplanestudio = $idplanestudio;
    }

    public function setIdlineaenfasisplanestudio($idlineaenfasisplanestudio) {
        $this->idlineaenfasisplanestudio = $idlineaenfasisplanestudio;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

    public function setCodigomateriareferenciaplanestudio($codigomateriareferenciaplanestudio) {
        $this->codigomateriareferenciaplanestudio = $codigomateriareferenciaplanestudio;
    }

    public function setCodigotiporeferenciaplanestudio($codigotiporeferenciaplanestudio) {
        $this->codigotiporeferenciaplanestudio = $codigotiporeferenciaplanestudio;
    }

    public function setFechacreacionreferenciaplanestudio($fechacreacionreferenciaplanestudio) {
        $this->fechacreacionreferenciaplanestudio = $fechacreacionreferenciaplanestudio;
    }

    public function setFechainicioreferenciaplanestudio($fechainicioreferenciaplanestudio) {
        $this->fechainicioreferenciaplanestudio = $fechainicioreferenciaplanestudio;
    }

    public function setFechavencimientoreferenciaplanestudio($fechavencimientoreferenciaplanestudio) {
        $this->fechavencimientoreferenciaplanestudio = $fechavencimientoreferenciaplanestudio;
    }

    public function setCodigoestadoreferenciaplanestudio($codigoestadoreferenciaplanestudio) {
        $this->codigoestadoreferenciaplanestudio = $codigoestadoreferenciaplanestudio;
    }

        
    public function getById() {
        
    }

    public static function getList($where = null, $orderBy = null) {
        $return = array();
        $db = \Sala\lib\Factory::createDbo();
        $query = "SELECT * FROM referenciaplanestudio "
                . " WHERE 1 ";
        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }
        //d($query);
        $datos = $db->GetAll($query);
        
        foreach ( $datos as $d) {
            $RefereneciaPlanEstudio = new ReferenciaPlanEstudio();
            $RefereneciaPlanEstudio->setIdplanestudio($d['idplanestudio']); 
            $RefereneciaPlanEstudio->setIdlineaenfasisplanestudio($d['idlineaenfasisplanestudio']); 
            $RefereneciaPlanEstudio->setCodigomateria($d['codigomateria']); 
            $RefereneciaPlanEstudio->setCodigomateriareferenciaplanestudio($d['codigomateriareferenciaplanestudio']); 
            $RefereneciaPlanEstudio->setCodigotiporeferenciaplanestudio($d['codigotiporeferenciaplanestudio']); 
            $RefereneciaPlanEstudio->setFechacreacionreferenciaplanestudio($d['fechacreacionreferenciaplanestudio']); 
            $RefereneciaPlanEstudio->setFechainicioreferenciaplanestudio($d['fechainicioreferenciaplanestudio']); 
            $RefereneciaPlanEstudio->setFechavencimientoreferenciaplanestudio($d['fechavencimientoreferenciaplanestudio']); 
            $RefereneciaPlanEstudio->setCodigoestadoreferenciaplanestudio($d['codigoestadoreferenciaplanestudio']); 
            $return[] = $RefereneciaPlanEstudio;
            unset($RefereneciaPlanEstudio);
        }
        return $return;
    }

}