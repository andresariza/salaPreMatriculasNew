<?php
namespace Sala\components\adminMenu\modelo;
defined('_EXEC') or die;
use \Sala\lib\Factory;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */

class AdminMenu implements \Sala\interfaces\Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type ControlAdminMenu Object
     * @access private
     */
    private $ControlAdminMenu;
    
    public function __construct() {
        $this->db = \Sala\lib\Factory::createDbo();
    }
    
    public function getVariables($variables){
        $array = array();
        //$variables->id = 512;
        //d($variables);
        $array['ControlMenu'] = new \Sala\control\ControlMenu(null,$this->db);
        //ddd($array['ControlMenu']);
        $this->ControlAdminMenu = new \Sala\components\adminMenu\control\ControlAdminMenu($variables);
        if(empty($variables->layout)){
            $array['listMenuOpcion'] = \Sala\entidad\MenuOpcion::getListMenuOpcion();
        }elseif($variables->layout=="createEdit"){
            $array['listMenuOpcion'] = \Sala\entidad\MenuOpcion::getListMenuOpcion();
            $array['listGerarquiaRol'] = \Sala\entidad\GerarquiaRol::getListGerarquiaRol();
            //d($array['listGerarquiaRol']);
            $array['MenuOpcion'] = new \Sala\entidad\MenuOpcion();
            if(!empty($variables->id)){ 
                $array['MenuOpcion']->setDb();
                $array['MenuOpcion']->setIdmenuopcion($variables->id);
                $array['MenuOpcion']->getMenuOpcionById();
            }
        }
        //d($array);
         
        return $array;
    }
}
