<?php
namespace Sala\components\misCarreras\modelo;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
defined('_EXEC') or die;
use Sala\lib\Factory;
class MisCarreras implements \Sala\interfaces\Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    public function __construct() {
        $this->db = Factory::createDbo();
    }
    
    public function getVariables($variables){
        $array = array();
        if(!empty($variables->origin) && $variables->origin=="cambioPeriodo"){
            $array["origin"] = "cambioPeriodo";
        }
        $query = "SELECT c.codigocarrera "
                . " FROM usuariofacultad uf "
                . " INNER JOIN carrera c ON (uf.codigofacultad = c.codigocarrera ) "
                . " INNER JOIN usuario u ON (u.usuario=uf.usuario) "
                . " WHERE u.usuario = ".$this->db->qstr(Factory::getSessionVar('MM_Username'))." "
                . " AND uf.codigoestado = '100' "
                . " ORDER BY c.nombrecarrera";
        //d($query);
        $datos = $this->db->Execute($query);
       
        $codigoCarrera = array();
        while($d = $datos->FetchRow()){
            $codigoCarrera[] = $d['codigocarrera'];
        }
        
        $array['listaCarreras'] = array();
        if(!empty($codigoCarrera)){
            $condicion = " codigocarrera IN (".implode(",",$codigoCarrera).") ";
            $listaCarreras = \Sala\entidad\Carrera::getList($condicion, "nombrecarrera ASC");
            //d($listaCarreras);
            $array['listaCarreras'] = $listaCarreras;
        }
        
        return $array;
    } 
}