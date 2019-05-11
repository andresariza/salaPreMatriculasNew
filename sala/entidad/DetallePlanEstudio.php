<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\entidad;
defined('_EXEC') or die;
use \Sala\interfaces\Entidad;
/**
 * Description of DetallePlanEstudio
 *
 * @author Andres
 */
class DetallePlanEstudio implements Entidad {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $idplanestudio;
    private $codigomateria;
    private $semestredetalleplanestudio;
    private $valormateriadetalleplanestudio;
    private $numerocreditosdetalleplanestudio;
    private $codigoformacionacademica;
    private $codigoareaacademica;
    private $fechacreaciondetalleplanestudio;
    private $fechainiciodetalleplanestudio;
    private $fechavencimientodetalleplanestudio;
    private $codigoestadodetalleplanestudio;
    private $codigotipomateria;
    
    public function __construct() {        
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }
    
    public function getIdplanestudio() {
        return $this->idplanestudio;
    }

    public function getCodigomateria() {
        return $this->codigomateria;
    }

    public function getSemestredetalleplanestudio() {
        return $this->semestredetalleplanestudio;
    }

    public function getValormateriadetalleplanestudio() {
        return $this->valormateriadetalleplanestudio;
    }

    public function getNumerocreditosdetalleplanestudio() {
        return $this->numerocreditosdetalleplanestudio;
    }

    public function getCodigoformacionacademica() {
        return $this->codigoformacionacademica;
    }

    public function getCodigoareaacademica() {
        return $this->codigoareaacademica;
    }

    public function getFechacreaciondetalleplanestudio() {
        return $this->fechacreaciondetalleplanestudio;
    }

    public function getFechainiciodetalleplanestudio() {
        return $this->fechainiciodetalleplanestudio;
    }

    public function getFechavencimientodetalleplanestudio() {
        return $this->fechavencimientodetalleplanestudio;
    }

    public function getCodigoestadodetalleplanestudio() {
        return $this->codigoestadodetalleplanestudio;
    }

    public function getCodigotipomateria() {
        return $this->codigotipomateria;
    }

    public function setIdplanestudio($idplanestudio) {
        $this->idplanestudio = $idplanestudio;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

    public function setSemestredetalleplanestudio($semestredetalleplanestudio) {
        $this->semestredetalleplanestudio = $semestredetalleplanestudio;
    }

    public function setValormateriadetalleplanestudio($valormateriadetalleplanestudio) {
        $this->valormateriadetalleplanestudio = $valormateriadetalleplanestudio;
    }

    public function setNumerocreditosdetalleplanestudio($numerocreditosdetalleplanestudio) {
        $this->numerocreditosdetalleplanestudio = $numerocreditosdetalleplanestudio;
    }

    public function setCodigoformacionacademica($codigoformacionacademica) {
        $this->codigoformacionacademica = $codigoformacionacademica;
    }

    public function setCodigoareaacademica($codigoareaacademica) {
        $this->codigoareaacademica = $codigoareaacademica;
    }

    public function setFechacreaciondetalleplanestudio($fechacreaciondetalleplanestudio) {
        $this->fechacreaciondetalleplanestudio = $fechacreaciondetalleplanestudio;
    }

    public function setFechainiciodetalleplanestudio($fechainiciodetalleplanestudio) {
        $this->fechainiciodetalleplanestudio = $fechainiciodetalleplanestudio;
    }

    public function setFechavencimientodetalleplanestudio($fechavencimientodetalleplanestudio) {
        $this->fechavencimientodetalleplanestudio = $fechavencimientodetalleplanestudio;
    }

    public function setCodigoestadodetalleplanestudio($codigoestadodetalleplanestudio) {
        $this->codigoestadodetalleplanestudio = $codigoestadodetalleplanestudio;
    }

    public function setCodigotipomateria($codigotipomateria) {
        $this->codigotipomateria = $codigotipomateria;
    }

    public function getById() {
        if (!empty($this->idplanestudio)) {
            $query = "SELECT * FROM detalleplanestudio "
                    . " WHERE idplanestudio = " . $this->db->qstr($this->idplanestudio);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if (!empty($d)) {
                $this->setIdplanestudio($d['idplanestudio']);
                $this->setCodigomateria($d['codigomateria']);
                $this->setSemestredetalleplanestudio($d['semestredetalleplanestudio']);
                $this->setValormateriadetalleplanestudio($d['valormateriadetalleplanestudio']);
                $this->setNumerocreditosdetalleplanestudio($d['numerocreditosdetalleplanestudio']);
                $this->setCodigoformacionacademica($d['codigoformacionacademica']);
                $this->setCodigoareaacademica($d['codigoareaacademica']);
                $this->setFechacreaciondetalleplanestudio($d['fechacreaciondetalleplanestudio']);
                $this->setFechainiciodetalleplanestudio($d['fechainiciodetalleplanestudio']);
                $this->setFechavencimientodetalleplanestudio($d['fechavencimientodetalleplanestudio']);
                $this->setCodigoestadodetalleplanestudio($d['codigoestadodetalleplanestudio']);
                $this->setCodigotipomateria($d['codigotipomateria']);
            }
        }
    }


    public static function getList($where = null, $orderBy = null) {
        $return = array();
        $db = \Sala\lib\Factory::createDbo();
        $query = "SELECT * FROM detalleplanestudio "
                . " WHERE 1 ";
        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        $query .= " ORDER BY  CONVERT(semestredetalleplanestudio,UNSIGNED INTEGER) " ;
        //d($query);
        //d($db);
        $datos = $db->GetAll($query);
        
        foreach ( $datos as $d) {
            $DetallePlanEstudio = new DetallePlanEstudio();
            $DetallePlanEstudio->setIdplanestudio($d['idplanestudio']);
            $DetallePlanEstudio->setCodigomateria($d['codigomateria']);
            $DetallePlanEstudio->setSemestredetalleplanestudio($d['semestredetalleplanestudio']);
            $DetallePlanEstudio->setValormateriadetalleplanestudio($d['valormateriadetalleplanestudio']);
            $DetallePlanEstudio->setNumerocreditosdetalleplanestudio($d['numerocreditosdetalleplanestudio']);
            $DetallePlanEstudio->setCodigoformacionacademica($d['codigoformacionacademica']);
            $DetallePlanEstudio->setCodigoareaacademica($d['codigoareaacademica']);
            $DetallePlanEstudio->setFechacreaciondetalleplanestudio($d['fechacreaciondetalleplanestudio']);
            $DetallePlanEstudio->setFechainiciodetalleplanestudio($d['fechainiciodetalleplanestudio']);
            $DetallePlanEstudio->setFechavencimientodetalleplanestudio($d['fechavencimientodetalleplanestudio']);
            $DetallePlanEstudio->setCodigoestadodetalleplanestudio($d['codigoestadodetalleplanestudio']);
            $DetallePlanEstudio->setCodigotipomateria($d['codigotipomateria']);
            $return[] = $DetallePlanEstudio;
            unset($DetallePlanEstudio);
        }
        return $return;
    }
}