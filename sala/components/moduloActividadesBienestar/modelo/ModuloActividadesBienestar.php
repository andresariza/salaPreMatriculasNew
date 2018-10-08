<?php 
namespace Sala\components\moduloActividadesBienestar\modelo;
defined('_EXEC') or die;
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package modelo
*/
class ModuloActividadesBienestar implements \Sala\interfaces\Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct() {
        $this->db = \Sala\lib\Factory::createDbo();
    }
    
    public function getVariables($variables){
        $array = array();
        if(empty($variables->layout)){
            $array['test'] = "Actividades Bienestar";
            $ActividadesBienestar = \Sala\entidad\ActividadesBienestar::getList();
            $array['ActividadesBienestar'] = $ActividadesBienestar;
//            $array['tmpl'] = @$variables->tmpl;
        }elseif($variables->layout=="createEdit"){
            $array["ActividadBienestar"] = new \Sala\entidad\ActividadesBienestar();
            if(!empty($variables->id)){
                $array["ActividadBienestar"]->setDb();
                $array["ActividadBienestar"]->setId($variables->id);
                $array["ActividadBienestar"]->getById();
            }
        }
         
        return $array;
    }
}
