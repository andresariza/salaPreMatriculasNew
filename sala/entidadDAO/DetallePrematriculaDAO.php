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
use \Sala\entidad\DetallePrematricula;
/**
 * Description of ReservaCupoDAO
 *
 * @author Andres
 */
class DetallePrematriculaDAO implements EntidadDAO {
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type Estudiante
     * @access private
     */
    private $detallePrematriculaEnt;

    public function __construct(DetallePrematricula $detallePrematriculaEnt) {
        $this->detallePrematriculaEnt = $detallePrematriculaEnt;
        $this->setDb();
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function save() {    
        $query = ""; $where = array();
        $id = $this->detallePrematriculaEnt->getIdDetallePrematricula();
        
        if(empty($id)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idDetallePrematricula = ".$this->db->qstr($id);
        }
      
        $query .= " detalleprematricula SET idprematricula = ".$this->db->qstr($this->detallePrematriculaEnt->getIdprematricula()) 
                .", codigomateria = ".$this->db->qstr($this->detallePrematriculaEnt->getCodigomateria())  
                .", codigomateriaelectiva = ".$this->db->qstr($this->detallePrematriculaEnt->getCodigomateriaelectiva())  
                .", codigoestadodetalleprematricula = ".$this->db->qstr($this->detallePrematriculaEnt->getCodigoestadodetalleprematricula())  
                .", codigotipodetalleprematricula = ".$this->db->qstr($this->detallePrematriculaEnt->getCodigotipodetalleprematricula())  
                .", idgrupo = ".$this->db->qstr($this->detallePrematriculaEnt->getIdgrupo())  
                .", numeroordenpago = ".$this->db->qstr($this->detallePrematriculaEnt->getNumeroordenpago())."";
       
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $rs = $this->db->Execute($query);
        if(empty($id)){
            $this->detallePrematriculaEnt->setIdDetallePrematricula($this->db->insert_Id());
        }
        
        $this->logAuditoria($this->detallePrematriculaEnt, $query);
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
