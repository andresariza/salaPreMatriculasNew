<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\entidadDAO;
defined('_EXEC') or die;
use \Sala\lib\Factory;
use \Sala\interfaces\EntidadDAO;
use \Sala\entidad\ReservaCupo;
/**
 * Description of ReservaCupoDAO
 *
 * @author Andres
 */
class ReservaCupoDAO implements EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Estudiante
     * @access private
     */
    private $reservaCupo;

    public function __construct(ReservaCupo $reservaCupo) {
        $this->reservaCupo = $reservaCupo;
        $this->setDb();
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function save() {    
        $query = ""; $where = array();
        $id = $this->reservaCupo->getId();
        
        if(empty($id)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " id = ".$this->db->qstr($id);
        }
      
        $query .= " ReservaCupo SET   idEstudiante = ".$this->db->qstr($this->reservaCupo->getIdEstudiante()).", nombreperiodo = ".$this->db->qstr($this->reservaCupo->getIdGrupo()).", codigoestadoperiodo = ".$this->db->qstr($this->reservaCupo->getFechaReserva()).""; 
       
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query);
        if(empty($id)){
            $this->reservaCupo->setId($this->db->insert_Id());
        }
        
        $this->logAuditoria($this->reservaCupo, $query);
        return $rs;
    }
    
    public function logAuditoria($e, $query) {
        return $query;
    }

}
