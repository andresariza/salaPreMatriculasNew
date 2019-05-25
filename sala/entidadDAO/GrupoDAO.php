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
use \Sala\entidad\Grupo;
/**
 * Description of ReservaCupoDAO
 *
 * @author Andres
 */
class GrupoDAO implements EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Estudiante
     * @access private
     */
    private $entidad;

    public function __construct(Grupo $entidad) {
        $this->entidad = $entidad;
        $this->setDb();
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function save() {    
        $query = ""; $where = array();
        $id = $this->entidad->getIdgrupo();
        
        if(empty($id)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idgrupo = ".$this->db->qstr($id);
        }
      
        $query .= " grupo SET matriculadosgrupo = ".$this->db->qstr($this->entidad->getMatriculadosgrupo())."";
       
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query);
        if(empty($id)){
            $this->entidad->setIdgrupo($this->db->insert_Id());
        }
        
        $this->logAuditoria($this->entidad, $query);
        return $rs;
    }
    
    public function delete(){
        $query = ""; $where = array();
        $id = $this->entidad->getIdgrupo();
        
        if(!empty($id)){
            $query .= "DELETE FROM grupo WHERE idgrupo = ".$this->db->qstr($id);
            
            $rs = $this->db->Execute($query);
            
            $this->logAuditoria($this->reservaCupo, $query);
            return $rs;
        }
    }
    
    public function logAuditoria($e, $query) {
        return $query;
    }

}
