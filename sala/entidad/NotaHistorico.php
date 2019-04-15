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
 * Description of NotaHistorico
 *
 * @author Andres
 */
class NotaHistorico  implements \Sala\interfaces\Entidad  {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    private $idnotahistorico;
    
    private $codigoperiodo;
    
    private $codigomateria;
    
    private $codigomateriaelectiva;
    
    private $codigoestudiante;
    
    private $notadefinitiva;
    
    private $codigotiponotahistorico;
    
    private $origennotahistorico;
    
    private $fechaprocesonotahistorico;
    
    private $idgrupo;
    
    private $idplanestudio;
    
    private $idlineaenfasisplanestudio;
    
    private $observacionnotahistorico;
    
    private $codigoestadonotahistorico;
    
    private $codigotipomateria;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdnotahistorico() {
        return $this->idnotahistorico;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function getCodigomateria() {
        return $this->codigomateria;
    }

    public function getCodigomateriaelectiva() {
        return $this->codigomateriaelectiva;
    }

    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }

    public function getNotadefinitiva() {
        return $this->notadefinitiva;
    }

    public function getCodigotiponotahistorico() {
        return $this->codigotiponotahistorico;
    }

    public function getOrigennotahistorico() {
        return $this->origennotahistorico;
    }

    public function getFechaprocesonotahistorico() {
        return $this->fechaprocesonotahistorico;
    }

    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function getIdplanestudio() {
        return $this->idplanestudio;
    }

    public function getIdlineaenfasisplanestudio() {
        return $this->idlineaenfasisplanestudio;
    }

    public function getObservacionnotahistorico() {
        return $this->observacionnotahistorico;
    }

    public function getCodigoestadonotahistorico() {
        return $this->codigoestadonotahistorico;
    }

    public function getCodigotipomateria() {
        return $this->codigotipomateria;
    }

    public function setIdnotahistorico($idnotahistorico) {
        $this->idnotahistorico = $idnotahistorico;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

    public function setCodigomateriaelectiva($codigomateriaelectiva) {
        $this->codigomateriaelectiva = $codigomateriaelectiva;
    }

    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }

    public function setNotadefinitiva($notadefinitiva) {
        $this->notadefinitiva = $notadefinitiva;
    }

    public function setCodigotiponotahistorico($codigotiponotahistorico) {
        $this->codigotiponotahistorico = $codigotiponotahistorico;
    }

    public function setOrigennotahistorico($origennotahistorico) {
        $this->origennotahistorico = $origennotahistorico;
    }

    public function setFechaprocesonotahistorico($fechaprocesonotahistorico) {
        $this->fechaprocesonotahistorico = $fechaprocesonotahistorico;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

    public function setIdplanestudio($idplanestudio) {
        $this->idplanestudio = $idplanestudio;
    }

    public function setIdlineaenfasisplanestudio($idlineaenfasisplanestudio) {
        $this->idlineaenfasisplanestudio = $idlineaenfasisplanestudio;
    }

    public function setObservacionnotahistorico($observacionnotahistorico) {
        $this->observacionnotahistorico = $observacionnotahistorico;
    }

    public function setCodigoestadonotahistorico($codigoestadonotahistorico) {
        $this->codigoestadonotahistorico = $codigoestadonotahistorico;
    }

    public function setCodigotipomateria($codigotipomateria) {
        $this->codigotipomateria = $codigotipomateria;
    }
    
    public function getById() {
        if(!empty($this->idnotahistorico)){
            $query = "SELECT * FROM notahistorico"
                    ." WHERE idnotahistorico = ".$this->db->qstr($this->idnotahistorico);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->setIdnotahistorico($d['idnotahistorico']);
                $this->setCodigoperiodo($d['codigoperiodo']);
                $this->setCodigomateria($d['codigomateria']);
                $this->setCodigomateriaelectiva($d['codigomateriaelectiva']);
                $this->setCodigoestudiante($d['codigoestudiante']);
                $this->setNotadefinitiva($d['notadefinitiva']);
                $this->setCodigotiponotahistorico($d['codigotiponotahistorico']);
                $this->setOrigennotahistorico($d['origennotahistorico']);
                $this->setFechaprocesonotahistorico($d['fechaprocesonotahistorico']);
                $this->setIdgrupo($d['idgrupo']);
                $this->setIdplanestudio($d['idplanestudio']);
                $this->setIdlineaenfasisplanestudio($d['idlineaenfasisplanestudio']);
                $this->setObservacionnotahistorico($d['observacionnotahistorico']);
                $this->setCodigoestadonotahistorico($d['codigoestadonotahistorico']);
                $this->setCodigotipomateria($d['codigotipomateria']);
            }  
        }
    }

    public static function getList($where = null, $orderBy = null) {
        $return = array();
        $db = \Sala\lib\Factory::createDbo();
        $query = "SELECT * FROM notahistorico "
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
            $NotaHistorico = new NotaHistorico();
            $NotaHistorico->setIdnotahistorico($d['idnotahistorico']);
            $NotaHistorico->setCodigoperiodo($d['codigoperiodo']);
            $NotaHistorico->setCodigomateria($d['codigomateria']);
            $NotaHistorico->setCodigomateriaelectiva($d['codigomateriaelectiva']);
            $NotaHistorico->setCodigoestudiante($d['codigoestudiante']);
            $NotaHistorico->setNotadefinitiva($d['notadefinitiva']);
            $NotaHistorico->setCodigotiponotahistorico($d['codigotiponotahistorico']);
            $NotaHistorico->setOrigennotahistorico($d['origennotahistorico']);
            $NotaHistorico->setFechaprocesonotahistorico($d['fechaprocesonotahistorico']);
            $NotaHistorico->setIdgrupo($d['idgrupo']);
            $NotaHistorico->setIdplanestudio($d['idplanestudio']);
            $NotaHistorico->setIdlineaenfasisplanestudio($d['idlineaenfasisplanestudio']);
            $NotaHistorico->setObservacionnotahistorico($d['observacionnotahistorico']);
            $NotaHistorico->setCodigoestadonotahistorico($d['codigoestadonotahistorico']);
            $NotaHistorico->setCodigotipomateria($d['codigotipomateria']);
            $return[] = $NotaHistorico;
            unset($NotaHistorico);
        }
        return $return;
    }

}