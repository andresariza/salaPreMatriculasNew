<?php
namespace Sala\components\mainMenu\control;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
require_once(PATH_SITE.'/control/ControlMenu.php');
use Sala\control\ControlMenu;
use Sala\lib\Factory;
class ControlMainMenu extends ControlMenu { 
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type stdObject
     * @access private
     */
    private $variables;
    
    public function __construct() {
        parent::setDb(Factory::createDbo());
        $this->db = Factory::createDbo();
        $usuario= Factory::getSessionVar('MM_Username');
        parent::setUsuario($usuario);
        parent::setQueryBase();
    }
    
    public function setVariables($variables){
        $this->variables = $variables; 
    }
    
    public function getTituloSeccion(){
         
        $return = array();
        $return['s'] = false;
        $menuId = $this->variables->menuId;
        $menuId = explode("_",$menuId);
        $menuId = @$menuId[1];
        
        if((!empty($menuId) || $menuId=="0") && is_numeric($menuId) ){
            $menu = parent::getCurrentMenu($menuId); 
            $breadCrumbs = Factory::renderBreadCrumbs($menu);
            $currentTitle = Factory::getCurrenTitle($menu);
            $return['s'] = true;
            $return['breadCrumbs'] = $breadCrumbs;
            $return['title'] = $currentTitle;
        }
        
        echo json_encode($return);
        exit();
    }
    
    public function buscarMenu(){
        $textoBusqueda = $this->variables->query;
        $query = $this->queryBase;
        if(!empty($textoBusqueda)){
                $query .="
                   AND (text LIKE '%".$textoBusqueda."%') 
                   AND link <> '' ";

        }
        $query .="
          GROUP BY id
          ORDER BY text, parent_id
        ";
        //d($query);
        $datos = $this->db->Execute($query);
        $arrayReturn = array();
        $i=0;
        while($d = $datos->fetchRow()){
            //echo $d["id"]."###".$d["text"]."|";
            $arrayReturn[$i] = new \stdClass();
            $arrayReturn[$i]->value = $d["text"];
            $arrayReturn[$i]->data = $d["id"];
            $i++;
	}
        echo json_encode(array("suggestions" => $arrayReturn));
        exit();
    }
}