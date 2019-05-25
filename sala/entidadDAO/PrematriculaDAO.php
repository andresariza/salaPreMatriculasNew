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
use \Sala\entidad\Prematricula;
/**
 * Description of ReservaCupoDAO
 *
 * @author Andres
 */
class PrematriculaDAO implements EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Estudiante
     * @access private
     */
    private $prematriculaEnt;

    public function __construct(Prematricula $prematriculaEnt) {
        $this->prematriculaEnt = $prematriculaEnt;
        $this->setDb();
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function save() {    
        $query = ""; $where = array();
        $id = $this->prematriculaEnt->getIdprematricula();
        
        if(empty($id)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idprematricula = ".$this->db->qstr($id);
        }
      
        $query .= " prematricula SET   fechaprematricula = ".$this->db->qstr($this->prematriculaEnt->getFechaprematricula()) .", codigoestudiante = ".$this->db->qstr($this->prematriculaEnt->getCodigoestudiante()) .", codigoperiodo = ".$this->db->qstr($this->prematriculaEnt->getCodigoperiodo()) .", codigoestadoprematricula = ".$this->db->qstr($this->prematriculaEnt->getCodigoestadoprematricula()) .", observacionprematricula = ".$this->db->qstr($this->prematriculaEnt->getObservacionprematricula()) .", semestreprematricula = ".$this->db->qstr($this->prematriculaEnt->getSemestreprematricula())."";
       
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //ddd($query);
        $rs = $this->db->Execute($query);
        if(empty($id)){
            $this->prematriculaEnt->setIdprematricula($this->db->insert_Id());
        }
        
        $this->logAuditoria($this->prematriculaEnt, $query);
        return $rs;
    }
    
    public function delete(){
        $query = ""; $where = array();
        $id = $this->prematriculaEnt->getIdprematricula();
        
        if(!empty($id)){
            $query .= "DELETE FROM prematricula WHERE idprematricula = ".$this->db->qstr($id);
            
            $rs = $this->db->Execute($query);
            
            $this->logAuditoria($this->reservaCupo, $query);
            return $rs;
        }
    }
    
    public function logAuditoria($e, $query) {
        return $query;
    }

}
