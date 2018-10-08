<?php
namespace Sala\entidad;
defined('_EXEC') or die;
use \Sala\lib\Factory;
/**
 * @author Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
 */
class EncuestaMateria implements \Sala\interfaces\Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $idencuestamateria;
    
    /**
     * @type int
     * @access private
     */
    private $codigomateria;
    
    /**
     * @type int
     * @access private
     */
    private $idencuesta;
    
    /**
     * @type int
     * @access private
     */
    private $codigomodulopostind;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function setIdencuenstamateria($idencuenstamateria){
        $this->idencuenstamateria = $idencuenstamateria;
    }
    
    public function setCodigomateria($codigomateria){
        $this->codigomateria = $codigomateria;
    }
    
    public function setIdencuesta($idencuesta){
        $this->idencuesta = $idencuesta;
    }
    
    public function setCodigomodulopostind($codigomodulopostind){
        $this->codigomodulopostind = $codigomodulopostind;
    }
    
    public function getIdencuenstamateria(){
        return $this->idencuenstamateria;
    }    
    
    public function getCodigomateria(){
        return $this->codigomateria;
    }
    
    public function getIdencuesta(){
        return $this->idencuesta;
    }
    
    public function getCodigomodulopostind(){
        return $this->codigomodulopostind;
    }
    
    public function getById(){
        if(!empty($this->idencuesta)){
            $query = "SELECT * FROM encuestamateria"
                    ." WHERE idencuesta = ".$this->db->qstr($this->idencuesta);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idencuestamateria = $d['idencuestamateria'];
                $this->codigomateria = $d['codigomateria'];
                $this->codigomodulopostind = $d['codigomodulopostind'];
            }           
        }
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        
        $query = "SELECT * FROM encuestamateria "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        //d($query);
        $datos = $this->db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $EncuestaMateria = new EncuestaMateria();
            $EncuestaMateria->idencuesta = $d['idencuesta'];
            $EncuestaMateria->idencuestamateria = $d['idencuestamateria'];
            $EncuestaMateria->codigomateria = $d['codigomateria'];
            $EncuestaMateria->codigomodulopostind = $d['codigomodulopostind'];
            
            $return[] = $EncuestaMateria;
            unset($EncuestaMateria);
        }
        
        return $return;
    }
    
    public function getEncuestamateriaEstudiante($periodo, $carrera, $estudiante){        
        
        $queryMaterias = "SELECT dp.codigomateria "
                . "FROM ordenpago o "
                . "INNER JOIN detalleordenpago d ON (o.numeroordenpago = d.numeroordenpago) "
                . "INNER JOIN detalleprematricula dp ON (o.numeroordenpago = dp.numeroordenpago) "
                . "INNER JOIN estudiante e ON (o.codigoestudiante = e.codigoestudiante) "
                . "WHERE o.codigoperiodo = ".$periodo." "
                . " AND d.codigoconcepto = 151 "
                . " AND o.codigoestadoordenpago IN (40,41,42,44) "
                . " AND dp.codigoestadodetalleprematricula = '30' "
                . " AND e.codigocarrera = ".$this->db->qstr($carrera)." "
                . " AND e.codigoestudiante = ".$this->db->qstr($estudiante);
        
        $listados = $this->db->GetAll($queryMaterias);
        $listamaterias = array();
        
        foreach($listados as $codigomaterias){
            $listamaterias[] = $codigomaterias['codigomateria'];
        }

        //Abril 30 2018
        //Se adiciona la validacion del estado y validacion de encuestas activas
        $query = "SELECT * "
                . "FROM encuestamateria em "
                . "INNER JOIN encuesta e ON (em.idencuesta = e.idencuesta)"
                . "WHERE e.codigoestado = '100' AND e.codigotipousuario = '600' AND e.fechafinalencuesta > now()"
                . " AND em.codigomateria IN (".implode(", ",$listamaterias).")";        
        $datos = $this->db->GetAll($query);        
        return $datos;        
    }    
    /*
     * Ivan Dario Quintero Rios
     * 8 de mayo 2018
     * Modificado: variable re resultados
     */
    
    public function getRespuestaencuestamateria($estudiante, $periodo, $materia){                
        // $resultado= array();
        $resultado = 0;
        $querycontador2=  "SELECT COUNT(DISTINCT r.idrespuestaautoevaluacion) AS contador "
                . "FROM respuestaautoevaluacion r "
                . "INNER JOIN encuestapregunta ep ON (r.idencuestapregunta = ep.idencuestapregunta) "
                . "INNER JOIN pregunta p ON (p.idpregunta = ep.idpregunta) "
                . "WHERE p.codigoestado = '100' "
                . " AND ep.codigoestado = '100' "
                . " AND p.idtipopregunta NOT IN (100, 101, 201) "
                . " AND r.codigoestudiante = ".$this->db->qstr($estudiante)." "
                . " AND r.codigoperiodo = ".$this->db->qstr($periodo)." "
                . " AND r.codigomateria = ".$this->db->qstr($materia)." "
                . " AND r.codigoestado = '100'";   

        $querycontador = $querycontador2
                . " AND r.valorrespuestaautoevaluacion <> '' ";
        
        $resultadorespuestas = $this->db->GetRow($querycontador);   
        $resultadopreguntas = $this->db->GetRow($querycontador2);           
        
        //si la cantidad de preguntas es mayor a cero
        if(empty($resultadopreguntas) && empty($resultadorespuestas)){
            $resultado = 1;
        }else{
            if($resultadopreguntas['contador'] >0 ){
                //si la cantidad de respuestas es mayor a cero
                if($resultadorespuestas['contador'] > 0){
                    //si cantidades son iguales
                    if($resultadorespuestas['contador'] == $resultadopreguntas['contador']){
                         $resultado = 1;
                    }
                }else{
                     $resultado = 0;
                }
            }else{
                $resultado = 0;
            }
        }
        return $resultado;
    }
}
