<?php
namespace Sala\entidad;
defined('_EXEC') or die;
use \Sala\lib\Factory;
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidad
 */
class Usuario implements \Sala\interfaces\Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
 	
    /**
     * @type int 
     * @access private
     */
    private $idusuario;

    /**
     * @type varchar 
     * @access private
     */
    private $usuario;

    /**
     * @type varchar 
     * @access private
     */
    private $numerodocumento;

    /**
     * @type char 
     * @access private
     */
    private $tipodocumento;

    /**
     * @type varchar 
     * @access private
     */
    private $apellidos;

    /**
     * @type varchar 
     * @access private
     */
    private $nombres;

    /**
     * @type varchar 
     * @access private
     */
    private $codigousuario;

    /**
     * @type varchar 
     * @access private
     */
    private $semestre;

    /**
     * @type int 
     * @access private
     */
    private $codigorol;

    /**
     * @type datetime 
     * @access private
     */
    private $fechainiciousuario;

    /**
     * @type datetime 
     * @access private
     */
    private $fechavencimientousuario;

    /**
     * @type datetime 
     * @access private
     */
    private $fecharegistrousuario;

    /**
     * @type char 
     * @access private
     */
    private $codigotipousuario;

    /**
     * @type int 
     * @access private
     */
    private $idusuariopadre;

    /**
     * @type varchar 
     * @access private
     */
    private $ipaccesousuario;

    /**
     * @type varchar 
     * @access private
     */
    private $codigoestadousuario;

    /**
     * Constructor
     * @param Singleton $persistencia
     */
    public function __construct(){
         $this->db = Factory::createDbo();
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdusuario() {
        return $this->idusuario;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getNombres() {
        return $this->nombres;
    }

    public function getCodigousuario() {
        return $this->codigousuario;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function getCodigorol() {
        return $this->codigorol;
    }

    public function getFechainiciousuario() {
        return $this->fechainiciousuario;
    }

    public function getFechavencimientousuario() {
        return $this->fechavencimientousuario;
    }

    public function getFecharegistrousuario() {
        return $this->fecharegistrousuario;
    }

    public function getCodigotipousuario() {
        return $this->codigotipousuario;
    }

    public function getIdusuariopadre() {
        return $this->idusuariopadre;
    }

    public function getIpaccesousuario() {
        return $this->ipaccesousuario;
    }

    public function getCodigoestadousuario() {
        return $this->codigoestadousuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }
    
    public function getUsuarioByIdUsuario(){
        if(!empty($this->idusuario)){
            $query = "SELECT * "
                    . "FROM usuario "
                    . "WHERE idusuario = ".$this->idusuario;
            $datos = $this->db->Execute($query);
            //ddd($query);
            if(!empty($datos)){
                $d = $datos->FetchRow();
                
                $this->usuario = $d['usuario'];
                $this->numerodocumento = $d['numerodocumento'];
                $this->tipodocumento = $d['tipodocumento'];
                $this->apellidos = $d['apellidos'];
                $this->nombres = $d['nombres'];
                $this->codigousuario = $d['codigousuario'];
                $this->semestre = $d['semestre'];
                $this->codigorol = $d['codigorol'];
                $this->fechainiciousuario = $d['fechainiciousuario'];
                $this->fechavencimientousuario = $d['fechavencimientousuario'];
                $this->fecharegistrousuario = $d['fecharegistrousuario'];
                $this->codigotipousuario = $d['codigotipousuario'];
                $this->idusuariopadre = $d['idusuariopadre'];
                $this->ipaccesousuario = $d['ipaccesousuario'];
                $this->codigoestadousuario = $d['codigoestadousuario'];
            }
        }
    }
    
    public function getById() {
        $this->getUsuarioByIdUsuario();
    }

    public static function getList($where) {
        $arrayReturn = array();
        return $arrayReturn;
    }

    public function getUsuarioByUsuario(){
        if(!empty($this->usuario)){
            $query = "SELECT * "
                    . "FROM usuario "
                    . "WHERE usuario = ".$this->usuario;
            $datos = $this->db->Execute($query);
            
            if(!empty($datos)){
                $d = $datos->FetchRow();
                
                $this->idusuario = $d['idusuario'];
                $this->usuario = $d['usuario'];
                $this->numerodocumento = $d['numerodocumento'];
                $this->tipodocumento = $d['tipodocumento'];
                $this->apellidos = $d['apellidos'];
                $this->nombres = $d['nombres'];
                $this->codigousuario = $d['codigousuario'];
                $this->semestre = $d['semestre'];
                $this->codigorol = $d['codigorol'];
                $this->fechainiciousuario = $d['fechainiciousuario'];
                $this->fechavencimientousuario = $d['fechavencimientousuario'];
                $this->fecharegistrousuario = $d['fecharegistrousuario'];
                $this->codigotipousuario = $d['codigotipousuario'];
                $this->idusuariopadre = $d['idusuariopadre'];
                $this->ipaccesousuario = $d['ipaccesousuario'];
                $this->codigoestadousuario = $d['codigoestadousuario'];
            }
        }
    }
	
 }