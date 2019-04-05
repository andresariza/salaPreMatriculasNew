<?php
namespace Sala\entidad;
defined('_EXEC') or die;
use \Sala\lib\Factory;
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
class FechaAcademica implements \Sala\interfaces\Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idfechaacademica;
    
    /**
     * @type int
     * @access private
     */
    private $codigoperiodo;
    
    /**
     * @type int
     * @access private
     */
    private $codigocarrera;
    
    /**
     * @type int
     * @access private
     */
    private $fechacortenotas;
    
    /**
     * @type int
     * @access private
     */
    private $fechacargaacademica;
    
    /**
     * @type int
     * @access private
     */
    private $fechainicialprematricula;
    
    /**
     * @type int
     * @access private
     */
    private $fechafinalprematricula;
    
    /**
     * @type int
     * @access private
     */
    private $fechainicialpostmatriculafechaacademica;
    
    /**
     * @type int
     * @access private
     */
    private $fechafinalpostmatriculafechaacademica;
    
    /**
     * @type int
     * @access private
     */
    private $fechainicialprematriculacarrera;
    
    /**
     * @type int
     * @access private
     */
    private $fechafinalprematriculacarrera;
    
    /**
     * @type int
     * @access private
     */
    private $fechainicialretiroasignaturafechaacademica;
    
    /**
     * @type int
     * @access private
     */
    private $fechafinallretiroasignaturafechaacademica;
    
    /**
     * @type int
     * @access private
     */
    private $fechainicialentregaordenpago;
    
    /**
     * @type int
     * @access private
     */
    private $fechafinalentregaordenpago;
    
    /**
     * @type int
     * @access private
     */
    private $fechafinalordenpagomatriculacarrera;
    
    public function __construct(){
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }
    function getIdfechaacademica() {
        return $this->idfechaacademica;
    }

    function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    function getCodigocarrera() {
        return $this->codigocarrera;
    }

    function getFechacortenotas() {
        return $this->fechacortenotas;
    }

    function getFechacargaacademica() {
        return $this->fechacargaacademica;
    }

    function getFechainicialprematricula() {
        return $this->fechainicialprematricula;
    }

    function getFechafinalprematricula() {
        return $this->fechafinalprematricula;
    }

    function getFechainicialpostmatriculafechaacademica() {
        return $this->fechainicialpostmatriculafechaacademica;
    }

    function getFechafinalpostmatriculafechaacademica() {
        return $this->fechafinalpostmatriculafechaacademica;
    }

    function getFechainicialprematriculacarrera() {
        return $this->fechainicialprematriculacarrera;
    }

    function getFechafinalprematriculacarrera() {
        return $this->fechafinalprematriculacarrera;
    }

    function getFechainicialretiroasignaturafechaacademica() {
        return $this->fechainicialretiroasignaturafechaacademica;
    }

    function getFechafinallretiroasignaturafechaacademica() {
        return $this->fechafinallretiroasignaturafechaacademica;
    }

    function getFechainicialentregaordenpago() {
        return $this->fechainicialentregaordenpago;
    }

    function getFechafinalentregaordenpago() {
        return $this->fechafinalentregaordenpago;
    }

    function getFechafinalordenpagomatriculacarrera() {
        return $this->fechafinalordenpagomatriculacarrera;
    }

    function setIdfechaacademica($idfechaacademica) {
        $this->idfechaacademica = $idfechaacademica;
    }

    function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    function setFechacortenotas($fechacortenotas) {
        $this->fechacortenotas = $fechacortenotas;
    }

    function setFechacargaacademica($fechacargaacademica) {
        $this->fechacargaacademica = $fechacargaacademica;
    }

    function setFechainicialprematricula($fechainicialprematricula) {
        $this->fechainicialprematricula = $fechainicialprematricula;
    }

    function setFechafinalprematricula($fechafinalprematricula) {
        $this->fechafinalprematricula = $fechafinalprematricula;
    }

    function setFechainicialpostmatriculafechaacademica($fechainicialpostmatriculafechaacademica) {
        $this->fechainicialpostmatriculafechaacademica = $fechainicialpostmatriculafechaacademica;
    }

    function setFechafinalpostmatriculafechaacademica($fechafinalpostmatriculafechaacademica) {
        $this->fechafinalpostmatriculafechaacademica = $fechafinalpostmatriculafechaacademica;
    }

    function setFechainicialprematriculacarrera($fechainicialprematriculacarrera) {
        $this->fechainicialprematriculacarrera = $fechainicialprematriculacarrera;
    }

    function setFechafinalprematriculacarrera($fechafinalprematriculacarrera) {
        $this->fechafinalprematriculacarrera = $fechafinalprematriculacarrera;
    }

    function setFechainicialretiroasignaturafechaacademica($fechainicialretiroasignaturafechaacademica) {
        $this->fechainicialretiroasignaturafechaacademica = $fechainicialretiroasignaturafechaacademica;
    }

    function setFechafinallretiroasignaturafechaacademica($fechafinallretiroasignaturafechaacademica) {
        $this->fechafinallretiroasignaturafechaacademica = $fechafinallretiroasignaturafechaacademica;
    }

    function setFechainicialentregaordenpago($fechainicialentregaordenpago) {
        $this->fechainicialentregaordenpago = $fechainicialentregaordenpago;
    }

    function setFechafinalentregaordenpago($fechafinalentregaordenpago) {
        $this->fechafinalentregaordenpago = $fechafinalentregaordenpago;
    }

    function setFechafinalordenpagomatriculacarrera($fechafinalordenpagomatriculacarrera) {
        $this->fechafinalordenpagomatriculacarrera = $fechafinalordenpagomatriculacarrera;
    }

        
    public function getById() {
        if(!empty($this->idfechaacademica)){
            $query = "SELECT * FROM fechaacademica "
                    ." WHERE idfechaacademica = ".$this->db->qstr($this->idfechaacademica);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
    
            if(!empty($d)){
                $this->setIdfechaacademica($d['idfechaacademica']);
                $this->setCodigoperiodo($d['codigoperiodo']);
                $this->setCodigocarrera($d['codigocarrera']);
                $this->setFechacortenotas($d['fechacortenotas']);
                $this->setFechacargaacademica($d['fechacargaacademica']);
                $this->setFechainicialprematricula($d['fechainicialprematricula']);
                $this->setFechafinalprematricula($d['fechafinalprematricula']);
                $this->setFechainicialpostmatriculafechaacademica($d['fechainicialpostmatriculafechaacademica']);
                $this->setFechafinalpostmatriculafechaacademica($d['fechafinalpostmatriculafechaacademica']);
                $this->setFechainicialprematriculacarrera($d['fechainicialprematriculacarrera']);
                $this->setFechafinalprematriculacarrera($d['fechafinalprematriculacarrera']);
                $this->setFechainicialretiroasignaturafechaacademica($d['fechainicialretiroasignaturafechaacademica']);
                $this->setFechafinallretiroasignaturafechaacademica($d['fechafinallretiroasignaturafechaacademica']);
                $this->setFechainicialentregaordenpago($d['fechainicialentregaordenpago']);
                $this->setFechafinalentregaordenpago($d['fechafinalentregaordenpago']);
                $this->setFechafinalordenpagomatriculacarrera($d['fechafinalordenpagomatriculacarrera']);
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM fechaacademica "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        //d($query);
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $FechaAcademica = new FechaAcademica();
                $FechaAcademica->setIdfechaacademica($d['idfechaacademica']);
                $FechaAcademica->setCodigoperiodo($d['codigoperiodo']);
                $FechaAcademica->setCodigocarrera($d['codigocarrera']);
                $FechaAcademica->setFechacortenotas($d['fechacortenotas']);
                $FechaAcademica->setFechacargaacademica($d['fechacargaacademica']);
                $FechaAcademica->setFechainicialprematricula($d['fechainicialprematricula']);
                $FechaAcademica->setFechafinalprematricula($d['fechafinalprematricula']);
                $FechaAcademica->setFechainicialpostmatriculafechaacademica($d['fechainicialpostmatriculafechaacademica']);
                $FechaAcademica->setFechafinalpostmatriculafechaacademica($d['fechafinalpostmatriculafechaacademica']);
                $FechaAcademica->setFechainicialprematriculacarrera($d['fechainicialprematriculacarrera']);
                $FechaAcademica->setFechafinalprematriculacarrera($d['fechafinalprematriculacarrera']);
                $FechaAcademica->setFechainicialretiroasignaturafechaacademica($d['fechainicialretiroasignaturafechaacademica']);
                $FechaAcademica->setFechafinallretiroasignaturafechaacademica($d['fechafinallretiroasignaturafechaacademica']);
                $FechaAcademica->setFechainicialentregaordenpago($d['fechainicialentregaordenpago']);
                $FechaAcademica->setFechafinalentregaordenpago($d['fechafinalentregaordenpago']);
                $FechaAcademica->setFechafinalordenpagomatriculacarrera($d['fechafinalordenpagomatriculacarrera']);
                
            $return[] = $FechaAcademica;
            unset($FechaAcademica);
        }
        return $return;
    }

}

/*/
idfechaacademica	int(11)
codigoperiodo	varchar(8)
codigocarrera	int(11)
fechacortenotas	date
fechacargaacademica	date
fechainicialprematricula	date
fechafinalprematricula	date
fechainicialpostmatriculafechaacademica	date
fechafinalpostmatriculafechaacademica	date
fechainicialprematriculacarrera	date
fechafinalprematriculacarrera	date
fechainicialretiroasignaturafechaacademica	date
fechafinallretiroasignaturafechaacademica	date
fechainicialentregaordenpago	date
fechafinalentregaordenpago	date
fechafinalordenpagomatriculacarrera	date
/**/