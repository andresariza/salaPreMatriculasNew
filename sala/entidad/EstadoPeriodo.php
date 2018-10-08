<?php
namespace Sala\entidad;
defined('_EXEC') or die;
use \Sala\lib\Factory;
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
class EstadoPeriodo implements \Sala\interfaces\Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestadoperiodo;
    
    /**
     * @type char
     * @access private
     */
    private $nombreestadoperiodo;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getCodigoestadoperiodo() {
        return $this->codigoestadoperiodo;
    }

    public function getNombreestadoperiodo() {
        return $this->nombreestadoperiodo;
    }

    public function setCodigoestadoperiodo($codigoestadoperiodo) {
        $this->codigoestadoperiodo = $codigoestadoperiodo;
    }

    public function setNombreestadoperiodo($nombreestadoperiodo) {
        $this->nombreestadoperiodo = $nombreestadoperiodo;
    }
    
    public function getById(){
        if(!empty($this->codigoestadoperiodo)){
            $query = "SELECT * FROM estadoperiodo "
                    ." WHERE codigoestadoperiodo = ".$this->db->qstr($this->codigoestadoperiodo);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombreestadoperiodo = $d['nombreestadoperiodo']; 
            }
        }
    }
    
    public static function getList($where) {
        $arrayReturn = array();
        return $arrayReturn;
    }
}
    
/*/
codigoestadoperiodo	char(2)
nombreestadoperiodo	varchar(25)
/**/