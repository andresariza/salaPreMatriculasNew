<?php
/**
 * Clase encargada del control de la autenticacion
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since  Enero 2019
 * @package lib/autenticacion
 */
namespace Sala\lib\autenticacion;
defined('_EXEC') or die;

use \Sala\lib\Factory;
class Autenticacion{
    
    /**
     * @type adodb Object
     * @access private
     */
    private $db;

    /**
     * @type String
     * @access public
     */
    public $usuario;

    /**
     * @type String
     * @access public
     */
    public $password;

    /**
     * @type String
     * @access public
     */
    public $pwdHash;

    /**
     * @type String
     * @access public
     */
    public $autenticarSegundaclave;

    /**
     * @type String
     * @access public
     */
    public $modoRespuestaAutenticacion;

    /**
     * @type boolean
     * @access public
     */
    public $app;

    /**
     * @type integer
     * @access public
     */
    public $acceso;
    
    function __construct($usuario,$password,$autenticarSegundaclave,$modoRespuestaAutenticacion='XML',$app=false,$acceso=0) {
        $this->db = Factory::createDbo();
        $this->usuario = $usuario;
        $this->password = $password;
        $this->pwdHash = hash('sha256',$password);
        $this->autenticarSegundaclave = $autenticarSegundaclave;
        $this->modoRespuestaAutenticacion = $modoRespuestaAutenticacion;
        $this->app = $app;
        $this->acceso = $acceso;
    }
    
    function usuarioVacio(){
        return ( empty($this->usuario)&&empty($this->password) );
    }
}