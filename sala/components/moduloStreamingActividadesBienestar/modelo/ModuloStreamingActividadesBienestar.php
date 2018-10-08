<?php
namespace Sala\components\moduloStreamingActividadesBienestar\modelo;
/** 
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package modelo
*/
defined('_EXEC') or die;
class ModuloStreamingActividadesBienestar implements \Sala\interfaces\Model{
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
            $array['test'] = "Url's Actividades Bienestar";
            $StreamingActividadesBienestar = \Sala\entidad\StreamingActividadesBienestar::getList();
            $array['StreamingActividadesBienestar'] = $StreamingActividadesBienestar;
//            $array['tmpl'] = @$variables->tmpl;
        }elseif($variables->layout=="createEdit"){
            $array["StreamingActividadBienestar"] = new \Sala\entidad\StreamingActividadesBienestar();
            if(!empty($variables->id)){
                $array["StreamingActividadBienestar"]->setDb();
                $array["StreamingActividadBienestar"]->setId($variables->id);
                $array["StreamingActividadBienestar"]->getById();
            }
        }
         
        return $array;
    }
}
