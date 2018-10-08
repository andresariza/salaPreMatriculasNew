<?php
namespace Sala\components\login\modelo;
defined('_EXEC') or die;
use Sala\lib\Factory;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
class Login implements \Sala\interfaces\Model{
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
        $array['clavereq2'] = Factory::getSessionVar('2clavereq');
        $array['MM_Username'] = Factory::getSessionVar('MM_Username');
        return $array;
    }
}
