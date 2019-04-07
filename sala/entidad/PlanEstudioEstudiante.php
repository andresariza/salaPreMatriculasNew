<?php

namespace Sala\entidad;

defined('_EXEC') or die;

/**
 * Description of PlanEstudioEstudiante
 *
 * @author Andres
 */
class PlanEstudioEstudiante implements \Sala\interfaces\Entidad {

    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    private $idplanestudio;
    private $codigoestudiante;
    private $fechaasignacionplanestudioestudiante;
    private $fechainicioplanestudioestudiante;
    private $fechavencimientoplanestudioestudiante;
    private $codigoestadoplanestudioestudiante;

    public function __construct() {
        
    }

    public function setDb() {
        $this->db = \Sala\lib\Factory::createDbo();
    }

    public function getIdplanestudio() {
        return $this->idplanestudio;
    }

    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }

    public function getFechaasignacionplanestudioestudiante() {
        return $this->fechaasignacionplanestudioestudiante;
    }

    public function getFechainicioplanestudioestudiante() {
        return $this->fechainicioplanestudioestudiante;
    }

    public function getFechavencimientoplanestudioestudiante() {
        return $this->fechavencimientoplanestudioestudiante;
    }

    public function getCodigoestadoplanestudioestudiante() {
        return $this->codigoestadoplanestudioestudiante;
    }

    public function setIdplanestudio($idplanestudio) {
        $this->idplanestudio = $idplanestudio;
    }

    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }

    public function setFechaasignacionplanestudioestudiante($fechaasignacionplanestudioestudiante) {
        $this->fechaasignacionplanestudioestudiante = $fechaasignacionplanestudioestudiante;
    }

    public function setFechainicioplanestudioestudiante($fechainicioplanestudioestudiante) {
        $this->fechainicioplanestudioestudiante = $fechainicioplanestudioestudiante;
    }

    public function setFechavencimientoplanestudioestudiante($fechavencimientoplanestudioestudiante) {
        $this->fechavencimientoplanestudioestudiante = $fechavencimientoplanestudioestudiante;
    }

    public function setCodigoestadoplanestudioestudiante($codigoestadoplanestudioestudiante) {
        $this->codigoestadoplanestudioestudiante = $codigoestadoplanestudioestudiante;
    }

    public function getById() {
        if (!empty($this->idplanestudio) && !empty($this->codigoestudiante)) {
            $query = "SELECT * FROM planestudioestudiante "
                    . " WHERE idplanestudio = " . $this->db->qstr($this->idplanestudio)
                    . " AND codigoestudiante = " . $this->db->qstr($this->codigoestudiante);

            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if (!empty($d)) {
                $this->setIdplanestudio($d['idplanestudio']);
                $this->setCodigoestudiante($d['codigoestudiante']);
                $this->setFechaasignacionplanestudioestudiante($d['fechaasignacionplanestudioestudiante']);
                $this->setFechainicioplanestudioestudiante($d['fechainicioplanestudioestudiante']);
                $this->setFechavencimientoplanestudioestudiante($d['fechavencimientoplanestudioestudiante']);
                $this->setFechavencimientoplanestudioestudiante($d['fechavencimientoplanestudioestudiante']);
            }
        }
    }

    public static function getList($where = null, $orderBy = null) {
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM planestudioestudiante "
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
            $PlanEstudioEstudiante = new PlanEstudioEstudiante();
            $PlanEstudioEstudiante->setIdplanestudio($d['idplanestudio']);
            $PlanEstudioEstudiante->setCodigoestudiante($d['codigoestudiante']);
            $PlanEstudioEstudiante->setFechaasignacionplanestudioestudiante($d['fechaasignacionplanestudioestudiante']);
            $PlanEstudioEstudiante->setFechainicioplanestudioestudiante($d['fechainicioplanestudioestudiante']);
            $PlanEstudioEstudiante->setFechavencimientoplanestudioestudiante($d['fechavencimientoplanestudioestudiante']);
            $PlanEstudioEstudiante->setFechavencimientoplanestudioestudiante($d['fechavencimientoplanestudioestudiante']);
            $return[] = $PlanEstudioEstudiante;
            unset($PlanEstudioEstudiante);
        }
        return $return;
    }

}
