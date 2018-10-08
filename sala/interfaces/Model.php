<?php
namespace Sala\interfaces;
defined('_EXEC') or die;
/**
 * Interface Model para la implementacion de todos los modelos de componentes y
 * modulos utilizados en el sistema
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package interfaces
 */
interface Model {
    /**
     * Consulta las y retorna el un array de variables que se utilizan en el render de los componentes
     * @access public
     * @param stdClass $variables
     * @return Array
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @since mayo 3, 2018
    */
    public function getVariables($variables);
}
