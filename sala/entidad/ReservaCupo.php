<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\entidad;
defined('_EXEC') or die;
use \Sala\interfaces\Entidad;
use \Sala\lib\Factory;

/**
 * Description of ReservaCupo
 *
 * @author Andres
 */
class ReservaCupo  implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $id;
    
    /**
     * @type int
     * @access private
     */
    private $idEstudiante;
    
    /**
     * @type int
     * @access private
     */
    private $idGrupo;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechaReserva;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getIdEstudiante() {
        return $this->idEstudiante;
    }

    public function getIdGrupo() {
        return $this->idGrupo;
    }

    public function getFechaReserva() {
        return $this->fechaReserva;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdEstudiante($idEstudiante) {
        $this->idEstudiante = $idEstudiante;
    }

    public function setIdGrupo($idGrupo) {
        $this->idGrupo = $idGrupo;
    }

    public function setFechaReserva($fechaReserva) {
        $this->fechaReserva = $fechaReserva;
    }
    
    public function getById() {
        $this->setDb();
        if (!empty($this->id)) {
            $query = "SELECT * FROM ReservaCupo "
                    . " WHERE id = " . $this->db->qstr($this->id);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if (!empty($d)) {
                $this->setId($d['id']);
                $this->setIdEstudiante($d['idEstudiante']);
                $this->setIdGrupo($d['idGrupo']);
                $this->setFechaReserva($d['fechaReserva']);
            }
        }
    }

    public static function getList($where = null, $orderBy = null) {
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM ReservaCupo "
                . " WHERE 1 ";
        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }
        //d($query);
        $datos = $db->Execute($query);

        while ($d = $datos->FetchRow()) {
            $ReservaCupo = new ReservaCupo();
            $ReservaCupo->setId($d['id']);
            $ReservaCupo->setIdEstudiante($d['idEstudiante']);
            $ReservaCupo->setIdGrupo($d['idGrupo']);
            $ReservaCupo->setFechaReserva($d['fechaReserva']);
            
            $return[] = $ReservaCupo;
            unset($ReservaCupo);
        }
        return $return;
    }
}
