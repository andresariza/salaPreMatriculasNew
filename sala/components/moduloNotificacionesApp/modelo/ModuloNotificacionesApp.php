<?php
namespace Sala\components\moduloNotificacionesApp\modelo;
defined('_EXEC') or die;
/** 
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package modelo
*/
class ModuloNotificacionesApp implements \Sala\interfaces\Model{
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
            $array['test'] = "Administracion Notificaciones";
            $NotificacionesApp = \Sala\entidad\NotificacionesApp::getList();
            $array['NotificacionesApp'] = $NotificacionesApp;
//            $array['tmpl'] = @$variables->tmpl;
        }elseif($variables->layout=="createEdit"){
            $array["NotificacionApp"] = new \Sala\entidad\NotificacionesApp();
            if(!empty($variables->id)){
                $array["NotificacionApp"]->setDb();
                $array["NotificacionApp"]->setId($variables->id);
                $array["NotificacionApp"]->getById();
            }
        }
         
        return $array;
    }
}
