<?php

namespace Sala\entidad;

defined('_EXEC') or die;

/**
 * Description of PlanEstudio
 *
 * @author Andres
 */
class PlanEstudio implements \Sala\interfaces\Entidad {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $idplanestudio;
    private $nombreplanestudio;
    private $codigocarrera;
    private $responsableplanestudio;
    private $cargoresponsableplanestudio;
    private $numeroautorizacionplanestudio;
    private $cantidadsemestresplanestudio;
    private $fechacreacionplanestudio;
    private $fechainioplanestudio;
    private $fechavencimientoplanestudio;
    private $codigoestadoplanestudio;
    private $codigotipocantidadelectivalibre;
    private $cantidadelectivalibre;

    function __construct() {
        
    }

    public function setDb() {
        $this->db = Factory::createDbo();
    }

    public function getIdplanestudio() {
        return $this->idplanestudio;
    }

    public function getNombreplanestudio() {
        return $this->nombreplanestudio;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function getResponsableplanestudio() {
        return $this->responsableplanestudio;
    }

    public function getCargoresponsableplanestudio() {
        return $this->cargoresponsableplanestudio;
    }

    public function getNumeroautorizacionplanestudio() {
        return $this->numeroautorizacionplanestudio;
    }

    public function getCantidadsemestresplanestudio() {
        return $this->cantidadsemestresplanestudio;
    }

    public function getFechacreacionplanestudio() {
        return $this->fechacreacionplanestudio;
    }

    public function getFechainioplanestudio() {
        return $this->fechainioplanestudio;
    }

    public function getFechavencimientoplanestudio() {
        return $this->fechavencimientoplanestudio;
    }

    public function getCodigoestadoplanestudio() {
        return $this->codigoestadoplanestudio;
    }

    public function getCodigotipocantidadelectivalibre() {
        return $this->codigotipocantidadelectivalibre;
    }

    public function getCantidadelectivalibre() {
        return $this->cantidadelectivalibre;
    }

    public function setIdplanestudio($idplanestudio) {
        $this->idplanestudio = $idplanestudio;
    }

    public function setNombreplanestudio($nombreplanestudio) {
        $this->nombreplanestudio = $nombreplanestudio;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function setResponsableplanestudio($responsableplanestudio) {
        $this->responsableplanestudio = $responsableplanestudio;
    }

    public function setCargoresponsableplanestudio($cargoresponsableplanestudio) {
        $this->cargoresponsableplanestudio = $cargoresponsableplanestudio;
    }

    public function setNumeroautorizacionplanestudio($numeroautorizacionplanestudio) {
        $this->numeroautorizacionplanestudio = $numeroautorizacionplanestudio;
    }

    public function setCantidadsemestresplanestudio($cantidadsemestresplanestudio) {
        $this->cantidadsemestresplanestudio = $cantidadsemestresplanestudio;
    }

    public function setFechacreacionplanestudio($fechacreacionplanestudio) {
        $this->fechacreacionplanestudio = $fechacreacionplanestudio;
    }

    public function setFechainioplanestudio($fechainioplanestudio) {
        $this->fechainioplanestudio = $fechainioplanestudio;
    }

    public function setFechavencimientoplanestudio($fechavencimientoplanestudio) {
        $this->fechavencimientoplanestudio = $fechavencimientoplanestudio;
    }

    public function setCodigoestadoplanestudio($codigoestadoplanestudio) {
        $this->codigoestadoplanestudio = $codigoestadoplanestudio;
    }

    public function setCodigotipocantidadelectivalibre($codigotipocantidadelectivalibre) {
        $this->codigotipocantidadelectivalibre = $codigotipocantidadelectivalibre;
    }

    public function setCantidadelectivalibre($cantidadelectivalibre) {
        $this->cantidadelectivalibre = $cantidadelectivalibre;
    }

    public function getById() {
        if (!empty($this->idplanestudio)) {
            $query = "SELECT * FROM planestudio "
                    . " WHERE idplanestudio = " . $this->db->qstr($this->idplanestudio);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if (!empty($d)) {
                $this->setIdplanestudio($d['idplanestudio']);
                $this->setNombreplanestudio($d['nombreplanestudio']);
                $this->setCodigocarrera($d['codigocarrera']);
                $this->setResponsableplanestudio($d['responsableplanestudio']);
                $this->setCargoresponsableplanestudio($d['cargoresponsableplanestudio']);
                $this->setNumeroautorizacionplanestudio($d['numeroautorizacionplanestudio']);
                $this->setCantidadsemestresplanestudio($d['cantidadsemestresplanestudio']);
                $this->setFechacreacionplanestudio($d['fechacreacionplanestudio']);
                $this->setFechainioplanestudio($d['fechainioplanestudio']);
                $this->setFechavencimientoplanestudio($d['fechavencimientoplanestudio']);
                $this->setCodigoestadoplanestudio($d['codigoestadoplanestudio']);
                $this->setCodigotipocantidadelectivalibre($d['codigotipocantidadelectivalibre']);
                $this->setCantidadelectivalibre($d['cantidadelectivalibre']);
            }
        }
    }

    public static function getList($where = null, $orderBy = null) {
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM planestudio "
                . " WHERE 1 ";
        if (!empty($where)) {
            $query .= " AND " . $where;
        }
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }
        //d($query);
        $datos = $db->Execute($query);

        while ($d = $datos->FetchRow()) {
            $PlanEstudio = new PlanEstudio();
            $PlanEstudio->setIdplanestudio($d['idplanestudio']);
            $PlanEstudio->setNombreplanestudio($d['nombreplanestudio']);
            $PlanEstudio->setCodigocarrera($d['codigocarrera']);
            $PlanEstudio->setResponsableplanestudio($d['responsableplanestudio']);
            $PlanEstudio->setCargoresponsableplanestudio($d['cargoresponsableplanestudio']);
            $PlanEstudio->setNumeroautorizacionplanestudio($d['numeroautorizacionplanestudio']);
            $PlanEstudio->setCantidadsemestresplanestudio($d['cantidadsemestresplanestudio']);
            $PlanEstudio->setFechacreacionplanestudio($d['fechacreacionplanestudio']);
            $PlanEstudio->setFechainioplanestudio($d['fechainioplanestudio']);
            $PlanEstudio->setFechavencimientoplanestudio($d['fechavencimientoplanestudio']);
            $PlanEstudio->setCodigoestadoplanestudio($d['codigoestadoplanestudio']);
            $PlanEstudio->setCodigotipocantidadelectivalibre($d['codigotipocantidadelectivalibre']);
            $PlanEstudio->setCantidadelectivalibre($d['cantidadelectivalibre']);
            $return[] = $PlanEstudio;
            unset($PlanEstudio);
        }
        return $return;
    }

}
